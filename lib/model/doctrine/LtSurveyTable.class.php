<?php

/**
 * LtSurveyTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class LtSurveyTable extends Doctrine_Table {

    /**
     * Returns an instance of this class.
     *
     * @return object LtSurveyTable
     */
    public static function getInstance() {
        return Doctrine_Core::getTable('LtSurvey');
    }

    /**
     * Get candidate types of surveys
     * 
     * @return object LtSurveyTable
     */
    public function getSurveysCandidateTypes() {
        $q = $this->fieldForSelect("candidate_type")
                ->where("s.candidate_type IS NOT NULL")
                /*->andWhere("s.candidate_type <> ?", 0)*/;

        return $this->groupByAndExecute($q, "s.candidate_type");
    }

    /**
     * Get all years of surveys
     * 
     * @return array
     */
    public function getSurveysYears() {
        $q = $this->fieldForSelect("year")
                ->where("s.year <> 0")
                ->andWhere("s.year IS NOT NULL");

        return $this->groupByAndExecute($q, "s.year");
    }

    /**
     * Get all surveys by client
     * 
     * @return object LtSurveyTable
     */
    public function getAllSurveys() {
        $q = $this->createQuery('s')
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
                ->leftJoin('pa.MainPracticeArea mpa');

        $q->orderBy('s.year ASC');

        return $q->execute();
    }

    public function getSurveysByYear() {
        $year = date('o');

        $q = $this->createQuery('s')
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
            ->where('s.year = ?', (int)$year);
        $q->orderBy('s.year ASC');

        return $q->execute();
    }

    public function getSurveysDeadlines() {
        $checkingquery = 'SELECT `s`.`id`, `s`.`survey_name`, `s`.`submission_deadline`, `o`.`name` FROM `surveys` AS `s` JOIN `organizations` AS `o` ON `s`.`submission_deadline` != "0000-00-00" AND `s`.`organization_id` = `o`.`id`';
        $resultupdate = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($checkingquery)->fetchAll();

        return $resultupdate;
    }

    public function getAllMySyrveysListIds() {
        $checkingquery = 'SELECT `survey_id` FROM `my_surveys`';
        $resultupdate = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($checkingquery)->fetchAll();

        return $resultupdate;
    }

    public function getAllMySyrveysList($id) {
        $checkingquery = 'SELECT `s`.`id`, `s`.`survey_name`, `s`.`submission_deadline`, `o`.`name` FROM `surveys` AS `s` JOIN `organizations` AS `o` ON `s`.`organization_id` = `o`.`id` WHERE `s`.`id` = '.$id.'';
        $resultupdate = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($checkingquery)->fetchAll();

        return $resultupdate;
    }

    public function getAllMySyrveysMonthList($first_day, $last_day) {
        $checkingquery = 'SELECT `s`.`id`, `s`.`survey_name`, `s`.`submission_deadline`, `o`.`name` FROM `surveys` AS `s` JOIN `organizations` AS `o` ON `s`.`organization_id` = `o`.`id` JOIN `my_surveys` AS `m_s` ON `s`.`id` = `m_s`.`survey_id` WHERE `s`.`submission_deadline` >= "'.$first_day.'" AND `s`.`submission_deadline` <= "'.$last_day.'" ORDER BY `s`.`submission_deadline` ASC';
        $resultupdate = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($checkingquery)->fetchAll();

        return $resultupdate;
    }

    /**
     * Get full information about survey
     * 
     * @param integer $survey_id    ID of survey
     * 
     * @return object LtSurveyTable
     */
    public function getFullInfo($survey_id) {
        $q = $this->createQuery('s')
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
                ->where('s.id = ?', $survey_id);

        return $q->fetchOne();
    }

    /**
     * Get survey practice areas
     * 
     * @return object LtSurveyTable
     */
    public function getSurveyPracticeAreas() {
        $q = $this->createQuery("s")
                ->innerJoin("s.LtSurveyPracticeArea spa")
                ->leftJoin("spa.PracticeArea pa")
                ->groupBy("spa.practice_area_id");

        return $q->execute();
    }

    /**
     * Get survey organizations
     * 
     * @return object LtSurveyTable
     */
    public function getSurveyOrganizations() {
        $q = $this->createQuery("s")
                ->innerJoin("s.Organization o")
                ->groupBy("s.organization_id")
                ->orderBy("s.organization_id");

        return $q->execute();
    }

    /**
     * Get survey regions
     * 
     * @return object LtSurveyTable
     */
    public function getSurveyRegions() {
        $q = $this->createQuery("s")
                ->innerJoin("s.Region r")
                ->groupBy("s.survey_region_id")
                ->orderBy("s.survey_region_id");

        return $q->execute();
    }

    /**
     * Begin of query for select one column from table
     * 
     * @param string $field_name  Name of field
     * 
     * @return object LtSurveyTable
     */
    public function fieldForSelect($field_name) {
        return $this->createQuery("s")
                        ->select("s." . $field_name);
    }

    /**
     * End of query for select one column from table
     * 
     * @param object $query       Query object
     * @param string $field_name  Name of field
     * 
     * @return array    Result array
     */
    public function groupByAndExecute($query, $field_name) {
        $result = $query->groupBy($field_name);

        return $result->execute(array(), Doctrine_Core::HYDRATE_SINGLE_SCALAR);
    }
    
    /**
     * Get surveys by IDs
     * 
     * @param array $survey_ids     Array with survey IDs
     * 
     * @return object LtSurveyTable
     */
    public function getSurveysByIds($survey_ids) {
        $q = $this->createQuery("s")
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
                ->whereIn('s.id', $survey_ids);
        
        return $q->execute();
    }
    
    /**
     * Get IDs of all past due surveys
     * 
     * @return array        Array with IDs of past due surveys
     */
    public function getIdsOfPastDueSurveys() {
        $q = $this->createQuery('s')
                ->select('s.id')
                ->where('s.submission_deadline < ?', date('Y-m-d'));
        
        return $q->execute(array(), Doctrine_Core::HYDRATE_SINGLE_SCALAR);
    }

}
