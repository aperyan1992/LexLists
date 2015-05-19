<?php

/**
 * my survey actions.
 *
 * @package    LexLists
 * @subpackage mySurvey
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mySurveyActions extends sfActions {

    public function executeCalendar(sfWebRequest $request) {

    }

    public function executeCalendarDates() {
        // Get all my surveys ids
        $surveys_ids = Doctrine_Core::getTable("LtSurvey")->getAllMySyrveysListIds();
        $all_my_surveys = array();
        foreach($surveys_ids as $survey_id)
        {
            // Get all my surveys
            $all_my_surveys[] = Doctrine_Core::getTable("LtSurvey")->getAllMySyrveysList($survey_id['survey_id']);

        }

        $newarray = array();
        foreach($all_my_surveys as $key=>$survey)
        {
            foreach($survey as $s)
            {
                $newarray[$key]['id'] = $s['id'];
                $newarray[$key]['title'] = $s['survey_name'] . ", " . $s['name'];
                //$newarray[$key]['url'] = '';
                $newarray[$key]['class'] = "event-warning";
                $newarray[$key]['start'] = (string)(strtotime($s['submission_deadline'])* 1000);
                $newarray[$key]['end'] = (string)(strtotime($s['submission_deadline'])* 1000);
            }

        }

        $result = array("success" => 1, "result"=> $newarray);
        echo json_encode($result);die;
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
                                
        $custom_logger->info('Directory | My List Award | Open | '.$word.$title.' | '.$id);
    }

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        //set session attribute for log file
        //$this->getUser()->setAttribute('Directory', 'My List');

        $final_filename = $this->getUser()->getAttribute('log_file_name');
        $logPath = sfConfig::get('sf_log_dir').'/'.$final_filename;
        $custom_logger = new sfFileLogger(new sfEventDispatcher(), array('file' => $logPath));

        $custom_logger->info("Directory | My List");

        // Get surveys years
        $this->surveys_years = Doctrine_Core::getTable('LtSurvey')->getSurveysYears();
        $this->survey_year_checkboxes = "";
        foreach ((array) $this->surveys_years as $year) {
            $allYears[]=$year;
            //$this->survey_year_checkboxes .= '<input checkbox_type="year" type="checkbox" class="year_checkbox" col_num="1" value="' . $year . '" id="' . $year . '" /><span>' . $year . '</span><br />';
        }
        rsort($allYears);//sorting Z-A

        foreach($allYears as $year){
            $this->survey_year_checkboxes .= '<input checkbox_type="year" type="checkbox" class="year_checkbox" col_num="1" value="' . $year . '" id="' . $year . '" /><span>' . $year . '</span><br />';
        }
        // Get survey organizations
        $this->survey_organizations = Doctrine_Core::getTable('LtSurvey')->getSurveyOrganizations();
        $this->survey_organization_checkboxes = "";
        foreach ($this->survey_organizations as $organization) {
            $organization_name = $organization->getOrganization()->getName();
            $allOrganizations[]=$organization_name;
//            $this->survey_organizations_checkboxes .= '<input checkbox_type="organization" type="checkbox" class="organization_checkbox" col_num="2" value="' . $organization_name . '" id="' . $organization_name . '" /><span>' . $organization_name . '</span><br />';
        }
        sort($allOrganizations);//sorting A-Z

        foreach($allOrganizations as $organization_name){
            $this->survey_organizations_checkboxes .= '<input checkbox_type="organization" type="checkbox" class="organization_checkbox" col_num="2" value="' . $organization_name . '" id="' . $organization_name . '" /><span>' . $organization_name . '</span><br />';
        }
        // Get survey candidate types
        $this->survey_candidate_types = Doctrine_Core::getTable('LtSurvey')->getSurveysCandidateTypes();
        $this->survey_candidate_types_checkboxes = "";
        foreach ((array) $this->survey_candidate_types as $candidate_type) {
            $c_type = "- - -";
            if (array_key_exists($candidate_type, LtSurvey::$candidate_types_array)) {
                $c_type = LtSurvey::$candidate_types_array[$candidate_type];
            }

            $this->survey_candidate_types_checkboxes .= '<input checkbox_type="candidate_type" type="checkbox" class="candidate_type_checkbox" col_num="4" value="' . $c_type . '" id="' . $c_type . '" /><span>' . $c_type . '</span><br />';
        }

        // Get survey practice areas
        $this->survey_practice_areas = Doctrine_Core::getTable("LtPracticeArea")->getAllPracticeAreas();
        $this->survey_practice_areas_checkboxes = "";
        foreach ($this->survey_practice_areas as $practice_area) {
            $practice_area_name = $practice_area->getShortCode();
            $allPractice_area_name[]=$practice_area_name;
//            $this->survey_practice_areas_checkboxes .= '<input checkbox_type="practice_area" type="checkbox" class="practice_area_checkbox" col_num="5" value="' . $practice_area_name . '" id="' . $practice_area_name . '" /><span>' . $practice_area_name . '</span><br />';
        }
        $allPractice_area_name = array_unique($allPractice_area_name);
        sort($allPractice_area_name);

        foreach($allPractice_area_name as $practice_area_name){
            $this->survey_practice_areas_checkboxes .= '<input checkbox_type="practice_area" type="checkbox" class="practice_area_checkbox" col_num="5" value="' . $practice_area_name . '" id="' . $practice_area_name . '" /><span>' . $practice_area_name . '</span><br />';
        }
        // Get survey regions
        $this->survey_regions = Doctrine_Core::getTable('LtSurvey')->getSurveyRegions();
        $this->survey_regions_checkboxes = "";
        foreach ($this->survey_regions as $region) {
//            $region_name = $region->getRegion()->getName();

            $region_name = $region->getRegion()->getName();
            //var_dump( $region->getRegion()->getName());
            $allRegion_name[]=$region_name;

//            $this->survey_regions_checkboxes .= '<input checkbox_type="region" type="checkbox" class="region_checkbox" col_num="7" value="' . $region_name . '" id="' . $region_name . '" /><span>' . $region_name . '</span><br />';
        }

        $sorted_names[0] = "US Mid-Atlantic";
        $sorted_names[1] = "US Midwest";
        $sorted_names[2] = "US Northeast";
        $sorted_names[3] = "US South";
        $sorted_names[4] = "US West";
        $sorted_names[5] = "Africa";
        $sorted_names[6] = "Asia";
        $sorted_names[7] = "Europe";
        $sorted_names[8] = "Australia";
        $sorted_names[9] = "North America";
        $sorted_names[10] = "South America";
        $sorted_names[11] = "Global (the world)";
        $sorted_names[12] = "US (All States)";


        foreach($sorted_names as $sorted_name)
        {
            foreach($allRegion_name as $region_names)
            {
                if($sorted_name == $region_names)
                {
                    $this->survey_regions_checkboxes .= '<input checkbox_type="region" type="checkbox" class="region_checkbox" col_num="7" value="' . $region_names . '" id="' . $region_names . '" /><span>' . $region_names . '</span><br />';
                }
            }
        }

        // Get survey special criterias
        $this->survey_special_criterias = Doctrine_Core::getTable('LtSpecialCriteria')->findAll();
        $this->survey_special_criterias_checkboxes = "";
        foreach ($this->survey_special_criterias as $special_criteria) {
            $s_criteria = $special_criteria->getName();

            $this->survey_special_criterias_checkboxes .= '<input checkbox_type="special_criteria" type="checkbox" class="special_criteria_checkbox" col_num="6" value="' . $s_criteria . '" id="' . $s_criteria . '" /><span>' . $s_criteria . '</span><br />';
        }
    }

    public function executeCancelMyListLog(sfWebRequest $request)
    {
        if ($request->isXmlHttpRequest()) {
            // Get request parameters
            $survey_id          = $request->getParameter("title", FALSE);


            if ($survey_id) {
                // Get survey info
                $survey = Doctrine_Core::getTable("LtMySurvey")->getFullMySurveyInfo($survey_id, $this->getUser()->getGuardUser()->getId());

                if ($survey) {                   
                    // Get organization
                    $organization = "";
                    if ((!is_null($survey->getSurvey()->getOrganizationId()) && $survey->getSurvey()->getOrganizationId() != "")) 
                    {                                           
                        $organization = $survey->getSurvey()->getOrganization()->getName();                        
                    }

                    $survey_name = "";
                    if (!is_null($survey->getSurvey()->getSurveyName()) && $survey->getSurvey()->getSurveyName() != "") 
                    {                        
                        $survey_name = $survey->getSurvey()->getSurveyName();                          
                    }
                }
            }

            //save info in log file
            $final_filename = $this->getUser()->getAttribute('log_file_name');
            $logPath = sfConfig::get('sf_log_dir').'/'.$final_filename;
            $custom_logger = new sfFileLogger(new sfEventDispatcher(), array('file' => $logPath));       

            $custom_logger->info("Directory | My List Award | Close | Award: ".$survey_name."; ".$organization." | ".$survey_id);
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

            // Get all my surveys
            $surveys = Doctrine_Core::getTable("LtSurvey")->getAllMySyrveysMonthList($first_day, $last_day);

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

            foreach($surveys as $survey)
            {
                $deaslines_array [$survey['submission_deadline']][$i]['survey_name'] = $survey['survey_name'];
                $deaslines_array [$survey['submission_deadline']][$i]['name'] = $survey['name'];

                $surveysforlog[] = $survey['survey_name'].'; '.$survey['name'].' | '.$survey['id'];

                $i++;

            }

            foreach($deaslines_array as $date=>$deadline)
            {
                $html .='
                    <h2 style="text-align: left; font-family: Georgia, serif; font-size: 4.5mm;">'.date('j F Y', strtotime($date)).'</h2>';

                foreach($deadline as $d)
                {
                    $html .='
                    <h2 style="text-align: left; font-family: Georgia, serif; font-size: 4mm; font-weight: normal;">- <i>'.$d['survey_name']."</i>, ".$d['name'].'</h2>';
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

            $checkingquery = 'SELECT `s`.`id`, `s`.`survey_name`, `s`.`submission_deadline`, `o`.`name` FROM `surveys` AS `s` JOIN `organizations` AS `o` ON `s`.`organization_id` = `o`.`id` JOIN `my_surveys` AS `m_s` ON `s`.`id` = `m_s`.`survey_id` WHERE `s`.`submission_deadline` >= "'.$year_start.'" AND `s`.`submission_deadline` <= "'.$year_end.'" ORDER BY `s`.`submission_deadline`';
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

            $checkingquery = 'SELECT `s`.`id`, `s`.`survey_name`, `s`.`submission_deadline`, `o`.`name` FROM `surveys` AS `s` JOIN `organizations` AS `o` ON `s`.`organization_id` = `o`.`id` JOIN `my_surveys` AS `m_s` ON `s`.`id` = `m_s`.`survey_id` WHERE `s`.`submission_deadline` >= "'.$week_start.'" AND `s`.`submission_deadline` <= "'.$week_end.'" ORDER BY `s`.`submission_deadline`';
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


    public function executeSendEmail(sfWebRequest $request) {
        if ($request->isXmlHttpRequest() && $this->getUser()->isAuthenticated()) {
            // Get request parameters
            $survey_ids         = $request->getParameter("survey_ids", FALSE);
            $email_address      = $request->getParameter("email_address", FALSE);
            $survey_name        = $request->getParameter("survey_name", FALSE);
            $organization       = $request->getParameter("organization", FALSE);


            //var_dump("name - ".$survey_name);die;
            $email_cc           = $request->getParameter("cc", FALSE);
            $email_me           = $request->getParameter("email_me", FALSE);
            $cc = array();
            $cc_for_log = array();
            if($email_cc)
            {
                foreach($email_cc as $ccs)
                {
                    
                    array_push($cc_for_log, $ccs);
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
            }

            $additional_message = $request->getParameter("message", FALSE);


            //var_dump("vvvvvvvv".$cc_for_log[0]);die;
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
                    $custom_logger->info("Directory | My List Award | EmailMe | Award:  ".$survey_name."; ".$organization." | ".$s_ids);

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
     * Get my surveys with ajax request
     *
     * @param sfWebRequest $request     Request object
     *
     * @return array                    JSON array with response message
     */
    public function executeGetMySurveys(sfWebRequest $request) {
        if ($request->isXmlHttpRequest()) {
            $i = 0;

            // Get all surveys
            $surveys = Doctrine_Core::getTable("LtMySurvey")->getAllMySyrveys($this->getUser()->getGuardUser()->getId());
            //$surveys = 'SELECT * FROM my_surveys WHERE user_id = '.$this->getUser()->getGuardUser()->getId().' OR share_with = '.$this->getUser()->getGuardUser()->getId();
            //$res = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($surveys2)->fetchAll();
            // echo "<pre>";
            // var_dump($res);die;
            if (isset($surveys) && $surveys->getFirst()) {
                $aa_data_array = array("aaData" => array());

                foreach ($surveys as $survey) {
                    // Set survey checkbox
                    $updated_bubble = "";
                    $is_updated     = 0;
                    if ($survey->getIsUpdated()) {
                        $updated_bubble = "<span class='bubble green table_bubble' ms_id='" . $survey->getId() . "' bubble_type='updated' title='Award info has been updated.'></span>";
                        $is_updated     = 1;
                    }
                    $past_due_bubble = "";
                    $is_past_due     = 0;
                    $survey_checkbox = '<input type="checkbox" style="float:left" class="table_checkbox" /><div style="float:right" class="menu-drop-wrapper">
                                        <a href="#" class="menu_link">
                    <span class="genericon genericon-menu"></span>
                                        </a>
                                        <ul class="menu-dropdown" >
                                            <li><a href="#" class="set_an_alert_class" s_id="' . $survey->getSurvey()->getId() . '">Set an Alert</a></li>
                                            <!--<li><a href="#">Send a Reminder</a></li>-->
                                            <li><a href="#" class="my_list_email_send" s_id="' . $survey->getSurvey()->getId() . '">E-mail</a></li>
                                            <li><a href="#" class="my_list_remove_survey" ms_id="' . $survey->getId() . '" updated="' . $is_updated . '" past_due="' . $is_past_due . '">Remove from MyList</a></li>
                                        </ul>
                                    </div>';

                    // Set year
                    $year = (!is_null($survey->getSurvey()->getYear()) && $survey->getSurvey()->getYear() != "" && $survey->getSurvey()->getYear() != 0) ? $survey->getSurvey()->getYear() : "- - -";

                    // Set organization
                    $organization = (!is_null($survey->getSurvey()->getOrganizationId()) && $survey->getSurvey()->getOrganizationId() != "") ? $this->CheckStringLength($survey->getSurvey()->getOrganization()->getName()) : "- - -";

                    // Set survey name
                    $survey_name = (!is_null($survey->getSurvey()->getSurveyName()) && $survey->getSurvey()->getSurveyName() != "") ? $this->CheckStringLength($survey->getSurvey()->getSurveyName()) : "- - -";

                    // Set survey name link with bubbles

                    if ($survey->getIsDeadlinePast()) {
                        $past_due_bubble = "<span class='bubble red table_bubble' ms_id='" . $survey->getId() . "' bubble_type='past_dues' title='Submission deadline passed.'></span>";
                        $is_past_due     = 1;
                    }
                    $survey_name_link = "<div class='survey_name_wrapper'>"
                            . $updated_bubble
                            . $past_due_bubble
                            . "<a href='#' class='custom_link details_link_for_my_lists' s_id='" . $survey->getSurvey()->getId() . "'>" . $this->CheckStringLength($survey_name) . "</a>"
                            . "</div>";

                    // Set candidate type
                    $candidate_type = (!is_null($survey->getSurvey()->getCandidateType()) && $survey->getSurvey()->getCandidateType() != "" && $survey->getSurvey()->getCandidateType() != "0" && isset(LtSurvey::$candidate_types_array[$survey->getSurvey()->getCandidateType()])) ? $this->CheckStringLength(LtSurvey::$candidate_types_array[$survey->getSurvey()->getCandidateType()]) : "- - -";

                    // Set practice area
                    $practice_areas = "- - -";
                    if ($survey->getSurvey()->getLtSurveyPracticeArea()->getFirst()) {
                        $practice_area_array = array();
                        foreach ($survey->getSurvey()->getLtSurveyPracticeArea() as $practice_area) {
                            $practice_area_array[] = $practice_area->getPracticeArea()->getShortCode();
                        }

                        $practice_areas = $this->CheckStringLength(implode(", ", $practice_area_array));
                    }

                    // Set special criteria
                    $special_criterias = "- - -";
                    if ($survey->getSurvey()->getLtSurveySpecialCriteria()->getFirst()) {
                        $special_criteria_array = array();
                        foreach ($survey->getSurvey()->getLtSurveySpecialCriteria() as $special_criteria) {
                            $special_criteria_array[] = $special_criteria->getSpecialCriteria()->getName();
                        }

                        $special_criterias = $this->CheckStringLength(implode(", ", $special_criteria_array));
                    }

                    // Set region
                    $region = (!is_null($survey->getSurvey()->getSurveyRegionId()) && $survey->getSurvey()->getSurveyRegionId() != "") ? $this->CheckStringLength($survey->getSurvey()->getRegion()->getName()) : "- - -";

                    // Set cities
                    $cities = "- - -";
                    if ($survey->getSurvey()->getLtSurveyCity()->getFirst()) {
                        $cities_array = array();
                        foreach ($survey->getSurvey()->getLtSurveyCity() as $city) {
                            $cities_array[] = $city->getCity()->getName();
                        }

                        $cities = $this->CheckStringLength(implode(", ", $cities_array));
                    }

                    // Set states
                    $states = "- - -";
                    if ($survey->getSurvey()->getLtSurveyState()->getFirst()) {
                        $states_array = array();
                        foreach ($survey->getSurvey()->getLtSurveyState() as $state) {
                            $states_array[] = $state->getState()->getName();
                        }

                        $states = $this->CheckStringLength(implode(", ", $states_array));
                    }

                    // Set countries
                    $countries = "- - -";
                    if ($survey->getSurvey()->getLtSurveyCountry()->getFirst()) {
                        $countries_array = array();
                        foreach ($survey->getSurvey()->getLtSurveyCountry() as $country) {
                            $countries_array[] = $country->getCountry()->getName();
                        }

                        $countries = $this->CheckStringLength(implode(", ", $countries_array));
                    }

                    // Set submission deadline
                    $submission_deadline = (!is_null($survey->getSurvey()->getSubmissionDeadline()) && $survey->getSurvey()->getSubmissionDeadline() != "") ? $survey->getSurvey()->getSubmissionDeadline() : "- - -";

                    // Set my status
                    $my_status = (!is_null($survey->getMyStatus()) && $survey->getMyStatus() != "") ? LtMySurvey::$my_statuses_array[$survey->getMyStatus()] : "- - -";

                    // Set owner
                    $owner = (!is_null($survey->getOwnerId()) && $survey->getOwnerId() != "") ? (ucfirst($survey->getOwner()->getLastName()) . ", " . ucfirst(substr($survey->getOwner()->getFirstName(), 0, 1)) . "." ) : "- - -";

                    // Set eligibility
                    $eligibility = (!is_null($survey->getSurvey()->getEligibilityCriteria()) && $survey->getSurvey()->getEligibilityCriteria() != "") ? $this->CheckStringLength($survey->getSurvey()->getShortEligibilityCriteria()) : "- - -";

                    // Set description
                    $description = (!is_null($survey->getSurvey()->getSurveyDescription()) && $survey->getSurvey()->getSurveyDescription() != "") ? $this->CheckStringLength($survey->getSurvey()->getShortSurveyDescription()) : "- - -";

                    // Set methodology
                    $methodology = (!is_null($survey->getSurvey()->getSelectionMethodology()) && $survey->getSurvey()->getSelectionMethodology() != "") ? $this->CheckStringLength($survey->getSurvey()->getShortSelectionMethodology()) : "- - -";

                    // Set email
                    /*$email_link = '<div class="menu-drop-wrapper">
                                        <a href="#" class="menu_link">
                                            <span class="genericon genericon-menu"></span>
                                        </a>
                                        <ul class="menu-dropdown" >
                                            <li><a href="#" class="set_an_alert_class" s_id="' . $survey->getSurvey()->getId() . '">Set an Alert</a></li>
                                            <!--<li><a href="#">Send a Reminder</a></li>-->
                                            <li><a href="#" class="my_list_email_send" s_id="' . $survey->getSurvey()->getId() . '">E-mail</a></li>
                                            <li><a href="#" class="my_list_remove_survey" ms_id="' . $survey->getId() . '" updated="' . $is_updated . '" past_due="' . $is_past_due . '">Remove from MyList</a></li>
                                        </ul>
                                    </div>
                    ';*/

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
                        $my_status,
                        $owner,
                        $eligibility,
                        $description,
                        $methodology,
                        //$email_link
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

    public function executeSaveShare(sfWebRequest $request)
    {
        if ($request->isXmlHttpRequest()) {
            $share_with = $request->getParameter("share_id", FALSE);
            $survey_id = $request->getParameter("survey_id", FALSE);
            $my_survey_id = $request->getParameter("my_survey_id", FALSE);
            $user_id = $request->getParameter("user_id", FALSE);
            //var_dump($survey_id."========".$my_survey_id);die;
            foreach ($user_id as $value) {
                $query_email = 'Select email_address FROM sf_guard_user WHERE id = '.$value;
                $res_email = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($query_email)->fetch();
                $user_email_address[] = $res_email['email_address'];
            }
            $user_email_address = implode("; ",$user_email_address);
            //var_dump($user_email_address1);die;
            // $query_email = 'Select email_address FROM sf_guard_user WHERE id = '.$user_id[0];
            // $res_email = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($query_email)->fetch();
            // $user_email_address = $res_email['email_address'];

            $user = $this->getUser()->getGuardUser(); 
            $guard_user = $user->getId();

            if($share_with && $survey_id && $user_id && $user_id != '')
            {   
                // $query = 'Select * FROM my_surveys WHERE id = '.$my_survey_id;
                // $res = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($query)->fetch();
                $query = 'Select * FROM my_surveys WHERE survey_id = '.$survey_id.' AND user_id = '.$user_id[0];
                $res = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($query)->fetch();
                if(!$res)
                {
                    // $insert = 'INSERT INTO my_surveys (survey_id, user_id, share_with) VALUES ('.$survey_id.','.$guard_user.','.$user_id[0].')';
                    // $res3 = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($insert);

                    $query = 'Select * FROM my_surveys WHERE id = '.$my_survey_id;
                    $res = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($query)->fetch();
                    if($res)
                    {
                        if(empty($res["my_status"]))
                            $res["my_status"] = "NULL";
                        if(empty($res["owner_id"]))
                            $res["owner_id"] = "NULL";
                        //var_dump($res);die;
                        $insert1 = 'INSERT INTO my_surveys (survey_id, user_id, my_status, owner_id, is_updated, is_deadline_past, share_with, created_at, updated_at) VALUES ('.$survey_id.','.$user_id[0].','.$res["my_status"].','.$res["owner_id"].','.$res["is_updated"].','.$res["is_deadline_past"].','.$res["share_with"].',NOW(), NOW())';
                        $res5 = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($insert1);
                    }

                    


                    $surveys = Doctrine_Core::getTable("LtSurvey")->getSurveysByIds(array($survey_id));
                     // Send email message
                    $additional_message = 'Hello, this is a notification that you have been shared this Award.';
                    //$user_info = Doctrine_Core::getTable("sfGuardUser")->findOneById($prev_owner_id);
                        $message = Swift_Message::newInstance()
                                ->setFrom($user->getEmailAddress())
                                ->setTo($user_email_address)
                                ->setSubject("LexLists E-mail")
                                ->setBody($this->getPartial("dashboard/survey_email_or_print", array("surveys" => $surveys, "additional_message" => $additional_message)))
                                ->setContentType("text/html");

                    $send_status = $this->getMailer()->send($message);
                }

                
            }

            // Check sending status//
            $status = false;
            if ($send_status == 1) {
                $status = true;
            }

            return $this->renderText(
                json_encode(
                    array(
                        "status" => "shared",
                        'email_user'=>$status,
                    )
                )
            );

        }
    }

    public function executeSaveOwner(sfWebRequest $request)
    {
        if ($request->isXmlHttpRequest()) {
            $prev_owner_id = $request->getParameter("prev_owner_id", FALSE);
            $new_owner_id = $request->getParameter("owner_id", FALSE);
            $survey_id = $request->getParameter("survey_id", FALSE);
//var_dump($new_owner_id."_________".$survey_id);die;
            if(isset($new_owner_id) && $survey_id)
            {
                if($new_owner_id == '0')
                {         
                    //var_dump($new_owner_id);die;
                    $new_owner_id = 'NULL';
                    $query = 'UPDATE my_surveys SET owner_id='.$new_owner_id.' WHERE survey_id='.$survey_id;
                    $res = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($query);
                    // $query2 = 'Select * FROM my_surveys WHERE survey_id='.$survey_id.' AND  user_id='.$new_owner_id;
                    // $res2 = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($query2)->fetch();
                    // if(!$res2)
                    // {
                    //     $insert = 'INSERT INTO my_surveys (owner_id, survey_id, user_id) VALUES ('.$new_owner_id.','.$survey_id.','.$new_owner_id.')';
                    //     $res3 = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($insert);
                    // }
                    $user = $this->getUser()->getGuardUser();
                    $surveys = Doctrine_Core::getTable("LtSurvey")->getSurveysByIds(array($survey_id));
                     // Send email message
                    $additional_message = 'Hello, this is a notification that you are no longer the owner of The Award and The Award has no owner.';
                    $owner_info = Doctrine_Core::getTable("sfGuardUser")->findOneById($prev_owner_id);
                        $message = Swift_Message::newInstance()
                                ->setFrom($user->getEmailAddress())
                                ->setTo($owner_info->email_address)
                                ->setSubject("LexLists E-mail")
                                ->setBody($this->getPartial("dashboard/survey_email_or_print", array("surveys" => $surveys, "additional_message" => $additional_message)))
                                ->setContentType("text/html");

                    $send_status = $this->getMailer()->send($message);

                    $query_email = 'Select email_address FROM sf_guard_user WHERE is_super_admin = "1"';
                    $res_email = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($query_email)->fetchAll();
                    foreach ($res_email as $value) {
                        $admin_email[] = $value['email_address'];
                    }
                    $admin_email = implode("; ", $admin_email);
                    //var_dump($admin_email);die;
                    // Send email message to admin
                    $owner_info = Doctrine_Core::getTable("sfGuardUser")->findOneById($prev_owner_id);
                    $prev_owner_name = $owner_info->first_name.' '.$owner_info->last_name;

                    $additional_message = 'Hello, this is a notification that '.$prev_owner_name.' is no longer the owner of The Award and The Award has no owner.';
                   
                        $message = Swift_Message::newInstance()
                                ->setFrom($user->getEmailAddress())
                                ->setTo($admin_email)
                                ->setSubject("LexLists E-mail")
                                ->setBody($this->getPartial("dashboard/survey_email_or_print", array("surveys" => $surveys, "additional_message" => $additional_message)))
                                ->setContentType("text/html");

                    $send_status = $this->getMailer()->send($message);



                }
                else
                {
                    $query = 'UPDATE my_surveys SET owner_id='.$new_owner_id.' WHERE survey_id='.$survey_id;
                    $res = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($query);
                    $query2 = 'Select * FROM my_surveys WHERE survey_id='.$survey_id.' AND  user_id='.$new_owner_id;
                    $res2 = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($query2)->fetch();
                    if(!$res2)
                    {
                        $insert = 'INSERT INTO my_surveys (owner_id, survey_id, user_id) VALUES ('.$new_owner_id.','.$survey_id.','.$new_owner_id.')';
                        $res3 = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($insert);
                    }
                    $user = $this->getUser()->getGuardUser();
                    $surveys = Doctrine_Core::getTable("LtSurvey")->getSurveysByIds(array($survey_id));
                     // Send email message
                    $additional_message = 'Hello, this is a notification that you are the new Owner of The Survey.';
                    $owner_info = Doctrine_Core::getTable("sfGuardUser")->findOneById($new_owner_id);
                        $message = Swift_Message::newInstance()
                                ->setFrom($user->getEmailAddress())
                                ->setTo($owner_info->email_address)
                                ->setSubject("LexLists E-mail")
                                ->setBody($this->getPartial("dashboard/survey_email_or_print", array("surveys" => $surveys, "additional_message" => $additional_message)))
                                ->setContentType("text/html");

                    $send_status = $this->getMailer()->send($message);
                }

                // Check sending status//
                $status = false;
                if ($send_status == 1) {
                    $status = true;
                }

                return $this->renderText(
                    json_encode(
                        array(
                            "status" => "updated",
                            'email_owner'=>$status,
                        )
                    )
                );
            }

            
        }
    }

    public function executeCloseForLog(sfWebRequest $request)
    {
        if ($request->isXmlHttpRequest()) {
            // Get request parameters
            $my_survey_id = $request->getParameter("my_survey_id", FALSE);            
            $my_survey_name = $request->getParameter("my_survey_name", FALSE);            
            $organization = $request->getParameter("organization", FALSE);  
            $close_alert = $request->getParameter("close_alert", FALSE);  
            $set = $request->getParameter("title", FALSE);  

            //save info in log file
            $final_filename = $this->getUser()->getAttribute('log_file_name');
            $logPath = sfConfig::get('sf_log_dir').'/'.$final_filename;
            $custom_logger = new sfFileLogger(new sfEventDispatcher(), array('file' => $logPath));
            
            //var_dump($survey_id);die;

            if (isset($close_alert) && $close_alert == 1) {
                $custom_logger->info('Directory | My List Award | Cancel Set Alert | Award: '.$my_survey_name.'; '.$organization.' | '.$my_survey_id);

            }
            elseif (isset($set) && $set == 'Set') 
            {
                $custom_logger->info('Directory | My List Award | Set Alert | Award: '.$my_survey_name.'; '.$organization.' | '.$my_survey_id);

            }
            else
            {
                $custom_logger->info('Directory | My List Award | Close | Award: '.$my_survey_name.'; '.$organization.' | '.$my_survey_id);
            }
            
        }          
    }

    /**
     * Saving of survey to "My Lists" section
     *
     * @param sfWebRequest $request     Request object
     *
     * @return array                    JSON array with response message
     */
    public function executeSaveSurveyToMyList(sfWebRequest $request) {
        if ($request->isXmlHttpRequest()) {
            // Get request parameters
            $survey_id = $request->getParameter("survey_id", FALSE);            
            $organization = $request->getParameter("organization", FALSE);            
            //$survey_name = $request->getParameter("survey_name", FALSE);

            if($survey_id) {
                // Get survey
                $survey = Doctrine_Core::getTable("LtSurvey")->findOneById($survey_id);
                
               
                // Get user
                $user = $this->getUser()->getGuardUser();

                if($survey) {
                    // Check existing of survey in my list
                    $check_survey = Doctrine_Core::getTable("LtMySurvey")->findOneBySurveyIdAndUserId($survey_id, $user->getId());
                    if($check_survey) {
                        return $this->renderText(
                            json_encode(
                                array(
                                    "status" => "exists"
                                )
                            )
                        );
                    }

                    // Save to "My Lists" section
                    $new_my_survey = new LtMySurvey();
                    $new_my_survey->setSurvey($survey);
                    $new_my_survey->setUser($user);
                    $new_my_survey->setOwner($user);
                    if(!is_null($survey->getSubmissionDeadline()) && strtotime($survey->getSubmissionDeadline()) < strtotime(date("Y-m-d"))) {
                        $new_my_survey->setIsDeadlinePast(true);
                    }
                    $new_my_survey->save();

                    //save info in log file
                    $final_filename = $this->getUser()->getAttribute('log_file_name');
                    $logPath = sfConfig::get('sf_log_dir').'/'.$final_filename;
                    $custom_logger = new sfFileLogger(new sfEventDispatcher(), array('file' => $logPath));
                    
                     $survey_name =  $survey->getSurveyName();
                    //var_dump($survey_id);die;
                    $custom_logger->info('Directory | Dashboard Award | Save | Award: '.$survey_name.'; '.$organization.' | '.$survey_id);


                    return $this->renderText(
                        json_encode(
                            array(
                                "status" => "success"
                            )
                        )
                    );
                }
            }
        }

        $this->redirect404();
    }

    /**
     * Multiple saving of surveys to "My Lists" section
     *
     * @param sfWebRequest $request     Request object
     *
     * @return array                    JSON array with response message
     */
    public function executeMultipleSaveSurveyToMyList(sfWebRequest $request) {
        if ($request->isXmlHttpRequest()) {
            // Get request parameters
            $survey_ids = $request->getParameter("survey_ids", FALSE);
            $s_ids_for_log = implode(", ",$survey_ids);
           
            if($survey_ids) {
                // Get user
                $user = $this->getUser()->getGuardUser();

                // Check existing of surveys
                $check_surveys = Doctrine_Core::getTable("LtSurvey")->getSurveysByIds($survey_ids);
                if($check_surveys->count() === count($survey_ids)) {
                    // Check existing of survey in my list
                    $existing_surveys_ids = Doctrine_Core::getTable("LtMySurvey")->getIdsOfExistingMySyrveys($survey_ids, $user->getId());

                    // Removing of existing survey IDs
                    $survey_ids = array_diff($survey_ids, (array) $existing_surveys_ids);

                    // Get connection
                    $con = Doctrine_Manager::getInstance()->getCurrentConnection();

                    try {
                        $con->beginTransaction();

                        // Save surveys to "My Lists" section
                        foreach ($survey_ids as $survey_id) {
                            // Get survey info
                            $survey = Doctrine_Core::getTable("LtSurvey")->findOneById($survey_id);

                            $new_my_survey = new LtMySurvey();
                            $new_my_survey->setSurveyId($survey_id);
                            $new_my_survey->setUser($user);
                            $new_my_survey->setOwner($user);
                            if($survey
                                    && !is_null($survey->getSubmissionDeadline())
                                    && (strtotime($survey->getSubmissionDeadline()) < strtotime(date("Y-m-d")))) {
                                $new_my_survey->setIsDeadlinePast(true);
                            }
                            $new_my_survey->save();

                            //save info in log file
                            $final_filename = $this->getUser()->getAttribute('log_file_name');
                            $logPath = sfConfig::get('sf_log_dir').'/'.$final_filename;
                            $custom_logger = new sfFileLogger(new sfEventDispatcher(), array('file' => $logPath));
                                                    
                            $custom_logger->info('Directory - Save Award To My List - Awards Ids - '.$s_ids_for_log);

                        }

                        $con->commit();

                        return $this->renderText(
                            json_encode(
                                array(
                                    "status" => "success"
                                )
                            )
                        );
                    } catch (Exception $ex) {
                        $con->rollBack();
                        var_dump($ex->getMessage());exit;
                    }
                }
            }
        }

        $this->forward404();
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

            if ($survey_id) {
                // Get survey info
                $survey = Doctrine_Core::getTable("LtMySurvey")->getFullMySurveyInfo($survey_id, $this->getUser()->getGuardUser()->getId());

                if ($survey) {
                    // Get year
                    $year = (!is_null($survey->getSurvey()->getYear()) && $survey->getSurvey()->getYear() != "") ? $survey->getSurvey()->getYear() : "- - -";

                    // Get organization
                    $organization = "- - -";
                    if ((!is_null($survey->getSurvey()->getOrganizationId()) && $survey->getSurvey()->getOrganizationId() != "")) {
                        if ($this->check_if_url_exists($survey->getSurvey()->getOrganizationUrl()))
                        {
                            $organization = "<a class='custom_link' target='_blank' href='" . $survey->getSurvey()->getOrganizationUrl() . "'>" . $survey->getSurvey()->getOrganization()->getName() . "</a>";
                            $org_name_for_log = $survey->getSurvey()->getOrganization()->getName();
                            $org_url_for_log = $survey->getSurvey()->getOrganizationUrl();
                        }
                        else
                        {
                            $organization = $survey->getSurvey()->getOrganization()->getName();
                            $org_name_for_log = $organization;
                        }
                    }

                    // Get survey name
                    $survey_name = "- - -";

                    if (!is_null($survey->getSurvey()->getSurveyName()) && $survey->getSurvey()->getSurveyName() != "") {
                        if ($this->check_if_url_exists($survey->getSurvey()->getSurveyUrl()))
                        {
                            $survey_name = "<a class='custom_link' target='_blank' href='" . $survey->getSurvey()->getSurveyUrl() . "'>" . $survey->getSurvey()->getSurveyName() . "</a>";
                            $s_name_for_log_file = $survey->getSurvey()->getSurveyName();
                            $survey_name_hidden = $survey->getSurvey()->getSurveyName();
                            $survey_url_for_log = $survey->getSurvey()->getSurveyUrl();
                        }
                        else
                        {
                            $survey_name = $survey->getSurvey()->getSurveyName();
                            $s_name_for_log_file = $survey_name;
                            $survey_name_hidden = $survey_name;
                        }

                    }

                    // Get submission deadline
                    $submission_deadline = (!is_null($survey->getSurvey()->getSubmissionDeadline()) && $survey->getSurvey()->getSubmissionDeadline() != "") ? $survey->getSurvey()->getSubmissionDeadline() : "- - -";

                    // Get candidate type
                    $candidate_type = ($survey->getSurvey()->getCandidateType() != 0 && isset(LtSurvey::$candidate_types_array[$survey->getSurvey()->getCandidateType()])) ? LtSurvey::$candidate_types_array[$survey->getSurvey()->getCandidateType()] : "- - -";

                    // Get special criterias
                    $special_criterias = "- - -";
                    if ($survey->getSurvey()->getLtSurveySpecialCriteria()->getFirst()) {
                        $special_criteria_array = array();
                        foreach ($survey->getSurvey()->getLtSurveySpecialCriteria() as $special_criteria) {
                            $special_criteria_array[] = $special_criteria->getSpecialCriteria()->getName();
                        }

                        $special_criterias = implode(", ", $special_criteria_array);
                    }

                    // Get eligibility notes
                    //$eligibility_notes = (!is_null($survey->getSurvey()->getEligibilityCriteria()) && $survey->getSurvey()->getEligibilityCriteria() != "") ? $survey->getSurvey()->getEligibilityCriteria() : "- - -";

                    // Get practice areas
                    $practice_areas = "- - -";
                    if ($survey->getSurvey()->getLtSurveyPracticeArea()->getFirst()) {
                        $practice_area_array = array();
                        foreach ($survey->getSurvey()->getLtSurveyPracticeArea() as $practice_area) {
                            $practice_area_array[] = $practice_area->getPracticeArea()->getShortCode();
                        }

                        $practice_areas = implode(", ", $practice_area_array);
                    }

                    // Get geographic area
                    $geographic_area = "- - -";
                    if ($survey->getSurvey()->getRegion()->getName() || $survey->getSurvey()->getLtSurveyCity()->getFirst() || $survey->getSurvey()->getLtSurveyState()->getFirst() || $survey->getSurvey()->getLtSurveyCountry()->getFirst()) {
                        // Get region
                        $region = "";
                        if ($survey->getSurvey()->getRegion()) {
                            $region = $survey->getSurvey()->getRegion()->getName();
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
                        if ($survey->getSurvey()->getLtSurveyCity()->getFirst()) {
                            $cities_array = array();
                            foreach ($survey->getSurvey()->getLtSurveyCity() as $city) {
                                $cities_array[] = $city->getCity()->getName();
                            }

                            $cities = implode(", ", $cities_array);
                            $cities .= "; ";
                        }

                        // Get countries
                        $countries = "";
                        if ($survey->getSurvey()->getLtSurveyCountry()->getFirst()) {
                            $countries_array = array();
                            foreach ($survey->getSurvey()->getLtSurveyCountry() as $country) {
                                $countries_array[] = $country->getCountry()->getName();
                            }

                            $countries = implode(", ", $countries_array);
                            $countries .= "; ";
                        }

                        // Get states
                        $states = "";
                        if ($survey->getSurvey()->getLtSurveyState()->getFirst()) {
                            $states_array = array();
                            foreach ($survey->getSurvey()->getLtSurveyState() as $state) {
                                $states_array[] = $state->getState()->getName();
                            }

                            $states = implode(", ", $states_array);
                            $states .= "; ";
                        }

                        $geographic_area = $region . "" . $cities . "" . $states . "" . $countries . "";
                        $geographic_area = rtrim($geographic_area, "; ");
                    }

                    // Get description
                    $description = (!is_null($survey->getSurvey()->getSurveyDescription()) && $survey->getSurvey()->getSurveyDescription() != "") ? $survey->getSurvey()->getSurveyDescription() : "- - -";

                    // Get submission methodology
                    //$submission_methodology = (!is_null($survey->getSurvey()->getSelectionMethodology()) && $survey->getSurvey()->getSelectionMethodology() != "") ? $survey->getSurvey()->getSelectionMethodology() : "- - -";

                    // Get nomination
                    $nomination = (!is_null($survey->getSurvey()->getNomination()) && $survey->getSurvey()->getNomination() != "") ? $survey->getSurvey()->getNominationWithLinks() : "- - -";

                    // Get frequency
                    $frequency = ($survey->getSurvey()->getFrequency() != 0) ? LtSurvey::$frequency_types_array[$survey->getSurvey()->getFrequency()] : "- - -";

                    // Get contac person
                    $contact_person = "- - -";
                    if ($survey->getSurvey()->getContact()) {
                        $phone_number = "";
                        if ($survey->getSurvey()->getContact()->getPhoneNumber() !== "") {
                            $phone_number = $survey->getSurvey()->getContact()->getPhoneNumber();
                        }

                        $contact_person = ltrim(ltrim(trim($survey->getSurvey()->getContact()->getLastName() .
                                ", " .
                                $survey->getSurvey()->getContact()->getFirstName() .
                                " (" .
                                $survey->getSurvey()->getContact()->getEmailAddress() .
                                ") " .
                                trim($phone_number,"ﾠ"), "ﾠ"),','), ' ');
                    }

                    // Get survey ID
                    $s_id = $survey->getSurvey()->getId();

                    // Get created date
                    $created_date = $survey->getSurvey()->getCreatedAt();

                    // Get updated date
                    $updated_date = $survey->getSurvey()->getUpdatedAt();

                    // Get owners list

                    
 
                    $owners = Doctrine_Core::getTable("sfGuardUser")->getUsersList($this->getUser()->hasCredential("superuser"));
                    //sort($owners);
                    $share_with_list_user = $owners;
                    // Get current owner
                    $owner = "- - -";
                    if($survey->getOwner())
                    {
                        $owner = $survey->getOwner()->getId();
                    }
                   
                    // Get "My Status" of award
                    $my_status = (!is_null($survey->getMyStatus()) && $survey->getMyStatus() != "") ? $survey->getMyStatus() : NULL;

                    // Get my survey ID
                    $my_survey_id = $survey->getId();

                    // Get list share with
                    $share_with_result = Doctrine_Core::getTable("LtMySurvey")->getShareWithList($survey_id, $owner);
                    $share_with = array();
                    foreach ($share_with_result as $val) {
                        $share_with[$val['user_id']] = $val['user_id'];

                    }

                    // remove user, which have this survey and filed "share_with" = 0
                    foreach (Doctrine_Core::getTable("LtMySurvey")->findAllSurveyWithoutShareWith($survey_id) as $value) {
                        if (isset($share_with_list_user[$value->getUserId()])) {
                            $shared_with_user_id[] = $share_with_list_user[$value->getUserId()];
                            unset($share_with_list_user[$value->getUserId()]);                            
                        }
                    }
                    

                    $user = $this->getUser()->getGuardUser();

                    // Get recipient email address
                    $recipient_email_address = $user->getEmailAddress();

                    //Get user first name and last name
                    $recipient_first_name = $user->getFirstName();
                    $recipient_last_name = $user->getLastName();

                    //save info in log file
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
                        $custom_logger->info("Directory | My List | Envelope | Award: ".$survey_name_hidden."; ".$org_name_for_log." | ".$s_id);
                    } 
                    elseif(isset($calendar) && !empty($calendar)) 
                    {
                        $custom_logger->info("Directory | Calendar | Open | Award: ".$survey_name_hidden."; ".$org_name_for_log." | ".$s_id);
                    }
                    else
                    {
                        $custom_logger->info("Directory | My List | Open | Award: ".$survey_name_hidden."; ".$org_name_for_log." | ".$s_id);
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
                                //"eligibility_notes"      => $eligibility_notes,
                                "practice_areas"         => $practice_areas,
                                "geographic_area"        => $geographic_area,
                                "description"            => $this->CheckStringLengthDescription($description,320),
                                "description_1"          => $description.' <span class="less" style="cursor:pointer; color:#ff6801;"> less</span>',
                                //"submission_methodology" => $submission_methodology,
                                "nomination"             => $nomination,
                                "frequency"              => $frequency,
                                "contact_person"         => $contact_person,
                                "survey_id"              => $s_id,
                                "created_date"           => $created_date,
                                "updated_date"           => $updated_date,
                                "owners"                 => $owners,
                                "owner"                  => $owner,
                                "my_status"              => $my_status,
                                "my_survey_id"           => $my_survey_id,
                                "share_with"             => $share_with,
                                "share_with_list_user"   => $share_with_list_user,
                                "user_email_hidden"      => $recipient_email_address
                            )
                        )
                    );
                }
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


    /**
     * Get notes of my survey
     *
     * @param sfWebRequest $request     Request object
     *
     * @return array                    JSON array with response message
     */
    public function executeGetMySurveyNotes(sfWebRequest $request) {
        if ($request->isXmlHttpRequest()) {
            // Get request parameters
            $survey_id = $request->getParameter("s_id", FALSE);

            if ($survey_id) {
                // Get notes
                $notes = Doctrine_Core::getTable("LtMySurveyNote")->getAwardNotes($survey_id);

                if ($notes->getFirst()) {
                    $aa_data_array = array("aaData" => array());

                    $i = 0;
                    foreach ($notes as $note) {
                        $aa_data_array['aaData'][$i] = array(
                            $note->getDateTimeObject("created_at")->format("d-M-Y"),
                            $note->getNote(),
                            ucfirst($note->getUser()->getFirstName()) . ", " . ucfirst(substr($note->getUser()->getFirstName(), 0, 1)) . "."
                        );

                        $i++;
                    }

                    $response_array = $aa_data_array;
                } else {
                    $response_array = array("aaData" => array());
                }
            }

            return $this->renderText(
                json_encode(
                    $response_array
                )
            );
        }

        $this->forward404();
    }

    /**
     * Adding of my survey note
     *
     * @param sfWebRequest $request     Request object
     *
     * @return array                    JSON array with response message
     */
    public function executeAddMySurveyNote(sfWebRequest $request) {
        if ($request->isXmlHttpRequest()) {
            // Get request parameters
            $survey_id = $request->getParameter("survey_id", FALSE);
            $note_text = $request->getParameter("note_text", FALSE);

            if ($survey_id && $note_text) {
                // Get user
                $user = $this->getUser()->getGuardUser();

                // Check existing of my survey
                $survey = Doctrine_Core::getTable("LtSurvey")->findOneById($survey_id);

                if($survey) {
                    // Save note
                    $new_note = new LtMySurveyNote();
                    $new_note->setSurvey($survey);
                    $new_note->setNote($note_text);
                    $new_note->setUser($user);
                    $new_note->save();

                    return $this->renderText(
                        json_encode(
                            array(
                                "created_at"      => $new_note->getDateTimeObject("created_at")->format("d-M-Y"),
                                "note_text"       => $new_note->getNote(),
                                "user_first_name" => ucfirst($new_note->getUser()->getFirstName())
                                                        . ", "
                                                        . ucfirst(substr($new_note->getUser()->getFirstName(), 0, 1))
                                                        . "."
                            )
                        )
                    );
                }
            }
        }

        $this->forward404();
    }

    public function executeSetCheckedRadioLog(sfWebRequest $request)
    {
        if ($request->isXmlHttpRequest()) {
          
            $checked = $request->getParameter("title", FALSE);
            $survey_name = $request->getParameter("survey_name", FALSE);
            $organization = $request->getParameter("organization", FALSE);
            $survey_id = $request->getParameter("survey_id", FALSE);
            $shared_with_user = $request->getParameter("shared_with_user", FALSE);
            $shared_notes = $request->getParameter("shared_notes", FALSE);

            if (isset($checked) && !empty($checked)) 
            {
                if ($checked == 'Definite') {
                    $final_filename = $this->getUser()->getAttribute('log_file_name');
                    $logPath = sfConfig::get('sf_log_dir').'/'.$final_filename;
                    $custom_logger = new sfFileLogger(new sfEventDispatcher(), array('file' => $logPath));
                    
                    $custom_logger->info("Directory | My List Award | Definite | Award: ".$survey_name."; ".$organization." | ".$survey_id);

                } elseif ($checked == 'Share') {
                    $final_filename = $this->getUser()->getAttribute('log_file_name');
                    $logPath = sfConfig::get('sf_log_dir').'/'.$final_filename;
                    $custom_logger = new sfFileLogger(new sfEventDispatcher(), array('file' => $logPath));
                    
                    $custom_logger->info("Directory | My List Award | Share | Award: ".$survey_name."; ".$organization." | ".$survey_id." | ".$shared_with_user." | ".$shared_notes);
                
                } else{
                    $final_filename = $this->getUser()->getAttribute('log_file_name');
                    $logPath = sfConfig::get('sf_log_dir').'/'.$final_filename;
                    $custom_logger = new sfFileLogger(new sfEventDispatcher(), array('file' => $logPath));
                    
                    $custom_logger->info("Directory | My List Award | Maybe | Award: ".$survey_name."; ".$organization." | ".$survey_id);

                }
            }

        }die;
    }

    /**
     * Saving of additional info about my survey
     *
     * @param sfWebRequest $request     Request object
     *
     * @return array                    JSON array with response message
     */
    public function executeSaveMySurveyAdditionalInfo(sfWebRequest $request) {
        if ($request->isXmlHttpRequest()) {
            // Get request parameters
            $my_survey_id = $request->getParameter("my_survey_id", FALSE);
            $my_status    = $request->getParameter("my_status", NULL);
            $owner        = $request->getParameter("owner", NULL);
            $shared_with  = $request->getParameter("shared_with", NULL);
            $status = 'success';
            //var_dump($my_survey_id."---------".$owner);die;
            if($my_survey_id && is_numeric($owner)) {
                // Check existing of my survey
                $my_survey = Doctrine_Core::getTable("LtMySurvey")->findOneById($my_survey_id);

                if ($my_survey) {
                    // Get user
                    $user = $this->getUser()->getGuardUser();

                    // Check existing of my survey by owner
                    $owner_my_survey = Doctrine_Core::getTable("LtMySurvey")->findOneBySurveyIdAndUserId($my_survey->getSurveyId(), $owner);

                    // Save additional info to my survey
                    if (!empty($my_status)) {
                        $my_survey->setMyStatus($my_status);
                    } else {
                        $my_survey->setMyStatus(NULL);
                    }

                    //if (!empty($owner) && !$owner_my_survey) {
                    //    $my_survey->setOwnerId($owner);
                    //} else {
                    //    $my_survey->setOwnerId($user->getId());
                    //}

                    $my_survey->save();


                    // Save Share with
                    // get array all "user_id" this "survey_id"
                    $all_surveys = Doctrine_Core::getTable("LtMySurvey")->findBySurveyId($my_survey->getSurveyId());
                    $all_surveys_in_base = array();
                    foreach ($all_surveys as $surveys) {

                        if ($surveys->getUserId() != $owner) {
                            $all_surveys_in_base[] = $surveys->getUserId();
                        }
                    }

                    // Set new owner
                    if ($my_survey->getOwnerId() != $owner) {
                        $aword_exists = Doctrine_Core::getTable("LtMySurvey")->findExistsSurvey($owner, $my_survey->getSurveyId());

                        if (!empty($aword_exists)) {
                            // if aword with the user already exists, then update it share_with to "0"
                            Doctrine_Core::getTable("LtMySurvey")->updateOldOwner($my_survey->getSurveyId(), $owner);
                            $old_owner_aword_exists = $owner;
                        } else {
                            // // Add my survey to new owner
                            // if ($user->getId() !== $owner) {
                            //     if (!$owner_my_survey) {var_dump($owner);
                            //         $new_my_survey = new LtMySurvey();
                            //         $new_my_survey->setSurveyId($my_survey->getSurveyId());
                            //         $new_my_survey->setUserId($owner);
                            //         $new_my_survey->setOwnerId($owner);
                            //         if($my_survey->getSurvey() && (strtotime($my_survey->getSurvey()->getSubmissionDeadline()) < strtotime(date("Y-m-d")))) {
                            //             $new_my_survey->setIsDeadlinePast(true);
                            //         }die("-------!23");
                            //         $new_my_survey->save();die("!23");
                            //     }
                            // }
                        }
                        Doctrine_Core::getTable("LtMySurvey")->setNewOwnerForAword($my_survey->getSurveyId(), $owner);
                    }

                    // $all_surveys_in_base - array users, with has in base
                    // $shared_with - array new users

                    // set field "share_with" in zero
                    if (count($all_surveys_in_base) > 0 && empty($shared_with)) {
                        Doctrine_Core::getTable("LtMySurvey")->removeAllShareWith($my_survey->getSurveyId(), $this->getUser()->getGuardUser()->getId());

                    } elseif (is_array($shared_with) && count($shared_with) > 0) {
                        $result_array = array_diff($shared_with, $all_surveys_in_base);

                        if (count($result_array) > 0) {

                            $query = 'INSERT INTO `my_surveys` (`survey_id`, `user_id`, `my_status`, `owner_id`, `is_updated`, `is_deadline_past`, `share_with`, `created_at`, `updated_at`) VALUES';

                            foreach ($result_array as $value) {

                                if (isset($old_owner_aword_exists) && $old_owner_aword_exists == $value) {
                                    continue;
                                }

                                $is_insert = true;
                                if (!is_numeric($value)) {
                                    $status = 'error';
                                    unset($is_insert);
                                    break;
                                }
                                $query .= " ('".$my_survey->getSurveyId()."', '{$value}', NULL, '".$my_survey->getOwnerId()."', '0', '0', 1, NOW(), NOW()),";
                            }
                            $query = substr($query, 0, -1);

                            // execute query
                            if (isset($is_insert)) {
                                Doctrine_Manager::getInstance()->getCurrentConnection()->execute($query);
                            }
                        }

                        Doctrine_Core::getTable("LtMySurvey")->removeSpecifyShareWith($my_survey->getSurveyId(), $shared_with, $my_survey->getOwnerId());
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

        $this->forward404();
    }

    /**
     * Remove survey from "My Lists" section
     *
     * @param sfWebRequest $request     Request object
     *
     * @return array                    JSON array with response message
     */
    public function executeRemoveFromMyList(sfWebRequest $request) {
        if ($request->isXmlHttpRequest()) {
            // Get request parameters
            $my_survey_id = $request->getParameter("my_survey_id", FALSE);

            if ($my_survey_id) {
                // Check existing of my survey
                $my_survey = Doctrine_Core::getTable("LtMySurvey")->findOneById($my_survey_id);

                // get survey_id
                $survey_id = $my_survey->getSurveyId();
                $survey_name_log = $my_survey->getSurvey()->getSurveyName();

                if($my_survey) {


                    $final_filename = $this->getUser()->getAttribute('log_file_name');
                    $logPath = sfConfig::get('sf_log_dir').'/'.$final_filename;
                    $custom_logger = new sfFileLogger(new sfEventDispatcher(), array('file' => $logPath));
                    
                    $custom_logger->info("Directory - Delete Award From My List - Award Id - ".$survey_id." - Award Name - ".$survey_name_log);



                    $my_survey->delete();

                    // find next owner
                    $next_owner_id = Doctrine_Core::getTable("LtMySurvey")->findOneBySurveyId($survey_id);
                    if ($next_owner_id) {
                        $new_owner = $next_owner_id->getUserId();

                        // set new owner
                        Doctrine_Core::getTable("LtMySurvey")->setNewOwnerForAword($survey_id, $new_owner);
                    }


                    return $this->renderText(
                        json_encode(
                            array(
                                "status" => "success"
                            )
                        )
                    );
                }
            }
        }

        $this->forward404();
    }

    /**
     * Get all emails
     *
     * @param sfWebRequest $request     Request object
     *
     * @return array                    JSON array with response message
     */
    public function executeGetAllEmails(sfWebRequest $request)
    {
        $current_user_id =$this->getUser()->getGuardUser()->getId();

        $my_client_id =$this->getUser()->getGuardUser()->getClient_id();
        if(!$my_client_id)
        {
            return $this->renderText(
                json_encode(array())
            );
        }

        $query = 'SELECT * FROM sf_guard_user WHERE client_id="'. $my_client_id .'" AND id !="'.$current_user_id.'" ORDER BY last_name';
        $arrEmails = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($query)->fetchAll();

        $user = $this->getUser()->getGuardUser();

        //Get user first name and last name
        $recipient_first_name = $user->getFirstName();
        $recipient_last_name = $user->getLastName();
        $recipient_email_address = $user->getEmailAddress();

        $survey_id = $request->getParameter("survey_id", FALSE);
        $org = "- - -";
        $srv = "- - -";

        if ($survey_id) {
            // Get survey info
            $survey = Doctrine_Core::getTable("LtMySurvey")->getFullMySurveyInfo($survey_id, $this->getUser()->getGuardUser()->getId());

            if ($survey) {

                if ((!is_null($survey->getSurvey()->getOrganizationId()) && $survey->getSurvey()->getOrganizationId() != ""))
                {
                    $org = $survey->getSurvey()->getOrganization()->getName();
                }

                if (!is_null($survey->getSurvey()->getSurveyName()) && $survey->getSurvey()->getSurveyName() != "")
                {
                    $srv = $survey->getSurvey()->getSurveyName();
                }

            }
        }


        $newarray = '';
        if($arrEmails)
        {
            $i = 0;
            foreach($arrEmails as $email)
            {
                if(!empty($email['email_address']))
                {
                    $newarray[$i]['email'] = $email['email_address'];
                    if(!empty($email['first_name']))
                    $newarray[$i]['f_name'] = $email['first_name'];
                    if(!empty($email['last_name']))
                    $newarray[$i]['l_name'] = $email['last_name'];



                    $i++;
                }

            }
            $final['array'] = $newarray;
            $final['me'] = $recipient_first_name." ".$recipient_last_name." (".$recipient_email_address.")";
            $final['organization'] = $org;
            $final['survey_name'] = $srv;

            //$newarray['me'] = $recipient_first_name." ".$recipient_last_name;
            return $this->renderText(
                json_encode($final)
            );
        }
        //$this->forward404();
    }

    /**
     * Save Survey alert details
     *
     *  @param sfWebRequest $request     Request object
     *
     * @return array                    JSON array with response message
     */
    public function executeSaveAlertDetails(sfWebRequest $request)
    {
        if($request->isXmlHttpRequest())
        {
            $details = $request->getParameter('details');
//var_dump($details);die;
            $anytime = 0;
            foreach($details as $d)
            {
                if($d['name'] == 'time-frame')
                {
                    $time_frame = $d['value'];
                }

                if($d['name'] == 'time-frame-type')
                {
                    $time_frame_type = $d['value'];
                }

                if($d['name'] == 'survey_id')
                {
                    $s_id = $d['value'];
                }
                if($d['name'] == 'to_me')
                {
                    $email_to_me = $d['value'];
                }
                if($d['name'] == 'cc_emails' && !empty($d['value']))
                {
                    $cc_email = $d['value'];
                }
                else
                {
                    $cc_email = '';
                }

                if($d['name'] == 'updated' && $d['value'] == 'on')
                {
                    $anytime = '1';
                    $updated = $d['value'];

                }

            }
//var_dump($anytime . ", ". $updated);die;
            if(isset($email_to_me) && $email_to_me == "true")
            {
                $arrDetails['to_me'] = 1;
            }
            else{
                $arrDetails['to_me'] = 0;
            }
            $arrDetails['cc_email'] = '';

            foreach($details as $detail)
            {
                if($detail['name'] == 'cc_emails' && !empty($detail['value']))
                {
                    foreach($detail['value'] as $val)
                    {
                        $arrDetails['cc_email'] .= $val.', ';
                    }
                    $arrDetails['cc_email'] = substr($arrDetails['cc_email'], 0, -2);
                }

            }

            $query = 'SELECT * FROM `survey_alerts` WHERE `survey_id` = "'.$s_id.'" AND `time-frame` = "'.$time_frame.'" AND `time-frame-type` = "'.$time_frame_type.'" AND  `cc_email` = "'.$arrDetails['cc_email'].'" AND `email_me` = "'.$arrDetails['to_me'].'" AND `anytime_updated` = "'.$anytime.'" ';
            $res = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($query)->fetchAll();



            if(isset($res) && !empty($res))
            {
                return $this->renderText(
                    json_encode(
                        'error'
                    )
                );
            }
            else
            {                
                if(isset($updated) && !empty($updated))
                {
                    $query = 'INSERT INTO `survey_alerts` (`survey_id`, `user_id`, `time-frame`, `time-frame-type`, `cc_email`, `email_me`, `anytime_updated`, `created_at`) VALUES';
                    $query .= " ('".$s_id."', '{$this->getUser()->getGuardUser()->getId()}','".$time_frame."' , '".$time_frame_type."', '".$arrDetails['cc_email']."', '".$arrDetails['to_me']."', '".$anytime."', NOW())";
                }
                else
                {
                    $query = 'INSERT INTO `survey_alerts` (`survey_id`, `user_id`, `time-frame`, `time-frame-type`, `cc_email`, `email_me`, `anytime_updated`) VALUES';
                    $query .= " ('".$s_id."', '{$this->getUser()->getGuardUser()->getId()}','".$time_frame."' , '".$time_frame_type."', '".$arrDetails['cc_email']."', '".$arrDetails['to_me']."', 0 )";

                }
                // execute query
                if(Doctrine_Manager::getInstance()->getCurrentConnection()->execute($query))
                {
                    if ($s_id) 
                    {
                        $survey = Doctrine_Core::getTable("LtMySurvey")->getFullMySurveyInfo($s_id, $this->getUser()->getGuardUser()->getId());
                        if ($survey) 
                        {     
                            if (!is_null($survey->getSurvey()->getSurveyName()) && $survey->getSurvey()->getSurveyName() != "")
                            {
                                $srv = $survey->getSurvey()->getSurveyName();
                            }

                            if ((!is_null($survey->getSurvey()->getOrganizationId()) && $survey->getSurvey()->getOrganizationId() != "")) 
                            {                                           
                                $org = $survey->getSurvey()->getOrganization()->getName();                        
                            }
                        }
                    }

                    $final_filename = $this->getUser()->getAttribute('log_file_name');
                    $logPath = sfConfig::get('sf_log_dir').'/'.$final_filename;
                    $custom_logger = new sfFileLogger(new sfEventDispatcher(), array('file' => $logPath));
                    if ($anytime == 1) {
                        $yes = "Yes";
                    } else {
                        $yes = "No";
                    }
                    $custom_logger->info('Directory | My List Award | Set Alert | Award: '.$srv.'; '.$org.' | '.$s_id.' | '.$arrDetails['cc_email'].' | '.$time_frame.' '.$time_frame_type.' | '.$yes);

                    return $this->renderText(
                        json_encode(
                            $arrDetails
                        )
                    );
                }
            }
        }
        $this->forward404();
    }

    /**
     * Get current user email address666666
     * @param sfWebRequest $request**/

    public function executeGetMyEmail(sfWebRequest $request)
    {
        $user = $this->getUser()->getGuardUser();

        //Get user first name and last name
        $recipient_first_name = $user->getFirstName();
        $recipient_last_name = $user->getLastName();
        $recipient_email_address = $user->getEmailAddress();

        $final['me'] = $recipient_first_name." ".$recipient_last_name." (".$recipient_email_address.")";

        return $this->renderText(
            json_encode($final)
        );
    }

    /**
     * Get all Alerts for survey
     *
     * @param sfWebRequest $request     Request object
     *
     * @return array                    JSON array with response message
     */

    public function executeGetAllAlerts(sfWebRequest $request)
    {
        // $final_filename = $this->getUser()->getAttribute('log_file_name');
        // $logPath = sfConfig::get('sf_log_dir').'/'.$final_filename;
        // $custom_logger = new sfFileLogger(new sfEventDispatcher(), array('file' => $logPath));

        // $custom_logger->info("Directory - My List - Set Alert");

        if($request->isXmlHttpRequest())
        {
            //$alerts_array = array();
            $survey_id = $request->getParameter('survey_id');

            $current_user_id =$this->getUser()->getGuardUser()->getId();
            /*$query = 'SELECT first_name, last_name, email_address FROM sf_guard_user WHERE id ="'.$current_user_id.'"';
            $user_email = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($query)->fetch();*/

            if($survey_id)
            {
                $query = 'SELECT * FROM survey_alerts WHERE user_id="'.$this->getUser()->getGuardUser()->getId().'" AND survey_id="'.$survey_id.'"';

                $alerts_array= Doctrine_Manager::getInstance()->getCurrentConnection()->execute($query)->fetchAll();
                //$alerts_array['user_email'] = $user_email['first_name']." ".$user_email['first_name']." (".$user_email['email_address'].")";

                //Svar_dump($alerts_array);die;


                if(!empty($alerts_array))
                {
                    return $this->renderText(
                        json_encode(
                            $alerts_array
                        )
                    );
                }
                else
                {
                    return $this->renderText(
                        json_encode(
                            'error'
                        )
                    );
                }
            }
        }

    }

    /**
     * Remove Survey Alert
     *
     * @param sfWebRequest $request     Request object
     *
     * @return array                    JSON array with response message
     */

    public function executeRemoveSurveyAlert(sfWebRequest $request)
    {
        if ($request->isXmlHttpRequest()) {
            $alert_id = $request->getParameter("alert_id", FALSE);           
            $my_survey_name = $request->getParameter("my_survey_name", FALSE);           
            $organization = $request->getParameter("organization", FALSE);           

            
            if ($alert_id) {

                $query = 'SELECT * FROM survey_alerts WHERE id ='.$alert_id;
                $alert = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($query);
                if($alert)
                {
                    foreach ($alert as $key => $value) {
                        $survey_id = $value[1];
                        $time_frame = $value[3];
                        $time_frame_type = $value[4];
                        $cc_emails = $value[5];
                        $anytime = $value[7];
                    }
           
                }
               


                $query = 'DELETE FROM survey_alerts WHERE id ='.$alert_id;
                $alerts = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($query);
                if($alerts)
                {

                    //save info in log file
                    $final_filename = $this->getUser()->getAttribute('log_file_name');
                    $logPath = sfConfig::get('sf_log_dir').'/'.$final_filename;
                    $custom_logger = new sfFileLogger(new sfEventDispatcher(), array('file' => $logPath));
                    
                    if($time_frame == 0)
                    {
                        $time_frame = '';
                    }
                    if($anytime == 1)
                    {
                        $yes = "Yes";
                    } else {
                        $yes = "No";
                    }
                    //var_dump($survey_id);die;
                    $custom_logger->info('Directory | My List Award | Remove Alert | Award:  '.$my_survey_name.'; '.$organization.' | '.$survey_id.' | '.$cc_emails.' | '.$time_frame.' '.$time_frame_type.' | '.$yes);


                    return $this->renderText(
                            json_encode(
                                array(
                                    "status" => "success"
                                )
                            )
                        );
                }

            }          
        }
    }

    /**
     * Change Survey Alert
     *
     * @param sfWebRequest $request     Request object
     *
     * @return array                    JSON array with response message
     */
    public  function executeChangeAlert(sfWebRequest $request)
    {
        if ($request->isXmlHttpRequest()) {
            $details = $request->getParameter('details');

            if ($details) {
                foreach($details as $detail)
                {
                    $arrDetails[$detail['name']] = $detail['value'];
                }
                /*echo "<pre>";
                var_dump($arrDetails);die;*/
                if(isset($arrDetails['to_me']) && $arrDetails['to_me']=='on')
                {
                    $arrDetails['to_me'] = 1;
                }
                else{
                    $arrDetails['to_me'] = 0;
                }
                if(isset($arrDetails['updated']))
                {/*die("123");*/
                    $query = 'UPDATE survey_alerts SET `time-frame`="'.$arrDetails['time-frame'].'", `time-frame-type`="'.$arrDetails['time-frame-type'].'", `cc_email`="'.$arrDetails['to'].'", `email_me`="'.$arrDetails['to_me'].'", `created_at`=NOW()  WHERE id="'.$arrDetails['alert_id'].'"';
                }
                else
                {/*die("456");*/
                    $query = 'UPDATE survey_alerts SET `time-frame`="'.$arrDetails['time-frame'].'", `time-frame-type`="'.$arrDetails['time-frame-type'].'", `cc_email`="'.$arrDetails['to'].'", `email_me`="'.$arrDetails['to_me'].'"  WHERE id="'.$arrDetails['alert_id'].'"';

                }
                // execute query
                if(Doctrine_Manager::getInstance()->getCurrentConnection()->execute($query))
                {
                    return $this->renderText(
                        json_encode(
                            $arrDetails
                        )
                    );
                }
            }
        }
    }
    /**
     * Set "Updated/Deadline Past" flag for my survey by click on bubble
     *
     * @param sfWebRequest $request     Request object
     *
     * @return array                    JSON array with response message
     */
    public function executeSetFlagByClick(sfWebRequest $request) {
        if ($request->isXmlHttpRequest()) {
            // Get request parameters
            $my_survey_id = $request->getParameter("my_survey_id", FALSE);
            $bubble_type  = $request->getParameter("bubble_type", FALSE);
            $flag         = $request->getParameter("flag", FALSE);

            if ($my_survey_id && ($bubble_type === "updated" || $bubble_type === "past_dues")) {
                // Check existing of my survey
                $my_survey = Doctrine_Core::getTable("LtMySurvey")->findOneById($my_survey_id);

                if ($my_survey) {
                    // Set flag
                    if ($bubble_type === "updated") {
                        $my_survey->setIsUpdated((bool) $flag);
                    } else {
                        $my_survey->setIsDeadlinePast((bool) $flag);
                    }

                    $my_survey->save();

                    return $this->renderText(
                        json_encode(
                            array(
                                "status" => "success"
                            )
                        )
                    );
                }
            }
        }

        $this->forward404();
    }

}
