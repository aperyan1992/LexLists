<?php

/**
 * LtMainPracticeAreaTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class LtMainPracticeAreaTable extends Doctrine_Table {

  /**
   * Returns an instance of this class.
   *
   * @return object LtMainPracticeAreaTable
   */
  public static function getInstance() {
    return Doctrine_Core::getTable('LtMainPracticeArea');
  }

  /**
   * Get practice areas with main practice areas
   * 
   * @return array
   */
  public function getPracticeAreasWithMainPracticeAreas() {
    $q = $this->createQuery("mpa")
            ->leftJoin("mpa.LtPracticeArea pa");

    $result = $q->orderBy('mpa.name');

    $main_practice_areas = $result->execute();

    $practice_areas_array    = array();
    $any_practice_area_array = array();
    if ($main_practice_areas->getFirst()) {
      foreach ($main_practice_areas as $main_practice_area) {
        if($main_practice_area->getName() != "ANY") {
          $practice_areas_array[$main_practice_area->getName()] = array();
          if ($main_practice_area->getId()=='555' && $main_practice_area->getLtPracticeArea()->getFirst()) {
            foreach ($main_practice_area->getLtPracticeArea() as $name) {
              $practice_areas_array[$main_practice_area->getName()][$name->getId()] = $name->getName();
            }
          } /*else {
            $practice_areas_array[$main_practice_area->getName()][""] = "";
          }*/
        } else {
          $any_practice_area_array[$main_practice_area->getLtPracticeArea()->getFirst()->getId()] = $main_practice_area->getLtPracticeArea()->getFirst()->getName();
        }
      }
    }
    //var_dump($any_practice_area_array + $practice_areas_array);die;
    return $any_practice_area_array + $practice_areas_array;
  }

}
