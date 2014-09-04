<?php

/**
 * LtPracticeArea filter form base class.
 *
 * @package    LexLists
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseLtPracticeAreaFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'main_practice_area_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('MainPracticeArea'), 'add_empty' => true)),
      'name'                       => new sfWidgetFormFilterInput(),
      'short_code'                 => new sfWidgetFormFilterInput(),
      'created_at'                 => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'                 => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'survey_practice_areas_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'LtSurvey')),
    ));

    $this->setValidators(array(
      'main_practice_area_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('MainPracticeArea'), 'column' => 'id')),
      'name'                       => new sfValidatorPass(array('required' => false)),
      'short_code'                 => new sfValidatorPass(array('required' => false)),
      'created_at'                 => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'                 => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'survey_practice_areas_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'LtSurvey', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lt_practice_area_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function addSurveyPracticeAreasListColumnQuery(Doctrine_Query $query, $field, $values)
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
      ->andWhereIn('LtSurveyPracticeArea.survey_id', $values)
    ;
  }

  public function getModelName()
  {
    return 'LtPracticeArea';
  }

  public function getFields()
  {
    return array(
      'id'                         => 'Number',
      'main_practice_area_id'      => 'ForeignKey',
      'name'                       => 'Text',
      'short_code'                 => 'Text',
      'created_at'                 => 'Date',
      'updated_at'                 => 'Date',
      'survey_practice_areas_list' => 'ManyKey',
    );
  }
}
