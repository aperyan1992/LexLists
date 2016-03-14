<?php

/**
 * dashboard actions.
 *
 * @package    LexLists
 * @subpackage dashboard
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class dashboardActions extends sfActions {


    public function executeCalendar(sfWebRequest $request) {
        if ($request->isXmlHttpRequest()) {
            
            $title = $request->getParameter("title", FALSE);
            $button = $request->getParameter("button", FALSE);

            if (isset($button) && !empty($button)) 
            {
                $final_filename = $this->getUser()->getAttribute('log_file_name');
                $logPath = sfConfig::get('sf_log_dir').'/'.$final_filename;
                $custom_logger = new sfFileLogger(new sfEventDispatcher(), array('file' => $logPath));

                $custom_logger->info("Directory | Calendar | ".$title);
            }
            else
            {
                $final_filename = $this->getUser()->getAttribute('log_file_name');
                $logPath = sfConfig::get('sf_log_dir').'/'.$final_filename;
                $custom_logger = new sfFileLogger(new sfEventDispatcher(), array('file' => $logPath));

                $custom_logger->info("Directory | Calendar");
            }            
            
        }
    }

    // public function executeOpenCalendarLog(sfWebRequest $request) {
    //     if ($request->isXmlHttpRequest()) {

    //         $title = $request->getParameter("title", FALSE);

    //         $final_filename = $this->getUser()->getAttribute('log_file_name');
    //         $logPath = sfConfig::get('sf_log_dir').'/'.$final_filename;
    //         $custom_logger = new sfFileLogger(new sfEventDispatcher(), array('file' => $logPath));

    //         $custom_logger->info("Directory | Dashboard");
            
    //     }
    // }

    public function executeCalendarDates() {
        $surveys = Doctrine_Core::getTable("LtSurvey")->getSurveysDeadlines();
        $newarray = array();
        foreach($surveys as $key=>$survey)
        {
            $newarray[$key]['id'] = $survey['id'];
            $newarray[$key]['title'] = $survey['survey_name'] . ", " . $survey['name'];
            //$newarray[$key]['url'] = '';
            $newarray[$key]['class'] = "event-warning";
            $newarray[$key]['start'] = (string)(strtotime($survey['submission_deadline'])* 1000);
            $newarray[$key]['end'] = (string)(strtotime($survey['submission_deadline'])* 1000);
        }
        $result = array("success" => 1, "result"=> $newarray);
        echo json_encode($result);die;
    }
    
    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {

        $final_filename = $this->getUser()->getAttribute('log_file_name');
        $logPath = sfConfig::get('sf_log_dir').'/'.$final_filename;
        $custom_logger = new sfFileLogger(new sfEventDispatcher(), array('file' => $logPath));

        $custom_logger->info("Directory | Dashboard");

        // Get surveys years
        $this->surveys_years = Doctrine_Core::getTable('LtSurvey')->getSurveysYears();
        $this->survey_year_checkboxes = "";
        if(!empty($this->surveys_years))
        {
            foreach ($this->surveys_years as $year) {
                $allYears[]=$year;
    //            $this->survey_year_checkboxes .= '<input checkbox_type="year" type="checkbox" class="year_checkbox" col_num="1" value="' . $year . '" id="' . $year . '" /><span>' . $year . '</span><br />';
            }
            rsort($allYears);//sorting Z-A

            foreach($allYears as $year){
                $this->survey_year_checkboxes .= '<input checkbox_type="year" type="checkbox" class="year_checkbox" col_num="1" value="' . $year . '" id="' . $year . '" /><span>' . $year . '</span><br />';
            }
        }

        // Get survey organizations
        $this->survey_organizations = Doctrine_Core::getTable('LtSurvey')->getSurveyOrganizations();
        $this->survey_organization_checkboxes = "";
        $allOrganizations = array();
        foreach ($this->survey_organizations as $organization) {
            $organization_name = $organization->getOrganization()->getName();
            if(!in_array($organization_name, $allOrganizations))
            {
                $allOrganizations[]=$organization_name;
            }           
            //$this->survey_organizations_checkboxes .= '<input checkbox_type="organization" type="checkbox" class="organization_checkbox" col_num="2" value="' . $organization_name . '" id="' . $organization_name . '" /><span>' . $organization_name . '</span><br />';
        }
        sort($allOrganizations);//sorting A-Z

        foreach($allOrganizations as $oganizations_name){
            $this->survey_organizations_checkboxes .= '<input checkbox_type="organization" type="checkbox" class="organization_checkbox" col_num="2" value="' . $oganizations_name . '" id="' . $oganizations_name . '" /><span>' . $oganizations_name . '</span><br />';
        }

        $this->types_checkboxes .= '<input type="checkbox" class="is_list_checkbox" value="Award" col_num="14"/><span>Directories</span><br />';
        $this->types_checkboxes .= '<input type="checkbox" class="is_list_checkbox" value="List" col_num="14"/><span>Awards/Lists</span><br />';

        $this->area_checkboxes .= '<input type="checkbox" class="is_legal_checkbox" value="Legal" col_num="15"/><span>Legal</span><br />';
        $this->area_checkboxes .= '<input type="checkbox" class="is_legal_checkbox" value="Business" col_num="15"/><span>Business/Trade</span><br />';

        // Get survey candidate types
        $this->survey_candidate_types = Doctrine_Core::getTable('LtSurvey')->getSurveysCandidateTypes();
       // var_dump($this->survey_candidate_types);die;
        $this->survey_candidate_types_checkboxes = "";
        if(!empty($this->survey_candidate_types))
        {
            $allC_type = array();
            foreach ($this->survey_candidate_types as $candidate_type) {
                $c_type = "- - -";
                if (array_key_exists($candidate_type, LtSurvey::$candidate_types_array)) {
                    $c_type = LtSurvey::$candidate_types_array[$candidate_type];

                }
                $allC_type[]=$c_type;
                //$this->survey_candidate_types_checkboxes .= '<input checkbox_type="candidate_type" type="checkbox" class="candidate_type_checkbox" col_num="4" value="' . $c_type . '" id="' . $c_type . '" /><span>' . $c_type . '</span><br />';
            }
            sort($allC_type);
            $sort_candidate_type[0] = "Individual";
            $sort_candidate_type[1] = "Practice group";
            $sort_candidate_type[2] = "Law firm";
            $sort_candidate_type[3] = "Judge";
            $sort_candidate_type[4] = "Company";
            $sort_candidate_type[5] = "Legal Department";
            $sort_candidate_type[6] = "Organization";
            foreach(/*$allC_type*/$sort_candidate_type as $c_types){
                $this->survey_candidate_types_checkboxes .= '<input checkbox_type="candidate_type" type="checkbox" class="candidate_type_checkbox" col_num="4" value="' . $c_types . '" id="' . $c_types . '" /><span>' . $c_types . '</span><br />';
            }
         }
        // Get survey practice areas
        $this->survey_practice_areas = Doctrine_Core::getTable("LtPracticeArea")->findAll();
        $this->survey_practice_areas_checkboxes = "";
        //var_dump($this->survey_practice_areas);die;
        if(!empty($this->survey_practice_areas))
        {
            foreach ($this->survey_practice_areas as $practice_area) {
                $practice_area_name = $practice_area->getShortCode();
                $allPractice_area_name[]=$practice_area_name;
                //$this->survey_practice_areas_checkboxes .= '<input checkbox_type="practice_area" type="checkbox" class="practice_area_checkbox" col_num="5" value="' . $practice_area_name . '" id="' . $practice_area_name . '" /><span>' . $practice_area_name . '</span><br />';
            }
           // var_dump($allPractice_area_name);die;
            $allPractice_area_name = @array_unique($allPractice_area_name);
            @sort($allPractice_area_name);
            $sort_prac_area[0] = "Antitrust";
            $sort_prac_area[1] = "Arbitration & Alternative Dispute Resolution";
            $sort_prac_area[2] = "Aviation";
            $sort_prac_area[3] = "Banking & Finance";
            $sort_prac_area[4] = "Bankruptcy";
            $sort_prac_area[5] = "Civil Rights";
            $sort_prac_area[6] = "Construction";
            $sort_prac_area[7] = "Corporate";
            $sort_prac_area[8] = "Corporate Crime & Investigations";
            $sort_prac_area[9] = "Criminal Law";
            $sort_prac_area[10] = "Education";
            $sort_prac_area[11] = "Employment Law";
            $sort_prac_area[12] = "Energy & Natural Resources";
            $sort_prac_area[13] = "Environmental";
            $sort_prac_area[14] = "Family Law";
            $sort_prac_area[15] = "Healthcare";
            $sort_prac_area[16] = "Immigration";
            $sort_prac_area[17] = "Insurance";
            $sort_prac_area[18] = "Intellectual Property";
            $sort_prac_area[19] = "International Arbitration";
            $sort_prac_area[20] = "International Trade";
            $sort_prac_area[21] = "Life Sciences";
            $sort_prac_area[22] = "Litigation";
            $sort_prac_area[23] = "M&A";
            $sort_prac_area[24] = "Media & Entertainment";
            $sort_prac_area[25] = "Poverty Law";
            $sort_prac_area[26] = "Private Equity";
            $sort_prac_area[27] = "Public Law & Policy";
            $sort_prac_area[28] = "Real Estate";
            $sort_prac_area[29] = "Security & Data Privacy";
            $sort_prac_area[30] = "Tax";
            $sort_prac_area[31] = "Telecommunications";
            $sort_prac_area[32] = "Transportation";
            $sort_prac_area[33] = "Trusts & Estates";
            $sort_prac_area[34] = "Venture Capital";

            foreach(/*$allPractice_area_name*/$sort_prac_area as $practice_area_names){
                $this->survey_practice_areas_checkboxes .= '<input checkbox_type="practice_area" type="checkbox" class="practice_area_checkbox" col_num="5" value="' . $practice_area_names . '" id="' . $practice_area_names . '" /><span>' . $practice_area_names . '</span><br />';

            }
        }
        // Get survey regions
        $this->survey_regions = Doctrine_Core::getTable('LtSurvey')->getSurveyRegions();
        $this->survey_regions_checkboxes = "";
        foreach ($this->survey_regions as $region) {
            $region_name = $region->getRegion()->getName();
            //var_dump( $region->getRegion()->getName());
            $allRegion_name[]=$region_name;
            //$this->survey_regions_checkboxes .= '<input checkbox_type="region" type="checkbox" class="region_checkbox" col_num="7" value="' . $region_name . '" id="' . $region_name . '" /><span>' . $region_name . '</span><br />';
        }
        @sort($allRegion_name);

        $sorted_names[0] = "US Mid-Atlantic";
        $sorted_names[1] = "US Midwest";
        $sorted_names[2] = "US Northeast";
        $sorted_names[3] = "US South";
        $sorted_names[4] = "US West";
        $sorted_names[5] = "Africa";
        $sorted_names[6] = "Australia";
        $sorted_names[7] = "AsiaAustralia";
        $sorted_names[8] = "Europe";
        $sorted_names[9] = "North America";
        $sorted_names[10] = "South America";
        $sorted_names[11] = "Global (the world)";
        $sorted_names[12] = "US (All States)";


        /*foreach($sorted_names as $sorted_name)
        {
            foreach($allRegion_name as $region_names)
            {
                if($sorted_name == $region_names)
                {
                    $this->survey_regions_checkboxes .= '<input checkbox_type="region" type="checkbox" class="region_checkbox" col_num="7" value="' . $region_names . '" id="' . $region_names . '" /><span>' . $region_names . '</span><br />';
                }
            }
        }*/
        foreach($sorted_names as $region_names)
            {               
                $this->survey_regions_checkboxes .= '<input checkbox_type="region" type="checkbox" class="region_checkbox" col_num="7" value="' . $region_names . '" id="' . $region_names . '" /><span>' . $region_names . '</span><br />';
               
            }
        //$this->survey_regions_checkboxes .= '<input checkbox_type="state" type="checkbox" class="state_checkbox" col_num="7" value="Texas" id="Texas" /><span>Texas</span><br />';

        // Get survey special criterias
        $this->survey_special_criterias = Doctrine_Core::getTable('LtSpecialCriteria')->findAll();
        $this->survey_special_criterias_checkboxes = "";
        foreach ($this->survey_special_criterias as $special_criteria) {
            $s_criteria = $special_criteria->getName();
            $allS_criteria[]=$s_criteria;
            //$this->survey_special_criterias_checkboxes .= '<input checkbox_type="special_criteria" type="checkbox" class="special_criteria_checkbox" col_num="6" value="' . $s_criteria . '" id="' . $s_criteria . '" /><span>' . $s_criteria . '</span><br />';
        }
        sort($allS_criteria);
        $sorted_criterias[0] = "Age";
        $sorted_criterias[1] ="Community or civic";
        $sorted_criterias[2] ="Minority";
        $sorted_criterias[3] ="Pro bono";
        $sorted_criterias[4] ="Women";
        $sorted_criterias[5] ="Years in Practice";

        foreach(/*$allS_criteria*/$sorted_criterias as $s_criterias){
            $this->survey_special_criterias_checkboxes .= '<input checkbox_type="special_criteria" type="checkbox" class="special_criteria_checkbox" col_num="6" value="' . $s_criterias . '" id="' . $s_criterias . '" /><span>' . $s_criterias . '</span><br />';
        }
    }

    /**
     * Get surveys with ajax request
     * 
     * @param sfWebRequest $request     Request object
     * 
     * @return array                    JSON array with response message
     */
    public function executeGetSurveys(sfWebRequest $request) {
        if ($request->isXmlHttpRequest()) {
            $i = 0;

            // Get all surveys
            $t1 = microtime();
            //$surveys = Doctrine_Core::getTable("LtSurvey")->getAllSurveys();
            $query = "SELECT surveys.year, surveys.keywords, surveys.id AS id, surveys.submission_deadline, surveys.survey_description, surveys.candidate_type, surveys.is_list, surveys.is_legal, surveys.organization_id, surveys.survey_name, organizations.name AS organization_name, regions.name AS region_name, surveys.survey_region_id,
                    (SELECT GROUP_CONCAT( cities.name ) AS
                    NAMES
                    FROM cities
                    LEFT JOIN survey_cities ON cities.id = survey_cities.city_id
                    WHERE survey_cities.survey_id = surveys.id
                    GROUP BY survey_cities.survey_id
                    ) AS city_name,

                    (SELECT GROUP_CONCAT( countries.name ) AS
                    NAMES
                    FROM countries
                    LEFT JOIN survey_countries ON countries.id = survey_countries.country_id
                    WHERE survey_countries.survey_id = surveys.id
                    GROUP BY survey_countries.survey_id
                    ) AS country_name,

                    (SELECT GROUP_CONCAT( practice_areas.name ) AS
                    NAMES
                    FROM practice_areas
                    LEFT JOIN survey_practice_areas ON practice_areas.id = survey_practice_areas.practice_area_id
                    WHERE survey_practice_areas.survey_id = surveys.id
                    GROUP BY survey_practice_areas.survey_id
                    ) AS practice_area_name,

                    (SELECT GROUP_CONCAT( special_criterias.name ) AS
                    NAMES
                    FROM special_criterias
                    LEFT JOIN survey_special_criterias ON special_criterias.id = survey_special_criterias.special_criteria_id
                    WHERE survey_special_criterias.survey_id = surveys.id
                    GROUP BY survey_special_criterias.survey_id
                    ) AS special_criteria_name,

                    (SELECT GROUP_CONCAT( states.name ) AS
                    NAMES
                    FROM states
                    LEFT JOIN survey_states ON states.id = survey_states.state_id
                    WHERE survey_states.survey_id = surveys.id
                    GROUP BY survey_states.survey_id
                    ) AS state_name

                    FROM surveys
                    LEFT JOIN organizations ON surveys.organization_id = organizations.id
                    LEFT JOIN regions ON surveys.survey_region_id = regions.id";
            $surveys = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($query)->fetchAll();
            //var_dump($surveys);die;
            if (isset($surveys) && !empty($surveys)) {
                $aa_data_array = array("aaData" => array());

                foreach ($surveys as $key => $survey) {
                    // Set survey checkbox
                    $survey_checkbox = "<input type='checkbox' class='table_checkbox' style='margin-right: 5px;' s_id='" . $survey['id'] . "' />"."<a href='#' style='margin-left: 8px; margin-top: 2px;' class='custom_link email_link' s_id='" . $survey['id'] . "'><span class='genericon genericon-mail'></span></a>";

                    // Set year
                    $year = (!is_null($survey['year']) && $survey['year'] != "" && $survey['year'] != 0) ? $survey['year'] : "- - -";

                    // Set organization
                    $organization = (!is_null($survey['organization_id']) && $survey['organization_id'] != "") ? $this->CheckStringLength($survey['organization_name'], 50) : "- - -";

                    // Set survey name
                    //$survey_name = (!is_null($survey->getSurveyName()) && $survey->getSurveyName() != "") ? $this->CheckStringLength($survey->getSurveyName()) : "- - -";
                    $survey_name = (!is_null($survey['survey_name']) && $survey['survey_name'] != "") ? $this->CheckStringLength($survey['survey_name'], 50) : "- - -";

                    // Set survey name link
                    $survey_name_link = "<a href='#' class='custom_link details_link' s_id='" . $survey['id'] . "'>" . $this->CheckStringLength($survey_name, 50) . "</a>";

                    $isList = (!is_null($survey['is_list']) && $survey['is_list'] == "1") ? 'List' : "Award";
                    $isLegal = (!is_null($survey['is_legal']) && $survey['is_legal'] == "1") ? 'Legal' : "Business";

                    // Set candidate type
                    if($survey['candidate_type'] != "")
                    {
                        $candidate_type = $survey['candidate_type'];
                    }
                    else
                    {
                        $candidate_type = "- - -";
                    }
                    // Set practice area
                    $practice_areas = "- - -";
                    if ($survey['practice_area_name']) {
                        $practice_areas = $survey['practice_area_name'];
                    }

                    // Set special criteria
                    $special_criterias = "- - -";
                    if ($survey['special_criteria_name']) {
                        $special_criterias = $survey['special_criteria_name'];
                    }

                    // Set region
                    $region = (!is_null($survey['survey_region_id']) && $survey['survey_region_id'] != "") ? $this->CheckStringLength($survey['region_name'], 50) : "- - -";

                    // Set cities
                    $cities = "- - -";
                    if ($survey['city_name']) {
                        $cities = $survey['city_name'];
                    }
                    
                    // Set states
                    $states = "- - -";
                    if ($survey['state_name']) {
                        $states = $survey['state_name'];
                    }
                    
                    // Set countries
                    $countries = "- - -";
                    if ($survey['country_name']) {
                        $countries = $survey['country_name'];
                    }

                    //Keywords

                    $keywords = "- - -";
                    if($survey['keywords'] != "")
                    {
                        $keywords =  $survey['keywords'];
                    }

                    // Set submission deadline
                    $submission_deadline = (!is_null($survey['submission_deadline']) && $survey['submission_deadline'] != "") ? date("d-M-Y", strtotime($this->CheckStringLength($survey['submission_deadline'], 50))) : "- - -";

                    // Set eligibility
                    //$eligibility = (!is_null($survey['eligibility_criteria']) && $survey['eligibility_criteria'] != "") ? $this->CheckStringLength($survey['eligibility_criteria'], 50) : "- - -";
                    
                    // Set description
                    $description = (!is_null($survey['survey_description']) && $survey['survey_description'] != "") ? $this->CheckStringLength($survey['survey_description'], 50) : "- - -";

                    // Set methodology
                    //$methodology = (!is_null($survey['selection_methodology']) && $survey['selection_methodology'] != "") ? $this->CheckStringLength($survey['selection_methodology'], 50) : "- - -";

                    // Set email
                    $email_link = null;//"<a href='#' class='custom_link email_link' s_id='" . $survey->getId() . "'><span class='genericon genericon-mail'></span></a>";

                    $aa_data_array['aaData'][$i] = array(
                        $survey_checkbox,
                        $year,
                        $organization,
                        $survey_name_link,
                        $candidate_type,
                        $practice_areas,
                        $special_criterias,
                        $region,
                        $cities,
                        $states,
                        $countries,
                        $submission_deadline,
                        $description,
                        $keywords,
                        $isList,
                        $isLegal
                        //$email_link,
                    );

                    $i++;
                }

                $response_array = $aa_data_array;
            } else {
                $response_array = array("aaData" => array());
            }

            return $this->renderText(
                json_encode(
                    $response_array
                )
            );
        }

        $this->redirect404();
    }

    public function executeGetSurveysByYear(sfWebRequest $request) {
        if ($request->isXmlHttpRequest()) {
            $i = 0;

            // Get all surveys
            $surveys = Doctrine_Core::getTable("LtSurvey")->getSurveysByYear();

            if (isset($surveys) && $surveys->getFirst()) {

                $aa_data_array = array("aaData" => array());

                foreach ($surveys as $survey) {

                    // Set survey checkbox
                    $survey_checkbox = "<input type='checkbox' class='table_checkbox' style='float:left' s_id='" . $survey->getId() . "' />"."<a href='#' style='float:right' class='custom_link email_link' s_id='" . $survey->getId() . "'><span class='genericon genericon-mail'></span></a>";

                    // Set year
                    $year = (!is_null($survey->getYear()) && $survey->getYear() != "" && $survey->getYear() != 0) ? $survey-> getYear() : "- - -";

                    // Set organization
                    $organization = (!is_null($survey->getOrganizationId()) && $survey->getOrganizationId() != "") ? $this->CheckStringLength($survey->getOrganization()->getName(), 50) : "- - -";

                    // Set survey name
                    //$survey_name = (!is_null($survey->getSurveyName()) && $survey->getSurveyName() != "") ? $this->CheckStringLength($survey->getSurveyName()) : "- - -";
                    $survey_name = (!is_null($survey->getSurveyName()) && $survey->getSurveyName() != "") ? $this->CheckStringLength($survey->getSurveyName(), 50) : "- - -";

                    // Set survey name link
                    $survey_name_link = "<a href='#' class='custom_link details_link' s_id='" . $survey->getId() . "'>" . $this->CheckStringLength($survey_name, 50) . "</a>";

                    $isList = (!is_null($survey->getIsList()) && $survey->getIsList() == "1") ? 'List' : "Award";
                    $isLegal = (!is_null($survey->getIsLegal()) && $survey->getIsLegal() == "1") ? 'Legal' : "Business";

                    // Set candidate type
                    $candidate_type = (isset(LtSurvey::$candidate_types_array[$survey->getCandidateType()]) && !is_null($survey->getCandidateType()) && $survey->getCandidateType() != "" && $survey->getCandidateType() != "0") ? $this->CheckStringLength(LtSurvey::$candidate_types_array[$survey->getCandidateType()], 50) : "- - -";

                    // Set practice area
                    $practice_areas = "- - -";
                    if ($survey->getLtSurveyPracticeArea()->getFirst()) {
                        $practice_area_array = array();
                        foreach ($survey->getLtSurveyPracticeArea() as $practice_area) {
                            $practice_area_array[] = $practice_area->getPracticeArea()->getShortCode();
                        }

                        $practice_areas = $this->CheckStringLength(implode(", ", $practice_area_array), 50);
                    }

                    // Set special criteria
                    $special_criterias = "- - -";
                    if ($survey->getLtSurveySpecialCriteria()->getFirst()) {
                        $special_criteria_array = array();
                        foreach ($survey->getLtSurveySpecialCriteria() as $special_criteria) {
                            $special_criteria_array[] = $special_criteria->getSpecialCriteria()->getName();
                        }

                        $special_criterias = $this->CheckStringLength(implode(", ", $special_criteria_array), 50);
                    }

                    // Set region
                    $region = (!is_null($survey->getSurveyRegionId()) && $survey->getSurveyRegionId() != "") ? $this->CheckStringLength($survey->getRegion()->getName(), 50) : "- - -";

                    // Set cities
                    $cities = "- - -";
                    if ($survey->getLtSurveyCity()->getFirst()) {
                        $cities_array = array();
                        foreach ($survey->getLtSurveyCity() as $city) {
                            $cities_array[] = $city->getCity()->getName();
                        }

                        $cities = $this->CheckStringLength(implode(", ", $cities_array), 50);
                    }

                    // Set states
                    $states = "- - -";
                    if ($survey->getLtSurveyState()->getFirst()) {
                        $states_array = array();
                        foreach ($survey->getLtSurveyState() as $state) {
                            $states_array[] = $state->getState()->getName();
                        }

                        $states = $this->CheckStringLength(implode(", ", $states_array), 50);
                    }

                    // Set countries
                    $countries = "- - -";
                    if ($survey->getLtSurveyCountry()->getFirst()) {
                        $countries_array = array();
                        foreach ($survey->getLtSurveyCountry() as $country) {
                            $countries_array[] = $country->getCountry()->getName();
                        }

                        $countries = $this->CheckStringLength(implode(", ", $countries_array), 50);
                    }
                     //Keywords

                    $query = 'SELECT keywords FROM surveys WHERE id="'. $survey->getId() .'"';
                    $resquery = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($query)->fetchAll();
                    $keywords = "- - -";
                    if(isset($resquery[0]['keywords']) && !empty($resquery[0]['keywords']) && $resquery[0]['keywords']!=' ')
                    {
                        $keywords =  $resquery[0]['keywords'];
                    }

                    // Set submission deadline
                    $submission_deadline = (!is_null($survey->getSubmissionDeadline()) && $survey->getSubmissionDeadline() != "") ? $this->CheckStringLength($survey->getSubmissionDeadline(), 50) : "- - -";

                    // Set eligibility
                    //$eligibility = (!is_null($survey->getEligibilityCriteria()) && $survey->getEligibilityCriteria() != "") ? $this->CheckStringLength($survey->getShortEligibilityCriteria(), 50) : "- - -";

                    // Set description
                    $description = (!is_null($survey->getSurveyDescription()) && $survey->getSurveyDescription() != "") ? $this->CheckStringLength($survey->getShortSurveyDescription(), 50) : "- - -";

                    // Set methodology
                    //$methodology = (!is_null($survey->getSelectionMethodology()) && $survey->getSelectionMethodology() != "") ? $this->CheckStringLength($survey->getShortSelectionMethodology(), 50) : "- - -";

                    // Set email
                    $email_link = null;//"<a href='#' class='custom_link email_link' s_id='" . $survey->getId() . "'><span class='genericon genericon-mail'></span></a>";


                    $aa_data_array['aaData'][$i] = array(
                        $survey_checkbox,
                        $year,
                        $organization,
                        $survey_name_link,
                        $candidate_type,
                        $practice_areas,
                        $special_criterias,
                        $region,
                        $cities,
                        $states,
                        $countries,
                        $submission_deadline,
                        //$eligibility,
                        $description,
                        //$methodology,
                        $keywords,
                        $isList,
                        $isLegal
                        //$email_link,
                    );

                    $i++;
                }

                $response_array = $aa_data_array;
            } else {
                $response_array = array("aaData" => array());
            }
            return $this->renderText(
                json_encode(
                    $response_array
                )
            );
        }

        $this->redirect404();
    }

    protected function CheckStringLengthDescription($string, $length)
    {
        if (strlen($string) > $length) {

            $stringCut = substr($string, 0, $length);

            $string = substr($stringCut, 0, strrpos($stringCut, ' ')).'<span class="more" style="cursor:pointer; color:#ff6801;"> ...more</span>';
        }
        return $string;
    }

    protected function CheckStringLength($string, $length)
    {
        if (strlen($string) > $length) {

            $stringCut = substr($string, 0, $length);

            $string = substr($stringCut, 0, strrpos($stringCut, ' ')).'...';
        }
        return $string;
    }

    protected function CheckURLLength($string, $length)
    {
        if (strlen($string) > $length) {

            $stringCut = substr($string, 0, $length);

            $string = $stringCut.'...'."'".'</a>';
        }
        return $string;
    }

    /**
     * Sending email message with survey information
     * 
     * @param sfWebRequest $request     Request object
     * 
     * @return array                    JSON array with response message
     */
    public function executeSendEmail() {
        if ($request->isXmlHttpRequest() && $this->getUser()->isAuthenticated()) {die("A");
            // Get request parameters
            $survey_ids         = $request->getParameter("survey_ids", FALSE);
            $email_address      = $request->getParameter("email_address", FALSE);
            $survey_name        = $request->getParameter("message", FALSE);
            $organization       = $request->getParameter("organization", FALSE);

            //var_dump("name - ".$survey_name);die;
            $email_cc           = $request->getParameter("cc", FALSE);
            $cc = array();
            $cc_for_log = array();
            if($email_cc)
            {
                $email_me = 1;
            }
            else
            {
                $email_me = 0;
            }

            $additional_message = $request->getParameter("message", FALSE);


            $cc_for_log = implode(", ", $cc_for_log);
            if(count($survey_ids)>1)
            {
                //save info in log file
                $final_filename = $this->getUser()->getAttribute('log_file_name');
                $logPath = sfConfig::get('sf_log_dir').'/'.$final_filename;
                $custom_logger = new sfFileLogger(new sfEventDispatcher(), array('file' => $logPath));
                $s_ids = implode(", ", $survey_ids);
                $custom_logger->info("Directory | Envelope | Send | Award: ".$survey_name."; ".$organization." | ".$s_ids." | ".$cc_for_log." | ".$additional_message);

            }
            else
            {
                $s_ids = implode(" ", $survey_ids);

                //save info in log file
                $final_filename = $this->getUser()->getAttribute('log_file_name');
                $logPath = sfConfig::get('sf_log_dir').'/'.$final_filename;
                $custom_logger = new sfFileLogger(new sfEventDispatcher(), array('file' => $logPath));
                $s_ids = implode(", ", $survey_ids);

                if($email_me == 0)
                {
                    $custom_logger->info("Directory | Envelope | Send | Award: ".$survey_name."; ".$organization." | ".$s_ids." | ".$cc_for_log." | ".$additional_message);

                }
                if($email_me == 1)
                {
                    $custom_logger->info("Directory | Dashboard Award | EmailMe | Award:  ".$survey_name."; ".$organization." | ".$s_ids);

                }
                
            }
            

            
            
            

            if ($survey_ids) {
                // Check if surveys exists
                $surveys = Doctrine_Core::getTable("LtSurvey")->getSurveysByIds($survey_ids);

                
                if ($surveys->getFirst()) {
                    // Get user
                    $user = $this->getUser()->getGuardUser();
                    // Get recipient email address
                    $recipient_email_address = $user->getEmailAddress();

                    if ($email_address !== false && !empty($email_address)) {
                        $recipient_email_address = $email_address;
                    }

                    // Send email message
                    $message = Swift_Message::newInstance();
                    $message->setFrom($user->getEmailAddress())
                            ->setTo($recipient_email_address)
                            ->setCc($cc)
                            ->setSubject("LexLists E-mail")
                            ->setBody($this->getPartial("dashboard/survey_email_or_print", array("surveys" => $surveys, "additional_message" => $additional_message)))
                            ->setContentType("text/html");

                    $send_status = $this->getMailer()->send($message);

                    // Check sending status//
                    $status = false;
                    if ($send_status == 1) {
                        $status = true;
                    }


                    return $this->renderText(
                        json_encode(
                            array(
                                "status" => $status
                            )
                        )
                    );
                }
            }
        }

        $this->redirect404();
    }

    public function executeSetStatesMapsLog(sfWebRequest $request)
    {
        if ($request->isXmlHttpRequest()) {
            // Get request parameters
            $states = '';
            $title = $request->getParameter("title", FALSE);
            $search = $request->getParameter("search", FALSE);

            if(isset($search) && !empty($search))
            {
                //save info in log file
                $final_filename = $this->getUser()->getAttribute('log_file_name');
                $logPath = sfConfig::get('sf_log_dir').'/'.$final_filename;
                $custom_logger = new sfFileLogger(new sfEventDispatcher(), array('file' => $logPath));   

            
                $custom_logger->info("Directory | Map | Open | ".$search.$title);
            }
            else
            {
                foreach ($title as $key => $value) 
                {                    
                    $states[] = $value[0];
                }
                $states = implode(', ', $states);
                //var_dump($states);die;
                //save info in log file
                $final_filename = $this->getUser()->getAttribute('log_file_name');
                $logPath = sfConfig::get('sf_log_dir').'/'.$final_filename;
                $custom_logger = new sfFileLogger(new sfEventDispatcher(), array('file' => $logPath));   
                $custom_logger->info("Directory | Map | Open | US States Map | ".$states);
            }
            
        }
    }

    public function executeSetWorldRegionsMapsLog(sfWebRequest $request)
    {
        if ($request->isXmlHttpRequest()) {
            // Get request parameters
            $states = '';
            $title = $request->getParameter("title", FALSE);
            $search = $request->getParameter("search", FALSE);
          
            if (isset($search) && !empty($search)) 
            {
                //save info in log file
                $final_filename = $this->getUser()->getAttribute('log_file_name');
                $logPath = sfConfig::get('sf_log_dir').'/'.$final_filename;
                $custom_logger = new sfFileLogger(new sfEventDispatcher(), array('file' => $logPath));
            
                $custom_logger->info("Directory | Map | Open | ".$search.$title);
            }
            else
            {
                $states = implode(', ', $title);
                //var_dump($states);die;
                //save info in log file
                $final_filename = $this->getUser()->getAttribute('log_file_name');
                $logPath = sfConfig::get('sf_log_dir').'/'.$final_filename;
                $custom_logger = new sfFileLogger(new sfEventDispatcher(), array('file' => $logPath));       

                $custom_logger->info("Directory | Map | Open | World Regions Map: ".$states);
            }

            
        }
    }
    public function executeSetUSRegionsMapsLog(sfWebRequest $request)
    {
        if ($request->isXmlHttpRequest()) {
            // Get request parameters
            $states = '';
            $title = $request->getParameter("title", FALSE);
            $search = $request->getParameter("search", FALSE);
          
            if (isset($search) && !empty($search)) 
            {
                //save info in log file
                $final_filename = $this->getUser()->getAttribute('log_file_name');
                $logPath = sfConfig::get('sf_log_dir').'/'.$final_filename;
                $custom_logger = new sfFileLogger(new sfEventDispatcher(), array('file' => $logPath));
            
                $custom_logger->info("Directory | Map | Open | ".$search.$title);
            }
            else
            {
                $states = implode(', ', $title);
                //var_dump($states);die;
                //save info in log file
                $final_filename = $this->getUser()->getAttribute('log_file_name');
                $logPath = sfConfig::get('sf_log_dir').'/'.$final_filename;
                $custom_logger = new sfFileLogger(new sfEventDispatcher(), array('file' => $logPath));       

                $custom_logger->info("Directory | Map | Open | US Regions Map: ".$states);
            }
            
        }
    }

    public function executeSetMapsLog(sfWebRequest $request)
    {
        if ($request->isXmlHttpRequest()) {
            // Get request parameters
            $title = $request->getParameter("title", FALSE);

            //save info in log file
            $final_filename = $this->getUser()->getAttribute('log_file_name');
            $logPath = sfConfig::get('sf_log_dir').'/'.$final_filename;
            $custom_logger = new sfFileLogger(new sfEventDispatcher(), array('file' => $logPath));       

            $custom_logger->info("Directory | Dashboard | Open | ".$title);
        }
    }

    public function executeCancelMapLog(sfWebRequest $request)
    {
        if ($request->isXmlHttpRequest()) {
            // Get request parameters
            $title = $request->getParameter("title", FALSE);
            //var_dump($title);die;
            if ($title == "container") 
            {
                $mapname = "World Regions Map";
            }
            if ($title == "container_us") 
            {   
                $mapname = "US Regions Map";
            }
            if ($title == "container_us_states") 
            {
                $mapname = "US States Map";
            }
            //$title = ltrim($title, "LexLists: ");
            //save info in log file
            $final_filename = $this->getUser()->getAttribute('log_file_name');
            $logPath = sfConfig::get('sf_log_dir').'/'.$final_filename;
            $custom_logger = new sfFileLogger(new sfEventDispatcher(), array('file' => $logPath));       

            $custom_logger->info("Directory | Map | Cancel | Search ".$mapname);
        }
    }
    public function executeCancelEmailLog(sfWebRequest $request)
    {
        if ($request->isXmlHttpRequest()) {
            // Get request parameters
            $survey_id          = $request->getParameter("survey_id", FALSE);
            $survey_name        = $request->getParameter("survey_name", FALSE);
            $organization       = $request->getParameter("organization", FALSE);

            //save info in log file
            $final_filename = $this->getUser()->getAttribute('log_file_name');
            $logPath = sfConfig::get('sf_log_dir').'/'.$final_filename;
            $custom_logger = new sfFileLogger(new sfEventDispatcher(), array('file' => $logPath));       

            $custom_logger->info("Directory | Envelope | Cancel | Award: ".$survey_name."; ".$organization." | ".$survey_id);
        }
    }

    /**
     * Printing of calendar
     *
     * @param sfWebRequest $request     Request object
     *
     * @return string       HTML for print
     */
    public function executePrintCalendar(sfWebRequest $request) {
        $date = date("F o");
        $calendar_type = $_POST['calendar_type'];
        $ducument_name = "---";

        $session_user_id = $_SESSION['symfony/user/sfUser/attributes']['sfGuardSecurityUser']['user_id'];

        $query1 = 'SELECT c.`name` FROM `clients` AS c JOIN `sf_guard_user` AS sgu ON sgu.`client_id` = c.`id` WHERE sgu.`id` = '. $session_user_id.'';
        $name1 = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($query1)->fetch();
        $survey_client_name = $name1['name'];

        $query = 'SELECT `first_name`, `last_name` FROM `sf_guard_user` WHERE `id` = '.$session_user_id.'';
        $name = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($query)->fetch();
        $survey_first_name = $name['first_name'];
        $survey_last_name = $name['last_name'];

        $this->getContext()->getConfiguration()->loadHelpers('tcpdf_include','tcpdf');

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(true);
        $pdf->setFooterData(array(0,0,0), array(255,255,255));
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, /*PDF_MARGIN_TOP,*/'', PDF_MARGIN_RIGHT);
        $pdf->SetTopMargin(16);
        $pdf->SetLeftMargin(40);
        $pdf->SetRightMargin(40);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('dejavusans', '', 12, '', true);
        $pdf->AddPage();
        $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
        $pdf->SetFooterMargin(20);
        $pdf->SetLeftMargin(105);

        $pdf->SetLeftMargin(20);
        $html1 = '<h3 style="font-size: 5mm; line-height: 100%;">Lex<span style="color:#ff6801; font-size: 5mm;">Lists</span></h3>';
        $pdf->writeHTML($html1, true, false, true, false, '');

        $pdf->Text(150, 10, '');
        $pdf->SetLeftMargin(155);
        $pdf->SetRightMargin(20);
        $html4 ='
               <div style="line-height: 70%;">
                   <h2 style="text-align: center; font-family: Georgia, serif; font-size: 4mm;">'.$survey_client_name.'</h2>
                   <h2 style="text-align: center; font-family: Georgia, serif; font-size: 4mm; font-weight: normal;"><i>'.$survey_first_name.'&nbsp;'.$survey_last_name.'</i></h2>

               </div>';

        $pdf->writeHTML($html4, true, false, true, false, '');

        if($calendar_type == "month")
        {
            $datemonth = $_POST['month'];
            $ducument_name = $datemonth;
            $first_day = "01 ". $datemonth;
            $first_day = strtotime($first_day);
            $first_day = date('Y-m-d', $first_day);
            $last_day = strtotime($first_day." + 1 month - 1 day");
            $last_day = date('Y-m-d', $last_day);

            $checkingquery = 'SELECT `s`.`id`, `s`.`survey_name`, `s`.`submission_deadline`, `o`.`name` FROM `surveys` AS `s` JOIN `organizations` AS `o` ON `s`.`organization_id` = `o`.`id` WHERE `s`.`submission_deadline` >= "'.$first_day.'" AND `s`.`submission_deadline` <= "'.$last_day.'" ORDER BY `s`.`submission_deadline`';
            $resultupdate = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($checkingquery)->fetchAll();

            $pdf->SetLeftMargin(105);
            $pdf->Text(100, 20, '');
            $html ='
                <div style="line-height: 70%;">
                    <h2 style="text-align: center; font-family: Georgia, serif; font-size: 4mm; font-weight: normal;">'.$datemonth.'</h2>
                </div>';
            $pdf->writeHTML($html, true, false, true, false, '');

            $pdf->SetLeftMargin(20);
            $pdf->SetRightMargin(20);
            $pdf->Text(10, 40, '');
            $html = '<div style="line-height: 100%;">';
            $deaslines_array = array();
            $surveysforlog = array();
            $i = 0;
            foreach($resultupdate as $res)
            {
                $deaslines_array [$res['submission_deadline']][$i]['survey_name'] = $res['survey_name'];
                $deaslines_array [$res['submission_deadline']][$i]['name'] = $res['name'];

                $surveysforlog[] = $res['survey_name'].'; '.$res['name'].' | '.$res['id'];
                $i++;
            }

            foreach($deaslines_array as $date=>$deadline)
            {
                $html .='
                    <h2 style="text-align: left; font-family: Georgia, serif; font-size: 4.5mm;">'.date('j F Y', strtotime($date)).'</h2>';

                foreach($deadline as $value)
                {
                    $html .='
                    <h2 style="text-align: left; font-family: Georgia, serif; font-size: 4mm; font-weight: normal;">- <i>'.$value['survey_name']."</i>, ".$value['name'].'</h2>';
                }
            }
            $html .='</div>';
            $pdf->writeHTML($html, true, false, true, false, '');

        }

        if($calendar_type == "year")
        {
            $datemonth = $_POST['month'];
            $ducument_name = $datemonth;
            $year_start = $datemonth."-01-01";
            $year_end = $datemonth."-12-31";

            $checkingquery = 'SELECT `s`.`id`, `s`.`survey_name`, `s`.`submission_deadline`, `o`.`name` FROM `surveys` AS `s` JOIN `organizations` AS `o` ON `s`.`organization_id` = `o`.`id` WHERE `s`.`submission_deadline` >= "'.$year_start.'" AND `s`.`submission_deadline` <= "'.$year_end.'" ORDER BY `s`.`submission_deadline`';
            $resultupdate = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($checkingquery)->fetchAll();

            $pdf->SetLeftMargin(105);
            $pdf->Text(100, 20, '');
            $html ='
                <div style="line-height: 70%;">
                    <h2 style="text-align: center; font-family: Georgia, serif; font-size: 4mm; font-weight: normal;">'.$datemonth.'</h2>
                </div>';
            $pdf->writeHTML($html, true, false, true, false, '');

            $pdf->SetLeftMargin(20);
            $pdf->SetRightMargin(20);
            $pdf->Text(10, 40, '');
            $html = '<div style="line-height: 100%;">';
            $deaslines_array = array();
            $surveysforlog = array();
            $i = 0;
            foreach($resultupdate as $res)
            {
                $deaslines_array [$res['submission_deadline']][$i]['survey_name'] = $res['survey_name'];
                $deaslines_array [$res['submission_deadline']][$i]['name'] = $res['name'];

                $surveysforlog[] = $res['survey_name'].'; '.$res['name'].' | '.$res['id'];
                
                $i++;
            }

            foreach($deaslines_array as $date=>$deadline)
            {
                $html .='
                    <h2 style="text-align: left; font-family: Georgia, serif; font-size: 4.5mm;">'.date('j F Y', strtotime($date)).'</h2>';

                foreach($deadline as $value)
                {
                    $html .='
                    <h2 style="text-align: left; font-family: Georgia, serif; font-size: 4mm; font-weight: normal;">- <i>'.$value['survey_name']."</i>, ".$value['name'].'</h2>';
                }
            }
            $html .='</div>';
            $pdf->writeHTML($html, true, false, true, false, '');

        }

        if($calendar_type == "week")
        {
            $datemonth = $_POST['month'];
            $ducument_name = $datemonth;

            $d = explode(" ",$datemonth);
            $week = $d[1];
            $year = $d[3];
            $week_number = strtotime($year."-01-01"." + ".($week-1)." week");
            $x = date("Y-m-d",$week_number);
            $week_day_number = date("N", $week_number);

            $diff_days = 7-($week_day_number -1);
            $week_start = strtotime($x." - ".$diff_days." day");

            $week_end = strtotime(date("Y-m-d",$week_start)." + 6 day");
            $week_start = date("Y-m-d",$week_start);
            $week_end = date("Y-m-d",$week_end);

            $checkingquery = 'SELECT `s`.`id`, `s`.`survey_name`, `s`.`submission_deadline`, `o`.`name` FROM `surveys` AS `s` JOIN `organizations` AS `o` ON `s`.`organization_id` = `o`.`id` WHERE `s`.`submission_deadline` >= "'.$week_start.'" AND `s`.`submission_deadline` <= "'.$week_end.'" ORDER BY `s`.`submission_deadline`';
            $resultupdate = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($checkingquery)->fetchAll();

            $pdf->SetLeftMargin(105);
            $pdf->Text(100, 20, '');
            $html ='
                <div style="line-height: 70%;">
                    <h2 style="text-align: center; font-family: Georgia, serif; font-size: 4mm; font-weight: normal;">'.$datemonth.'</h2>
                </div>';
            $pdf->writeHTML($html, true, false, true, false, '');

            $pdf->SetLeftMargin(20);
            $pdf->SetRightMargin(20);
            $pdf->Text(10, 40, '');
            $html = '<div style="line-height: 100%;">';
            $deaslines_array = array();
            $surveysforlog = array();
            $i = 0;
            foreach($resultupdate as $res)
            {
                $deaslines_array [$res['submission_deadline']][$i]['survey_name'] = $res['survey_name'];
                $deaslines_array [$res['submission_deadline']][$i]['name'] = $res['name'];

                $surveysforlog[] = $res['survey_name'].'; '.$res['name'].' | '.$res['id'];

                $i++;
            }

            foreach($deaslines_array as $date=>$deadline)
            {
                $html .='
                    <h2 style="text-align: left; font-family: Georgia, serif; font-size: 4.5mm;">'.date('j F Y', strtotime($date)).'</h2>';

                foreach($deadline as $value)
                {
                    $html .='
                    <h2 style="text-align: left; font-family: Georgia, serif; font-size: 4mm; font-weight: normal;">- <i>'.$value['survey_name']."</i>, ".$value['name'].'</h2>';
                }
            }
            $html .='</div>';
            $pdf->writeHTML($html, true, false, true, false, '');

        }

        $final_filename = $this->getUser()->getAttribute('log_file_name');
        $logPath = sfConfig::get('sf_log_dir').'/'.$final_filename;
        $custom_logger = new sfFileLogger(new sfEventDispatcher(), array('file' => $logPath));
        
        $surveysforlogfinal = implode(", ", $surveysforlog);

        $custom_logger->info('Directory | Calendar | Print | Award: '.$surveysforlogfinal);


        $pdf->Output("LexLists-Report-$ducument_name.pdf", 'I');die;
    }

    public function executeSetTextSearchLog(sfWebRequest $request)
    {
        $textsearch = $request->getParameter("current", FALSE);

        //save info in log file
        $final_filename = $this->getUser()->getAttribute('log_file_name');
        $logPath = sfConfig::get('sf_log_dir').'/'.$final_filename;
        $custom_logger = new sfFileLogger(new sfEventDispatcher(), array('file' => $logPath));
                                
        $custom_logger->info('Directory | Search Text | '.$textsearch);
    }

    public function executeSetURLLog(sfWebRequest $request)
    {
        $title = $request->getParameter("title", FALSE);
        $id = $request->getParameter("id", FALSE);
        $word = $request->getParameter("word", FALSE);
       
        //save info in log file
        $final_filename = $this->getUser()->getAttribute('log_file_name');
        $logPath = sfConfig::get('sf_log_dir').'/'.$final_filename;
        $custom_logger = new sfFileLogger(new sfEventDispatcher(), array('file' => $logPath));
                                
        $custom_logger->info('Directory | Dashboard Award | Open | '.$word.$title.' | '.$id);
    }

    public function executeSetFilterLog(sfWebRequest $request)
    {
        $title = $request->getParameter("title", FALSE);
        $action = $request->getParameter("filter_action", FALSE);
        $action = ucfirst($action);
        //var_dump($title.', '.$action);die;

        //save info in log file
        $final_filename = $this->getUser()->getAttribute('log_file_name');
        $logPath = sfConfig::get('sf_log_dir').'/'.$final_filename;
        $custom_logger = new sfFileLogger(new sfEventDispatcher(), array('file' => $logPath));
                                
        $custom_logger->info('Directory | Filter | '.$action.$title);
    }

    public function executeSetOpenEmailLog(sfWebRequest $request)
    {
        $title = $request->getParameter("title", FALSE);
        $action = $request->getParameter("filter_action", FALSE);
        //var_dump($title.', '.$action);die;

        //save info in log file
        $final_filename = $this->getUser()->getAttribute('log_file_name');
        $logPath = sfConfig::get('sf_log_dir').'/'.$final_filename;
        $custom_logger = new sfFileLogger(new sfEventDispatcher(), array('file' => $logPath));
                                
        $custom_logger->info('Directory - '.$action.$title);
    }
    
    /**
     * Printing of surveys
     * 
     * @param sfWebRequest $request     Request object
     * 
     * @return string       HTML for print
     */
    public function executePrintSurvey(sfWebRequest $request) {

        $date = date("d-M-Y");   


        $session_user_id = $_SESSION['symfony/user/sfUser/attributes']['sfGuardSecurityUser']['user_id'];

        $query1 = 'SELECT c.`name` FROM `clients` AS c JOIN `sf_guard_user` AS sgu ON sgu.`client_id` = c.`id` WHERE sgu.`id` = '. $session_user_id.'';
        $name1 = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($query1)->fetch();
        $survey_client_name = $name1['name'];

        $query = 'SELECT `first_name`, `last_name` FROM `sf_guard_user` WHERE `id` = '.$session_user_id.'';
        $name = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($query)->fetch();
        $survey_first_name = $name['first_name'];
        $survey_last_name = $name['last_name'];

        $this->getContext()->getConfiguration()->loadHelpers('tcpdf_include','tcpdf');

        // Get request parameters
        $survey_ids = $request->getParameter("surveys_for_print", FALSE);
        //print_r($survey_ids);
        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetPrintHeader(false);
        $pdf->SetPrintFooter(false);
        $pdf->setFooterData(array(0,0,0), array(255,255,255));
        $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, /*PDF_MARGIN_TOP,*/'', PDF_MARGIN_RIGHT);
        $pdf->SetTopMargin(16);
        $pdf->SetLeftMargin(40);
        $pdf->SetRightMargin(40);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        //$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFontSubsetting(true);
        $pdf->SetFont('dejavusans', '', 12, '', true);
        $pdf->AddPage();
        $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));
        $pdf->SetFooterMargin(45);
        $pdf->startPageGroup();
        $pdf->SetLeftMargin(105);

        if (count($survey_ids)>1)
        {
            $s_id_for_log = $survey_ids;
            $top = 0;
            $first_survey = true;
            $c = count($survey_ids);

            if(($c %2) != 0)
            {
                $last_footer = true;
            }else{
                $last_footer = false;
            }

            $s_names_for_log = array();
            foreach($survey_ids as $key =>$survey_id)
            {
                // Check if surveys exists
                $surveys = Doctrine_Core::getTable("LtSurvey")->getSurveysByIds($survey_id);
                foreach($surveys as $survey)
                {
                    if(!is_null($survey->getSurveyName()) && $survey->getSurveyName() != ""){
                        $survey_name = $survey->getSurveyName();
                        $s_names_for_log[] = $survey_name;
                    }else{
                        $survey_name = "- - -";
                    }

                    if ((!is_null($survey->getOrganizationId()) && $survey->getOrganizationId() != "")) {                        
                        $organization = $survey->getOrganization()->getName();                            
                    }else{
                        $organization = "- - -";
                    }

                    if(!is_null($survey->getSubmissionDeadline()) && $survey->getSubmissionDeadline() != ""){
                        $survey_submission_deadline = $survey->getSubmissionDeadline();
                    }else{
                        $survey_submission_deadline = "- - -";
                    }

                    if($survey->getCandidateType() != 0){
                        $survey_type = LtSurvey::$candidate_types_array[$survey->getCandidateType()];
                    }else{
                        $survey_type = "- - -";
                    }

                    $special_criterias = "- - -";
                    if ($survey->getLtSurveySpecialCriteria()->getFirst()) {
                        $special_criteria_array = array();
                        foreach ($survey->getLtSurveySpecialCriteria() as $special_criteria) {
                            $special_criteria_array[] = $special_criteria->getSpecialCriteria()->getName();
                        }

                        $special_criterias = implode(", ", $special_criteria_array);
                    }

                    // if(!is_null($survey->getEligibilityCriteria()) && $survey->getEligibilityCriteria() != ""){
                    //     $survey_eligibility = $survey->getEligibilityCriteria();
                    // }else{
                    //     $survey_eligibility = "- - -";
                    // }

                    $practice_areas = "- - -";
                    if ($survey->getLtSurveyPracticeArea()->getFirst()) {
                        $practice_area_array = array();
                        foreach ($survey->getLtSurveyPracticeArea() as $practice_area) {
                            $practice_area_array[] = $practice_area->getPracticeArea()->getShortCode();
                        }
                        $practice_areas = implode(", ", $practice_area_array);
                    }

                    $geographic_area = "- - -";
                    if($survey->getRegion()->getName() || $survey->getLtSurveyCity()->getFirst() || $survey->getLtSurveyState()->getFirst() || $survey->getLtSurveyCountry()->getFirst()) {
                        // Get region
                        $region = "";
                        if($survey->getRegion()) {
                            $region = $survey->getRegion()->getName();
                            if($region == '')
                            {
                                $region = "";
                            }
                            else
                            {
                                $region .= "; ";
                            }
                        }

                        // Get cities
                        $cities = "";

                        if ($survey->getLtSurveyCity()->getFirst()) {

                            $cities_array = array();
                            foreach ($survey->getLtSurveyCity() as $city) {
                                $cities_array[] = $city->getCity()->getName();
                            }
                            $cities = implode(", ", $cities_array);
                            $cities .= "; ";
                        }

                        // Get countries
                        $countries = "";
                        if($survey->getLtSurveyCountry()->getFirst()) {
                        }
                            $countries_array = array();
                            foreach ($survey->getLtSurveyCountry() as $country) {
                                $countries_array[] = $country->getCountry()->getName();
                            }
                            $countries = implode(", ", $countries_array);
                            $countries .= "; ";

                        // Get states
                        $states = "";
                        if($survey->getLtSurveyState()->getFirst()) {
                            $states_array = array();
                            foreach ($survey->getLtSurveyState() as $state) {
                                $states_array[] = $state->getState()->getName();
                            }
                            $states = implode(", ", $states_array);
                            $states .= "; ";
                        }

                        $geographic_area = $region . "" . $cities . "". $states . "" . $countries . "";
                        $geographic_area = rtrim($geographic_area, "; ");
                    }

                    if(!is_null($survey->getSurveyDescription()) && $survey->getSurveyDescription() != ""){
                        $survey_description = $survey->getSurveyDescription();
                    }else{
                        $survey_description = "- - -";
                    }

                    // if(!is_null($survey->getSelectionMethodology()) && $survey->getSelectionMethodology() != ""){
                    //     $survey_methodology = $survey->getSelectionMethodology();
                    // }else{
                    //     $survey_methodology = "- - -";
                    // }

                    // if(!is_null($survey->getNomination()) && $survey->getNomination() != ""){
                    //     $survey_how_to_apply = $survey->getNominationWithLinks();
                    //     //$this->CheckStringLength($survey_how_to_apply, 90);
                    // }else{
                    //     $survey_how_to_apply = "- - -";
                    // }

                    if($survey->getFrequency() != 0){
                        $survey_frequency = LtSurvey::$frequency_types_array[$survey->getFrequency()];
                    }else{
                        $survey_frequency = "- - -";
                    }

                    $survey_contact_person = ltrim(ltrim($survey->getContact()->getLastName() .
                        ", " .
                        $survey->getContact()->getFirstName() .
                        " (" .
                        $survey->getContact()->getEmailAddress() .
                        ")", ','), ' ');
                }

                //            if ($surveys->getFirst()) {
                //                $this->setLayout(false);
                //
                //                return $this->renderPartial("dashboard/survey_email_or_print", array("surveys" => $surveys, "additional_message" => false));
                //            }

                if($top == 0)
                {
                    $foot = false;
                    $pdf->SetLeftMargin(20);
                    $html1 = '<h3 style="font-size: 5mm; line-height: 100%;">Lex<span style="color:#ff6801; font-size: 5mm;">Lists</span></h3>';
                    $pdf->writeHTML($html1, true, false, true, false, '');

                    $pdf->Text(150, 10, '');
                    $pdf->SetLeftMargin(155);
                    $pdf->SetRightMargin(0);
                    $html4 = '
                       <div style="line-height: 70%;">
                           <h2 style="text-align: center; font-family: Georgia, serif; font-size: 4mm;">'.$survey_client_name.'</h2>
                           <h2 style="text-align: center; font-family: Georgia, serif; font-size: 4mm; font-weight: normal;"><i>'.$survey_first_name.'&nbsp;'.$survey_last_name.'</i></h2>

                       </div>';

                    $pdf->writeHTML($html4, true, false, true, false, '');

                    if($first_survey == true)
                    {
                        $first_survey = false;
                        $pdf->SetLeftMargin(105);
                        $pdf->Text(100, 20, '');
                        $html ='
                            <div style="line-height: 70%;">
                                <h2 style="text-align: center; font-family: Georgia, serif; font-size: 4mm;">Awards (Full Listing)</h2>
                                <h2 style="text-align: center; font-family: Georgia, serif; font-size: 4mm; font-weight: normal;">'.$date.'</h2>
                            </div>';
                        $pdf->writeHTML($html, true, false, true, false, '');
                    }

                    $pdf->SetLeftMargin(15);
                    $pdf->SetRightMargin(15);

                    $top = 1;
                }else{
                    $foot = true;
                    $top = 0;
                }

                $html_t ='
                    <div style="border-top: 1px solid black; "></div>

                    <table style=" font-size: 2.7mm;">
                        <tr>
                            <td width="115" style="text-align: right;">Award:</td>
                            <td width="510">'.$survey_name.'</td>
                        </tr>
                        <tr>
                            <td width="115" style="text-align: right;">Submission Deadline:</td>
                            <td width="510">'.$survey_submission_deadline.'</td>
                        </tr>
                        <tr>
                            <td width="115" style="text-align: right;">Type:</td>
                            <td width="510">'.$survey_type.'</td>
                        </tr>
                        <tr>
                            <td width="115" style="text-align: right;">Special Criteria(s):</td>
                            <td width="510">'.$special_criterias.'</td>
                        </tr>
                        
                        <tr>
                            <td width="115" style="text-align: right;">Practice Area(s):</td>
                            <td width="510">'.$practice_areas.'</td>
                        </tr>
                        <tr>
                            <td width="115" style="text-align: right;">Geographic Area:</td>
                            <td width="510">'.$geographic_area.'</td>
                        </tr>
                        <tr>
                            <td width="115" style="text-align: right;">Description:</td>
                            <td width="510">'.$survey_description.'</td>
                        </tr>
                        
                        <tr>
                            <td width="115" style="text-align: right;">Frequency:</td>
                            <td width="510">'.$survey_frequency.'</td>
                        </tr>
                        <tr>
                            <td width="115" style="text-align: right;">Contact Person:</td>
                            <td width="510">'.$survey_contact_person.'</td>
                        </tr>
                    </table>

                    <table style="padding-top: 1mm;">
                    <tr>
                    <td></td>
                    </tr>
                    </table>
                ';

                $pdf->writeHTML($html_t, true, false, true, false, '');

                if($foot == true)
                {

                    $page_number = $pdf->PageNo();
                    $pages = $pdf->getAliasNbPages();

                    $pdf->Text(150, 250, '');
                    $pdf->SetLeftMargin(180);
                    $pdf->SetRightMargin(-30);
                    $html = '<p style="font-size: 2.5mm; letter-spacing: 1mm;">'.$page_number.'/'.$pages.'</p>';
                    $pdf->writeHTML($html, true, false, true, false, '');

                    $pdf->Text(19, 255, '');
                    $pdf->SetLeftMargin(15);
                    $pdf->SetRightMargin(15);
                    $html5 = '
                    <p style="font-size: 3.6mm;font-weight: bold;">LexLists.com: Discover Awards!</p>

                    <p style="font-size: 2.7mm;">Sharing or using this output in any way outside its intended use is a violation of the License Terms & Agreement.
                    Copyright 2012-2015 LexLists by LexSource. All Rights Reserved.</p>
                    ';

                    $pdf->writeHTML($html5, true, false, true, false, '');
                }

            }
            if($last_footer == true)
            {
                $page_number = $pdf->PageNo();
                $pages = $pdf->getAliasNbPages();

                $pdf->Text(150, 250, '');
                $pdf->SetLeftMargin(180);
                $pdf->SetRightMargin(-30);
                $html = '<p style="font-size: 2.5mm; letter-spacing: 1mm;">'.$page_number.'/'.$pages.'</p>';
                $pdf->writeHTML($html, true, false, true, false, '');

                $pdf->Text(19, 255, '');
                $pdf->SetLeftMargin(15);
                $pdf->SetRightMargin(15);
                $html5 = '
                   <p style="font-size: 3.6mm;font-weight: bold;">LexLists.com: Discover Awards!</p>

                   <p style="font-size: 2.7mm;">Sharing or using this output in any way outside its intended use is a violation of the License Terms & Agreement.
                       Copyright 2012-2015 LexLists by LexSource. All Rights Reserved.</p>
                   ';

                $pdf->writeHTML($html5, true, false, true, false, '');
            }

            //save info in log file
            $final_filename = $this->getUser()->getAttribute('log_file_name');

            $logPath = sfConfig::get('sf_log_dir').'/'.$final_filename;
            $custom_logger = new sfFileLogger(new sfEventDispatcher(), array('file' => $logPath));
            $s_id_for_log = implode(", ",$s_id_for_log);
            $s_names_for_log = implode(", ", $s_names_for_log);
            
            $section = $request->getParameter("hidden_section_name_for_log", FALSE);
            //var_dump($section);die;
            if(isset($section) && $section == 'dashboard')
            {
                $custom_logger->info('Directory | Dashboard Award | Print | Award: '.$s_names_for_log.'; '.$organization.' | '.$s_id_for_log);

            }
            else
            {
                $custom_logger->info('Directory | My List Award | Print | Award: '.$s_names_for_log.'; '.$organization.' | '.$s_id_for_log);

            }
           
            

        }

        else{
            $pdf->SetLeftMargin(20);

            $html1 = '<h3 style="font-size: 5mm;">Lex<span style="color:#ff6801; font-size: 5mm;">Lists</span></h3>';
            $pdf->Text(100, 12, '');
            $pdf->writeHTML($html1, true, false, true, false, '');

            $pdf->SetLeftMargin(40);

            if ($survey_ids) {
                $s_id_for_log = $survey_ids;
                // Check if surveys exists
                $surveys = Doctrine_Core::getTable("LtSurvey")->getSurveysByIds($survey_ids);
                foreach($surveys as $survey)
                {
                    if(!is_null($survey->getSurveyName()) && $survey->getSurveyName() != ""){
                        $survey_name = $survey->getSurveyName();
                        $s_names_for_log = $survey_name;
                    }else{
                        $survey_name = "- - -";
                    }

                    if ((!is_null($survey->getOrganizationId()) && $survey->getOrganizationId() != "")) {                        
                        $organization = $survey->getOrganization()->getName();                            
                    }else{
                        $organization = "- - -";
                    }

                    if(!is_null($survey->getSubmissionDeadline()) && $survey->getSubmissionDeadline() != ""){
                        $survey_submission_deadline = $survey->getSubmissionDeadline();
                    }else{
                        $survey_submission_deadline = "- - -";
                    }

                    if($survey->getCandidateType() != 0){
                        $survey_type = LtSurvey::$candidate_types_array[$survey->getCandidateType()];
                    }else{
                        $survey_type = "- - -";
                    }

                    $special_criterias = "- - -";
                    if ($survey->getLtSurveySpecialCriteria()->getFirst()) {
                        $special_criteria_array = array();
                        foreach ($survey->getLtSurveySpecialCriteria() as $special_criteria) {
                            $special_criteria_array[] = $special_criteria->getSpecialCriteria()->getName();
                        }
                        $special_criterias = implode(", ", $special_criteria_array);
                    }

                    // if(!is_null($survey->getEligibilityCriteria()) && $survey->getEligibilityCriteria() != ""){
                    //     $survey_eligibility = $survey->getEligibilityCriteria();
                    // }else{
                    //     $survey_eligibility = "- - -";
                    // }

                    $practice_areas = "- - -";
                    if ($survey->getLtSurveyPracticeArea()->getFirst()) {
                        $practice_area_array = array();
                        foreach ($survey->getLtSurveyPracticeArea() as $practice_area) {
                            $practice_area_array[] = $practice_area->getPracticeArea()->getShortCode();
                        }
                        $practice_areas = implode(", ", $practice_area_array);
                    }

                    $geographic_area = "- - -";
                    if($survey->getRegion()->getName() || $survey->getLtSurveyCity()->getFirst() || $survey->getLtSurveyState()->getFirst() || $survey->getLtSurveyCountry()->getFirst()) {
                        // Get region
                        $region = "";
                        if($survey->getRegion()) {
                            $region = $survey->getRegion()->getName();
                            if($region == '')
                            {
                                $region = "";
                            }
                            else
                            {
                                $region .= "; ";
                            }

                        }

                        // Get cities
                        $cities = "";
                        if ($survey->getLtSurveyCity()->getFirst()) {
                            $cities_array = array();
                            foreach ($survey->getLtSurveyCity() as $city) {
                                $cities_array[] = $city->getCity()->getName();
                            }
                            $cities = implode(", ", $cities_array);
                            $cities .= "; ";
                        }

                        // Get countries
                        $countries = "";
                        if($survey->getLtSurveyCountry()->getFirst()) {
                            $countries_array = array();
                            foreach ($survey->getLtSurveyCountry() as $country) {
                                $countries_array[] = $country->getCountry()->getName();
                            }
                            $countries = implode(", ", $countries_array);
                            $countries .= "; ";
                        }

                        // Get states
                        $states = "";
                        if($survey->getLtSurveyState()->getFirst()) {
                            $states_array = array();
                            foreach ($survey->getLtSurveyState() as $state) {
                                $states_array[] = $state->getState()->getName();
                            }
                            $states = implode(", ", $states_array);
                            $states .= "; ";
                        }

                        $geographic_area = $region . "" . $cities . "". $states . "" . $countries . "";
                        $geographic_area = rtrim($geographic_area, "; ");
                    }

                    if(!is_null($survey->getSurveyDescription()) && $survey->getSurveyDescription() != ""){
                        $survey_description = $survey->getSurveyDescription();
                    }else{
                        $survey_description = "- - -";
                    }

                    // if(!is_null($survey->getSelectionMethodology()) && $survey->getSelectionMethodology() != ""){
                    //     $survey_methodology = $survey->getSelectionMethodology();
                    // }else{
                    //     $survey_methodology = "- - -";
                    // }

                    // if(!is_null($survey->getNomination()) && $survey->getNomination() != ""){
                    //     $survey_how_to_apply = $survey->getNominationWithLinks();
                    //     //$this->CheckURLLength($survey_how_to_apply, 90);
                    // }else{
                    //     $survey_how_to_apply = "- - -";
                    // }

                    if($survey->getFrequency() != 0){
                        $survey_frequency = LtSurvey::$frequency_types_array[$survey->getFrequency()];
                    }else{
                        $survey_frequency = "- - -";
                    }

                    $survey_contact_person = ltrim(ltrim($survey->getContact()->getLastName() .
                        ", " .
                        $survey->getContact()->getFirstName() .
                        " (" .
                        $survey->getContact()->getEmailAddress() .
                        ")", ','), ' ');
                }

                //            if ($surveys->getFirst()) {
                //                $this->setLayout(false);
                //
                //                return $this->renderPartial("dashboard/survey_email_or_print", array("surveys" => $surveys, "additional_message" => false));
                //            }

                $pdf->Text(150, 9, '');
                $pdf->SetLeftMargin(155);
                $pdf->SetRightMargin(0);
                $html ='
                    <div style="line-height: 70%;">
                        <h2 style="text-align: center; font-family: Georgia, serif; font-size: 4mm;">'.$survey_client_name.'</h2>
                        <h2 style="text-align: center; font-family: Georgia, serif; font-size: 4mm; font-weight: normal;"><i>'.$survey_first_name.'&nbsp;'.$survey_last_name.'</i></h2>
                    </div>';

                $pdf->writeHTML($html, true, false, true, false, '');

                $pdf->SetLeftMargin(105);
                $pdf->Text(100, 20, '');
                $html ='
                    <div style="line-height: 70%;">
                        <h2 style="text-align: center; font-family: Georgia, serif; font-size: 4mm;">Awards (Full Listing)</h2>
                        <h2 style="text-align: center; font-family: Georgia, serif; font-size: 4mm; font-weight: normal;">'.$date.'</h2>
                    </div>';
                $pdf->writeHTML($html, true, false, true, false, '');

                $pdf->SetLeftMargin(15);
                $pdf->SetRightMargin(15);
                $pdf->Text(70, 37, '');
                $html ='
                    <div style="border-top: 1px solid black;"></div>

                    <table style=" font-size: 2.7mm;">
                        <tr>
                            <td width="105" style="text-align: right;">Award:</td>
                            <td width="520">'.$survey_name.'</td>
                        </tr>
                        <tr>
                            <td width="105" style="text-align: right;">Submission Deadline:</td>
                            <td width="520">'.$survey_submission_deadline.'</td>
                        </tr>
                        <tr>
                            <td width="105" style="text-align: right;">Type:</td>
                            <td width="520">'.$survey_type.'</td>
                        </tr>
                        <tr>
                            <td width="105" style="text-align: right;">Special Criteria(s):</td>
                            <td width="520">'.$special_criterias.'</td>
                        </tr>
                       
                        <tr>
                            <td width="105" style="text-align: right;">Practice Area(s):</td>
                            <td width="520">'.$practice_areas.'</td>
                        </tr>
                        <tr>
                            <td width="105" style="text-align: right;">Geographic Area:</td>
                            <td width="520">'.$geographic_area.'</td>
                        </tr>
                        <tr>
                            <td width="105" style="text-align: right;">Description:</td>
                            <td width="520">'.$survey_description.'</td>
                        </tr>
                        
                        <tr>
                            <td width="105" style="text-align: right;">Frequency:</td>
                            <td width="520">'.$survey_frequency.'</td>
                        </tr>
                        <tr>
                            <td width="105" style="text-align: right;">Contact Person:</td>
                            <td width="520">'.$survey_contact_person.'</td>
                        </tr>
                    </table>
                ';

                $pdf->writeHTML($html, true, false, true, false, '');

                $pdf->Text(150, 250, '');
                $pdf->SetLeftMargin(180);
                //$pdf->SetRightMargin(-30);
                $html = '<p style="font-size: 2.5mm; letter-spacing: 1mm;">1/1</p>';
                $pdf->writeHTML($html, true, false, true, false, '');

                $pdf->Text(19, 255, '');
                $pdf->SetLeftMargin(15);
                $pdf->SetRightMargin(15);

                $html = '
                    <p style="font-size: 3.6mm;font-weight: bold;">LexLists.com: Discover Awards!</p>

                    <p style="font-size: 2.7mm;">Sharing or using this output in any way outside its intended use is a violation of the License Terms & Agreement.
                    Copyright 2012-2015 LexLists by LexSource. All Rights Reserved.</p>
                    ';

                    $pdf->writeHTML($html, true, false, true, false, '');
            }
            //save info in log file
            $final_filename = $this->getUser()->getAttribute('log_file_name');
            $logPath = sfConfig::get('sf_log_dir').'/'.$final_filename;
            $custom_logger = new sfFileLogger(new sfEventDispatcher(), array('file' => $logPath));
            $s_id_for_log = implode(" ",$s_id_for_log);
            // $s_names_for_log = implode(" ", $s_names_for_log);

            $section = $request->getParameter("hidden_section_name_for_log", FALSE);
            //var_dump($section);die;
            if(isset($section) && $section == 'dashboard')
            {
           
                $custom_logger->info('Directory | Dashboard Award | Print | Award: '.$s_names_for_log.'; '.$organization.' | '.$s_id_for_log);
            }
            else
            {
                $custom_logger->info('Directory | My List Award | Print | Award: '.$s_names_for_log.'; '.$organization.' | '.$s_id_for_log);
            }          

        }


        


        $pdf->Output("LexLists-$survey_first_name-$survey_last_name-$date.pdf", 'I');die;

        //$this->forward404();
    }

    public function executeCloseForLog(sfWebRequest $request)
    {
        if ($request->isXmlHttpRequest()) {
            // Get request parameters
            $my_survey_id = $request->getParameter("my_survey_id", FALSE);            
            $my_survey_name = $request->getParameter("my_survey_name", FALSE);            
            $organization = $request->getParameter("organization", FALSE);  

            //save info in log file
            $final_filename = $this->getUser()->getAttribute('log_file_name');
            $logPath = sfConfig::get('sf_log_dir').'/'.$final_filename;
            $custom_logger = new sfFileLogger(new sfEventDispatcher(), array('file' => $logPath));
            
            //var_dump($survey_id);die;
            $custom_logger->info('Directory | Dashboard Award | Close | Award: '.$my_survey_name.'; '.$organization.' | '.$my_survey_id);

        } 
    }

    /**
     * Get information about survey
     * 
     * @param sfWebRequest $request     Request object
     * 
     * @return array                    JSON array with response message
     */
    public function executeGetSurveyInfo(sfWebRequest $request) {
        if ($request->isXmlHttpRequest()) {
            // Get request parameters
            $survey_id = $request->getParameter("survey_id", FALSE);
            $calendar = $request->getParameter("calendar", FALSE);
            //$survey_name_hidden = $request->getParameter("survey_name", FALSE);

            if ($survey_id) {
                // Get survey info
                $survey = Doctrine_Core::getTable("LtSurvey")->getFullInfo($survey_id);
                // Get year
                $year = (!is_null($survey->getYear()) && $survey->getYear() != "") ? $survey->getYear() : "- - -";

                // Get organization
                $organization = "- - -";

                if ((!is_null($survey->getOrganizationId()) && $survey->getOrganizationId() != "")) {
                    if ($this->check_if_url_exists($survey->getOrganizationUrl()))
                    {
                        $organization = "<a class='custom_link' target='_blank' href='" . $survey->getOrganizationUrl() . "'>" . $survey->getOrganization()->getName() . "</a>";
                        $org_name_for_log = $survey->getOrganization()->getName();
                        $org_url_for_log = $survey->getOrganizationUrl();
                    }
                    else
                    {
                        $organization = $survey->getOrganization()->getName();
                        $org_name_for_log = $organization;
                    }

                }

                // Get survey name
                $survey_name = "- - -";

                if (!is_null($survey->getSurveyName()) && $survey->getSurveyName() != "") {
                    if ($this->check_if_url_exists($survey->getSurveyUrl()))
                    {
                        $survey_name = "<a class='custom_link' target='_blank' href='" . $survey->getSurveyUrl() . "'>" . $survey->getSurveyName() . "</a>";
                        $survey_name_hidden = $survey->getSurveyName();
                        $survey_url_for_log = $survey->getSurveyUrl();
                    }
                    else
                    {
                        $survey_name = $survey->getSurveyName();
                        $survey_name_hidden = $survey_name;
                    }

                }

                // Get submission deadline
                $submission_deadline = (!is_null($survey->getSubmissionDeadline()) && $survey->getSubmissionDeadline() != "") ? $survey->getSubmissionDeadline() : "- - -";

                // Get candidate type
                $candidate_type = ($survey->getCandidateType() != 0 && isset(LtSurvey::$candidate_types_array[$survey->getCandidateType()])) ? LtSurvey::$candidate_types_array[$survey->getCandidateType()] : "- - -";

                // Get special criterias
                $special_criterias = "- - -";
                if ($survey->getLtSurveySpecialCriteria()->getFirst()) {
                    $special_criteria_array = array();
                    foreach ($survey->getLtSurveySpecialCriteria() as $special_criteria) {
                        $special_criteria_array[] = $special_criteria->getSpecialCriteria()->getName();
                    }

                    $special_criterias = implode(", ", $special_criteria_array);
                }

                // Get eligibility notes
                //$eligibility_notes = (!is_null($survey->getEligibilityCriteria()) && $survey->getEligibilityCriteria() != "") ? $survey->getEligibilityCriteria() : "- - -";

                // Get practice areas
                $practice_areas = "- - -";
                if ($survey->getLtSurveyPracticeArea()->getFirst()) {

                    $practice_area_array = array();
                    foreach ($survey->getLtSurveyPracticeArea() as $practice_area) {
                        $practice_area_array[] = $practice_area->getPracticeArea()->getName();                        
                    }

                    $practice_areas = implode(", ", $practice_area_array);
                }
                if($practice_areas == "")
                {
                    $practice_areas = "- - -";
                }

                // Get geographic area
                $geographic_area = "- - -";
                    // Get region
                    $region = "";
                    if ($survey->getRegion()) {
                        $region = $survey->getRegion()->getName();
                        if($region == '')
                        {
                            $region = "";
                        }
                        else
                        {
                            $region .= "; ";
                        }

                    }

                    // Get cities
                    $cities = "";

                    if ($survey->getLtSurveyCity()) {
                        $cities_array = array();
                        foreach ($survey->getLtSurveyCity() as $city) {
                            $cities_array[] = $city->getCity()->getName();
                        }

                        $cities = implode(", ", $cities_array);
                        $cities .= "; ";
                    }
                    if($cities == "; ") $cities = "";

                    // Get countries
                    $countries = "";
                    if ($survey->getLtSurveyCountry()) {
                        $countries_array = array();
                        foreach ($survey->getLtSurveyCountry() as $country) {
                            $countries_array[] = $country->getCountry()->getName();
                        }

                        $countries = implode(", ", $countries_array);
                        $countries .= "; ";
                    }
                    if($countries == "; ") $countries = "";

                    // Get states
                    $states = "";
                    if ($survey->getLtSurveyState()) {
                        $states_array = array();
                        foreach ($survey->getLtSurveyState() as $state) {
                            $states_array[] = $state->getState()->getName();
                        }

                        $states = implode(", ", $states_array);
                        $states .= "; ";
                    }
                    if($states == "; ") $states = "";

                    $geographic_area = $region . "" . $cities . "" . $states . "" . $countries . "";
                    $geographic_area = rtrim($geographic_area, "; ");
                
                if($geographic_area == "") $geographic_area = "- - -";
                // Get description
                $description = (!is_null($survey->getSurveyDescription()) && $survey->getSurveyDescription() != "") ? $survey->getSurveyDescription() : "- - -";
                //$description = $this->CheckURLLength($description, 320);

                // Get submission methodology
                //$submission_methodology = (!is_null($survey->getSelectionMethodology()) && $survey->getSelectionMethodology() != "") ? $survey->getSelectionMethodology() : "- - -";

                // Get nomination
                $nomination = (!is_null($survey->getNomination()) && $survey->getNomination() != "") ? $survey->getNominationWithLinks() : "- - -";
                //$nomination = $this->CheckURLLength($nomination, 90);

                // var_dump($nomination);die;

                //Keywords

              $query = 'SELECT keywords FROM surveys WHERE id="'. $survey_id .'"';
                $resquery = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($query)->fetchAll();
                $keywords = "- - -";
                if(isset($resquery[0]['keywords']) && !empty($resquery[0]['keywords']))
                {
                    $keywords =  $resquery[0]['keywords'];
                }              
                // Get frequency
                $frequency = ($survey->getFrequency() != 0 && isset(LtSurvey::$frequency_types_array[$survey->getFrequency()])) ? LtSurvey::$frequency_types_array[$survey->getFrequency()] : "- - -";

                // Get contac person
                $contact_person = "- - -";
                if ($survey->getContact()) {
                    $phone_number = "";
                    if ($survey->getContact()->getPhoneNumber() !== "") {
                        $phone_number = $survey->getContact()->getPhoneNumber();
                    }
                    if($survey->getContact()->getLastName())
                    {
                        $surLastname = $survey->getContact()->getLastName().', ';
                    }
                    else{
                        $surLastname = '';
                    }
                    if($survey->getContact()->getFirstName())
                    {
                        $surFirstname = $survey->getContact()->getFirstName();
                    }
                    else{
                        $surFirstname = '';

                    }

                    $s_email = $survey->getContact()->getEmailAddress();

                    if(isset($s_email) && $s_email !== '')
                    {
                        $survey_email = " (". $s_email .") ";
                    }
                    else
                    {
                        $survey_email = '';
                    }

                    if($surLastname == '' && $surFirstname == '' && $survey_email == '' && $phone_number == '')
                    {
                        $contact_person = "- - -";
                    }
                    else
                    {
                        $contact_person = trim($surLastname .
                            $surFirstname .
                            /*"" .*/
                            /*$survey->getContact()->getEmailAddress() .*/
                            $survey_email.
                            /* "" .*/
                            trim($phone_number, "ﾠ"), "ﾠ");
                    }


                }

                // Get survey ID
                $s_id = $survey->getId();

                // Get created date
                $created_date = $survey->getCreatedAt();

                // Get updated date
                $updated_date = $survey->getUpdatedAt();

                $user = $this->getUser()->getGuardUser();

                // Get recipient email address
                $recipient_email_address = $user->getEmailAddress();

                //Get user first name and last name
                $recipient_first_name = $user->getFirstName();
                $recipient_last_name = $user->getLastName();

                //save info to log file
                $final_filename = $this->getUser()->getAttribute('log_file_name');
                $logPath = sfConfig::get('sf_log_dir').'/'.$final_filename;
                $custom_logger = new sfFileLogger(new sfEventDispatcher(), array('file' => $logPath));
                
                $award_url = '';
                if(isset($survey_url_for_log) && !empty($survey_url_for_log))
                {
                    $award_url = " - Award URL - ".$survey_url_for_log;           
                }

                $org_url = '';
                if(isset($org_url_for_log) && !empty($org_url_for_log))
                {
                    $org_url = " - Organization URL - ".$org_url_for_log;           
                }

            
                $is_email_link = $request->getParameter("email", FALSE);
                if($is_email_link == '1')
                {
                    $custom_logger->info("Directory | Dashboard | Envelope | Award: ".$survey_name_hidden."; ".$org_name_for_log." | ".$s_id);
                }
                elseif(isset($calendar) && !empty($calendar)) 
                {
                    $custom_logger->info("Directory | Calendar | Open | Award: ".$survey_name_hidden."; ".$org_name_for_log." | ".$s_id);
                }
                else
                {
                    $custom_logger->info("Directory | Dashboard | Open | Award: ".$survey_name_hidden."; ".$org_name_for_log." | ".$s_id);
                }
                
                return $this->renderText(
                    json_encode(
                        array(
                            "year"                   => $year,
                            "organization"           => $organization,
                            "survey_name"            => $survey_name,
                            "survey_name_hidden"     => $survey_name_hidden,
                            "submission_deadline"    => $submission_deadline,
                            "candidate_type"         => $candidate_type,
                            "special_criterias"      => $special_criterias,
                            // "eligibility_notes"      => $eligibility_notes,
                            "practice_areas"         => $practice_areas,
                            "geographic_area"        => $geographic_area,
                            "description"            => $this->CheckStringLengthDescription($description,320),
                            "description_1"          => $description.' <span class="less" style="cursor:pointer; color:#ff6801;"> less</span>',
                            // "submission_methodology" => $submission_methodology,
                            "nomination"             => $nomination,
                            "keywords"               => $keywords,
                            "frequency"              => $frequency,
                            "contact_person"         => $contact_person,
                            "survey_id"              => $s_id,
                            "created_date"           => $created_date,
                            "updated_date"           => $updated_date,
                            "user_email"             => /*$recipient_email_address*/$recipient_first_name." ".$recipient_last_name,
                            "user_email_hidden"      => $recipient_email_address
                        )
                    )
                );
            }
        }

        $this->forward404();
    }

    public function executeGetSelfInfo() {

        $user = $this->getUser()->getGuardUser();

        // Get recipient email address
        $recipient_email_address = $user->getEmailAddress();

        //Get user first name and last name
        $recipient_first_name = $user->getFirstName();
        $recipient_last_name = $user->getLastName();

        //save info to log file
        $final_filename = $this->getUser()->getAttribute('log_file_name');
        $logPath = sfConfig::get('sf_log_dir').'/'.$final_filename;
        $custom_logger = new sfFileLogger(new sfEventDispatcher(), array('file' => $logPath));



        return $this->renderText(
            json_encode(
                array(
                    "user_email"             => /*$recipient_email_address*/$recipient_first_name." ".$recipient_last_name,
                    "user_email_hidden"      => $recipient_email_address
                )
            )
        );
        $this->forward404();
    }

    public function check_if_url_exists($url) {
        if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
            return false;
        }
        if (!$fp = curl_init($url)) return false;
        return true;
    }

}
