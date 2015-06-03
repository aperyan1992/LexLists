<?php

require_once dirname(__FILE__) . '/../lib/surveyManagementGeneratorConfiguration.class.php';
require_once dirname(__FILE__) . '/../lib/surveyManagementGeneratorHelper.class.php';

/**
 * surveyManagement actions.
 *
 * @package    LexLists
 * @subpackage surveyManagement
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class surveyManagementActions extends autoSurveyManagementActions {

    /**
     * Saving of survey information
     * 
     * @param sfWebRequest $request     Request object
     * 
     * @return array                    JSON array with response message
     */
    public function executeSaveSurveyInfo(sfWebRequest $request) {
        if ($request->isXmlHttpRequest()) {
            // Get parameters
            $organization          = $request->getParameter("organization", NULL);
            $organization_url      = $request->getParameter("organization_url", NULL);
            $survey_name           = $request->getParameter("survey_name", NULL);
            $survey_year           = $request->getParameter("survey_year", NULL);
            $survey_url            = $request->getParameter("survey_url", NULL);
            $frequency             = $request->getParameter("frequency", NULL);
            $submission_deadline   = $request->getParameter("submission_deadline", NULL);
            $survey_cities         = $request->getParameter("survey_cities", NULL);
            $survey_states         = $request->getParameter("survey_states", NULL);
            $survey_countries      = $request->getParameter("survey_countries", NULL);
            $survey_region         = $request->getParameter("survey_region", NULL);
            $survey_description    = $request->getParameter("survey_description", NULL);
            $candidate_type        = $request->getParameter("candidate_type", NULL);
            $eligibility_criteria  = $request->getParameter("eligibility_criteria", NULL);
            $special_criterias     = $request->getParameter("special_criterias", NULL);
            $practice_areas        = $request->getParameter("practice_areas", NULL);
            $nomination            = $request->getParameter("nomination", NULL);
            $selection_methodology = $request->getParameter("selection_methodology", NULL);
            $self_nomination       = $request->getParameter("self_nomination", NULL);
            $fees                  = $request->getParameter("fees", NULL);
            $pay_for_play          = $request->getParameter("pay_for_play", NULL);
            $keywords              = $request->getParameter("keywords", NULL);
            $contact_id            = $request->getParameter("contact_id", NULL);
            $survey_notes          = $request->getParameter("survey_notes", NULL);
            $staff_notes           = $request->getParameter("staff_notes", NULL);
            $is_new_object         = $request->getParameter("is_new_object", FALSE);

            if ($is_new_object) {
                if ($is_new_object == 'true') {
                    $survey = new LtSurvey();
                } else {
                    $survey = Doctrine_Core::getTable("LtSurvey")->findOneById($is_new_object);
                    if (!$survey) {
                        return $this->renderText(
                            json_encode(
                                array(
                                    "status" => "error"
                                )
                            )
                        );
                    }
                }

                // Get connection
                $con = Doctrine_Manager::getInstance()->getCurrentConnection();

                try {
                    $con->beginTransaction();

                    // Save/Update survey
                    if (!empty($organization)) {
                        $survey->setOrganizationId($organization);
                    } else {
                        $survey->setOrganizationId(NULL);
                    }
                    $survey->setOrganizationUrl($organization_url);
                    $survey->setKeywords($keywords);
                    $survey->setSurveyName($survey_name);
                    if (!empty($survey_year)) {
                        $survey->setYear($survey_year);
                    } else {
                        $survey->setYear(NULL);
                    }
                    $survey->setSurveyUrl($survey_url);
                    $survey->setFrequency($frequency);
                    if (!empty($submission_deadline)) {
                        $survey->setSubmissionDeadline(date("Y-m-d", strtotime($submission_deadline)));
                    } else {
                        $survey->setSubmissionDeadline(NULL);
                    }
                    if (!empty($survey_region)) {
                        $survey->setSurveyRegionId($survey_region);
                    } else {
                        $survey->setSurveyRegionId(NULL);
                    }
                    $survey->setSurveyDescription($survey_description);
                    $survey->setCandidateType($candidate_type);
                    $survey->setEligibilityCriteria($eligibility_criteria);
                    $survey->setNomination($nomination);
                    $survey->setSelectionMethodology($selection_methodology);
                    if ($self_nomination != "false") {
                        $survey->setSelfNomination($self_nomination);
                    }
                    if ($fees != "false") {
                        $survey->setFees($fees);
                    }
                    if ($pay_for_play != "false") {
                        $survey->setPayForPlay($pay_for_play);
                    }
                    if (!empty($contact_id)) {
                        $survey->setSurveyContactId($contact_id);
                    } else {
                        $survey->setSurveyContactId(NULL);
                    }
                    $survey->setSurveyNotes($survey_notes);
                    $survey->setStaffNotes($staff_notes);
                    $survey->save();

                    // Save survey cities
                    Doctrine_Core::getTable("LtSurveyCity")->deleteOldRows($survey->getId());
                    if (!empty($survey_cities)) {
                        foreach ($survey_cities as $survey_city) {
                            $new_survey_city = new LtSurveyCity();
                            $new_survey_city->setSurvey($survey);
                            $new_survey_city->setCityId($survey_city);
                            $new_survey_city->save();
                        }
                    }
                    
                    // Save survey states
                    Doctrine_Core::getTable("LtSurveyState")->deleteOldRows($survey->getId());
                    if (!empty($survey_states)) {
                        foreach ($survey_states as $survey_state) {
                            $new_survey_state = new LtSurveyState();
                            $new_survey_state->setSurvey($survey);
                            $new_survey_state->setStateId($survey_state);
                            $new_survey_state->save();
                        }
                    }

                    // Save survey countries
                    Doctrine_Core::getTable("LtSurveyCountry")->deleteOldRows($survey->getId());
                    if (!empty($survey_countries)) {
                        foreach ($survey_countries as $survey_country) {
                            $new_survey_country = new LtSurveyCountry();
                            $new_survey_country->setSurvey($survey);
                            $new_survey_country->setCountryId($survey_country);
                            $new_survey_country->save();
                        }
                    }

                    // Save survey special criterias
                    Doctrine_Core::getTable("LtSurveySpecialCriteria")->deleteOldRows($survey->getId());
                    if (!empty($special_criterias)) {
                        foreach ($special_criterias as $special_criteria) {
                            $new_special_criteria = new LtSurveySpecialCriteria();
                            $new_special_criteria->setSurvey($survey);
                            $new_special_criteria->setSpecialCriteriaId($special_criteria);
                            $new_special_criteria->save();
                        }
                    }

                    // Save survey practice areas
                    Doctrine_Core::getTable("LtSurveyPracticeArea")->deleteOldRows($survey->getId());
                    if (!empty($practice_areas)) {
                        foreach ($practice_areas as $practice_area) {
                            $new_practice_area = new LtSurveyPracticeArea();
                            $new_practice_area->setSurvey($survey);
                            $new_practice_area->setPracticeAreaId($practice_area);
                            $new_practice_area->save();
                        }
                    }

                    // Set flag for updated survey (for "My List" section)
                    $updated_survey = Doctrine_Core::getTable("LtMySurvey")->setFlagForUpdatedSurvey($survey->getId());

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
                    var_dump($ex->getMessage());
                    exit;
                }
            }
        }

        $this->forward404();
    }

    /**
     * Add survey contact
     * 
     * @param sfWebRequest $request     Request parameters
     * 
     * @return array                    JSON array with new marketing contact info
     */
    public function executeAddSurveyContact(sfWebRequest $request) {
        if ($request->isXmlHttpRequest()) {
            // Get request parameters
            $first_name    = $request->getParameter('first_name', FALSE);
            $last_name     = $request->getParameter("last_name", FALSE);
            $email_address = $request->getParameter("email", FALSE);
            $phone_number  = $request->getParameter("phone", FALSE);

            if ($first_name && $last_name && $email_address) {
                // Check unique email address
                $check_email_address = Doctrine_Core::getTable("LtSurveyContact")->findOneByEmailAddress($email_address);

                if (!$check_email_address) {
                    // Save new survey contact
                    $new_survey_contact = new LtSurveyContact();
                    $new_survey_contact->setFirstName($first_name);
                    $new_survey_contact->setLastName($last_name);
                    $new_survey_contact->setEmailAddress($email_address);
                    $new_survey_contact->setPhoneNumber($phone_number);
                    $new_survey_contact->save();

                    // Set array with contact's info
                    $contact_array = array(
                        "id"            => $new_survey_contact->getId(),
                        "first_name"    => $new_survey_contact->getFirstName(),
                        "last_name"     => $new_survey_contact->getLastName(),
                        "email_address" => $new_survey_contact->getEmailAddress(),
                        "phone_number"  => ($new_survey_contact->getPhoneNumber() != "") ? $new_survey_contact->getPhoneNumber() : "- - -",
                        "error"         => FALSE
                    );

                    return $this->renderText(json_encode($contact_array));
                } else {
                    return $this->renderText(json_encode(array("error" => "email")));
                }
            }
        }

        $this->forward404();
    }

    /**
     * Add organization
     * 
     * @param sfWebRequest $request     Request parameters
     * 
     * @return array                    JSON array with new marketing contact info
     */
    public function executeAddOrganization(sfWebRequest $request) {
        if ($request->isXmlHttpRequest()) {
            // Get request parameters
            $organization = $request->getParameter('organization', FALSE);

            if ($organization) {
                // Check unique organization
                $check_organization = Doctrine_Core::getTable("LtOrganization")->findOneByName($organization);

                if (!$check_organization) {
                    // Save new organization
                    $new_organization = new LtOrganization();
                    $new_organization->setName($organization);
                    $new_organization->save();

                    // Set array with organization's info
                    $organization_array = array(
                        "id"           => $new_organization->getId(),
                        "organization" => $new_organization->getName(),
                        "error"        => FALSE
                    );

                    return $this->renderText(json_encode($organization_array));
                } else {
                    return $this->renderText(json_encode(array("error" => "exists")));
                }
            }
        }

        $this->forward404();
    }

    /**
     * Add survey city
     * 
     * @param sfWebRequest $request     Request parameters
     * 
     * @return array                    JSON array with new marketing contact info
     */
    public function executeAddSurveyCity(sfWebRequest $request) {
        if ($request->isXmlHttpRequest()) {
            // Get request parameters
            $survey_city = $request->getParameter('survey_city', FALSE);

            if ($survey_city) {
                // Check unique city
                $check_city = Doctrine_Core::getTable("LtCity")->findOneByName(trim($survey_city));

                if (!$check_city) {
                    // Save new survey city
                    $new_survey_city = new LtCity();
                    $new_survey_city->setName($survey_city);
                    $new_survey_city->save();

                    // Set array with city's info
                    $city_array = array(
                        "id"    => $new_survey_city->getId(),
                        "city"  => $new_survey_city->getName(),
                        "error" => FALSE
                    );

                    return $this->renderText(json_encode($city_array));
                } else {
                    return $this->renderText(json_encode(array("error" => "exists")));
                }
            }
        }

        $this->forward404();
    }
    
    /**
     * Add survey special criteria
     * 
     * @param sfWebRequest $request     Request parameters
     * 
     * @return array                    JSON array with new marketing contact info
     */
    public function executeAddSurveySpecialCriteria(sfWebRequest $request) {
        if ($request->isXmlHttpRequest()) {
            // Get request parameters
            $survey_special_criteria = $request->getParameter('survey_special_criteria', FALSE);

            if ($survey_special_criteria) {
                // Check unique special criteria
                $check_special_criteria = Doctrine_Core::getTable("LtSpecialCriteria")->findOneByName($survey_special_criteria);

                if (!$check_special_criteria) {
                    // Save new survey special criteria
                    $new_survey_special_criteria = new LtSpecialCriteria();
                    $new_survey_special_criteria->setName($survey_special_criteria);
                    $new_survey_special_criteria->save();

                    // Set array with special criteria's info
                    $special_criteria_array = array(
                        "id"               => $new_survey_special_criteria->getId(),
                        "special_criteria" => $new_survey_special_criteria->getName(),
                        "error"            => FALSE
                    );

                    return $this->renderText(json_encode($special_criteria_array));
                } else {
                    return $this->renderText(json_encode(array("error" => "exists")));
                }
            }
        }

        $this->forward404();
    }

}
