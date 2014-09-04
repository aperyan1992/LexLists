<?php if ($additional_message !== false && !empty($additional_message)) : ?>
    <h3>Message:</h3>
    <?php echo $additional_message; ?>
    <br/><br/>
<?php endif; ?>

<h3>Lex<span style="color: #ff6801 !important;">Lists</span></h3>
<?php foreach ($surveys as $survey) : ?>
    <table>
        <tr>
            <th align="left">Award:</th>
            <td><?php echo (!is_null($survey->getSurveyName()) && $survey->getSurveyName() != "") ? $survey->getSurveyName() : "- - -"; ?></td>
        </tr>
        <tr>
            <th align="left">Submission Deadline:</th>
            <td><?php echo (!is_null($survey->getSubmissionDeadline()) && $survey->getSubmissionDeadline() != "") ? $survey->getSubmissionDeadline() : "- - -"; ?></td>
        </tr>
        <tr>
            <th align="left">Type:</th>
            <td><?php echo ($survey->getCandidateType() != 0) ? LtSurvey::$candidate_types_array[$survey->getCandidateType()] : "- - -"; ?></td>
        </tr>
        <tr>
            <th align="left">Special Criteria(s):</th>
            <td>
                <?php
                $special_criterias = "- - -";
                if ($survey->getLtSurveySpecialCriteria()->getFirst()) {
                    $special_criteria_array = array();
                    foreach ($survey->getLtSurveySpecialCriteria() as $special_criteria) {
                        $special_criteria_array[] = $special_criteria->getSpecialCriteria()->getName();
                    }

                    $special_criterias = implode(", ", $special_criteria_array);
                }

                echo $special_criterias;
                ?>
            </td>
        </tr>
        <tr>
            <th align="left">Eligibility:</th>
            <td><?php echo (!is_null($survey->getEligibilityCriteria()) && $survey->getEligibilityCriteria() != "") ? $survey->getEligibilityCriteria() : "- - -"; ?></td>
        </tr>
        <tr>
            <th align="left">Practice Area(s):</th>
            <td>
                <?php
                $practice_areas = "- - -";
                if ($survey->getLtSurveyPracticeArea()->getFirst()) {
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
            <th align="left">Geographic Area:</th>
            <td>
                <?php
                $geographic_area = "- - -";
                if($survey->getRegion() || $survey->getLtSurveyCity()->getFirst() || $survey->getLtSurveyState()->getFirst() || $survey->getLtSurveyCountry()->getFirst()) {
                    // Get region
                    $region = "- - -";
                    if($survey->getRegion()) {
                        $region = $survey->getRegion()->getName();
                    }

                    // Get cities
                    $cities = "- - -";
                    if ($survey->getLtSurveyCity()->getFirst()) {
                        $cities_array = array();
                        foreach ($survey->getLtSurveyCity() as $city) {
                            $cities_array[] = $city->getCity()->getName();
                        }

                        $cities = implode(", ", $cities_array);
                    }

                    // Get countries
                    $countries = "- - -";
                    if($survey->getLtSurveyCountry()->getFirst()) {
                        $countries_array = array();
                        foreach ($survey->getLtSurveyCountry() as $country) {
                            $countries_array[] = $country->getCountry()->getName();
                        }

                        $countries = implode(", ", $countries_array);
                    }

                    // Get states
                    $states = "- - -";
                    if($survey->getLtSurveyState()->getFirst()) {
                        $states_array = array();
                        foreach ($survey->getLtSurveyState() as $state) {
                            $states_array[] = $state->getState()->getName();
                        }

                        $states = implode(", ", $states_array);
                    }

                    $geographic_area = $region . "; " . $cities . "; ". $states . "; " . $countries . ";";
                }

                echo $geographic_area;
                ?>
            </td>
        </tr>
        <tr>
            <th align="left" valign="top">Description:</th>
            <td><?php echo (!is_null($survey->getSurveyDescription()) && $survey->getSurveyDescription() != "") ? $survey->getSurveyDescription() : "- - -"; ?></td>
        </tr>
        <tr>
            <th align="left" valign="top">Methodology:</th>
            <td><?php echo (!is_null($survey->getSelectionMethodology()) && $survey->getSelectionMethodology() != "") ? $survey->getSelectionMethodology() : "- - -"; ?></td>
        </tr>
        <tr>
            <th align="left" valign="top">How to Apply:</th>
            <td><?php echo (!is_null($survey->getNomination()) && $survey->getNomination() != "") ? $survey->getNominationWithLinks() : "- - -"; ?></td>
        </tr>
        <tr>
            <th align="left">Frequency:</th>
            <td><?php echo ($survey->getFrequency() != 0) ? LtSurvey::$frequency_types_array[$survey->getFrequency()] : "- - -"; ?></td>
        </tr>
        <tr>
            <th align="left">Contact Person:</th>
            <td>
                <?php
                echo $survey->getContact()->getLastName() .
                ", " .
                $survey->getContact()->getFirstName() .
                " (" .
                $survey->getContact()->getEmailAddress() .
                ")"
                ?>
            </td>
        </tr>
        <tr>
            <td colspan="2"><hr/><hr/></td>
        </tr>
    </table>
<?php endforeach; ?>

<br/><br/>
<b>LexLists: Discover Awards!</b>
<br/>
Sharing or using this output in any way outside its intended use is a violation of the License & Terms Agreement.