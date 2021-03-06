<?php

/**
 * BaseLtSpecialCriteria
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $name
 * @property Doctrine_Collection $SurveySpecialCriterias
 * @property Doctrine_Collection $LtSurveySpecialCriteria
 * 
 * @method string              getName()                    Returns the current record's "name" value
 * @method Doctrine_Collection getSurveySpecialCriterias()  Returns the current record's "SurveySpecialCriterias" collection
 * @method Doctrine_Collection getLtSurveySpecialCriteria() Returns the current record's "LtSurveySpecialCriteria" collection
 * @method LtSpecialCriteria   setName()                    Sets the current record's "name" value
 * @method LtSpecialCriteria   setSurveySpecialCriterias()  Sets the current record's "SurveySpecialCriterias" collection
 * @method LtSpecialCriteria   setLtSurveySpecialCriteria() Sets the current record's "LtSurveySpecialCriteria" collection
 * 
 * @package    LexLists
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseLtSpecialCriteria extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('special_criterias');
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));

        $this->option('type', 'InnoDB');
        $this->option('collate', 'utf8_general_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('LtSurvey as SurveySpecialCriterias', array(
             'refClass' => 'LtSurveySpecialCriteria',
             'local' => 'special_criteria_id',
             'foreign' => 'survey_id'));

        $this->hasMany('LtSurveySpecialCriteria', array(
             'local' => 'id',
             'foreign' => 'special_criteria_id'));

        $timestampable0 = new Doctrine_Template_Timestampable(array(
             ));
        $this->actAs($timestampable0);
    }
}