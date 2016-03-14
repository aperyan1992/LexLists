<?php if ($additional_message !== false && !empty($additional_message)) : ?>
    <h3>Message:</h3>
    <?php echo $additional_message; ?>
    <br/><br/>
<?php endif; ?>
<?php  ?>
<h3>Lex<span style="color: #ff6801 !important;">Lists</span></h3>
<?php foreach ($surveys as $key => $survey) : ?>
    <table>
        <tr>
            <th align="left">Award:</th>
            <td><?php echo (!is_null($survey['survey_name']) && $survey['survey_name'] != "") ? $survey['survey_name'] : "- - -"; ?></td>
        </tr>
        <tr>
            <th align="left">Submission Deadline:</th>
            <td><?php echo (!is_null($survey['submission_deadline']) && $survey['submission_deadline'] != "") ? $survey['submission_deadline'] : "- - -"; ?></td>
        </tr>

        <tr>
            <th align="left">Type:</th>
            <td><?php echo ($survey['candidate_type'] != 0) ? $survey['candidate_type'] : "- - -"; ?></td>
        </tr>
        <tr>
            <th align="left">Special Criteria(s):</th>
            <td>
                <?php
                $special_criterias = "- - -";
                if ($survey['special_criteria_name']) {
                    $special_criterias = $survey['special_criteria_name'];
                }
                echo $special_criterias;
                ?>
            </td>
        </tr>
        <tr>
            <th align="left">Practice Area(s):</th>
            <td>
                <?php
                $practice_areas = "- - -";
                if ($survey['practice_area_name']) {
                    $practice_areas = $survey['practice_area_name'];
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
                if($survey['region_name'] || $survey['city_name'] || $survey['state_name'] || $survey['country_name']) {
                    // Get region
                    $region = (!is_null($survey['survey_region_id']) && $survey['survey_region_id'] != "") ? $survey['region_name'] : "- - -";

                    // Get cities
                    $cities = "- - -";
                    if ($survey['city_name']) {
                        $cities = $survey['city_name'];
                    }
                    // Get countries
                    $countries = "- - -";
                    if ($survey['country_name']) {
                        $countries = $survey['country_name'];
                    }

                    // Get states
                    $states = "- - -";
                    if ($survey['state_name']) {
                        $states = $survey['state_name'];
                    }
                    $geographic_area = $region . " " . $cities . " ". $states . " " . $countries . "";
                    $geographic_area = rtrim($geographic_area, "; ");
                }
                echo $geographic_area;
                ?>
            </td>
        </tr>
        <tr>
            <th align="left" valign="top">Description:</th>
            <td><?php echo (!is_null($survey['survey_description']) && $survey['survey_description'] != "") ? $survey['survey_description'] : "- - -"; ?></td>
        </tr>
        <tr>
            <th align="left" valign="top">How to Apply:</th>
            <td><?php echo (!is_null($survey['nomination']) && $survey['nomination'] != "") ? $survey['nomination'] : "- - -"; ?></td>
        </tr>
        <tr>
            <th align="left">Frequency:</th>
            <td><?php echo ($survey['frequency'] != 0) ? LtSurvey::$frequency_types_array[$survey['frequency']]  : "- - -"; ?></td>
        </tr>
        <tr>
            <th align="left">Contact Person:</th>
            <td>
                <?php
                echo $survey['last_name'] .
                ", " .
                $survey['first_name'] .
                " (" .
                $survey['email_address'] .
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