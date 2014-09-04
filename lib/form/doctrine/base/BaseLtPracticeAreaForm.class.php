<?php

/**
 * LtPracticeArea form base class.
 *
 * @method LtPracticeArea getObject() Returns the current form's model object
 *
 * @package    LexLists
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseLtPracticeAreaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                         => new sfWidgetFormInputHidden(),
      'main_practice_area_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('MainPracticeArea'), 'add_empty' => true)),
      'name'                       => new sfWidgetFormTextarea(),
      'short_code'                 => new sfWidgetFormTextarea(),
      'created_at'                 => new sfWidgetFormDateTime(),
      'updated_at'                 => new sfWidgetFormDateTime(),
      'survey_practice_areas_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'LtSurvey')),
    ));

    $this->setValidators(array(
      'id'                         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'main_practice_area_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('MainPracticeArea'), 'required' => false)),
      'name'                       => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'short_code'                 => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'created_at'                 => new sfValidatorDateTime(),
      'updated_at'                 => new sfValidatorDateTime(),
      'survey_practice_areas_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'LtSurvey', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lt_practice_area[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'LtPracticeArea';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['survey_practice_areas_list']))
    {
      $this->setDefault('survey_practice_areas_list', $this->object->SurveyPracticeAreas->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveSurveyPracticeAreasList($con);

    parent::doSave($con);
  }

  public function saveSurveyPracticeAreasList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['survey_practice_areas_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->SurveyPracticeAreas->getPrimaryKeys();
    $values = $this->getValue('survey_practice_areas_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('SurveyPracticeAreas', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('SurveyPracticeAreas', array_values($link));
    }
  }

}
