<?php

/**
 * basicUserForm
 */
class basicUserForm extends sfGuardUserAdminForm {

    /**
     * @see sfForm
     */
    public function configure() {
        
        // Remove fields
        $this->removeFields();
        
        // Set widgets
        $this->widgetSchema['password']->setAttribute('title', "Password.");
        $this->widgetSchema['password_again']->setAttribute('title', "Password confirmation.");
        
        // Set validators
        $this->validatorSchema['password']->setOption('required', true);
        $this->validatorSchema['password']->setMessage('required', 'This field is required.');
                
        $this->validatorSchema['password_again'] = clone $this->validatorSchema['password'];
        $this->validatorSchema['password_again']->setMessage('required', 'This field is required.');
        
        // Set labels
        $this->widgetSchema['password']->setLabel("Password");
        $this->widgetSchema['password_again']->setLabel("Password Again");
        
    }
    
    private function removeFields() {
        unset(
                $this['first_name'],
                $this['last_name'],
                $this['email_address'],
                $this['username'],
                $this['is_active'],
                $this['is_super_admin'],
                $this['client_id'],
                $this['is_client_admin'],
                $this['groups_list'],
                $this['permissions_list']
        );
    }

}
