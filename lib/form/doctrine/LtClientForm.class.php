<?php

/**
 * LtClient form.
 *
 * @package    LexLists
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class LtClientForm extends BaseLtClientForm {

    public function configure() {
        
        // Remove fields
        $this->removeFields();
        
        // Set widgets
        $this->widgetSchema['name']                    = new sfWidgetFormInputText();
        $this->widgetSchema['is_enabled']              = new sfWidgetFormInputCheckbox(array(), array('class' => 'correct_admin_checkbox'));
        
        // Set validators
        $this->validatorSchema['name']                    = new sfValidatorString(array("max_length" => 100, "required" => true), array("required" => "This field is required."));
        $this->validatorSchema['is_enabled']              = new sfValidatorBoolean(array('required' => false));
        
        // Set labels
        $this->widgetSchema->setLabel('name', "Client Name");
        $this->widgetSchema->setLabel('is_enabled', "Is Enabled");
        
        // Set tooltips
        $this->widgetSchema->setHelp('name', "Client name.");
        $this->widgetSchema->setHelp('is_enabled', "Is client enabled?");
        
    }
    
    private function removeFields() {
        unset(
                $this['created_at'],
                $this['updated_at']
        );
    }
    
    public function doSave($con = null) { 
        // Enabling/Disabling client account users
        if (!$this->getValue("is_enabled") && $this->getObject()->getIsEnabled()) {
            $this->disablingOfClientAccountUsers($this->getObject()->getId());
        } elseif($this->getValue("is_enabled") && !$this->getObject()->getIsEnabled()) {
            $this->enablingOfClientAccountUsers($this->getObject()->getId());
        }

        return parent::doSave($con = null);
    }
    
    /**
     * Disabling of client account users
     * 
     * @param integer $client_id    ID of client
     * 
     * @return object
     */
    private function disablingOfClientAccountUsers($client_id) {
        return Doctrine_Query::create()
                ->update("sfGuardUser u")
                ->set(array("u.is_active" => false))
                ->where("u.client_id = ?", $client_id)
                ->execute();
    }
    
    /**
     * Enabling of client account users
     * 
     * @param integer $client_id    ID of client
     * 
     * @return object
     */
    private function enablingOfClientAccountUsers($client_id) {
        return Doctrine_Query::create()
                ->update("sfGuardUser u")
                ->set(array("u.is_active" => true))
                ->where("u.client_id = ?", $client_id)
                ->execute();
    }

}
