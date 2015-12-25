<?php

/**
 * LtSurvey filter form base class.
 *
 * @package    LexLists
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseLtSurveyFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    // Get years range
    $years_range_array = array();
    for($year = sfConfig::get("app_survey_year_from"); $year <= (int) sfConfig::get("app_survey_year_to"); $year++) {
      $years_range_array[$year] = $year;
    }
    $this->setWidgets(array(
      'organization_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organization'), 'add_empty' => true)),
      'organization_url'       => new sfWidgetFormFilterInput(),
      'survey_name'            => new sfWidgetFormFilterInput(),
      'year'                   => new sfCustomWidgetFormChoice(array("add_empty" => "", "choices" => $years_range_array), array("style" => "width: 60px !important;")),
      'survey_url'             => new sfWidgetFormFilterInput(),
      'frequency'              => new sfWidgetFormFilterInput(),
      'submission_deadline'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'survey_region_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Region'), 'add_empty' => true)),
      'survey_description'     => new sfWidgetFormFilterInput(),
      'candidate_type'         => new sfWidgetFormFilterInput(),
      'eligibility_criteria'   => new sfWidgetFormFilterInput(),
      'nomination'             => new sfWidgetFormFilterInput(),
      'selection_methodology'  => new sfWidgetFormFilterInput(),
      'self_nomination'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'fees'                   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'pay_for_play'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'survey_contact_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Contact'), 'add_empty' => true)),
      'survey_notes'           => new sfWidgetFormFilterInput(),
      'staff_notes'            => new sfWidgetFormFilterInput(),
      'created_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'cities_list'            => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'LtCity')),
      'states_list'            => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'LtState')),
      'countries_list'         => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'LtCountry')),
      'special_criterias_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'LtSpecialCriteria')),
      'practice_areas_list'    => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'LtPracticeArea')),
    ));

    $this->setValidators(array(
      'organization_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Organization'), 'column' => 'id')),
      'organization_url'       => new sfValidatorPass(array('required' => false)),
      'survey_name'            => new sfValidatorPass(array('required' => false)),
      'year'                   => new sfValidatorChoice(array('choices' => array_keys($years_range_array), 'required' => false), array("required" => "This field is required.")),
      'survey_url'             => new sfValidatorPass(array('required' => false)),
      'frequency'              => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'submission_deadline'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'survey_region_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Region'), 'column' => 'id')),
      'survey_description'     => new sfValidatorPass(array('required' => false)),
      'candidate_type'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'eligibility_criteria'   => new sfValidatorPass(array('required' => false)),
      'nomination'             => new sfValidatorPass(array('required' => false)),
      'selection_methodology'  => new sfValidatorPass(array('required' => false)),
      'self_nomination'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'fees'                   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'pay_for_play'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'survey_contact_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Contact'), 'column' => 'id')),
      'survey_notes'           => new sfValidatorPass(array('required' => false)),
      'staff_notes'            => new sfValidatorPass(array('required' => false)),
      'created_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'cities_list'            => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'LtCity', 'required' => false)),
      'states_list'            => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'LtState', 'required' => false)),
      'countries_list'         => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'LtCountry', 'required' => false)),
      'special_criterias_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'LtSpecialCriteria', 'required' => false)),
      'practice_areas_list'    => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'LtPracticeArea', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lt_survey_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addCitiesListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.LtSurveyCity LtSurveyCity')
      ->andWhereIn('LtSurveyCity.city_id', $values)
    ;
  }

  public function addStatesListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.LtSurveyState LtSurveyState')
      ->andWhereIn('LtSurveyState.state_id', $values)
    ;
  }

  public function addCountriesListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.LtSurveyCountry LtSurveyCountry')
      ->andWhereIn('LtSurveyCountry.country_id', $values)
    ;
  }

  public function addSpecialCriteriasListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.LtSurveySpecialCriteria LtSurveySpecialCriteria')
      ->andWhereIn('LtSurveySpecialCriteria.special_criteria_id', $values)
    ;
  }

  public function addPracticeAreasListColumnQuery(Doctrine_Query $query, $field, $values)
  {
    if (!is_array($values))
    {
      $values = array($values);
    }

    if (!count($values))
    {
      return;
    }

    $query
      ->leftJoin($query->getRootAlias().'.LtSurveyPracticeArea LtSurveyPracticeArea')
      ->andWhereIn('LtSurveyPracticeArea.practice_area_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'LtSurvey';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'organization_id'        => 'ForeignKey',
      'organization_url'       => 'Text',
      'survey_name'            => 'Text',
      'year'                   => 'Boolean',
      'survey_url'             => 'Text',
      'frequency'              => 'Number',
      'submission_deadline'    => 'Date',
      'survey_region_id'       => 'ForeignKey',
      'survey_description'     => 'Text',
      'candidate_type'         => 'Number',
      'eligibility_criteria'   => 'Text',
      'nomination'             => 'Text',
      'selection_methodology'  => 'Text',
      'self_nomination'        => 'Boolean',
      'fees'                   => 'Boolean',
      'pay_for_play'           => 'Boolean',
      'survey_contact_id'      => 'ForeignKey',
      'survey_notes'           => 'Text',
      'staff_notes'            => 'Text',
      'created_at'             => 'Date',
      'updated_at'             => 'Date',
      'cities_list'            => 'ManyKey',
      'states_list'            => 'ManyKey',
      'countries_list'         => 'ManyKey',
      'special_criterias_list' => 'ManyKey',
      'practice_areas_list'    => 'ManyKey',
    );
  }
}
