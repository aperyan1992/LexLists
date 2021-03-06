<?php

/**
 * BaseLtMainPracticeArea
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $name
 * @property string $short_code
 * @property Doctrine_Collection $LtPracticeArea
 * 
 * @method string              getName()           Returns the current record's "name" value
 * @method string              getShortCode()      Returns the current record's "short_code" value
 * @method Doctrine_Collection getLtPracticeArea() Returns the current record's "LtPracticeArea" collection
 * @method LtMainPracticeArea  setName()           Sets the current record's "name" value
 * @method LtMainPracticeArea  setShortCode()      Sets the current record's "short_code" value
 * @method LtMainPracticeArea  setLtPracticeArea() Sets the current record's "LtPracticeArea" collection
 * 
 * @package    LexLists
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseLtMainPracticeArea extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('main_practice_areas');
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('short_code', 'string', 255, array(
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
        $this->hasMany('LtPracticeArea', array(
             'local' => 'id',
             'foreign' => 'main_practice_area_id'));

        $timestampable0 = new Doctrine_Template_Timestampable(array(
             ));
        $this->actAs($timestampable0);
    }
}