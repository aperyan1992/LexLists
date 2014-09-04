<?php

/**
 * LtCountry form base class.
 *
 * @method LtCountry getObject() Returns the current form's model object
 *
 * @package    LexLists
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseLtCountryForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'name'                  => new sfWidgetFormInputText(),
      'created_at'            => new sfWidgetFormDateTime(),
      'updated_at'            => new sfWidgetFormDateTime(),
      'survey_countries_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'LtSurvey')),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'            => new sfValidatorDateTime(),
      'updated_at'            => new sfValidatorDateTime(),
      'survey_countries_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'LtSurvey', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lt_country[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'LtCountry';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['survey_countries_list']))
    {
      $this->setDefault('survey_countries_list', $this->object->SurveyCountries->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveSurveyCountriesList($con);

    parent::doSave($con);
  }

  public function saveSurveyCountriesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['survey_countries_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->SurveyCountries->getPrimaryKeys();
    $values = $this->getValue('survey_countries_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('SurveyCountries', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('SurveyCountries', array_values($link));
    }
  }

}
