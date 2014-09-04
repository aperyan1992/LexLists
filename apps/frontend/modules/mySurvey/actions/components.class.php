<?php

/**
 * my survey components.
 * 
 * @package    LexLists
 * @subpackage mySurvey
 * @author Sergey Kuprianov <sergey.kuprianov@sibers.com>
 */
class mySurveyComponents extends sfComponents {

    /**
     *  Get bubbles number for "My List" tab
     */
    public function executeMySurveysBubbles() {
        $numbers_for_bubbles = Doctrine_Core::getTable("LtMySurvey")->getNumbersForBubbles($this->getUser()->getGuardUser()->getId());
        
        // Get amount of "Updated" surveys
        $this->updated_amount = (int) $numbers_for_bubbles[0]['updated_amount'];
        
        // Get amount of "Past dues" surveys
        $this->past_dues_amount = (int) $numbers_for_bubbles[0]['past_due_amount'];
        
        // Check if both bubbles exist
        $this->both_bubble = false;
        if ($this->updated_amount > 0 && $this->past_dues_amount > 0) {
            $this->both_bubble = true;
        }
    }

}
