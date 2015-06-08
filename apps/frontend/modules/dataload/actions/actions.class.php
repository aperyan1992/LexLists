<?php
/**
 * dataload actions.
 *
 * @package    LexLists
 * @subpackage dataload
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */

class dataloadActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
      sfConfig::add(array(
          'sf_upload_dir_name'  => $sf_upload_dir_name = 'uploads',
          'sf_upload_dir'       => sfConfig::get('sf_root_dir').DIRECTORY_SEPARATOR.sfConfig::get('sf_web_dir_name').DIRECTORY_SEPARATOR.$sf_upload_dir_name,
      ));
      //$this->forward('default', 'module');
  }

    public function executeUpload(sfWebRequest $request)
    {   
    


//var_dump($arrCities[$city['name']]);die;
        $query = 'SELECT MAX(`id`) FROM `surveys`';
        $max_survey_id = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($query)->fetch();
        $max_survey_id = $max_survey_id[0];
        //var_dump($max_survey_id);die;

        $allowedExts = array("xls", 'csv');
        $temp = explode(".", $_FILES["file"]["name"]);
        $updated = false;
        $extension = end($temp);
        if ($_FILES["file"]["type"] == "text/csv"
            && ($_FILES["file"]["size"] < 200000000000)
            && in_array($extension, $allowedExts)) {
            if ($_FILES["file"]["error"] > 0) {
                echo "Error: " . $_FILES["file"]["error"] . "<br>";
            } else {
                $handle = fopen($_FILES["file"]["tmp_name"], "r");
                while(($data = fgetcsv($handle, 1000, "|"))!==FALSE)
                {
                    $csvdata[] = $data;
                }
                foreach($csvdata[0] as $key=>$value)
                {
                    $arrKeys[strtolower(str_replace(' ', '_', $value))] = $key;
                }
                unset($csvdata[0], $csvdata[1]);

                foreach($csvdata as $key=>$data)
                {
                    $arrStates = array();
                    $arrPracticeAreas = array();
                    $arrCities = array();
                    $all_states = 'SELECT* FROM states';
                    $states_query = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($all_states)->fetchAll();
                    foreach($states_query as $state){
                        $arrStates[$state['short_code']] =$state['id'];
                    }
                    $all_practiceareas = 'SELECT* FROM practice_areas where id="555"';
                    $practiceareas_query = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($all_practiceareas)->fetchAll();
                    foreach($practiceareas_query as $practicearea){
                        $arrPracticeAreas[$practicearea['name']] =$practicearea['id'];
                    }

                    $all_cities = 'SELECT* FROM cities';
                    $cities_query = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($all_cities)->fetchAll();
                    foreach($cities_query as $city){
                        $arrCities[$city['name']] =$city['id'];
                    }

                   // var_dump($data);die;
                    $data = $this->escape_character($data);
                    $query = 'Select `id`, `name` FROM `regions`';
                    $regoins = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($query)->fetchAll();
                    foreach($regoins as $regoin)
                    {
                        $newregoins[$regoin['name']] = $regoin['id'];
                    }

                    $query = 'Select `id`, `name` FROM `organizations`';
                    $organizationarray = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($query)->fetchAll();
                    foreach($organizationarray as $organization)
                    {
                        $neworganizationarray[$organization['name']] = $organization['id'];
                    }

                    $query = 'Select `id`, `name` FROM `countries`';
                    $countries = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($query)->fetchAll();
                    foreach($countries as $countrie)
                    {
                        $newcountries[$countrie['name']] = $countrie['id'];
                    }

                    if(!empty($data[$arrKeys['region']]) && isset($newregoins[$data[$arrKeys['region']]]))
                    {
                        $fianlresult[$key]['survey_region_id'] = $newregoins[$data[$arrKeys['region']]];
                    }
                    else{
                        $fianlresult[$key]['survey_region_id'] = 13;
                    }

                    if(isset($data[$arrKeys['organization_url']]))
                    {
                        $fianlresult[$key]['organization_url'] = $data[$arrKeys['organization_url']];
                    }
                    else{
                        $fianlresult[$key]['organization_url'] = null;
                    }

                    if(isset($data[$arrKeys['award_name']]))
                    {

                        $fianlresult[$key]['survey_name'] = $data[$arrKeys['award_name']];
                        $contact['name'] = ($data[$arrKeys['award_contact_name']]?$data[$arrKeys['award_contact_name']]:null);
                    }
                    else{
                        $fianlresult[$key]['survey_name'] = null;
                        $contact['name'] = null;
                    }

                    if(isset($data[$arrKeys['year']]))
                    {
                        $fianlresult[$key]['year'] = (int)preg_replace('/\D/', '', $data[$arrKeys['year']]);
                    }
                    else{
                        $fianlresult[$key]['year'] = null;
                    }

                    if(isset($data[$arrKeys['award_url']]))
                    {
                        $fianlresult[$key]['survey_url'] = $data[$arrKeys['award_url']];
                    }
                    else{
                        $fianlresult[$key]['survey_url'] = null;
                    }

                    if(isset($data[$arrKeys['frequency']]))
                    {
                        $fianlresult[$key]['frequency'] = $data[$arrKeys['frequency']];
                    }
                    else{
                        $fianlresult[$key]['frequency'] = null;
                    }

                    if(!empty($data[$arrKeys['submission_deadline']]))
                    {
                        $fianlresult[$key]['submission_deadline'] = date('Y-m-d',strtotime($data[$arrKeys['submission_deadline']]));
                    }
                    else{
                        $fianlresult[$key]['submission_deadline'] = null;
                    }

                    if(isset($data[$arrKeys['description']]))
                    {
                        $fianlresult[$key]['survey_description'] = $data[$arrKeys['description']];
                    }
                    else{
                        $fianlresult[$key]['survey_description'] = null;
                    }

                    if(isset($data[$arrKeys['candidate_type']]))
                    {
                        $fianlresult[$key]['candidate_type'] = $data[$arrKeys['candidate_type']];
                    }
                    else{
                        $fianlresult[$key]['candidate_type'] = null;
                    }

                    if(isset($data[$arrKeys['special_criteria']]))
                    {
                        $fianlresult[$key]['eligibility_criteria'] = $data[$arrKeys['special_criteria']];
                    }
                    else{
                        $fianlresult[$key]['eligibility_criteria'] = null;
                    }

                    if(isset($data[$arrKeys['city']]))
                    {
                        $fianlresult[$key]['city'] = $data[$arrKeys['city']];
                    }
                    else{
                        $fianlresult[$key]['city'] = null;
                    }

                    if(isset($data[$arrKeys['state']]))
                    {
                        $fianlresult[$key]['state'] = $data[$arrKeys['state']];
                    }
                    else{
                        $fianlresult[$key]['state'] = null;
                    } 

                    if(isset($data[$arrKeys['practice_areas']]))
                    {
                        $fianlresult[$key]['practice_areas'] = $data[$arrKeys['practice_areas']];
                    }
                    else{
                        $fianlresult[$key]['practice_areas'] = null;
                    }                     

                    if(isset($data[$arrKeys['notes']]))
                    {
                        $fianlresult[$key]['survey_notes'] = $data[$arrKeys['notes']];
                    }
                    else{
                        $fianlresult[$key]['survey_notes'] = null;
                    }
                    $fianlresult[$key]['id'] = '';

                    if(isset($data[$arrKeys['award_contact_email']]))
                    {
                        $contact['email'] = $data[$arrKeys['award_contact_email']];
                    }
                    else{
                        $contact['email'] = null;
                    }

                    if(isset($data[$arrKeys['award_contact_phone_number']]))
                    {
                        $contact['phone'] = $data[$arrKeys['award_contact_phone_number']];
                    }
                    else{
                        $contact['phone'] = null;
                    }

                    if(isset($data[$arrKeys['organization']]) && !empty($neworganizationarray[$data[$arrKeys['organization']]]))
                    {
                        $checkingquery = 'SELECT * FROM `surveys` WHERE survey_name="'.$data[$arrKeys['award_name']].'" AND organization_id="'.$neworganizationarray[$data[$arrKeys['organization']]].'"';
                        $resultupdate = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($checkingquery)->fetch();
                           // var_dump($checkingquery);die;
                        if($resultupdate)
                        {
                            $update = true;
                            $updated = true;
                        }
                        else{
                            $update = false;
                        }
                    }
                    else
                    {
                        $update = false;
                    }

                    $now = new DateTime();

                    if($update)
                    {


                        $query = 'UPDATE `survey_contacts` SET `first_name`="'.$contact['name'].'",`email_address`="'.$contact['email'].'", `phone_number`="'.$contact['phone'].'" ,`updated_at`="'.$now->format('Y-m-d H:i:s').'"   ';
                        $query .= ' WHERE id="'.$resultupdate['survey_contact_id'].'"';

                        $result = Doctrine_Manager::getInstance()->getCurrentConnection();

                        if($result->execute($query))
                        {
                            $fianlresult[$key]['survey_contact_id'] = $resultupdate['survey_contact_id'];
                        }
                    }
                    else{
                        $query = 'INSERT INTO `survey_contacts` (`first_name`,`email_address`, `phone_number`,`created_at`,`updated_at`) VALUES';
                        $query .= ' ("'.$contact['name'].'","'.$contact['email'].'","'.$contact['phone'].'","'.$now->format('Y-m-d H:i:s').'","'.$now->format('Y-m-d H:i:s').' ")';

                        $result = Doctrine_Manager::getInstance()->getCurrentConnection();

                        if($result->execute($query))
                        {
                            $lastid = $result->lastInsertId();
                            $fianlresult[$key]['survey_contact_id'] = $lastid;
                        }
                    }


                    if(isset($data[$arrKeys['organization']]))
                    {
                        if(!$update)
                        {
                            if(!empty($neworganizationarray[$data[$arrKeys['organization']]]))
                            {
                                $fianlresult[$key]['organization_id'] = $neworganizationarray[$data[$arrKeys['organization']]];
                            }
                            else
                            {
                                $query = 'INSERT INTO `organizations` (`name`) VALUES';
                                $query .= " ('".$data[$arrKeys['organization']]."')";
                                $result = Doctrine_Manager::getInstance()->getCurrentConnection();
                                if($result->execute($query))
                                {
                                    $lastid = $result->lastInsertId();
                                    $fianlresult[$key]['organization_id'] = $lastid;
                                }
                            }
                        }
                    }

                    if(isset($data[$arrKeys['city']]))
                    {
                        if(!$update)
                        {
                            if(!empty($newcitiesarray[$data[$arrKeys['city']]]))
                            {
                                $fianlresult[$key]['city_id'] = $newcitiesarray[$data[$arrKeys['city']]];
                            }
                            else
                            {
                                $query = 'INSERT INTO `cities` (`name`) VALUES';


                                $exist_cities = 'SELECT* FROM `cities` where name = "'.$data[$arrKeys['city']].'"';
                                $cities = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($exist_cities)->fetchAll();
                                if(empty($cities) || $cities == '')
                                {
                                    $query .= " ('".$data[$arrKeys['city']]."')";
                                    $result = Doctrine_Manager::getInstance()->getCurrentConnection();
                                    if($result->execute($query))
                                    {
                                        $lastid = $result->lastInsertId();
                                        $fianlresult[$key]['city'] = $lastid;
                                    }
                                }
                            }
                        }
                    }

                    if(isset($data[$arrKeys['practice_areas']]))
                    {
                        $pracarea_query_str = 'INSERT INTO practice_areas (`main_practice_area_id`,`name`,`short_code`) VALUES ';

                        $pracareas1 = $data[$arrKeys['practice_areas']];
                        if (strpos($pracareas1,';') !== false) {
                                $arrPrac = explode(';', $pracareas1); 
                                foreach ($arrPrac as $value) {
                                    
                                    if($value!=' ' && strlen($value)>=2 )
                                    {
                                        $exist_prac = 'SELECT* FROM `practice_areas` where name LIKE "'.preg_replace('/\s\s+/', ' ', $value).'" and main_practice_area_id="555"';
                                        $pracss = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($exist_prac)->fetchAll();
                                        $pracarea_query_str = 'INSERT INTO practice_areas (`main_practice_area_id`,`name`,`short_code`) VALUES ';

                                        if(empty($pracss) || $pracss == '')
                                        {
                                            $pracarea_query_str .= '("555", "'.preg_replace('/\s\s+/', ' ', $value).'","'.preg_replace('/\s\s+/', ' ', $value).'")';   
                                            $result = Doctrine_Manager::getInstance()->getCurrentConnection();
                                            $result->execute($pracarea_query_str); 
                                            $pracarea_query_str="";                                   
                                        } 
                                    }
                                }                                                          
                            }  
                            else
                            {
                                $exist_prac = 'SELECT* FROM `practice_areas` where name LIKE "'.$data[$arrKeys['practice_areas']].'" and main_practice_area_id="555"';
                                $pracss = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($exist_prac)->fetchAll();
                                if(empty($pracss) || $pracss == '')
                                {
                                    $pracarea_query_str .= '("555", "'.preg_replace('/\s\s+/', ' ', $data[$arrKeys['practice_areas']]).'","'.preg_replace('/\s\s+/', ' ', $data[$arrKeys['practice_areas']]).'")';   
                                    $result = Doctrine_Manager::getInstance()->getCurrentConnection();
                                    $result->execute($pracarea_query_str);                                    
                                }
                            }
                                     
                    }


                    if($update)
                    {
                        $now = new DateTime();

                        $query = 'UPDATE `surveys` SET ';
                        $details = '';
                        foreach($fianlresult[$key] as $k=>$value)
                        {
                            if($k != "state" && $k != "city" && $k!='practice_areas' && $k!= 'id')
                            {
                                $details .=  '`'.$k.'`="'.$value.'", ';
                            }
                        }
                        if($details!='')
                        {
                            $query.=$details;
                            $query.='`updated_at`="'.$now->format('Y-m-d H:i:s').'"';
                            //$query = rtrim($query, ", ");
                            $query .= ' WHERE id="'.$resultupdate['id'].'"';
                            $result = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($query);
                            if($result)
                            {
                                unset($fianlresult[$key]);
                            }
                         }
                    }
                }
                
                if(!empty($fianlresult))
                {
                    $arrStates = array();
                    $arrPracticeAreas = array();
                    $arrCities = array();
                    $all_states = 'SELECT* FROM states';
                    $states_query = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($all_states)->fetchAll();
                    foreach($states_query as $state){
                        $arrStates[$state['short_code']] =$state['id'];
                    }
                    $all_practiceareas = 'SELECT* FROM practice_areas where main_practice_area_id="555"';
                    $practiceareas_query = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($all_practiceareas)->fetchAll();
                    foreach($practiceareas_query as $practicearea){
                        $arrPracticeAreas[$practicearea['name']] =$practicearea['id'];
                    }

                    $all_cities = 'SELECT* FROM cities';
                    $cities_query = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($all_cities)->fetchAll();
                    foreach($cities_query as $city){
                        $arrCities[$city['name']] =$city['id'];
                    }
                    $now = new DateTime();
                    $i = $max_survey_id+1;
                    $final_states_string = 'INSERT INTO `survey_states` (`survey_id`, `state_id`) VALUES (';
                    $final_cities_string = 'INSERT INTO `survey_cities` (`survey_id`, `city_id`) VALUES (';
                    $final_practice_areas_string = 'INSERT INTO `survey_practice_areas` (`survey_id`,`practice_area_id`) VALUES (';
                    

                    $arraykey = array_keys($fianlresult);
                    //var_dump($arraykey[0]);die;
                    $finalquerystring = 'INSERT INTO `surveys` (';
                    foreach($fianlresult[$arraykey[0]] as $key=>$value)
                    {
                        if($key != "state" && $key != "city" && $key != 'practice_areas')
                        {
                            $finalquerystring.='`'.$key.'`,';
                        }
                    }

                    $finalquerystring.='`created_at`,`updated_at`';
                    $finalquerystring = rtrim($finalquerystring, ",");

                    $finalquerystring.=') VALUES (';
                    $valuepracticeareas = false;
                    foreach($fianlresult as $final)
                    {
                        if($final['state']!='' && isset($arrStates[$final['state']]))
                        {
                            $final_states_string .= '"'. $i .'","'. $arrStates[$final['state']] .'"),(';
                            $valuestate = true;
                        }
                        if($final['practice_areas']!='')
                        {
                            if (strpos($final['practice_areas'],';') !== false) {
                                $arrPrac = explode(';', $final['practice_areas']); 
                                foreach ($arrPrac as $value) {
                                    if(isset($arrPracticeAreas[$value]))
                                    {
                                        $final_practice_areas_string .= '"'. $i .'","'. $arrPracticeAreas[$value] .'"),(';
                                        $valuepracticeareas = true;
                                    }
                                   }                               
                            }  
                            elseif(isset($arrPracticeAreas[$final['practice_areas']]))
                            {
                                $final_practice_areas_string .= '"'. $i .'","'. $arrPracticeAreas[$final['practice_areas']] .'"),(';
                                $valuepracticeareas = true;
                            }                            
                        }

                        if($final['city']!='' && isset($arrCities[$final['city']]))
                        {
                            $final_cities_string .= '"'. $i .'","'. $arrCities[$final['city']] .'"),(';
                            $valuecity = true;
                        }
                        $final['id'] = $i;
                        $i++;
                        foreach($final as $key=>$value)
                        {

                            if($key != "state" && $key != "city" && $key != 'practice_areas')
                            {
                                $finalquerystring.='"'.$value.'",';
                            }
                        }
                        $finalquerystring = rtrim($finalquerystring, ",");

                        $finalquerystring.=',"'.$now->format('Y-m-d H:i:s').'","'.$now->format('Y-m-d H:i:s').'"';


                        $finalquerystring.='),(';

                    }

                    $finalquerystring = rtrim($finalquerystring, ",(");
                    $final_states_string = rtrim($final_states_string, ",(");
                    $final_cities_string = rtrim($final_cities_string, ",(");
                    $final_practice_areas_string = rtrim($final_practice_areas_string, ",(");
                                               // var_dump($final_practice_areas_string);die;

                    if(Doctrine_Manager::getInstance()->getCurrentConnection()->execute($finalquerystring))
                    {
                        if(isset($valuestate))
                        {
                            Doctrine_Manager::getInstance()->getCurrentConnection()->execute($final_states_string);

                        }
                        if(isset($valuecity))
                        {
                            Doctrine_Manager::getInstance()->getCurrentConnection()->execute($final_cities_string);

                        }
                        if($valuepracticeareas)
                        {
                            Doctrine_Manager::getInstance()->getCurrentConnection()->execute($final_practice_areas_string);

                        }
                        $this->result = '<h2> The CSV data has been successfully uploaded(updated).</h2>';

                    }


                }
                else{
                    if($updated)
                    {
                        $this->result = '<h2> The CSV data has been successfully updated</h2>';
                    }
                    else
                    $this->result = '<h2> There is no updates to be loaded</h2>';
                }

            }
        } else {
            $this->result = false;
        }
    }

    protected function escape_character($array)
    {
        $newArray = array();
        foreach($array as $key=>$value)
        {
            $newArray[$key]=$this->escape2($value);
        }
        return $newArray;

    }
    protected function escape2($value)
    {
        $value = str_replace("'", "\'", $value);
        $value = str_replace('"', '\"', $value);
        return $value;
    }
}
