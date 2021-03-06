<?php

/**
 * LtMySurveyNoteTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class LtMySurveyNoteTable extends Doctrine_Table {

    /**
     * Returns an instance of this class.
     *
     * @return object LtMySurveyNoteTable
     */
    public static function getInstance() {
        return Doctrine_Core::getTable('LtMySurveyNote');
    }
    
    /**
     * Get notes of award
     * 
     * @param integer   $survey_id       ID of survey
     * 
     * @return object LtMySurveyNoteTable
     */
    public function getAwardNotes($survey_id) {
        $q = $this->createQuery("msn")
                ->where("msn.survey_id = ?", $survey_id);
        
        return $q->execute();
    }

}
