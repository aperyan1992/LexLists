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
        $this->survey_practice_areas = Doctrine_Core::getTable("LtPracticeArea")->getAllPracticeAreas();
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
            
            if (isset($surveys) && $surveys->getFirst()) {
                $aa_data_array = array("aaData" => array());

                foreach ($surveys as $survey) {
                    // Set survey checkbox
                    $survey_checkbox = "<input type='checkbox' class='table_checkbox' />";

                    // Set year
                    $year = (!is_null($survey->getSurvey()->getYear()) && $survey->getSurvey()->getYear() != "" && $survey->getSurvey()->getYear() != 0) ? $survey->getSurvey()->getYear() : "- - -";

                    // Set organization
                    $organization = (!is_null($survey->getSurvey()->getOrganizationId()) && $survey->getSurvey()->getOrganizationId() != "") ? $survey->getSurvey()->getOrganization()->getName() : "- - -";

                    // Set survey name
                    $survey_name = (!is_null($survey->getSurvey()->getSurveyName()) && $survey->getSurvey()->getSurveyName() != "") ? $survey->getSurvey()->getSurveyName() : "- - -";

                    // Set survey name link with bubbles
                    $updated_bubble = "";
                    $is_updated     = 0;
                    if ($survey->getIsUpdated()) {
                        $updated_bubble = "<span class='bubble green table_bubble' ms_id='" . $survey->getId() . "' bubble_type='updated' title='Award info has been updated.'></span>";
                        $is_updated     = 1;
                    }
                    $past_due_bubble = "";
                    $is_past_due     = 0;
                    if ($survey->getIsDeadlinePast()) {
                        $past_due_bubble = "<span class='bubble red table_bubble' ms_id='" . $survey->getId() . "' bubble_type='past_dues' title='Submission deadline passed.'></span>";
                        $is_past_due     = 1;
                    }
                    $survey_name_link = "<div class='survey_name_wrapper'>"
                            . $updated_bubble
                            . $past_due_bubble
                            . "<a href='#' class='custom_link details_link_for_my_lists' s_id='" . $survey->getSurvey()->getId() . "'>" . $survey_name . "</a>"
                            . "</div>";

                    // Set candidate type
                    $candidate_type = (!is_null($survey->getSurvey()->getCandidateType()) && $survey->getSurvey()->getCandidateType() != "") ? LtSurvey::$candidate_types_array[$survey->getSurvey()->getCandidateType()] : "- - -";

                    // Set practice area
                    $practice_areas = "- - -";
                    if ($survey->getSurvey()->getLtSurveyPracticeArea()->getFirst()) {
                        $practice_area_array = array();
                        foreach ($survey->getSurvey()->getLtSurveyPracticeArea() as $practice_area) {
                            $practice_area_array[] = $practice_area->getPracticeArea()->getShortCode();
                        }

                        $practice_areas = implode(", ", $practice_area_array);
                    }

                    // Set special criteria
                    $special_criterias = "- - -";
                    if ($survey->getSurvey()->getLtSurveySpecialCriteria()->getFirst()) {
                        $special_criteria_array = array();
                        foreach ($survey->getSurvey()->getLtSurveySpecialCriteria() as $special_criteria) {
                            $special_criteria_array[] = $special_criteria->getSpecialCriteria()->getName();
                        }

                        $special_criterias = implode(", ", $special_criteria_array);
                    }

                    // Set region
                    $region = (!is_null($survey->getSurvey()->getSurveyRegionId()) && $survey->getSurvey()->getSurveyRegionId() != "") ? $survey->getSurvey()->getRegion()->getName() : "- - -";

                    // Set cities
                    $cities = "- - -";
                    if ($survey->getSurvey()->getLtSurveyCity()->getFirst()) {
                        $cities_array = array();
                        foreach ($survey->getSurvey()->getLtSurveyCity() as $city) {
                            $cities_array[] = $city->getCity()->getName();
                        }

                        $cities = implode(", ", $cities_array);
                    }
                    
                    // Set states
                    $states = "- - -";
                    if ($survey->getSurvey()->getLtSurveyState()->getFirst()) {
                        $states_array = array();
                        foreach ($survey->getSurvey()->getLtSurveyState() as $state) {
                            $states_array[] = $state->getState()->getName();
                        }

                        $states = implode(", ", $states_array);
                    }
                    
                    // Set countries
                    $countries = "- - -";
                    if ($survey->getSurvey()->getLtSurveyCountry()->getFirst()) {
                        $countries_array = array();
                        foreach ($survey->getSurvey()->getLtSurveyCountry() as $country) {
                            $countries_array[] = $country->getCountry()->getName();
                        }

                        $countries = implode(", ", $countries_array);
                    }
                    
                    // Set submission deadline
                    $submission_deadline = (!is_null($survey->getSurvey()->getSubmissionDeadline()) && $survey->getSurvey()->getSubmissionDeadline() != "") ? $survey->getSurvey()->getSubmissionDeadline() : "- - -";

                    // Set my status
                    $my_status = (!is_null($survey->getMyStatus()) && $survey->getMyStatus() != "") ? LtMySurvey::$my_statuses_array[$survey->getMyStatus()] : "- - -";
                    
                    // Set owner
                    $owner = (!is_null($survey->getOwnerId()) && $survey->getOwnerId() != "") ? (ucfirst($survey->getOwner()->getLastName()) . ", " . ucfirst(substr($survey->getOwner()->getFirstName(), 0, 1)) . "." ) : "- - -";
                    
                    // Set eligibility
                    $eligibility = (!is_null($survey->getSurvey()->getEligibilityCriteria()) && $survey->getSurvey()->getEligibilityCriteria() != "") ? $survey->getSurvey()->getShortEligibilityCriteria() : "- - -";
                    
                    // Set description
                    $description = (!is_null($survey->getSurvey()->getSurveyDescription()) && $survey->getSurvey()->getSurveyDescription() != "") ? $survey->getSurvey()->getShortSurveyDescription() : "- - -";

                    // Set methodology
                    $methodology = (!is_null($survey->getSurvey()->getSelectionMethodology()) && $survey->getSurvey()->getSelectionMethodology() != "") ? $survey->getSurvey()->getShortSelectionMethodology() : "- - -";
                                        
                    // Set email
                    $email_link = '<div class="menu-drop-wrapper">
                                        <a href="#" class="menu_link">
                                            <span class="genericon genericon-menu"></span>
                                        </a>
                                        <ul class="menu-dropdown" >
                                            <li><a href="#">Set an Alert</a></li>
                                            <li><a href="#">Send a Reminder</a></li>
                                            <li><a href="#" class="my_list_email_send" s_id="' . $survey->getSurvey()->getId() . '">E-mail</a></li>
                                            <li><a href="#" class="my_list_remove_survey" ms_id="' . $survey->getId() . '" updated="' . $is_updated . '" past_due="' . $is_past_due . '">Remove from MyList</a></li>
                                        </ul>
                                    </div>
                    ';

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
                        $email_link
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

            if ($survey_id) {
                // Get survey info
                $survey = Doctrine_Core::getTable("LtMySurvey")->getFullMySurveyInfo($survey_id, $this->getUser()->getGuardUser()->getId());

                if ($survey) {
                    // Get year
                    $year = (!is_null($survey->getSurvey()->getYear()) && $survey->getSurvey()->getYear() != "") ? $survey->getSurvey()->getYear() : "- - -";

                    // Get organization
                    $organization = "- - -";
                    if ((!is_null($survey->getSurvey()->getOrganizationUrl()) && $survey->getSurvey()->getOrganizationUrl() != "") &&
                            (!is_null($survey->getSurvey()->getOrganizationId()) && $survey->getSurvey()->getOrganizationId() != "")) {
                        $organization = "<a class='custom_link' target='_blank' href='" . $survey->getSurvey()->getOrganizationUrl() . "'>" . $survey->getSurvey()->getOrganization()->getName() . "</a>";
                    }

                    // Get survey name
                    $survey_name = (!is_null($survey->getSurvey()->getSurveyName()) && $survey->getSurvey()->getSurveyName() != "") ? $survey->getSurvey()->getSurveyName() : "- - -";

                    // Get submission deadline
                    $submission_deadline = (!is_null($survey->getSurvey()->getSubmissionDeadline()) && $survey->getSurvey()->getSubmissionDeadline() != "") ? $survey->getSurvey()->getSubmissionDeadline() : "- - -";

                    // Get candidate type
                    $candidate_type = ($survey->getSurvey()->getCandidateType() != 0) ? LtSurvey::$candidate_types_array[$survey->getSurvey()->getCandidateType()] : "- - -";

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
                    $eligibility_notes = (!is_null($survey->getSurvey()->getEligibilityCriteria()) && $survey->getSurvey()->getEligibilityCriteria() != "") ? $survey->getSurvey()->getEligibilityCriteria() : "- - -";

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
                    if ($survey->getSurvey()->getRegion() || $survey->getSurvey()->getLtSurveyCity()->getFirst() || $survey->getSurvey()->getLtSurveyState()->getFirst() || $survey->getSurvey()->getLtSurveyCountry()->getFirst()) {
                        // Get region
                        $region = "- - -";
                        if ($survey->getSurvey()->getRegion()) {
                            $region = $survey->getSurvey()->getRegion()->getName();
                        }

                        // Get cities
                        $cities = "- - -";
                        if ($survey->getSurvey()->getLtSurveyCity()->getFirst()) {
                            $cities_array = array();
                            foreach ($survey->getSurvey()->getLtSurveyCity() as $city) {
                                $cities_array[] = $city->getCity()->getName();
                            }

                            $cities = implode(", ", $cities_array);
                        }

                        // Get countries
                        $countries = "- - -";
                        if ($survey->getSurvey()->getLtSurveyCountry()->getFirst()) {
                            $countries_array = array();
                            foreach ($survey->getSurvey()->getLtSurveyCountry() as $country) {
                                $countries_array[] = $country->getCountry()->getName();
                            }

                            $countries = implode(", ", $countries_array);
                        }

                        // Get states
                        $states = "- - -";
                        if ($survey->getSurvey()->getLtSurveyState()->getFirst()) {
                            $states_array = array();
                            foreach ($survey->getSurvey()->getLtSurveyState() as $state) {
                                $states_array[] = $state->getState()->getName();
                            }

                            $states = implode(", ", $states_array);
                        }

                        $geographic_area = $region . "; " . $cities . "; " . $states . "; " . $countries . ";";
                    }

                    // Get description
                    $description = (!is_null($survey->getSurvey()->getSurveyDescription()) && $survey->getSurvey()->getSurveyDescription() != "") ? $survey->getSurvey()->getSurveyDescription() : "- - -";

                    // Get submission methodology
                    $submission_methodology = (!is_null($survey->getSurvey()->getSelectionMethodology()) && $survey->getSurvey()->getSelectionMethodology() != "") ? $survey->getSurvey()->getSelectionMethodology() : "- - -";

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

                        $contact_person = $survey->getSurvey()->getContact()->getLastName() .
                                ", " .
                                $survey->getSurvey()->getContact()->getFirstName() .
                                " (" .
                                $survey->getSurvey()->getContact()->getEmailAddress() .
                                ") " .
                                $phone_number;
                    }

                    // Get survey ID
                    $s_id = $survey->getSurvey()->getId();

                    // Get created date
                    $created_date = $survey->getSurvey()->getCreatedAt();

                    // Get updated date
                    $updated_date = $survey->getSurvey()->getUpdatedAt();

                    // Get owners list
                    $share_with_list_user = $owners = Doctrine_Core::getTable("sfGuardUser")->getUsersList($this->getUser()->hasCredential("superuser"));
                    
                    // Get current owner
                    $owner = $survey->getOwner()->getId();
                    
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
                        if ($share_with_list_user[$value->getUserId()]) {
                            unset($share_with_list_user[$value->getUserId()]);
                        }
                    }

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
                                "owners"                 => $owners,
                                "owner"                  => $owner,
                                "my_status"              => $my_status,
                                "my_survey_id"           => $my_survey_id,
                                "share_with"             => $share_with,
                                "share_with_list_user"   => $share_with_list_user,
                            )
                        )
                    );
                }
            }
        }

        $this->forward404();
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
                            // Add my survey to new owner
                            if ($user->getId() !== $owner) {
                                if (!$owner_my_survey) {
                                    $new_my_survey = new LtMySurvey();
                                    $new_my_survey->setSurveyId($my_survey->getSurveyId());
                                    $new_my_survey->setUserId($owner);
                                    $new_my_survey->setOwnerId($owner);
                                    if($my_survey->getSurvey() && (strtotime($my_survey->getSurvey()->getSubmissionDeadline()) < strtotime(date("Y-m-d")))) {
                                        $new_my_survey->setIsDeadlinePast(true);
                                    }
                                    $new_my_survey->save();
                                }
                            }
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
                
                if($my_survey) {
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
