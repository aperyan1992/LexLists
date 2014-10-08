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
        $this->survey_practice_areas = Doctrine_Core::getTable("LtPracticeArea")->findAll();
        $this->survey_practice_areas_checkboxes = "";
        foreach ($this->survey_practice_areas as $practice_area) {
            $practice_area_name = $practice_area->getShortCode();

            $this->survey_practice_areas_checkboxes .= '<input checkbox_type="practice_area" type="checkbox" class="practice_area_checkbox" col_num="5" value="' . $practice_area_name . '" id="' . $practice_area_name . '" /><span>' . $practice_area_name . '</span><br />';
        }

        // Get survey regions
        $this->survey_regions = Doctrine_Core::getTable('LtSurvey')->getSurveyRegions();
        $this->survey_regions_checkboxes = "";
        foreach ($this->survey_regions as $region) {
            $region_name = $region->getRegion()->getName();

            $this->survey_regions_checkboxes .= '<input checkbox_type="region" type="checkbox" class="region_checkbox" col_num="7" value="' . $region_name . '" id="' . $region_name . '" /><span>' . $region_name . '</span><br />';
        }

        // Get survey special criterias
        $this->survey_special_criterias = Doctrine_Core::getTable('LtSpecialCriteria')->findAll();
        $this->survey_special_criterias_checkboxes = "";
        foreach ($this->survey_special_criterias as $special_criteria) {
            $s_criteria = $special_criteria->getName();

            $this->survey_special_criterias_checkboxes .= '<input checkbox_type="special_criteria" type="checkbox" class="special_criteria_checkbox" col_num="6" value="' . $s_criteria . '" id="' . $s_criteria . '" /><span>' . $s_criteria . '</span><br />';
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
                    $survey_checkbox = "<input type='checkbox' class='table_checkbox' s_id='" . $survey->getId() . "' />";

                    // Set year
                    $year = (!is_null($survey->getYear()) && $survey->getYear() != "" && $survey->getYear() != 0) ? $survey->getYear() : "- - -";

                    // Set organization
                    $organization = (!is_null($survey->getOrganizationId()) && $survey->getOrganizationId() != "") ? $survey->getOrganization()->getName() : "- - -";

                    // Set survey name
                    $survey_name = (!is_null($survey->getSurveyName()) && $survey->getSurveyName() != "") ? $survey->getSurveyName() : "- - -";

                    // Set survey name link
                    $survey_name_link = "<a href='#' class='custom_link details_link' s_id='" . $survey->getId() . "'>" . $survey_name . "</a>";

                    // Set candidate type
                    $candidate_type = (!is_null($survey->getCandidateType()) && $survey->getCandidateType() != "" && $survey->getCandidateType() != "0") ? LtSurvey::$candidate_types_array[$survey->getCandidateType()] : "- - -";

                    // Set practice area
                    $practice_areas = "- - -";
                    if ($survey->getLtSurveyPracticeArea()->getFirst()) {
                        $practice_area_array = array();
                        foreach ($survey->getLtSurveyPracticeArea() as $practice_area) {
                            $practice_area_array[] = $practice_area->getPracticeArea()->getShortCode();
                        }

                        $practice_areas = implode(", ", $practice_area_array);
                    }

                    // Set special criteria
                    $special_criterias = "- - -";
                    if ($survey->getLtSurveySpecialCriteria()->getFirst()) {
                        $special_criteria_array = array();
                        foreach ($survey->getLtSurveySpecialCriteria() as $special_criteria) {
                            $special_criteria_array[] = $special_criteria->getSpecialCriteria()->getName();
                        }

                        $special_criterias = implode(", ", $special_criteria_array);
                    }

                    // Set region
                    $region = (!is_null($survey->getSurveyRegionId()) && $survey->getSurveyRegionId() != "") ? $survey->getRegion()->getName() : "- - -";

                    // Set cities
                    $cities = "- - -";
                    if ($survey->getLtSurveyCity()->getFirst()) {
                        $cities_array = array();
                        foreach ($survey->getLtSurveyCity() as $city) {
                            $cities_array[] = $city->getCity()->getName();
                        }

                        $cities = implode(", ", $cities_array);
                    }
                    
                    // Set states
                    $states = "- - -";
                    if ($survey->getLtSurveyState()->getFirst()) {
                        $states_array = array();
                        foreach ($survey->getLtSurveyState() as $state) {
                            $states_array[] = $state->getState()->getName();
                        }

                        $states = implode(", ", $states_array);
                    }
                    
                    // Set countries
                    $countries = "- - -";
                    if ($survey->getLtSurveyCountry()->getFirst()) {
                        $countries_array = array();
                        foreach ($survey->getLtSurveyCountry() as $country) {
                            $countries_array[] = $country->getCountry()->getName();
                        }

                        $countries = implode(", ", $countries_array);
                    }
                    
                    // Set submission deadline
                    $submission_deadline = (!is_null($survey->getSubmissionDeadline()) && $survey->getSubmissionDeadline() != "") ? $survey->getSubmissionDeadline() : "- - -";

                    // Set eligibility
                    $eligibility = (!is_null($survey->getEligibilityCriteria()) && $survey->getEligibilityCriteria() != "") ? $survey->getShortEligibilityCriteria() : "- - -";
                    
                    // Set description
                    $description = (!is_null($survey->getSurveyDescription()) && $survey->getSurveyDescription() != "") ? $survey->getShortSurveyDescription() : "- - -";

                    // Set methodology
                    $methodology = (!is_null($survey->getSelectionMethodology()) && $survey->getSelectionMethodology() != "") ? $survey->getShortSelectionMethodology() : "- - -";
                            
                    // Set email
                    $email_link = "<a href='#' class='custom_link email_link' s_id='" . $survey->getId() . "'><span class='genericon genericon-mail'></span></a>";

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
                        $email_link,
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
                            ->setSubject("LexLists E-mail")
                            ->setBody($this->getPartial("dashboard/survey_email_or_print", array("surveys" => $surveys, "additional_message" => $additional_message)))
                            ->setContentType("text/html");

                    $send_status = $this->getMailer()->send($message);

                    // Check sending status
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
        // Get request parameters
        $survey_ids = $request->getParameter("surveys_for_print", FALSE);
        
        if ($survey_ids) {
            // Check if surveys exists
            $surveys = Doctrine_Core::getTable("LtSurvey")->getSurveysByIds($survey_ids);
            if ($surveys->getFirst()) {    
                $this->setLayout(false);
                
                return $this->renderPartial("dashboard/survey_email_or_print", array("surveys" => $surveys, "additional_message" => false));
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

            if ($survey_id) {
                // Get survey info
                $survey = Doctrine_Core::getTable("LtSurvey")->getFullInfo($survey_id);

                // Get year
                $year = (!is_null($survey->getYear()) && $survey->getYear() != "") ? $survey->getYear() : "- - -";

                // Get organization
                $organization = "- - -";
                if ((!is_null($survey->getOrganizationUrl()) && $survey->getOrganizationUrl() != "") &&
                        (!is_null($survey->getOrganizationId()) && $survey->getOrganizationId() != "")) {
                    $organization = "<a class='custom_link' target='_blank' href='" . $survey->getOrganizationUrl() . "'>" . $survey->getOrganization()->getName() . "</a>";
                }

                // Get survey name
                $survey_name = (!is_null($survey->getSurveyName()) && $survey->getSurveyName() != "") ? $survey->getSurveyName() : "- - -";

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

                    $contact_person = $survey->getContact()->getLastName() .
                            ", " .
                            $survey->getContact()->getFirstName() .
                            " (" .
                            $survey->getContact()->getEmailAddress() .
                            ") " .
                            $phone_number;
                }

                // Get survey ID
                $s_id = $survey->getId();

                // Get created date
                $created_date = $survey->getCreatedAt();

                // Get updated date
                $updated_date = $survey->getUpdatedAt();

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
                            "updated_date"           => $updated_date
                        )
                    )
                );
            }
        }

        $this->forward404();
    }

}
