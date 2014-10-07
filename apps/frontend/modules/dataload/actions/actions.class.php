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
        $allowedExts = array("gif", "jpeg", "jpg", "png", "xls", 'csv');
        $temp = explode(".", $_FILES["file"]["name"]);
        $extension = end($temp);
//        var_dump($_FILES["file"]["type"]);
        if ($_FILES["file"]["type"] == "text/csv"
            && ($_FILES["file"]["size"] < 20000000)
            && in_array($extension, $allowedExts)) {
            if ($_FILES["file"]["error"] > 0) {
                echo "Error: " . $_FILES["file"]["error"] . "<br>";
            } else {
                $handle = fopen($_FILES["file"]["tmp_name"], "r");
                while(($data = fgetcsv($handle, 1000, ","))!==FALSE)
                {
                    $csvdata[] = $data;
                }
                unset($csvdata[0], $csvdata[1]);
                $query = 'Select `id`, `name` FROM `regions`';
                $regoins = Doctrine_Manager::getInstance()->getCurrentConnection()->execute($query)->fetchAll();
                foreach($regoins as $regoin)
                {
                    $newregoins[$regoin['name']] = $regoin['id'];
                }
                echo '<pre>';
               // var_dump($csvdata);die;
                foreach($csvdata as $key=>$data)
                {

                    if(isset($newregoins[$data[10]]))
                    {
                        $fianlresult[$key]['survey_region_id'] = $newregoins[$data[10]];
                    }
                    else{
                        $fianlresult[$key]['survey_region_id'] = null;
                    }
                    if(isset($data[22]))
                    {
                        $fianlresult[$key]['organization_url'] = $data[10];
                    }
                    else{
                        $fianlresult[$key]['organization_url'] = null;
                    }
                    if(isset($data[2]))
                    {
                        $fianlresult[$key]['survey_name'] = $data[2];
                    }
                    else{
                        $fianlresult[$key]['survey_name'] = null;
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
                    if(isset($data[5]))
                    {
                        $fianlresult[$key]['submission_deadline'] = $data[5];
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

                    //var_dump($data);echo '<hr>';
                  /*  if(isset($data[1]))
                    {
                        $query = 'INSERT INTO `organizations` (`name`) VALUES';
                        $query .= " ('".$data[1]."')";
                        $result = Doctrine_Manager::getInstance()->getCurrentConnection();
                        if($result->execute($query))
                        {
                            $lastid = $result->lastInsertId();
                            $fianlresult[$key]['organization_id'] = $lastid;
                        }
                    }*/
                }
                echo "<pre>";
                print_r($fianlresult);

            }
        } else {
            echo "Invalid file";
        };die;
    }
}
