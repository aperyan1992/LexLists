<?php

/**
 * LtSpecialCriteria form base class.
 *
 * @method LtSpecialCriteria getObject() Returns the current form's model object
 *
 * @package    LexLists
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseLtSpecialCriteriaForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                            => new sfWidgetFormInputHidden(),
      'name'                          => new sfWidgetFormInputText(),
      'created_at'                    => new sfWidgetFormDateTime(),
      'updated_at'                    => new sfWidgetFormDateTime(),
      'survey_special_criterias_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'LtSurvey')),
    ));

    $this->setValidators(array(
      'id'                            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'                          => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'                    => new sfValidatorDateTime(),
      'updated_at'                    => new sfValidatorDateTime(),
      'survey_special_criterias_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'LtSurvey', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lt_special_criteria[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'LtSpecialCriteria';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['survey_special_criterias_list']))
    {
      $this->setDefault('survey_special_criterias_list', $this->object->SurveySpecialCriterias->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveSurveySpecialCriteriasList($con);

    parent::doSave($con);
  }

  public function saveSurveySpecialCriteriasList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['survey_special_criterias_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->SurveySpecialCriterias->getPrimaryKeys();
    $values = $this->getValue('survey_special_criterias_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('SurveySpecialCriterias', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('SurveySpecialCriterias', array_values($link));
    }
  }

}
