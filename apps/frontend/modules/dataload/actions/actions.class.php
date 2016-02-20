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
                //var_dump(count($csvdata));die;
                foreach($csvdata[0] as $key=>$value)
                {
                    $arrKeys[strtolower(str_replace(' ', '_', $value))] = $key;
                    if(is_int(strpos(strtolower($value),'list')))
                    {
                        $arrKeys['is_list'] = $key;
                        unset($arrKeys[strtolower(str_replace(' ', '_', $value))]);
                    }
                    if(is_int(strpos(strtolower($value),'legal')))
                    {
                        $arrKeys['is_legal'] = $key;
                        unset($arrKeys[strtolower(str_replace(' ', '_', $value))]);
                    }                   
                }
                /*$strcreate = 'CREATE TABLE Persons
                        (
                        id int,';
                        $arrMap = array("organization", "award_name", "year", "description", "submission_deadline", "is_list", "is_legal", "city", "state", "country", "region", "practice_areas", "key_words", "frequency", "award_contact_name", "award_contact_email", "award_contact_phone_number", "candidate_type", "special_criteria", "year_of_last_known_award", "award_url", "organization_url", "notes");

                foreach($arrMap as $key)
                {
                    $strcreate .= $key.' varchar(255), ';
                }
                $strcreate = rtrim($strcreate,', ');
                $strcreate .= ')';*/
                //echo $strcreate ;die;
                
                //echo '<pre>';
                //var_dump($arrKeys);die;
                unset($csvdata[0], $csvdata[1]);
                //var_dump($arrKeys);die;
                $insert_csv = "INSERT INTO `surveys_temp`(`organization`, `award_name`, `year`, `description`, `submission_deadline`, `is_list`, `is_legal`, `city`, `state`, `country`, `region`, `practice_area`, `key_words`, `frequency`, `award_contact_name`, `award_contact_email`, `award_contact_phone_number`, `candidate_type`, `special_criteria`, `year_of_last_known_award`, `award_url`, `organization_url`, `notes`) 
                        VALUES ";
                        $arrMap = array("organization", "award_name", "year", "description", "submission_deadline", "is_list", "is_legal", "city", "state", "country", "region", "practice_area", "key_words", "frequency", "award_contact_name", "award_contact_email", "award_contact_phone_number", "candidate_type", "special_criteria", "year_of_last_known_award", "award_url", "organization_url", "notes");
                        var_dump(count($csvdata));
                foreach($csvdata as $key=>$data)
                {
                    //var_dump($data);die();
                     $insert_csv .= '(';
                        foreach($arrMap as $key)
                        {
                            if(isset($data[$arrKeys[$key]]))
                            {
                                $insert_csv .= '"'.str_replace('"',"'",$data[$arrKeys[$key]]).'",';
                            }
                            else
                            {
                                $insert_csv .= '"",';
                            }
                        }
                        $insert_csv = rtrim($insert_csv,',');
                        $insert_csv .= '),';                    
                }
                $insert_csv = rtrim($insert_csv,',');
               // echo( $insert_csv );die();
                Doctrine_Manager::getInstance()->getCurrentConnection()->execute('truncate surveys_temp');
                Doctrine_Manager::getInstance()->getCurrentConnection()->execute($insert_csv);//die;
                $tempSurveys = Doctrine_Manager::getInstance()->getCurrentConnection()->execute('Select * from surveys_temp')->fetchAll();
                //var_dump($tempSurveys);die;
                if(!empty($tempSurveys))
                {
                    foreach($tempSurveys as $survey)
                    {
                        $arrSurvey = array(
                            'organization_url'=> $survey['organization_url'],
                            'survey_name'=> $survey['award_name'],
                            'year'=> $survey['year'],
                            'survey_url'=> $survey['award_url'],
                            'submission_deadline'=> date('Y-m-d',strtotime($survey['submission_deadline'])),
                            'survey_description'=> $survey['description'],
                            'frequency'=> $survey['frequency'],
                            'keywords'=> $survey['key_words'],
                            'is_list'=> $survey['is_list'],
                            'is_legal'=> $survey['is_legal'],
                            'survey_notes'=> $survey['notes'],
                            );
                        $arrSurvey['organization_id']='1';
                        if(!empty($survey['organization']))
                        {
                            $organization = Doctrine_Manager::getInstance()->getCurrentConnection()->execute('Select * from  organizations where name="'.$survey['organization'].'"')->fetch();
                            if(!empty($organization))
                            {
                                $arrSurvey['organization_id'] = $organization['id'];
                            }
                            else
                            {
                               Doctrine_Manager::getInstance()->getCurrentConnection()->execute('Insert into organizations (`name`,`created_at`,`updated_at`) VALUES ("'.$survey['organization'].'",NOW(),NOW())');
                                $arrSurvey['organization_id'] = Doctrine_Manager::getInstance()->getCurrentConnection()->lastInsertId();
                            }
                        }
                        else
                        {
                            $arrValod[]= $survey['id'];
                        }
                        $arrSurvey['region_id']='';
                        if(!empty($survey['region']))
                        {
                            $region = Doctrine_Manager::getInstance()->getCurrentConnection()->execute('Select * from  regions where name="'.$survey['region'].'"')->fetch();
                            if(!empty($region))
                            {
                                $arrSurvey['region_id'] = $region['id'];
                            }
                            else
                            {
                                Doctrine_Manager::getInstance()->getCurrentConnection()->execute('Insert into regions (`name`,`created_at`,`updated_at`) VALUES ("'.$survey['organization'].'",NOW(),NOW())');
                                $arrSurvey['region_id'] = Doctrine_Manager::getInstance()->getCurrentConnection()->lastInsertId();
                            }
                        }
                        $arrSurvey['survey_contact_id']='';
                        if(!empty($survey['award_contact_email']) OR !empty($survey['award_contact_name']) OR !empty($survey['award_contact_phone_number']))
                        {
                            
                            Doctrine_Manager::getInstance()->getCurrentConnection()->execute('Insert into survey_contacts (`first_name`,`email_address`,`phone_number`,`created_at`,`updated_at`) VALUES ("'.$survey['award_contact_name'].'","'.$survey['award_contact_email'].'","'.$survey['award_contact_phone_number'].'",NOW(),NOW())');
                            $arrSurvey['survey_contact_id'] = Doctrine_Manager::getInstance()->getCurrentConnection()->lastInsertId();
                        }
                        $strInsertSurvey = 'INSERT INTO surveys (`organization_url`,
                            `survey_name`,
                            `year`,
                            `survey_url`,
                            `submission_deadline`,
                            `survey_description`,
                            `frequency`,
                            `keywords`,
                            `is_list`,
                            `is_legal`,
                            `survey_notes`,
                            `organization_id`,
                            `survey_region_id`,
                            `survey_contact_id`
                            ) VALUES (';
                        foreach($arrSurvey as $field)
                        {
                            $strInsertSurvey .= '"'.$field.'",';
                        }
                        $strInsertSurvey = rtrim($strInsertSurvey, ',');
                        $strInsertSurvey .= ')';
                        Doctrine_Manager::getInstance()->getCurrentConnection()->execute( $strInsertSurvey );
                        $survey_id = Doctrine_Manager::getInstance()->getCurrentConnection()->lastInsertId();
                        $arrMapRelations = array(
                            'city'=>'cities',
                            'country'=>'countries',
                            'practice_area'=>'practice_areas',
                            'special_criteria'=>'special_criterias',
                            'state'=>'states',
                            );
                        //var_dump($survey);
                        foreach($arrMapRelations as $key=>$value)
                        {
                            if(!empty($survey[$key]))
                            {
                                $arrDatas = explode('; ',$survey[$key]);                               
                                foreach($arrDatas as $data)
                                {                                    
                                    $query = Doctrine_Manager::getInstance()->getCurrentConnection()->execute('Select * from  '.$value.' where name="'.$data.'"')->fetch();
                                    if(!empty($query))
                                    {
                                        $id = $query['id'];
                                    }
                                    else
                                    {
                                        Doctrine_Manager::getInstance()->getCurrentConnection()->execute('Insert into '.$value.' (`name`,`created_at`,`updated_at`) VALUES ("'.$data.'",NOW(),NOW())');
                                        $id = Doctrine_Manager::getInstance()->getCurrentConnection()->lastInsertId();
                                    }
                                    $strAdd = 'INSERT INTO survey_'.$value.' (`survey_id`,`'.$key.'_id`,`created_at`,`updated_at`) VALUES ("'.$survey_id.'","'.$id.'",NOW(),NOW())';
                                    Doctrine_Manager::getInstance()->getCurrentConnection()->execute($strAdd);
                                   
                                }
                            }
                        }
                    }
                }
die;
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
                    //var_dump($finalquerystring);
                    foreach($fianlresult as $final)
                    {
                        if(count($final)==19)
                        {
                            var_dump($final);die;
                            continue;
                        }
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
                        //var_dump($finalquerystring);die;
                    $final_states_string = rtrim($final_states_string, ",(");
                    $final_cities_string = rtrim($final_cities_string, ",(");
                    $final_practice_areas_string = rtrim($final_practice_areas_string, ",(");
                                                var_dump($final_practice_areas_string);die;

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
