<h3>Survey Information:</h3>
<table>
  <tr>
    <th align="right">Year:</th>
    <td><?php echo (!is_null($survey->getYear()) && $survey->getYear() != "") ? $survey->getYear() : "- - -"; ?></td>
  </tr>
  <tr>
    <th align="right">Organization:</th>
    <td><?php echo (!is_null($survey->getOrganizationId()) && $survey->getOrganizationId() != "") ? $survey->getOrganization()->getName() : "- - -" ?></td>
  </tr>
  <tr>
    <th align="right">Survey Name:</th>
    <td><?php echo (!is_null($survey->getSurveyName()) && $survey->getSurveyName() != "") ? $survey->getSurveyName() : "- - -"; ?></td>
  </tr>
  <!-- <tr>
    <th align="right">Eligibility:</th>
    <td><?php echo ($survey->getCandidateType() != 0) ? LtSurvey::$candidate_types_array[$survey->getCandidateType()] : "- - -"; ?></td>
  </tr>
  <tr>
    <th align="right">Eligibility Notes:</th>
    <td><?php echo (!is_null($survey->getEligibilityCriteria()) && $survey->getEligibilityCriteria() != "") ? $survey->getEligibilityCriteria() : "- - -"; ?></td>
  </tr> -->
  <tr>
    <th align="right">Practice Area(s):</th>
    <td>
      <?php
        $practice_areas = "- - -";
        if($survey->getLtSurveyPracticeArea()->getFirst()) {
          $practice_area_array = array();
          foreach ($survey->getLtSurveyPracticeArea() as $practice_area) {
            $practice_area_array[] = $practice_area->getPracticeArea()->getShortCode();
          }

          $practice_areas = implode(", ", $practice_area_array);
        }
        
        echo $practice_areas; 
      ?>
    </td>
  </tr>
  <tr>
    <th align="right">Description/Criteria:</th>
    <td><?php echo (!is_null($survey->getSurveyDescription()) && $survey->getSurveyDescription() != "") ? $survey->getSurveyDescription() : "- - -"; ?></td>
  </tr>
 <!--  <tr>
    <th align="right">Submission Methodology:</th>
    <td><?php echo (!is_null($survey->getSelectionMethodology()) && $survey->getSelectionMethodology() != "") ? $survey->getSelectionMethodology() : "- - -"; ?></td>
  </tr> -->
  <tr>
    <th align="right">Contact Person:</th>
    <td>
      <?php echo $survey->getContact()->getLastName() . 
              ", " . 
              $survey->getContact()->getFirstName() . 
              " (" . 
              $survey->getContact()->getEmailAddress() . 
              ")" 
      ?>
    </td>
  </tr>
  <tr>
    <td colspan="2"><hr/></td>
  </tr>
  <tr>
    <td colspan="2"><h3>Record Information:</h3></td>
  </tr>
  <tr>
    <th align="right">ID:</th>
    <td><?php echo $survey->getId() ?></td>
  </tr>
  <tr>
    <th align="right">Created:</th>
    <td><?php echo $survey->getDateTimeObject("created_at")->format("y-M-d") ?></td>
  </tr>
  <tr>
    <th align="right">Updated</th>
    <td><?php echo $survey->getDateTimeObject("updated_at")->format("y-M-d") ?></td>
  </tr>
</table>