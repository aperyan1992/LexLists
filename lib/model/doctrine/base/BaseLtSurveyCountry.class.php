<?php

/**
 * BaseLtSurveyCountry
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $survey_id
 * @property integer $country_id
 * @property LtSurvey $Survey
 * @property LtCountry $Country
 * 
 * @method integer         getSurveyId()   Returns the current record's "survey_id" value
 * @method integer         getCountryId()  Returns the current record's "country_id" value
 * @method LtSurvey        getSurvey()     Returns the current record's "Survey" value
 * @method LtCountry       getCountry()    Returns the current record's "Country" value
 * @method LtSurveyCountry setSurveyId()   Sets the current record's "survey_id" value
 * @method LtSurveyCountry setCountryId()  Sets the current record's "country_id" value
 * @method LtSurveyCountry setSurvey()     Sets the current record's "Survey" value
 * @method LtSurveyCountry setCountry()    Sets the current record's "Country" value
 * 
 * @package    LexLists
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseLtSurveyCountry extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('survey_countries');
        $this->hasColumn('survey_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));
        $this->hasColumn('country_id', 'integer', null, array(
             'type' => 'integer',
             'primary' => true,
             ));

        $this->option('type', 'InnoDB');
        $this->option('collate', 'utf8_general_ci');
        $this->option('charset', 'utf8');
        $this->option('symfony', array(
             'form' => false,
             'filter' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('LtSurvey as Survey', array(
             'local' => 'survey_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('LtCountry as Country', array(
             'local' => 'country_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable(array(
             ));
        $this->actAs($timestampable0);
    }
}