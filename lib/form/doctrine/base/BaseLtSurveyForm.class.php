<?php

/**
 * LtSurvey form base class.
 *
 * @method LtSurvey getObject() Returns the current form's model object
 *
 * @package    LexLists
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseLtSurveyForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'organization_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Organization'), 'add_empty' => true)),
      'organization_url'       => new sfWidgetFormInputText(),
      'survey_name'            => new sfWidgetFormInputText(),
      'year'                   => new sfWidgetFormInputText(),
      'survey_url'             => new sfWidgetFormInputText(),
      'frequency'              => new sfWidgetFormInputText(),
      'submission_deadline'    => new sfWidgetFormDate(),
      'survey_region_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Region'), 'add_empty' => true)),
      'survey_description'     => new sfWidgetFormTextarea(),
      'is_legal'               => new sfWidgetFormInputCheckbox(),
      'is_list'                => new sfWidgetFormInputCheckbox(),
      'candidate_type'         => new sfWidgetFormInputText(),
      'eligibility_criteria'   => new sfWidgetFormTextarea(),
      'nomination'             => new sfWidgetFormTextarea(),
      'selection_methodology'  => new sfWidgetFormTextarea(),
      'self_nomination'        => new sfWidgetFormInputCheckbox(),
      'fees'                   => new sfWidgetFormInputCheckbox(),
      'pay_for_play'           => new sfWidgetFormInputCheckbox(),
      'keywords'               => new sfWidgetFormInputText(),
      'survey_contact_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Contact'), 'add_empty' => true)),
      'survey_notes'           => new sfWidgetFormTextarea(),
      'staff_notes'            => new sfWidgetFormTextarea(),
      'created_at'             => new sfWidgetFormDateTime(),
      'updated_at'             => new sfWidgetFormDateTime(),
      'cities_list'            => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'LtCity')),
      'states_list'            => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'LtState')),
      'countries_list'         => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'LtCountry')),
      'special_criterias_list' => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'LtSpecialCriteria')),
      'practice_areas_list'    => new sfWidgetFormDoctrineChoice(array('multiple' => true, 'model' => 'LtPracticeArea')),

    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'organization_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Organization'), 'required' => false)),
      'organization_url'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'survey_name'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'year'                   => new sfValidatorInteger(array('required' => false)),
      'survey_url'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'frequency'              => new sfValidatorInteger(array('required' => false)),
      'submission_deadline'    => new sfValidatorDate(array('required' => false)),
      'survey_region_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Region'), 'required' => false)),
      'survey_description'     => new sfValidatorString(array('max_length' => 5000, 'required' => false)),
      'is_legal'               => new sfValidatorBoolean(array('required' => false)),
      'is_list'                => new sfValidatorBoolean(array('required' => false)),
      'candidate_type'         => new sfValidatorInteger(array('required' => false)),
      'eligibility_criteria'   => new sfValidatorString(array('max_length' => 5000, 'required' => false)),
      'nomination'             => new sfValidatorString(array('max_length' => 5000, 'required' => false)),
      'selection_methodology'  => new sfValidatorString(array('max_length' => 5000, 'required' => false)),
      'self_nomination'        => new sfValidatorBoolean(array('required' => false)),
      'fees'                   => new sfValidatorBoolean(array('required' => false)),
      'pay_for_play'           => new sfValidatorBoolean(array('required' => false)),
      'keywords'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'survey_contact_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Contact'), 'required' => false)),
      'survey_notes'           => new sfValidatorString(array('max_length' => 5000, 'required' => false)),
      'staff_notes'            => new sfValidatorString(array('max_length' => 5000, 'required' => false)),
      'created_at'             => new sfValidatorDateTime(),
      'updated_at'             => new sfValidatorDateTime(),
      'cities_list'            => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'LtCity', 'required' => false)),
      'states_list'            => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'LtState', 'required' => false)),
      'countries_list'         => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'LtCountry', 'required' => false)),
      'special_criterias_list' => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'LtSpecialCriteria', 'required' => false)),
      'practice_areas_list'    => new sfValidatorDoctrineChoice(array('multiple' => true, 'model' => 'LtPracticeArea', 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('lt_survey[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'LtSurvey';
  }

  public function updateDefaultsFromObject()
  {
    parent::updateDefaultsFromObject();

    if (isset($this->widgetSchema['cities_list']))
    {
      $this->setDefault('cities_list', $this->object->Cities->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['states_list']))
    {
      $this->setDefault('states_list', $this->object->States->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['countries_list']))
    {
      $this->setDefault('countries_list', $this->object->Countries->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['special_criterias_list']))
    {
      $this->setDefault('special_criterias_list', $this->object->SpecialCriterias->getPrimaryKeys());
    }

    if (isset($this->widgetSchema['practice_areas_list']))
    {
      $this->setDefault('practice_areas_list', $this->object->PracticeAreas->getPrimaryKeys());
    }

  }

  protected function doSave($con = null)
  {
    $this->saveCitiesList($con);
    $this->saveStatesList($con);
    $this->saveCountriesList($con);
    $this->saveSpecialCriteriasList($con);
    $this->savePracticeAreasList($con);

    parent::doSave($con);
  }

  public function saveCitiesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['cities_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Cities->getPrimaryKeys();
    $values = $this->getValue('cities_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Cities', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Cities', array_values($link));
    }
  }

  public function saveStatesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['states_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->States->getPrimaryKeys();
    $values = $this->getValue('states_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('States', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('States', array_values($link));
    }
  }

  public function saveCountriesList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['countries_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->Countries->getPrimaryKeys();
    $values = $this->getValue('countries_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('Countries', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('Countries', array_values($link));
    }
  }

  public function saveSpecialCriteriasList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['special_criterias_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->SpecialCriterias->getPrimaryKeys();
    $values = $this->getValue('special_criterias_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('SpecialCriterias', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('SpecialCriterias', array_values($link));
    }
  }

  public function savePracticeAreasList($con = null)
  {
    if (!$this->isValid())
    {
      throw $this->getErrorSchema();
    }

    if (!isset($this->widgetSchema['practice_areas_list']))
    {
      // somebody has unset this widget
      return;
    }

    if (null === $con)
    {
      $con = $this->getConnection();
    }

    $existing = $this->object->PracticeAreas->getPrimaryKeys();
    $values = $this->getValue('practice_areas_list');
    if (!is_array($values))
    {
      $values = array();
    }

    $unlink = array_diff($existing, $values);
    if (count($unlink))
    {
      $this->object->unlink('PracticeAreas', array_values($unlink));
    }

    $link = array_diff($values, $existing);
    if (count($link))
    {
      $this->object->link('PracticeAreas', array_values($link));
    }
  }

}
