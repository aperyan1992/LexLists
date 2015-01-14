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

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        // Get surveys years
        $this->surveys_years = Doctrine_Core::getTable('LtSurvey')->getSurveysYears();
        $this->survey_year_checkboxes = "";
        foreach ((array) $this->surveys_years as $year) {
            $this->survey_year_checkboxes .= '<input checkbox_type="year" type="checkbox" class="year_checkbox" col_num="1" value="' . $year . '" id="' . $year . '" /><span>' . $year . '</span><br />';
        }



        // Get survey organizations
        $this->survey_organizations = Doctrine_Core::getTable('LtSurvey')->getSurveyOrganizations();
        $this->survey_organization_checkboxes = "";
        foreach ($this->survey_organizations as $organization) {
            $organization_name = $organization->getOrganization()->getName();
            $allOrganizations[]=$organization_name;
            //$this->survey_organizations_checkboxes .= '<input checkbox_type="organization" type="checkbox" class="organization_checkbox" col_num="2" value="' . $organization_name . '" id="' . $organization_name . '" /><span>' . $organization_name . '</span><br />';
        }
        sort($allOrganizations);//sorting A-Z

        foreach($allOrganizations as $oganizations_name){
            $this->survey_organizations_checkboxes .= '<input checkbox_type="organization" type="checkbox" class="organization_checkbox" col_num="2" value="' . $oganizations_name . '" id="' . $oganizations_name . '" /><span>' . $oganizations_name . '</span><br />';
        }

        // Get survey candidate types
        $this->survey_candidate_types = Doctrine_Core::getTable('LtSurvey')->getSurveysCandidateTypes();
        $this->survey_candidate_types_checkboxes = "";

        foreach ((array) $this->survey_candidate_types as $candidate_type) {
            $c_type = "- - -";
            if (array_key_exists($candidate_type, LtSurvey::$candidate_types_array)) {
                $c_type = LtSurvey::$candidate_types_array[$candidate_type];

            }
            $allC_type[]=$c_type;
            //$this->survey_candidate_types_checkboxes .= '<input checkbox_type="candidate_type" type="checkbox" class="candidate_type_checkbox" col_num="4" value="' . $c_type . '" id="' . $c_type . '" /><span>' . $c_type . '</span><br />';
        }
        sort($allC_type);
        foreach($allC_type as $c_types){
            $this->survey_candidate_types_checkboxes .= '<input checkbox_type="candidate_type" type="checkbox" class="candidate_type_checkbox" col_num="4" value="' . $c_types . '" id="' . $c_types . '" /><span>' . $c_types . '</span><br />';

        }

        // Get survey practice areas
        $this->survey_practice_areas = Doctrine_Core::getTable("LtPracticeArea")->findAll();
        $this->survey_practice_areas_checkboxes = "";
        foreach ($this->survey_practice_areas as $practice_area) {
            $practice_area_name = $practice_area->getShortCode();
            $allPractice_area_name[]=$practice_area_name;
            //$this->survey_practice_areas_checkboxes .= '<input checkbox_type="practice_area" type="checkbox" class="practice_area_checkbox" col_num="5" value="' . $practice_area_name . '" id="' . $practice_area_name . '" /><span>' . $practice_area_name . '</span><br />';
        }
        sort($allPractice_area_name);
        foreach($allPractice_area_name as $practice_area_names){
            $this->survey_practice_areas_checkboxes .= '<input checkbox_type="practice_area" type="checkbox" class="practice_area_checkbox" col_num="5" value="' . $practice_area_names . '" id="' . $practice_area_names . '" /><span>' . $practice_area_names . '</span><br />';

        }
        // Get survey regions
        $this->survey_regions = Doctrine_Core::getTable('LtSurvey')->getSurveyRegions();
        $this->survey_regions_checkboxes = "";
        foreach ($this->survey_regions as $region) {
            $region_name = $region->getRegion()->getName();
            $allRegion_name[]=$region_name;
            //$this->survey_regions_checkboxes .= '<input checkbox_type="region" type="checkbox" class="region_checkbox" col_num="7" value="' . $region_name . '" id="' . $region_name . '" /><span>' . $region_name . '</span><br />';
        }
        sort($allRegion_name);
        foreach($allRegion_name as $region_names){
            $this->survey_regions_checkboxes .= '<input checkbox_type="region" type="checkbox" class="region_checkbox" col_num="7" value="' . $region_names . '" id="' . $region_names . '" /><span>' . $region_names . '</span><br />';

        }
        $this->survey_regions_checkboxes .= '<input checkbox_type="state" type="checkbox" class="state_checkbox" col_num="7" value="Texas" id="Texas" /><span>Texas</span><br />';

        // Get survey special criterias
        $this->survey_special_criterias = Doctrine_Core::getTable('LtSpecialCriteria')->findAll();
        $this->survey_special_criterias_checkboxes = "";
        foreach ($this->survey_special_criterias as $special_criteria) {
            $s_criteria = $special_criteria->getName();
            $allS_criteria[]=$s_criteria;
            //$this->survey_special_criterias_checkboxes .= '<input checkbox_type="special_criteria" type="checkbox" class="special_criteria_checkbox" col_num="6" value="' . $s_criteria . '" id="' . $s_criteria . '" /><span>' . $s_criteria . '</span><br />';
        }
        sort($allS_criteria);
        foreach($allS_criteria as $s_criterias){
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
            $surveys = Doctrine_Core::getTable("LtSurvey")->getAllSurveys();

            if (isset($surveys) && $surveys->getFirst()) {
                $aa_data_array = array("aaData" => array());

                foreach ($surveys as $survey) {

                    // Set survey checkbox
                    $survey_checkbox = "<input type='checkbox' class='table_checkbox' style='float:left' s_id='" . $survey->getId() . "' />"."<a href='#' style='float:right' class='custom_link email_link' s_id='" . $survey->getId() . "'><span class='genericon genericon-mail'></span></a>";

                    // Set year
                    $year = (!is_null($survey->getYear()) && $survey->getYear() != "" && $survey->getYear() != 0) ? $survey-> getYear() : "- - -";

                    // Set organization
                    $organization = (!is_null($survey->getOrganizationId()) && $survey->getOrganizationId() != "") ? $this->CheckStringLength($survey->getOrganization()->getName()) : "- - -";

                    // Set survey name
                    //$survey_name = (!is_null($survey->getSurveyName()) && $survey->getSurveyName() != "") ? $this->CheckStringLength($survey->getSurveyName()) : "- - -";
                    $survey_name = (!is_null($survey->getSurveyName()) && $survey->getSurveyName() != "") ? $this->CheckStringLength($survey->getSurveyName()) : "- - -";

                    // Set survey name link
                    $survey_name_link = "<a href='#' class='custom_link details_link' s_id='" . $survey->getId() . "'>" . $this->CheckStringLength($survey_name) . "</a>";

                    // Set candidate type
                    $candidate_type = (!is_null($survey->getCandidateType()) && $survey->getCandidateType() != "" && $survey->getCandidateType() != "0") ? $this->CheckStringLength(LtSurvey::$candidate_types_array[$survey->getCandidateType()]) : "- - -";

                    // Set practice area
                    $practice_areas = "- - -";
                    if ($survey->getLtSurveyPracticeArea()->getFirst()) {
                        $practice_area_array = array();
                        foreach ($survey->getLtSurveyPracticeArea() as $practice_area) {
                            $practice_area_array[] = $practice_area->getPracticeArea()->getShortCode();
                        }

                        $practice_areas = $this->CheckStringLength(implode(", ", $practice_area_array));
                    }

                    // Set special criteria
                    $special_criterias = "- - -";
                    if ($survey->getLtSurveySpecialCriteria()->getFirst()) {
                        $special_criteria_array = array();
                        foreach ($survey->getLtSurveySpecialCriteria() as $special_criteria) {
                            $special_criteria_array[] = $special_criteria->getSpecialCriteria()->getName();
                        }

                        $special_criterias = $this->CheckStringLength(implode(", ", $special_criteria_array));
                    }

                    // Set region
                    $region = (!is_null($survey->getSurveyRegionId()) && $survey->getSurveyRegionId() != "") ? $this->CheckStringLength($survey->getRegion()->getName()) : "- - -";

                    // Set cities
                    $cities = "- - -";
                    if ($survey->getLtSurveyCity()->getFirst()) {
                        $cities_array = array();
                        foreach ($survey->getLtSurveyCity() as $city) {
                            $cities_array[] = $city->getCity()->getName();
                        }

                        $cities = $this->CheckStringLength(implode(", ", $cities_array));
                    }
                    
                    // Set states
                    $states = "- - -";
                    if ($survey->getLtSurveyState()->getFirst()) {
                        $states_array = array();
                        foreach ($survey->getLtSurveyState() as $state) {
                            $states_array[] = $state->getState()->getName();
                        }

                        $states = $this->CheckStringLength(implode(", ", $states_array));
                    }
                    
                    // Set countries
                    $countries = "- - -";
                    if ($survey->getLtSurveyCountry()->getFirst()) {
                        $countries_array = array();
                        foreach ($survey->getLtSurveyCountry() as $country) {
                            $countries_array[] = $country->getCountry()->getName();
                        }

                        $countries = $this->CheckStringLength(implode(", ", $countries_array));
                    }
                    
                    // Set submission deadline
                    $submission_deadline = (!is_null($survey->getSubmissionDeadline()) && $survey->getSubmissionDeadline() != "") ? $this->CheckStringLength($survey->getSubmissionDeadline()) : "- - -";

                    // Set eligibility
                    $eligibility = (!is_null($survey->getEligibilityCriteria()) && $survey->getEligibilityCriteria() != "") ? $this->CheckStringLength($survey->getShortEligibilityCriteria()) : "- - -";
                    
                    // Set description
                    $description = (!is_null($survey->getSurveyDescription()) && $survey->getSurveyDescription() != "") ? $this->CheckStringLength($survey->getShortSurveyDescription()) : "- - -";

                    // Set methodology
                    $methodology = (!is_null($survey->getSelectionMethodology()) && $survey->getSelectionMethodology() != "") ? $this->CheckStringLength($survey->getShortSelectionMethodology()) : "- - -";

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
                        $eligibility,
                        $description,
                        $methodology,
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

    protected function CheckStringLength($string)
    {
        if (strlen($string) > 50) {

            // truncate string
            $stringCut = substr($string, 0, 50);

            // make sure it ends in a word so assassinate doesn't become ass...
            $string = substr($stringCut, 0, strrpos($stringCut, ' ')).'...';
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
    public function executeSendEmail(sfWebRequest $request) {
        if ($request->isXmlHttpRequest() && $this->getUser()->isAuthenticated()) {
            // Get request parameters
            $survey_ids         = $request->getParameter("survey_ids", FALSE);
            $email_address      = $request->getParameter("email_address", FALSE);
            $email_cc           = $request->getParameter("cc", FALSE);
            $cc = array();
            foreach($email_cc as $ccs)
            {
                if(strpos($ccs,'('))
                {
                    $c = explode("(", $ccs);
                    $c = explode(")", $c[1]);
                    array_push($cc, $c[0]);
                }
                else{
                    array_push($cc,$ccs);
                }

            }
            $additional_message = $request->getParameter("message", FALSE);

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
                    $message = Swift_Message::newInstance()
                            ->setFrom($user->getEmailAddress())
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
            $top = 0;
            $first_survey = true;
            $c = count($survey_ids);

            if(($c %2) != 0)
            {
                $last_footer = true;
            }else{
                $last_footer = false;
            }

            foreach($survey_ids as $key =>$survey_id)
            {
                // Check if surveys exists
                $surveys = Doctrine_Core::getTable("LtSurvey")->getSurveysByIds($survey_id);
                foreach($surveys as $survey)
                {
                    if(!is_null($survey->getSurveyName()) && $survey->getSurveyName() != ""){
                        $survey_name = $survey->getSurveyName();
                    }else{
                        $survey_name = "- - -";
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

                    if(!is_null($survey->getEligibilityCriteria()) && $survey->getEligibilityCriteria() != ""){
                        $survey_eligibility = $survey->getEligibilityCriteria();
                    }else{
                        $survey_eligibility = "- - -";
                    }

                    $practice_areas = "- - -";
                    if ($survey->getLtSurveyPracticeArea()->getFirst()) {
                        $practice_area_array = array();
                        foreach ($survey->getLtSurveyPracticeArea() as $practice_area) {
                            $practice_area_array[] = $practice_area->getPracticeArea()->getShortCode();
                        }
                        $practice_areas = implode(", ", $practice_area_array);
                    }

                    $geographic_area = "- - -";
                    if($survey->getRegion() || $survey->getLtSurveyCity()->getFirst() || $survey->getLtSurveyState()->getFirst() || $survey->getLtSurveyCountry()->getFirst()) {
                        // Get region
                        $region = "- - -";
                        if($survey->getRegion()) {
                            $region = $survey->getRegion()->getName();
                        }

                        // Get cities
                        $cities = "- - -";
                        if ($survey->getLtSurveyCity()->getFirst()) {
                            $cities_array = array();
                            foreach ($survey->getLtSurveyCity() as $city) {
                                $cities_array[] = $city->getCity()->getName();
                            }
                            $cities = implode(", ", $cities_array);
                        }

                        // Get countries
                        $countries = "- - -";
                        if($survey->getLtSurveyCountry()->getFirst()) {
                        }
                            $countries_array = array();
                            foreach ($survey->getLtSurveyCountry() as $country) {
                                $countries_array[] = $country->getCountry()->getName();
                            }
                            $countries = implode(", ", $countries_array);

                        // Get states
                        $states = "- - -";
                        if($survey->getLtSurveyState()->getFirst()) {
                            $states_array = array();
                            foreach ($survey->getLtSurveyState() as $state) {
                                $states_array[] = $state->getState()->getName();
                            }
                            $states = implode(", ", $states_array);
                        }

                        $geographic_area = $region . "; " . $cities . "; ". $states . "; " . $countries . ";";
                    }

                    if(!is_null($survey->getSurveyDescription()) && $survey->getSurveyDescription() != ""){
                        $survey_description = $survey->getSurveyDescription();
                    }else{
                        $survey_description = "- - -";
                    }

                    if(!is_null($survey->getSelectionMethodology()) && $survey->getSelectionMethodology() != ""){
                        $survey_methodology = $survey->getSelectionMethodology();
                    }else{
                        $survey_methodology = "- - -";
                    }

                    if(!is_null($survey->getNomination()) && $survey->getNomination() != ""){
                        $survey_how_to_apply = $survey->getNominationWithLinks();
                    }else{
                        $survey_how_to_apply = "- - -";
                    }

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
                            <td width="115" style="text-align: right;">Eligibility:</td>
                            <td width="510">'.$survey_eligibility.'</td>
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
                            <td width="115" style="text-align: right;">Methodology:</td>
                            <td width="510">'.$survey_methodology.'</td>
                        </tr>
                        <tr>
                            <td width="115" style="text-align: right;">How to Apply:</td>
                            <td width="510">'.$survey_how_to_apply.'</td>
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
        }

        else{
            $pdf->SetLeftMargin(20);

            $html1 = '<h3 style="font-size: 5mm;">Lex<span style="color:#ff6801; font-size: 5mm;">Lists</span></h3>';
            $pdf->Text(100, 12, '');
            $pdf->writeHTML($html1, true, false, true, false, '');

            $pdf->SetLeftMargin(40);

            if ($survey_ids) {
                // Check if surveys exists
                $surveys = Doctrine_Core::getTable("LtSurvey")->getSurveysByIds($survey_ids);
                foreach($surveys as $survey)
                {
                    if(!is_null($survey->getSurveyName()) && $survey->getSurveyName() != ""){
                        $survey_name = $survey->getSurveyName();
                    }else{
                        $survey_name = "- - -";
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

                    if(!is_null($survey->getEligibilityCriteria()) && $survey->getEligibilityCriteria() != ""){
                        $survey_eligibility = $survey->getEligibilityCriteria();
                    }else{
                        $survey_eligibility = "- - -";
                    }

                    $practice_areas = "- - -";
                    if ($survey->getLtSurveyPracticeArea()->getFirst()) {
                        $practice_area_array = array();
                        foreach ($survey->getLtSurveyPracticeArea() as $practice_area) {
                            $practice_area_array[] = $practice_area->getPracticeArea()->getShortCode();
                        }
                        $practice_areas = implode(", ", $practice_area_array);
                    }

                    $geographic_area = "- - -";
                    if($survey->getRegion() || $survey->getLtSurveyCity()->getFirst() || $survey->getLtSurveyState()->getFirst() || $survey->getLtSurveyCountry()->getFirst()) {
                        // Get region
                        $region = "- - -";
                        if($survey->getRegion()) {
                            $region = $survey->getRegion()->getName();
                        }

                        // Get cities
                        $cities = "- - -";
                        if ($survey->getLtSurveyCity()->getFirst()) {
                            $cities_array = array();
                            foreach ($survey->getLtSurveyCity() as $city) {
                                $cities_array[] = $city->getCity()->getName();
                            }
                            $cities = implode(", ", $cities_array);
                        }

                        // Get countries
                        $countries = "- - -";
                        if($survey->getLtSurveyCountry()->getFirst()) {
                            $countries_array = array();
                            foreach ($survey->getLtSurveyCountry() as $country) {
                                $countries_array[] = $country->getCountry()->getName();
                            }
                            $countries = implode(", ", $countries_array);
                        }

                        // Get states
                        $states = "- - -";
                        if($survey->getLtSurveyState()->getFirst()) {
                            $states_array = array();
                            foreach ($survey->getLtSurveyState() as $state) {
                                $states_array[] = $state->getState()->getName();
                            }
                            $states = implode(", ", $states_array);
                        }

                        $geographic_area = $region . "; " . $cities . "; ". $states . "; " . $countries . ";";
                    }

                    if(!is_null($survey->getSurveyDescription()) && $survey->getSurveyDescription() != ""){
                        $survey_description = $survey->getSurveyDescription();
                    }else{
                        $survey_description = "- - -";
                    }

                    if(!is_null($survey->getSelectionMethodology()) && $survey->getSelectionMethodology() != ""){
                        $survey_methodology = $survey->getSelectionMethodology();
                    }else{
                        $survey_methodology = "- - -";
                    }

                    if(!is_null($survey->getNomination()) && $survey->getNomination() != ""){
                        $survey_how_to_apply = $survey->getNominationWithLinks();
                    }else{
                        $survey_how_to_apply = "- - -";
                    }

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
                            <td width="105" style="text-align: right;">Eligibility:</td>
                            <td width="520">'.$survey_eligibility.'</td>
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
                            <td width="105" style="text-align: right;">Methodology:</td>
                            <td width="520">'.$survey_methodology.'</td>
                        </tr>
                        <tr>
                            <td width="105" style="text-align: right;">How to Apply:</td>
                            <td width="520">'.$survey_how_to_apply.'</td>
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
        }

        $pdf->Output("LexLists-$survey_first_name-$survey_last_name-$date.pdf", 'I');die;

        //$this->forward404();
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
                    }
                    else
                    {
                        $organization = $survey->getOrganization()->getName();
                    }

                }

                // Get survey name
                $survey_name = "- - -";

                if (!is_null($survey->getSurveyName()) && $survey->getSurveyName() != "") {
                    if ($this->check_if_url_exists($survey->getSurveyUrl()))
                    {
                        $survey_name = "<a class='custom_link' target='_blank' href='" . $survey->getSurveyUrl() . "'>" . $survey->getSurveyName() . "</a>";
                    }
                    else
                    {
                        $survey_name = $survey->getSurveyName();
                    }

                }

                // Get submission deadline
                $submission_deadline = (!is_null($survey->getSubmissionDeadline()) && $survey->getSubmissionDeadline() != "") ? $survey->getSubmissionDeadline() : "- - -";

                // Get candidate type
                $candidate_type = ($survey->getCandidateType() != 0) ? LtSurvey::$candidate_types_array[$survey->getCandidateType()] : "- - -";

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
                $eligibility_notes = (!is_null($survey->getEligibilityCriteria()) && $survey->getEligibilityCriteria() != "") ? $survey->getEligibilityCriteria() : "- - -";

                // Get practice areas
                $practice_areas = "- - -";
                if ($survey->getLtSurveyPracticeArea()->getFirst()) {
                    $practice_area_array = array();
                    foreach ($survey->getLtSurveyPracticeArea() as $practice_area) {
                        $practice_area_array[] = $practice_area->getPracticeArea()->getShortCode();
                    }

                    $practice_areas = implode(", ", $practice_area_array);
                }

                // Get geographic area
                $geographic_area = "- - -";
                if ($survey->getRegion() || $survey->getLtSurveyCity()->getFirst() || $survey->getLtSurveyState()->getFirst() || $survey->getLtSurveyCountry()->getFirst()) {
                    // Get region
                    $region = "- - -";
                    if ($survey->getRegion()) {
                        $region = $survey->getRegion()->getName();
                    }

                    // Get cities
                    $cities = "- - -";
                    if ($survey->getLtSurveyCity()->getFirst()) {
                        $cities_array = array();
                        foreach ($survey->getLtSurveyCity() as $city) {
                            $cities_array[] = $city->getCity()->getName();
                        }

                        $cities = implode(", ", $cities_array);
                    }

                    // Get countries
                    $countries = "- - -";
                    if ($survey->getLtSurveyCountry()->getFirst()) {
                        $countries_array = array();
                        foreach ($survey->getLtSurveyCountry() as $country) {
                            $countries_array[] = $country->getCountry()->getName();
                        }

                        $countries = implode(", ", $countries_array);
                    }

                    // Get states
                    $states = "- - -";
                    if ($survey->getLtSurveyState()->getFirst()) {
                        $states_array = array();
                        foreach ($survey->getLtSurveyState() as $state) {
                            $states_array[] = $state->getState()->getName();
                        }

                        $states = implode(", ", $states_array);
                    }

                    $geographic_area = $region . "; " . $cities . "; " . $states . "; " . $countries . ";";
                }

                // Get description
                $description = (!is_null($survey->getSurveyDescription()) && $survey->getSurveyDescription() != "") ? $survey->getSurveyDescription() : "- - -";

                // Get submission methodology
                $submission_methodology = (!is_null($survey->getSelectionMethodology()) && $survey->getSelectionMethodology() != "") ? $survey->getSelectionMethodology() : "- - -";

                // Get nomination
                $nomination = (!is_null($survey->getNomination()) && $survey->getNomination() != "") ? $survey->getNominationWithLinks() : "- - -";

                // Get frequency
                $frequency = ($survey->getFrequency() != 0) ? LtSurvey::$frequency_types_array[$survey->getFrequency()] : "- - -";

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
                    $contact_person = trim($surLastname .
                             $surFirstname .
                            " (" .
                            $survey->getContact()->getEmailAddress() .
                            ") " .
                            trim($phone_number, "ﾠ"), "ﾠ");

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

                return $this->renderText(
                    json_encode(
                        array(
                            "year"                   => $year,
                            "organization"           => $organization,
                            "survey_name"            => $survey_name,
                            "submission_deadline"    => $submission_deadline,
                            "candidate_type"         => $candidate_type,
                            "special_criterias"      => $special_criterias,
                            "eligibility_notes"      => $eligibility_notes,
                            "practice_areas"         => $practice_areas,
                            "geographic_area"        => $geographic_area,
                            "description"            => $description,
                            "submission_methodology" => $submission_methodology,
                            "nomination"             => $nomination,
                            "frequency"              => $frequency,
                            "contact_person"         => $contact_person,
                            "survey_id"              => $s_id,
                            "created_date"           => $created_date,
                            "updated_date"           => $updated_date,
                            "user_email"             => $recipient_email_address
                        )
                    )
                );
            }
        }

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
