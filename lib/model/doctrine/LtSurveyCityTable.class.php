<?php

/**
 * LtSurveyCityTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class LtSurveyCityTable extends Doctrine_Table {

    /**
     * Returns an instance of this class.
     *
     * @return object LtSurveyCityTable
     */
    public static function getInstance() {
        return Doctrine_Core::getTable('LtSurveyCity');
    }

    /**
     * Delete all rows related to particular survey
     * 
     * @param integer $survey_id    ID of survey
     * 
     * @return object LtSurveyCityTable
     */
    public function deleteOldRows($survey_id) {
        $q = $this->createQuery("sc")
                ->delete()
                ->where("sc.survey_id = ?", $survey_id);

        return $q->execute();
    }

}
