<?php

/**
 * BaseLtCountry
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $name
 * @property Doctrine_Collection $SurveyCountries
 * @property Doctrine_Collection $LtSurveyCountry
 * 
 * @method string              getName()            Returns the current record's "name" value
 * @method Doctrine_Collection getSurveyCountries() Returns the current record's "SurveyCountries" collection
 * @method Doctrine_Collection getLtSurveyCountry() Returns the current record's "LtSurveyCountry" collection
 * @method LtCountry           setName()            Sets the current record's "name" value
 * @method LtCountry           setSurveyCountries() Sets the current record's "SurveyCountries" collection
 * @method LtCountry           setLtSurveyCountry() Sets the current record's "LtSurveyCountry" collection
 * 
 * @package    LexLists
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseLtCountry extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('countries');
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
        $this->hasMany('LtSurvey as SurveyCountries', array(
             'refClass' => 'LtSurveyCountry',
             'local' => 'country_id',
             'foreign' => 'survey_id'));

        $this->hasMany('LtSurveyCountry', array(
             'local' => 'id',
             'foreign' => 'country_id'));

        $timestampable0 = new Doctrine_Template_Timestampable(array(
             ));
        $this->actAs($timestampable0);
    }
}