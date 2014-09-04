<?php

/**
 * clientAdminUserManagementForm for admin generators
 *
 * @package    sfDoctrineGuardPlugin
 * @subpackage form
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfGuardUserAdminForm.class.php 23536 2009-11-02 21:41:21Z Kris.Wallsmith $
 */
class clientAdminUserManagementForm extends sfGuardUserAdminForm {

    /**
     * @see sfForm
     */
    public function configure() {
        
        // Unset fields
        unset($this['username']);
        
        // Set widgets
        $this->widgetSchema['password']       = new sfWidgetFormInputPassword();
        $this->widgetSchema['password_again'] = new sfWidgetFormInputPassword();
        $this->widgetSchema['email_address']  = new sfWidgetFormInputText();
        $this->widgetSchema['client_id']      = new sfWidgetFormInputHidden(array(), array("value" => sfContext::getInstance()->getUser()->getGuardUser()->getClientId()));
        $this->widgetSchema['groups_list']    = new sfWidgetFormChoice(array("choices" => array(2 => "Admin", 3 => "User")), array("style" => "width: 333px !important; height: 16px;"));
        $this->widgetSchema['is_active']      = new sfWidgetFormInputCheckbox();
        $this->widgetSchema['is_visible']     = new sfWidgetFormInputCheckbox();
        
        // Set validators        
        $this->validatorSchema['first_name']->setOption('required', true); 
        $this->validatorSchema['first_name']->setMessage('required', 'This field is required.');
        $this->validatorSchema['last_name']->setOption('required', true); 
        $this->validatorSchema['last_name']->setMessage('required', 'This field is required.');
        if(sfContext::getInstance()->getRouting()->getCurrentRouteName() == 'sf_guard_user2_edit' || sfContext::getInstance()->getRouting()->getCurrentRouteName() == 'sf_guard_user2_update') {
            $this->validatorSchema['password']->setOption('required', false);     
        } else {
            $this->validatorSchema['password']->setOption('required', true);     
        } 
        $this->validatorSchema['password']->setMessage('required', 'This field is required.');                
        $this->validatorSchema['password_again'] = clone $this->validatorSchema['password'];
        $this->validatorSchema['password_again']->setMessage('required', 'This field is required.');                
        $this->validatorSchema['email_address']  = new sfValidatorEmail(array("required" => true), array("required" => "This field is required."));
        $this->validatorSchema['client_id']      = new sfValidatorChoice(array("choices" => array(sfContext::getInstance()->getUser()->getGuardUser()->getClientId()), 'required' => false));
        $this->validatorSchema['groups_list']    = new sfValidatorChoice(array("choices" => array(2, 3), 'required' => false));
        $this->validatorSchema['is_active']      = new sfValidatorBoolean(array('required' => false));
        $this->validatorSchema['is_visible']     = new sfValidatorBoolean(array('required' => false));
        
        // Set help messages
        $this->widgetSchema->setHelp("client_id", "Client account.");
        $this->widgetSchema->setHelp("first_name", "First name.");
        $this->widgetSchema->setHelp("last_name", "Last name.");
        $this->widgetSchema->setHelp("email_address", "Email Address.");
        $this->widgetSchema->setHelp("password", "Password.");
        $this->widgetSchema->setHelp("password_again", "Password confirmation.");
        $this->widgetSchema->setHelp("is_active", "Is active user?");
        $this->widgetSchema->setHelp("is_visible", "Is visible user?");
        $this->widgetSchema->setHelp("groups_list", "User's group.");        
        
    }

}
