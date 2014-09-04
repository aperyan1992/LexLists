<?php

/**
 * sfGuardUser
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    LexLists
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class sfGuardUser extends PluginsfGuardUser {

  /**
   * Get groups of user
   * 
   * @return array
   */
  public function getUserGroups() {
    $q = Doctrine_Query::create()
            ->select('gr.name')
            ->from('sfGuardGroup gr')
            ->leftJoin('gr.Users u')
            ->where('u.id = ?', $this->getId());

    return $q->execute(array(), Doctrine_Core::HYDRATE_SINGLE_SCALAR);
  }

  /**
   * Get client name
   * 
   * @return string
   */
  public function getClientName() {
    if (is_null($this->getClient())) {
      return '';
    }
    return $this->Client->name;
  }

}
