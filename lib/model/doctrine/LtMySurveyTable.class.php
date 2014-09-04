<?php

/**
 * LtMySurveyTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class LtMySurveyTable extends Doctrine_Table {

    /**
     * Returns an instance of this class.
     *
     * @return object LtMySurveyTable
     */
    public static function getInstance() {
        return Doctrine_Core::getTable('LtMySurvey');
    }

    /**
     * Get all my surveys
     * 
     * @param integer   $user_id        Id of user
     * 
     * @return object LtMySurveyTable
     */
    public function getAllMySyrveys($user_id) {
        $q = $this->createQuery('ms')
                ->leftJoin('ms.Owner owner')
                ->leftJoin('ms.User u')
                ->leftJoin('ms.Survey s')
                ->leftJoin('s.Contact c')
                ->leftJoin("s.Organization o")
                ->leftJoin("s.LtSurveyCity s_city")
                ->leftJoin("s_city.City city")
                ->leftJoin("s.Region region")
                ->leftJoin("s.LtSurveyState ss")
                ->leftJoin("ss.State state")
                ->leftJoin("s.LtSurveyCountry sc")
                ->leftJoin("sc.Country country")
                ->leftJoin("s.LtSurveySpecialCriteria ssc")
                ->leftJoin("ssc.SpecialCriteria")
                ->leftJoin("s.LtSurveyPracticeArea spa")
                ->leftJoin('spa.PracticeArea pa')
                ->leftJoin('pa.MainPracticeArea mpa')
                ->where('ms.user_id = ?', $user_id)
                ->orderBy('s.submission_deadline ASC');

        return $q->execute();
    }
    
    /**
     * Get full information about my survey
     * 
     * @param integer   $survey_id      ID of survey
     * @param integer   $user_id        Id of user
     * 
     * @return object LtSurveyTable
     */
    public function getFullMySurveyInfo($survey_id, $user_id) {
        $q = $this->createQuery('ms')
                ->leftJoin('ms.Owner owner')
                ->leftJoin('ms.User u')
                ->leftJoin('ms.Survey s')
                ->leftJoin('s.Contact c')
                ->leftJoin("s.Organization o")
                ->leftJoin("s.LtSurveyCity s_city")
                ->leftJoin("s_city.City city")
                ->leftJoin("s.Region region")
                ->leftJoin("s.LtSurveyState ss")
                ->leftJoin("ss.State state")
                ->leftJoin("s.LtSurveyCountry sc")
                ->leftJoin("sc.Country country")
                ->leftJoin("s.LtSurveySpecialCriteria ssc")
                ->leftJoin("ssc.SpecialCriteria")
                ->leftJoin("s.LtSurveyPracticeArea spa")
                ->leftJoin('spa.PracticeArea pa')
                ->leftJoin('pa.MainPracticeArea mpa')
                ->where('ms.survey_id = ?', $survey_id)
                ->andWhere('ms.user_id = ?', $user_id);

        return $q->fetchOne();
    }

    /**
     * Get share with current aword
     *
     * @param integer $survey_id - current survey id
     * @return array - share with
     */
    public function getShareWithList($survey_id, $owner_id)
    {
        $q = $this->createQuery('ms')
            ->select('ms.id, ms.user_id, u.first_name, u.last_name')
            ->where('ms.survey_id = ?', $survey_id)
            ->addWhere('ms.share_with = ?', 1)
            ->andWhere('ms.user_id != ?', $owner_id);

        return $q->fetchArray();
    }

    /**
     * Get IDs of existing surveys in "My Lists" section
     * 
     * @param array     $survey_ids     Array with survey IDs
     * @param integer   $user_id        Id of user
     * 
     * @return array    Array with survey IDs
     */
    public function getIdsOfExistingMySyrveys($survey_ids, $user_id) {
        $q = $this->createQuery('ms')
                ->select('ms.survey_id')
                ->whereIn('ms.survey_id', $survey_ids)
                ->andWhere('ms.user_id = ?', $user_id);
        
        return $q->execute(array(), Doctrine_Core::HYDRATE_SINGLE_SCALAR);
    }

    /**
     * Remove all share_with
     *
     * @param integer $survey_id
     * @param integer $user_guard_id - current user id
     */
    public function removeAllShareWith($survey_id, $user_guard_id)
    {
        $this->createQuery("ms")
            ->delete()
            ->where('ms.survey_id = ?', $survey_id)
            ->andWhere('ms.share_with = ?', 1)
            ->andWhere('ms.user_id != ?', $user_guard_id)
            ->execute();
    }

    /**
     * Remove specify share_with
     *
     * @param integer $survey_id
     * @param array $share_with_array
     * @param integer $owner_id
     */
    public function removeSpecifyShareWith($survey_id, $share_with_array, $owner_id)
    {
        $share_with_array[] = $owner_id;
        $this->createQuery("ms")
            ->delete()
            ->where('ms.survey_id = ?', $survey_id)
            ->addWhere('ms.share_with = ?', 1)
            ->whereNotIn('ms.user_id', $share_with_array)
            ->execute();
    }

    /**
     * Find all survey without "share_with"
     *
     * @param integer $survey_id
     *
     * @return Doctrine_Collection result
     */
    public function findAllSurveyWithoutShareWith($survey_id)
    {
        return $this->createQuery('ms')->where('ms.survey_id = ?', $survey_id)->addWhere('ms.share_with = ?', 0)->execute();
    }

    /**
     * Set new owner
     *
     * @param integer $survey_id
     * @param integer $owner
     */
    public function setNewOwnerForAword($survey_id, $owner)
    {
        Doctrine_Query::create()->update('LtMySurvey')->set('owner_id', $owner)->where('survey_id = ?', $survey_id)->execute();
    }

    public function findExistsSurvey($owner, $survey_id)
    {
        return $this->createQuery("ms")->where('ms.user_id = ?', $owner)->andWhere('ms.survey_id = ?', $survey_id)->fetchArray();
    }

    public function updateOldOwner($survey_id, $owner)
    {
        Doctrine_Query::create()->update('LtMySurvey')->set('share_with', 0)->where('survey_id = ?', $survey_id)->andWhere('user_id = ?', $owner)->execute();
    }
    
    /**
     * Get amounts of "updated" and "past dues" surveys
     * 
     * @param integer $user_id      ID of user
     * 
     * @return array    Array with surveys amounts
     */
    public function getNumbersForBubbles($user_id) {
        $q = $this->createQuery("ms")
                ->select("SUM(ms.is_updated) AS updated_amount, SUM(ms.is_deadline_past) AS past_due_amount")
                ->where("ms.user_id = ?", $user_id);
        
        return $q->execute(array(), Doctrine_Core::HYDRATE_ARRAY);
    }
    
    /**
     * Set "is_deadline_past" flag to true for all past due surveys
     * 
     * @return integer      Number of updated rows
     */
    public function setFlagForPastDueMySurveys() {
        // Get IDs of all past due surveys
        $past_due_survey_ids = (array) Doctrine_Core::getTable("LtSurvey")->getIdsOfPastDueSurveys();
        
        if (count($past_due_survey_ids) > 0) {                        
            $q = $this->createQuery("ms")
                    ->update()
                    ->set(array("ms.is_deadline_past" => true))
                    ->whereIn("ms.survey_id", $past_due_survey_ids);

            return $q->execute();
        }
        
        return 0;
    }
    
    /**
     * Set "is_updated" flag for updated survey
     * 
     * @param integer $survey_id    IF of survey
     * @param boolean $flag         Is updated?
     * 
     * @return integer      Number of updated rows
     */
    public function setFlagForUpdatedSurvey($survey_id, $flag = true) {
        $q = $this->createQuery("ms")
                ->update()
                ->set(array("ms.is_updated" => $flag))
                ->where("ms.survey_id = ?", $survey_id);
        
        return $q->execute();
    }

}
