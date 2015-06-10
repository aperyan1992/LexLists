<?php

/**
 * SurveyManagement form.
 *
 * @package       LexLists
 * @subpackage    form
 * @author        Sergey Kuprianov <sergey.kuprianov@sibers.com>
 */
class SurveyManagementForm extends LtSurveyForm {

    /**
     *
     */
    public function configure() {
    // Remove fields
    $this->removeFields();
    
    // Get years range
    $years_range_array = array();
    for($year = sfConfig::get("app_survey_year_from"); $year <= (int) sfConfig::get("app_survey_year_to"); $year++) {
        $years_range_array[$year] = $year;
    }
      $statuses_array = array(
          'Gone' => 'Gone',
          'Done' => 'Done' ,
          'Stale' => 'Stale',
          'Not Updated' => 'Not Updated' ,
          'New' =>'New'
      );
    
    // Get choices
    $practice_area_choices = Doctrine_Core::getTable("LtMainPracticeArea")->getPracticeAreasWithMainPracticeAreas();
    $contact_choices       = Doctrine_Core::getTable("LtSurveyContact")->getSurveyContacts();
    
    // Set widgets
    $this->widgetSchema['organization_id']        = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organization'), 'add_empty' => true), array("style" => "width: 281px; height: 16px; margin-bottom: 0 !important;"));
    $this->widgetSchema['organization_url']       = new sfWidgetFormInputText(array(), array("class" => "admin_survey_management_input_text set_padding"));
    $this->widgetSchema['survey_name']            = new sfWidgetFormInputText(array(), array("class" => "admin_survey_management_input_text"));
    $this->widgetSchema['year']                   = new sfCustomWidgetFormChoice(array("add_empty" => "", "choices" => $years_range_array), array("style" => "width: 281px; height: 16px; margin-bottom: 0 !important;"));
    $this->widgetSchema['survey_url']             = new sfWidgetFormInputText(array(), array("class" => "admin_survey_management_input_text"));
    $this->widgetSchema['frequency']              = new sfCustomWidgetFormChoice(array("add_empty" => "", "choices" => LtSurvey::$frequency_types_array), array("style" => "width: 281px; height: 16px; margin-bottom: 0 !important;"));
    $this->widgetSchema['submission_deadline']    = new sfWidgetFormInputText(array(), array("class" => "admin_survey_management_input_text admin_datapicker", "readonly" => true, "style" => "background-color: #ffffff !important;"));
    $this->widgetSchema['cities_list']            = new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'LtCity'), array("style" => "width: 281px; height: 16px; margin-bottom: 0 !important;"));
    $this->widgetSchema['states_list']            = new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'LtState'), array("style" => "width: 281px; height: 16px; margin-bottom: 0 !important;"));
    $this->widgetSchema['countries_list']         = new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'LtCountry'), array("style" => "width: 281px; height: 16px; margin-bottom: 0 !important;"));
    $this->widgetSchema['survey_region_id']       = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Region'), 'add_empty' => true), array("style" => "width: 281px; height: 16px; margin-bottom: 0 !important;"));
    $this->widgetSchema['survey_description']     = new sfWidgetFormTextarea(array(), array("class" => "admin_survey_management_textarea"));
    $this->widgetSchema['is_legal']               = new sfWidgetFormInputCheckbox();
    $this->widgetSchema['is_list']                = new sfWidgetFormInputCheckbox();

    $this->widgetSchema['candidate_type']         = new sfCustomWidgetFormChoice(array("add_empty" => "", "choices" => LtSurvey::$candidate_types_array), array("style" => "width: 281px; height: 16px; margin-bottom: 0 !important;"));
    $this->widgetSchema['eligibility_criteria']   = new sfWidgetFormTextarea(array(), array("class" => "admin_survey_management_textarea"));
    $this->widgetSchema['special_criterias_list'] = new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'LtSpecialCriteria'), array("style" => "width: 281px; height: 16px; margin-bottom: 0 !important;"));
    $this->widgetSchema['practice_areas_list']    = new sfCustomWidgetFormChoice(array("choices" => $practice_area_choices, "multiple" => true), array("style" => "width: 281px; height: 16px; margin-bottom: 0 !important;"));
    $this->widgetSchema['keywords']               = new sfWidgetFormInputText(array(), array("style" => "width: 281px; height: 16px; margin-bottom: 0 !important;"));

    $this->widgetSchema['nomination']             = new sfWidgetFormTextarea(array(), array("class" => "admin_survey_management_textarea"));
    $this->widgetSchema['selection_methodology']  = new sfWidgetFormTextarea(array(), array("class" => "admin_survey_management_textarea"));
    $this->widgetSchema['self_nomination']        = new sfWidgetFormChoice(array("expanded" => true, "choices"  => array(1 => 'Yes', 0 => 'No')),array('class' => 'admin_syrvey_management_radio'));
    $this->widgetSchema['fees']                   = new sfWidgetFormChoice(array("expanded" => true, "choices"  => array(1 => 'Yes', 0 => 'No')),array('class' => 'admin_syrvey_management_radio'));
    $this->widgetSchema['pay_for_play']           = new sfWidgetFormChoice(array("expanded" => true, "choices"  => array(1 => 'Yes', 0 => 'No')),array('class' => 'admin_syrvey_management_radio'));
    $this->widgetSchema['survey_contact_id']      = new sfCustomWidgetFormChoice(array("add_empty" => "", "choices" => $contact_choices), array("style" => "width: 281px; height: 16px; margin-bottom: 0 !important;"));
    $this->widgetSchema['survey_notes']           = new sfWidgetFormTextarea(array(), array("class" => "admin_survey_management_textarea"));
    $this->widgetSchema['status']                 = new sfCustomWidgetFormChoice(array("add_empty" => "", "choices" => $statuses_array), array("style" => "width: 281px; height: 16px; margin-bottom: 0 !important;"));

    $this->widgetSchema['staff_notes']            = new sfWidgetFormTextarea(array(), array("class" => "admin_survey_management_textarea"));
    
    // Set validators
    $this->validatorSchema['organization_id']        = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Organization'), 'required' => false));
    $this->validatorSchema['organization_url']       = new sfValidatorString(array('max_length' => 255, 'required' => false), array("max_length" => "Maximum length (255 characters)"));
    $this->validatorSchema['survey_name']            = new sfValidatorString(array('max_length' => 255, 'required' => false), array("max_length" => "Maximum length (255 characters)"));    
    $this->validatorSchema['year']                   = new sfValidatorChoice(array('choices' => array_keys($years_range_array), 'required' => false), array("required" => "This field is required."));
    $this->validatorSchema['survey_url']             = new sfValidatorString(array('max_length' => 255, 'required' => false), array("max_length" => "Maximum length (255 characters)"));
    $this->validatorSchema['frequency']              = new sfValidatorChoice(array('choices' => array_keys(LtSurvey::$frequency_types_array), 'required' => false), array("required" => "This field is required."));
    $this->validatorSchema['submission_deadline']    = new sfValidatorString(array('max_length' => 15, 'required' => false), array("max_length" => "Maximum length (15 characters)"));
    $this->validatorSchema['cities_list']            = new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'LtCity', 'required' => false));
    $this->validatorSchema['states_list']            = new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'LtState', 'required' => false));
    $this->validatorSchema['countries_list']         = new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'LtCountry', 'required' => false));
    $this->validatorSchema['survey_region_id']       = new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Region'), 'required' => false));    
    $this->validatorSchema['survey_description']     = new sfValidatorString(array('max_length' => 5000, 'required' => false), array("max_length" => "Maximum length (5000 characters)"));
    $this->validatorSchema['candidate_type']         = new sfValidatorChoice(array('choices' => array_keys(LtSurvey::$candidate_types_array), 'required' => false), array("required" => "This field is required."));
    $this->validatorSchema['eligibility_criteria']   = new sfValidatorString(array('max_length' => 5000, 'required' => false), array("max_length" => "Maximum length (5000 characters)"));
    $this->validatorSchema['special_criterias_list'] = new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'LtSpecialCriteria', 'required' => false));
    $this->validatorSchema['practice_areas_list']    = new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'LtPracticeArea', 'required' => false));
    $this->validatorSchema['nomination']             = new sfValidatorString(array('max_length' => 5000, 'required' => false), array("max_length" => "Maximum length (5000 characters)"));
    $this->validatorSchema['selection_methodology']  = new sfValidatorString(array('max_length' => 5000, 'required' => false), array("max_length" => "Maximum length (5000 characters)"));
    $this->validatorSchema['self_nomination']        = new sfValidatorChoice(array('choices' => array_keys(array(1 => 'Yes', 0 => 'No')), 'required' => false), array("required" => "This field is required."));
    $this->validatorSchema['fees']                   = new sfValidatorChoice(array('choices' => array_keys(array(1 => 'Yes', 0 => 'No')), 'required' => false), array("required" => "This field is required."));
    $this->validatorSchema['pay_for_play']           = new sfValidatorChoice(array('choices' => array_keys(array(1 => 'Yes', 0 => 'No')), 'required' => false), array("required" => "This field is required."));
    $this->validatorSchema['survey_contact_id']      = new sfValidatorChoice(array('choices' => array_keys($contact_choices), 'required' => false), array("required" => "This field is required."));
    $this->validatorSchema['survey_notes']           = new sfValidatorString(array('max_length' => 5000, 'required' => false), array("max_length" => "Maximum length (5000 characters)"));
    $this->validatorSchema['status']                 = new sfValidatorChoice(array('choices' => array_keys($statuses_array), 'required' => false), array("required" => "This field is required."));
    $this->validatorSchema['staff_notes']            = new sfValidatorString(array('max_length' => 5000, 'required' => false), array("max_length" => "Maximum length (5000 characters)"));
    
    // Set help messages
    $this->widgetSchema->setHelp("organization_id", "The organization publishing the survey.");
    $this->widgetSchema->setHelp("organization_url", "URL of the organization that is running the survey.");
    $this->widgetSchema->setHelp("survey_name", "The name of the survey. One organization may be publishing multiple surveys each year.");
    $this->widgetSchema->setHelp("year", "Year of the survey. Typically, one organization may run one specific survey only once a year. In very rare occasions a survey may run more than once in a year (ex. semi-annual or quarterly survey).");
    $this->widgetSchema->setHelp("survey_url", "URL of the survey announcement.");
    $this->widgetSchema->setHelp("frequency", "How often is the survey running?");
    $this->widgetSchema->setHelp("submission_deadline", "Submission deadline for the survey.");
    $this->widgetSchema->setHelp("cities_list", "The focus city for the survey. Survey will accept candidates only from this city.");
    $this->widgetSchema->setHelp("states_list", "The focus state for the survey. Survey will accept candidates only from this state.");
    $this->widgetSchema->setHelp("countries_list", "The focus country for the survey. Survey will accept candidates only from this country.");    
    $this->widgetSchema->setHelp("survey_region_id", "The focus of the geographic region of acceptable candidates.");
    $this->widgetSchema->setHelp("survey_description", "Survey description.");
    $this->widgetSchema->setHelp("candidate_type", "The type of eligible candidates.");
    $this->widgetSchema->setHelp("eligibility_criteria", "The criteria to make a candidate eligible.");
    $this->widgetSchema->setHelp("special_criterias_list", "This is one or more special criteria to be identify a survey. For example: Minority women under 40.");
    $this->widgetSchema->setHelp("practice_areas_list", "Practice areas covered by the survey.");
    $this->widgetSchema->setHelp("nomination", "How to apply or nominate candidate(s)");
    $this->widgetSchema->setHelp("selection_methodology", "The survey selection and evaluation methodology.");
    $this->widgetSchema->setHelp("self_nomination", "Can a candidate be self-nominated?");
    $this->widgetSchema->setHelp("fees", "Are there any fees associated with participation?");
    $this->widgetSchema->setHelp("pay_for_play", "Can candidate pay to be listed (is it a directory)?");
    $this->widgetSchema->setHelp("survey_contact_id", "Survey contact at Organization.");
    $this->widgetSchema->setHelp("survey_notes", "Any notes we want to include about this survey.");
    $this->widgetSchema->setHelp("staff_notes", "Any notes not visible to users we want to include in the survey.");    
    
    // Set labels
    $this->widgetSchema->setLabel("organization_id", "Organization");
    $this->widgetSchema->setLabel("organization_url", "Organization URL");
    $this->widgetSchema->setLabel("survey_name", "Survey Name");
    $this->widgetSchema->setLabel("year", "Year");
    $this->widgetSchema->setLabel("survey_url", "Survey URL");
    $this->widgetSchema->setLabel("frequency", "Frequency");
    $this->widgetSchema->setLabel("submission_deadline", "Submission Deadline");
    $this->widgetSchema->setLabel("cities_list", "Survey City");
    $this->widgetSchema->setLabel("states_list", "Survey State");
    $this->widgetSchema->setLabel("countries_list", "Survey Country");    
    $this->widgetSchema->setLabel("survey_region_id", "Survey Region");
    $this->widgetSchema->setLabel("survey_description", "Survey Description");
    $this->widgetSchema->setLabel("candidate_type", "Candidate Type");
    $this->widgetSchema->setLabel("eligibility_criteria", "Eligibility Criteria");
    $this->widgetSchema->setLabel("special_criterias_list", "Special Criteria");
    $this->widgetSchema->setLabel("practice_areas_list", "Practice Area");
    $this->widgetSchema->setLabel("nomination", "Nomination");
    $this->widgetSchema->setLabel("selection_methodology", "Selection Methodology");
    $this->widgetSchema->setLabel("self_nomination", "Self-Nomination");
    $this->widgetSchema->setLabel("fees", "Fees");
    $this->widgetSchema->setLabel("pay_for_play", "Pay-For-Play");
    $this->widgetSchema->setLabel("survey_contact_id", "Survey Contact");
    $this->widgetSchema->setLabel("survey_notes", "Survey Notes");
    $this->widgetSchema->setLabel("staff_notes", "Staff Notes");
    
    // Set order of fields
    $this->widgetSchema->moveField("cities_list", sfWidgetFormSchema::AFTER, 'submission_deadline');
    $this->widgetSchema->moveField("states_list", sfWidgetFormSchema::AFTER, 'cities_list');
    $this->widgetSchema->moveField("countries_list", sfWidgetFormSchema::AFTER, 'states_list');
    $this->widgetSchema->moveField("special_criterias_list", sfWidgetFormSchema::AFTER, 'eligibility_criteria');
    $this->widgetSchema->moveField("practice_areas_list", sfWidgetFormSchema::AFTER, 'special_criterias_list');
    
  }
  
  /**
   *  Remove fields from form
   */
  private function removeFields() {
    unset(
      $this['created_at'],
      $this['updated_at']
    );
  }

}
