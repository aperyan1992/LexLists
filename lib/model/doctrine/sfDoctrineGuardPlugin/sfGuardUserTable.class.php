<?php

/**
 * sfGuardUserTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class sfGuardUserTable extends PluginsfGuardUserTable {

    /**
     * Returns an instance of this class.
     *
     * @return object sfGuardUserTable
     */
    public static function getInstance() {
        return Doctrine_Core::getTable('sfGuardUser');
    }

    /**
     * Retrieves a sfGuardUser object by username or email_address and is_active flag.
     *
     * @param  string  $username The username
     * @param  boolean $isActive The user's status
     *
     * @return sfGuardUser
     */
    public function retrieveByEmailAddress($email_address, $isActive = true) {
        $query = Doctrine_Core::getTable('sfGuardUser')->createQuery('u')
                ->where('u.email_address = ?', $email_address)
                ->addWhere('u.is_active = ?', $isActive);

        return $query->fetchOne();
    }

    public static function doSelectJoinClient($query) {
        $rootAlias = $query->getRootAlias();

        return $query->select($rootAlias . '.*, c.name')
                        ->leftJoin($rootAlias . '.Client c');
    }

    /**
     * Checking email address for uniqueness
     * 
     * @param string   $email_address       Email address
     * @param integer  $user_id             ID of user
     * 
     * @return sfGuardUser
     */
    public function checkUniqueEmailAddress($email_address, $user_id = false) {
        $q = $this->createQuery('u')
                ->where('u.email_address = ?', $email_address);

        if ($user_id !== false) {
            $q->andWhere('u.id <> ?', $user_id);
        }

        $result = $q->fetchOne();

        return $result;
    }
    
    /**
     * Get list of users
     * 
     * @param bool $is_superuser_flag   Is superuser?
     * 
     * @return array
     */
    public function getUsersList($is_superuser_flag = false) {
        $q = $this->createQuery('u');

        $owners = false;
        if(!$is_superuser_flag) {

            $query = 'SELECT * FROM sf_guard_user WHERE client_id="'. sfContext::getInstance()->getUser()->getGuardUser()->getClientId() .'" ORDER BY last_name ASC';
           // $query = 'SELECT * FROM sf_guard_user WHERE client_id="'. sfContext::getInstance()->getUser()->getGuardUser()->getClientId() .'" AND is_client_admin ="false" ORDER BY last_name ASC';
            $owners = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($query);
//pordzi

            // $q->where("u.client_id = ?", sfContext::getInstance()->getUser()->getGuardUser()->getClientId())
            //     ->andWhere('u.is_client_admin = ?', false)
            //     ->orderBy('u.last_name ASC');
        }

        //$owners = $q->orderBy('u.last_name ASC')->execute(); 
        
        $owners_array = array();
        if($owners) {//var_dump($owners);die;
            foreach ($owners as $owner) {
                $email_address = "- - -";
                if($owner['email_address'] != '') {
                    $email_address = $owner['email_address'];
                }
                
                $phone = "- - -";
                if($owner['phone_number'] != '') {
                    $phone = $owner['phone_number'];
                }
                
                $owners_array[$owner['id']] = $owner['last_name'] . ", " . $owner['first_name'] . " (Email: " . $email_address . ", Phone: " . $phone . ")";
            }
        }        
        
        return $owners_array;
    }

}
