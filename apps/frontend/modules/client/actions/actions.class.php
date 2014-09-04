<?php

require_once dirname(__FILE__) . '/../lib/clientGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/clientGeneratorHelper.class.php';

/**
 * client actions.
 *
 * @package    LexLists
 * @subpackage client
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class clientActions extends autoClientActions {

    /**
     * Saving of client information
     * 
     * @param sfWebRequest $request     Request object
     * 
     * @return array                    JSON array with response message
     */
    public function executeSaveClientInfo(sfWebRequest $request) {
        if($request->isXmlHttpRequest()) {
            // Get parameters
            $client_name        = $request->getParameter("client_name", FALSE);
            $is_enabled         = $request->getParameter("is_enabled", FALSE);
            $is_new_object      = $request->getParameter("is_new_object", FALSE);
            
            if($client_name && $is_new_object) {
                if($is_new_object == 'true') {
                    // Save new client
                    $new_client             = new LtClient();
                    $new_client->name       = $client_name;
                    $new_client->is_enabled = ($is_enabled == 'true') ? 1 : 0;
                    $new_client->save();
                    
                    $client_id = $new_client->getId();
                } else {
                    // Update client info
                    $client_info = Doctrine_Core::getTable("LtClient")->findOneById($is_new_object);
                    if($client_info) {
                        $client_info->name       = $client_name;
                        $client_info->is_enabled = ($is_enabled == 'true') ? 1 : 0;
                        $client_info->save();
                        
                        $client_id = $client_info->getId();
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
     * Processing of form
     * 
     * @param sfWebRequest $request     Request object
     * @param sfForm $form              Form object
     * 
     * @return mixed
     */
    protected function processForm(sfWebRequest $request, sfForm $form) {
        $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
        if ($form->isValid()) {
            $notice = $form->getObject()->isNew() ? 'The item was created successfully.' : 'The item was updated successfully.';

            try {
                $lt_client = $form->save();
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

            $this->dispatcher->notify(new sfEvent($this, 'admin.save_object', array('object' => $lt_client)));

            if ($request->hasParameter('_save_and_add')) {
                $this->getUser()->setFlash('notice', $notice . ' You can add another one below.');

                $this->redirect('@lt_client_new');
            } else {
                $this->getUser()->setFlash('notice', $notice);

                $this->redirect(array('sf_route' => 'lt_client_edit', 'sf_subject' => $lt_client));
            }
        } else {
            $this->getUser()->setFlash('error', 'There is missing information. Please complete the required fields.', false);
        }
    }
    
    /**
     * Checking client name for uniqueness 
     * 
     * @param sfWebRequest $request     Request object
     * 
     * @return array                    JSON array with response message
     */
    public function executeCheckUniqueClientName(sfWebRequest $request) {
        if($request->isXmlHttpRequest()) {
            // Get parameters
            $client_name = $request->getParameter("client_name", FALSE);
            $client_id   = $request->getParameter("client_id", FALSE);
            
            if($client_name) {
                // Check unique client name
                if($client_id == 'false') {
                    $check_client_name = Doctrine_Core::getTable("LtClient")->checkUniqueClientName($client_name);
                } else {
                    $check_client_name = Doctrine_Core::getTable("LtClient")->checkUniqueClientName($client_name, $client_id);
                }                
                
                if($check_client_name) {
                    $status = "client_name_exist";
                } else {
                    $status = "client_name_not_exist";
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

}
