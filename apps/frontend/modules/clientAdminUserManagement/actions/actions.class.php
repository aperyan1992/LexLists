<?php

require_once dirname(__FILE__) . '/../lib/clientAdminUserManagementGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/clientAdminUserManagementGeneratorHelper.class.php';

/**
 * clientAdminUserManagement actions.
 *
 * @package    LexLists
 * @subpackage clientAdminUserManagement
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class clientAdminUserManagementActions extends autoClientAdminUserManagementActions {

    public function executeDelete(sfWebRequest $request) {
        $request->checkCSRFProtection();

        $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));
        
        if(sfContext::getInstance()->getUser()->getGuardUser()->getId() != $this->getRoute()->getObject()->getId()) {
            if ($this->getRoute()->getObject()->delete()) {
                $this->getUser()->setFlash('notice', 'The item was deleted successfully.');
            }
        } else {
            $this->getUser()->setFlash('error', "Client admin can't delete yourself.");
        }        

        $this->redirect('@sf_guard_user2');
    }

    protected function executeBatchDelete(sfWebRequest $request) {
        $ids = $request->getParameter('ids');

        $records = Doctrine_Query::create()
                ->from('sfGuardUser')
                ->whereIn('id', $ids)
                ->andWhere('id <> ?', sfContext::getInstance()->getUser()->getGuardUser()->getId())
                ->execute();

        foreach ($records as $record) {
            $record->delete();
        }

        $this->getUser()->setFlash('notice', 'The selected items have been deleted successfully.');
        $this->redirect('@sf_guard_user2');
    }
    
    protected function processForm(sfWebRequest $request, sfForm $form) {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid()) {
            $notice = $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.';

            try {
                $sf_guard_user = $form->save();
            } catch (Doctrine_Validator_Exception $e) {

                $errorStack = $form->getObject()->getErrorStack();

                $message = get_class($form->getObject()) . ' has ' . count($errorStack) . " field" . (count($errorStack) > 1 ? 's' : null) . " with validation errors: ";
                foreach ($errorStack as $field => $errors) {
                    $message .= "$field (" . implode(", ", $errors) . "), ";
                }
                $message = trim($message, ', ');

                $this->getUser()->setFlash('error', $message);
                return sfView::SUCCESS;
            }

            $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $sf_guard_user)));

            if ($request->hasParameter('_save_and_add')) {
                $this->getUser()->setFlash('notice', $notice . ' You can add another one below.');

                $this->redirect('@sf_guard_user2_new');
            } else {
                $this->getUser()->setFlash('notice', $notice);

                $this->redirect(array('sf_route' => 'sf_guard_user2_edit', 'sf_subject' => $sf_guard_user));
            }
        } else {
            $this->getUser()->setFlash('error', 'There is missing information. Please complete the required fields.', false);
        }
    }
    
    /**
     * Checking email address for uniqueness 
     * 
     * @param sfWebRequest $request     Request object
     * 
     * @return array                    JSON array with response message
     */
    public function executeCheckUniqueEmailAddress(sfWebRequest $request) {
        if($request->isXmlHttpRequest()) {
            // Get parameters
            $email_address = $request->getParameter("email_address", FALSE);
            $user_id       = $request->getParameter("user_id", FALSE);
            
            if($email_address) {
                // Check unique email address
                if($user_id == 'false') {
                    $check_email_address = Doctrine_Core::getTable("sfGuardUser")->checkUniqueEmailAddress($email_address);
                } else {
                    $check_email_address = Doctrine_Core::getTable("sfGuardUser")->checkUniqueEmailAddress($email_address, $user_id);
                }                
                
                if($check_email_address) {
                    $status = "email_address_exist";
                } else {
                    $status = "email_address_not_exist";
                }
                
                return $this->renderText(
                    json_encode(
                        array(
                            "status" => $status
                        )
                    )
                );
            }
        }
        
        $this->forward404();
    }
    
    /**
     * Saving of user information
     * 
     * @param sfWebRequest $request     Request object
     * 
     * @return array                    JSON array with response message
     */
    public function executeSaveUserInfo(sfWebRequest $request) {
        if($request->isXmlHttpRequest()) {
            // Get parameters
            $client_id      = $request->getParameter("client_id", FALSE);
            $first_name     = $request->getParameter("first_name", FALSE);
            $last_name      = $request->getParameter("last_name", FALSE);
            $email_address  = $request->getParameter("email_address", FALSE);
            $password       = $request->getParameter("password", FALSE);
            $password_again = $request->getParameter("password_again", FALSE);
            $is_active      = $request->getParameter("is_active", FALSE);
            $is_visible     = $request->getParameter("is_visible", FALSE);
            $group          = $request->getParameter("group", FALSE);
            $is_new_object  = $request->getParameter("is_new_object", FALSE);
            
            if($first_name && $last_name && $email_address && $is_active && $group && $is_new_object) {
                switch ($group) {
                    case 1:
                        $super_user_flag   = TRUE;
                        $client_admin_flag = FALSE;
                        
                        break;
                    case 2:
                        $super_user_flag   = FALSE;
                        $client_admin_flag = TRUE;
                        
                        break;
                    case 3:
                        $super_user_flag   = FALSE;
                        $client_admin_flag = FALSE;
                        
                        break;
                }
                
                if($is_new_object == 'true') {
                    // Save new user
                    $new_user = new sfGuardUser();
                    if($client_id != '') {
                        $new_user->client_id    = $client_id;
                    }
                    $new_user->first_name       = $first_name;
                    $new_user->last_name        = $last_name;
                    $new_user->email_address    = $email_address;
                    $new_user->password         = $password;
                    $new_user->is_active        = ($is_active == 'true') ? 1 : 0;
                    $new_user->is_visible       = ($is_visible == 'true') ? 1 : 0;
                    $new_user->is_super_admin   = $super_user_flag;
                    $new_user->is_client_admin  = $client_admin_flag;
                    $new_user->save();
                    
                    // Save marketing contact's group
                    $new_user_group            = new sfGuardUserGroup();
                    $new_user_group->user_id   = $new_user->getId();
                    $new_user_group->group_id  = $group;
                    $new_user_group->save();
                } else {
                    $user_info = Doctrine_Core::getTable("sfGuardUser")->findOneById($is_new_object);
                    if($user_info) {
                        if($client_id != '') {
                            $user_info->client_id    = $client_id;
                        } else {
                            $user_info->client_id    = NULL;
                        }
                        $user_info->first_name       = $first_name;
                        $user_info->last_name        = $last_name;
                        $user_info->email_address    = $email_address;
                        if($password != '') {
                            $user_info->password     = $password;
                        }                        
                        $user_info->is_active        = ($is_active == 'true') ? 1 : 0;
                        $user_info->is_visible       = ($is_visible == 'true') ? 1 : 0;
                        $user_info->is_super_admin   = $super_user_flag;
                        $user_info->is_client_admin  = $client_admin_flag;
                        
                        $user_info->getSfGuardUserGroup()->getFirst()->setGroupId($group);
                        
                        $user_info->save();
                    }
                }
                
                return $this->renderText(
                    json_encode(
                        array(
                            "status" => "success"
                        )
                    )
                );
            }
        }
        
        $this->forward404();
    }
    
    /**
     * Changing of password
     * 
     * @param sfWebRequest $request Request object
     */
    public function executeBasicUser(sfWebRequest $request) {
        $this->basic_user_form = new basicUserForm($this->getUser()->getGuardUser());
        
        if ($request->isMethod(sfRequest::PUT)) {
            $this->processPasswordForm($request, $this->basic_user_form);
        }
    }

    /**
     * Processing of the password form
     * 
     * @param sfWebRequest $request     Request object
     * @param sfForm $form              Form object
     */
    protected function processPasswordForm(sfWebRequest $request, sfForm $form) {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid()) {
            $change_user_password = $form->save();

            $this->getUser()->setFlash('notice', 'Your password was changed successfully.');
            
            $this->redirect('@basic_user');
        }
    }

}
