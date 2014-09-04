<?php

/**
 * sfGuardFormSignin for sfGuardAuth signin action
 *
 * @package    sfDoctrineGuardPlugin
 * @subpackage form
 * @author     Fabien Potencier <fabien.potencier@symfony-project.com>
 * @version    SVN: $Id: sfGuardFormSignin.class.php 23536 2009-11-02 21:41:21Z Kris.Wallsmith $
 */
class sfGuardFormSignin extends BasesfGuardFormSignin {

    /**
     * @see sfForm
     */
    public function configure() {
        
        // Set widgets
        $this->setWidgets(array(
            'username' => new sfWidgetFormInputText(array()),
            'password' => new sfWidgetFormInputPassword(array('type' => 'password')),
            'remember' => new sfWidgetFormInputCheckbox(array()),
        ));
      
        // Set labels
        $this->widgetSchema['username']->setLabel('Email:');
        $this->widgetSchema['password']->setLabel('Password:');
        
        $this->widgetSchema->setNameFormat('signin[%s]');
        
    }

}
