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
        $all_states = 'SELECT* FROM states';
        $states_query = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($all_states)->fetchAll();
        foreach($states_query as $state){
            $arrStates[$state['short_code']] =$state['id'];
        }



//var_dump($arrCities[$city['name']]);die;
        $query = 'SELECT MAX(`id`) FROM `surveys`';
        $max_survey_id = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($query)->fetch();
        $max_survey_id = $max_survey_id[0];
        //var_dump($max_survey_id);die;

        $allowedExts = array("gif", "jpeg", "jpg", "png", "xls", 'csv');
        $temp = explode(".", $_FILES["file"]["name"]);
        $updated = false;
        $extension = end($temp);
        if ($_FILES["file"]["type"] == "text/csv"
            && ($_FILES["file"]["size"] < 20000000)
            && in_array($extension, $allowedExts)) {
            if ($_FILES["file"]["error"] > 0) {
                echo "Error: " . $_FILES["file"]["error"] . "<br>";
            } else {
                $handle = fopen($_FILES["file"]["tmp_name"], "r");
                while(($data = fgetcsv($handle, 1000, "|"))!==FALSE)
                {
                    $csvdata[] = $data;
                }

                unset($csvdata[0], $csvdata[1]);

                foreach($csvdata as $key=>$data)
                {
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

                    if(!empty($data[10]) && isset($newregoins[$data[10]]))
                    {
                        $fianlresult[$key]['survey_region_id'] = $newregoins[$data[10]];
                    }
                    else{
                        $fianlresult[$key]['survey_region_id'] = 13;
                    }

                    if(isset($data[22]))
                    {
                        $fianlresult[$key]['organization_url'] = $data[22];
                    }
                    else{
                        $fianlresult[$key]['organization_url'] = null;
                    }

                    if(isset($data[2]))
                    {

                        $fianlresult[$key]['survey_name'] = $data[2];
                        $contact['name'] = $data[15];
                    }
                    else{
                        $fianlresult[$key]['survey_name'] = null;
                        $contact['name'] = null;
                    }

                    if(isset($data[3]))
                    {
                        $fianlresult[$key]['year'] = (int)preg_replace('/\D/', '', $data[3]);
                    }
                    else{
                        $fianlresult[$key]['year'] = null;
                    }

                    if(isset($data[21]))
                    {
                        $fianlresult[$key]['survey_url'] = $data[21];
                    }
                    else{
                        $fianlresult[$key]['survey_url'] = null;
                    }

                    if(isset($data[14]))
                    {
                        $fianlresult[$key]['frequency'] = $data[14];
                    }
                    else{
                        $fianlresult[$key]['frequency'] = null;
                    }

                    if(!empty($data[5]))
                    {
                        $fianlresult[$key]['submission_deadline'] = date('Y-m-d',strtotime($data[5]));
                    }
                    else{
                        $fianlresult[$key]['submission_deadline'] = null;
                    }

                    if(isset($data[4]))
                    {
                        $fianlresult[$key]['survey_description'] = $data[4];
                    }
                    else{
                        $fianlresult[$key]['survey_description'] = null;
                    }

                    if(isset($data[18]))
                    {
                        $fianlresult[$key]['candidate_type'] = $data[18];
                    }
                    else{
                        $fianlresult[$key]['candidate_type'] = null;
                    }

                    if(isset($data[19]))
                    {
                        $fianlresult[$key]['eligibility_criteria'] = $data[19];
                    }
                    else{
                        $fianlresult[$key]['eligibility_criteria'] = null;
                    }

                    if(isset($data[7]))
                    {
                        $fianlresult[$key]['city'] = $data[7];
                    }
                    else{
                        $fianlresult[$key]['city'] = null;
                    }
                    if(isset($data[8]))
                    {
                        $fianlresult[$key]['state'] = $data[8];
                    }
                    else{
                        $fianlresult[$key]['state'] = null;
                    }

                    if(isset($data[12]))
                    {
                        $fianlresult[$key]['nomination'] = $data[12];
                    }
                    else{
                        $fianlresult[$key]['nomination'] = null;
                    }

                    if(isset($data[13]))
                    {
                        $fianlresult[$key]['selection_methodology'] = $data[13];
                    }
                    else{
                        $fianlresult[$key]['selection_methodology'] = null;
                    }

                    if(isset($data[23]))
                    {
                        $fianlresult[$key]['survey_notes'] = $data[23];
                    }
                    else{
                        $fianlresult[$key]['survey_notes'] = null;
                    }


                    if(isset($data[16]))
                    {
                        $contact['email'] = $data[16];
                    }
                    else{
                        $contact['email'] = null;
                    }

                    if(isset($data[17]))
                    {
                        $contact['phone'] = $data[17];
                    }
                    else{
                        $contact['phone'] = null;
                    }


                    if(isset($data[1]) && !empty($neworganizationarray[$data[1]]))
                    {
                        $checkingquery = 'SELECT * FROM `surveys` WHERE survey_name="'.$contact['name'].'" AND organization_id="'.$neworganizationarray[$data[1]].'"';
                        $resultupdate = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($checkingquery)->fetch();
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


                    if(isset($data[1]))
                    {
                        if(!$update)
                        {
                            if(!empty($neworganizationarray[$data[1]]))
                            {
                                $fianlresult[$key]['organization_id'] = $neworganizationarray[$data[1]];
                            }
                            else
                            {
                                $query = 'INSERT INTO `organizations` (`name`) VALUES';
                                $query .= " ('".$data[1]."')";
                                $result = Doctrine_Manager::getInstance()->getCurrentConnection();
                                if($result->execute($query))
                                {
                                    $lastid = $result->lastInsertId();
                                    $fianlresult[$key]['organization_id'] = $lastid;
                                }
                            }
                        }
                    }

                    if(isset($data[7]))
                    {
                        if(!$update)
                        {
                            if(!empty($newcitiesarray[$data[7]]))
                            {
                                $fianlresult[$key]['city_id'] = $newcitiesarray[$data[7]];
                            }
                            else
                            {
                                $query = 'INSERT INTO `cities` (`name`) VALUES';


                                $exist_cities = 'SELECT* FROM `cities` where name = "'.$data[7].'"';
                                $cities = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($exist_cities)->fetchAll();
                                if(empty($cities) || $cities == '')
                                {
                                    $query .= " ('".$data[7]."')";
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


                    if($update)
                    {
                        $now = new DateTime();

                        $query = 'UPDATE `surveys` SET ';
                        $details = '';
                        foreach($fianlresult[$key] as $k=>$value)
                        {
                            if($k != "state" && $k != "city")
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
                    $now = new DateTime();
                    $i = $max_survey_id+1;
                    $final_states_string = 'INSERT INTO `survey_states` (`survey_id`, `state_id`) VALUES (';
                    $final_cities_string = 'INSERT INTO `survey_cities` (`survey_id`, `city_id`) VALUES (';
                    $all_cities = 'SELECT* FROM cities';
                    $cities_query = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($all_cities)->fetchAll();
                    foreach($cities_query as $city){
                        $arrCities[$city['name']] =$city['id'];
                    }

                    $arraykey = array_keys($fianlresult);
                    //var_dump($arraykey[0]);die;
                    $finalquerystring = 'INSERT INTO `surveys` (';
                    foreach($fianlresult[$arraykey[0]] as $key=>$value)
                    {
                        if($key != "state" && $key != "city")
                        {
                            $finalquerystring.='`'.$key.'`,';
                        }
                    }

                    $finalquerystring.='`created_at`,`updated_at`';
                    $finalquerystring = rtrim($finalquerystring, ",");

                    $finalquerystring.=') VALUES (';

                    foreach($fianlresult as $final)
                    {
                        if($final['state']!='' && isset($arrStates[$final['state']]))
                        {
                            $final_states_string .= '"'. $i .'","'. $arrStates[$final['state']] .'"),(';
                            $valuestate = true;
                        }

                        //var_dump($final['city']);
                        if($final['city']!='' && isset($arrCities[$final['city']]))
                        {
                            $final_cities_string .= '"'. $i .'","'. $arrCities[$final['city']] .'"),(';
                            $valuecity = true;
                        }
                        $i++;
                        foreach($final as $key=>$value)
                        {

                            if($key != "state" && $key != "city")
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
