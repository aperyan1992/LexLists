<?php

/**
 * sfGuardUserAdminForm for admin generators
 *
 * @package    sfDoctrineGuardPlugin
 * @subpackage form
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfGuardUserAdminForm.class.php 23536 2009-11-02 21:41:21Z Kris.Wallsmith $
 */
class sfGuardUserAdminForm extends BasesfGuardUserAdminForm {

    /**
     * @see sfForm
     */
    public function configure() {
        
        // Unset fields
        unset($this['username']);

        // Set widgets
        $this->widgetSchema['client_id']->setAttributes(array("style" => "width: 333px !important; height: 16px;"));
        $this->widgetSchema['password']         = new sfWidgetFormInputPassword();
        $this->widgetSchema['password_again']   = new sfWidgetFormInputPassword();
        $this->widgetSchema['email_address']    = new sfWidgetFormInputText();
        $this->widgetSchema['groups_list']      = new sfWidgetFormDoctrineChoice(array('multiple' => false, 'model' => 'sfGuardGroup'), array("style" => "width: 333px !important; height: 16px;"));
        
        // Set validators
        $this->validatorSchema['first_name']->setOption('required', true); 
        $this->validatorSchema['first_name']->setMessage('required', 'This field is required.');
        $this->validatorSchema['last_name']->setOption('required', true); 
        $this->validatorSchema['last_name']->setMessage('required', 'This field is required.');
        if(sfContext::getInstance()->getRouting()->getCurrentRouteName() == 'sf_guard_user_edit' || sfContext::getInstance()->getRouting()->getCurrentRouteName() == 'sf_guard_user_update') {
            $this->validatorSchema['password']->setOption('required', false);     
        } else {
            $this->validatorSchema['password']->setOption('required', true);     
        }   
        $this->validatorSchema['password']->setMessage('required', 'This field is required.');                
        $this->validatorSchema['password_again'] = clone $this->validatorSchema['password'];
        $this->validatorSchema['password_again']->setMessage('required', 'This field is required.');        
        $this->validatorSchema['email_address']  = new sfValidatorEmail(array("required" => true), array("required" => "This field is required."));
        $this->validatorSchema['groups_list']    = new sfValidatorDoctrineChoice(array('multiple' => false, 'model' => 'sfGuardGroup', 'required' => false));

        // Set help messages
        $this->widgetSchema->setHelp("client_id", "Client account.");
        $this->widgetSchema->setHelp("first_name", "First name.");
        $this->widgetSchema->setHelp("last_name", "Last name.");
        $this->widgetSchema->setHelp("email_address", "Email Address.");
        $this->widgetSchema->setHelp("password", "Password.");
        $this->widgetSchema->setHelp("password_again", "Password confirmation.");
        $this->widgetSchema->setHelp("is_active", "Is active user?");
        $this->widgetSchema->setHelp("groups_list", "User's group.");
    }

    protected function doSave($con = null) {
        $this->saveGroupsList($con);
        $this->savePermissionsList($con);
        
        if (null === $con) {
            $con = $this->getConnection();
        }

        $this->updateObject();

        $this->getObject()->save($con);

        // embedded forms
        $this->saveEmbeddedForms($con);
        
        switch ($this->getValue("groups_list")) {
            case 1:
                $this->getObject()->setIsSuperAdmin(true);
                $this->getObject()->setIsClientAdmin(false);
                $this->getObject()->save();
                break;
            case 2:
                $this->getObject()->setIsSuperAdmin(false);
                $this->getObject()->setIsClientAdmin(true);
                $this->getObject()->save();
                break;
            case 3:
                $this->getObject()->setIsSuperAdmin(false);
                $this->getObject()->setIsClientAdmin(false);
                $this->getObject()->save();
                break;
            case 4:
                $this->getObject()->setIsSuperAdmin(false);
                $this->getObject()->setIsClientAdmin(false);
                $this->getObject()->save();
                break;
        }
    }
    
    public function save($con = null) {   
        if (!$this->isValid()) {
            throw $this->getErrorSchema();
        }

        if (null === $con) {
            $con = $this->getConnection();
        }

        try {
            $con->beginTransaction();

            $this->doSave($con);

            $con->commit();
        } catch (Exception $e) {
            $con->rollBack();

            throw $e;
        }

        return $this->getObject();
    }

    public function saveGroupsList($con = null) {
        if (!$this->isValid()) {
            throw $this->getErrorSchema();
        }

        if (!isset($this->widgetSchema['groups_list'])) {
            // somebody has unset this widget
            return;
        }

        if (null === $con) {
            $con = $this->getConnection();
        }

        $existing = $this->object->Groups->getPrimaryKeys();
        $pre_values = $this->getValue('groups_list');

        $values = array('0' => $pre_values);

        if (!is_array($values)) {
            $values = array();
        }

        $unlink = array_diff($existing, $values);
        if (count($unlink)) {
            $this->object->unlink('Groups', array_values($unlink));
        }

        $link = array_diff($values, $existing);
        if (count($link)) {
            $this->object->link('Groups', array_values($link));
        }
    }

}
