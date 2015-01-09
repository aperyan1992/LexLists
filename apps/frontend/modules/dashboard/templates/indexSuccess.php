<section id="content" class="span12 report_content">
<div class="row">
<div class="left-sidebar">
    <div class="filters_header">
        <h3 title="Select from the fields below to refine and better focus the results.">Filter By</h3> /
        <a href="#" id="clear_filters" class="custom_link">Clear Filters</a>
    </div>

    <div class="other_filters_block">
        <div class="year">
            <h3 class="custom_color" title="The year of the survey or award.">Year<i class="filter_arrow"></i></h3>
            <div class="org-body test_smaller">
                <form action="" name="">
                    <?php echo $sf_data->getRaw('survey_year_checkboxes') ?>
                </form>
            </div>
        </div>

        <div class="organization">
            <h3 class="custom_color" title="The organization running the survey or award.">Organization <i class="filter_arrow"></i></h3>
            <div class="org-body test_smaller">
                <form action="" name="">
                    <?php echo $sf_data->getRaw('survey_organizations_checkboxes') ?>
                </form>
            </div>
        </div>

        <div class="candidate_type">
            <h3 class="custom_color" title="The type of candidate eligible to participate in a survey or be considered for an award.">Candidate Type <i class="filter_arrow"></i></h3>
            <div class="org-body">
                <form action="" name="">
                    <?php echo $sf_data->getRaw('survey_candidate_types_checkboxes') ?>
                </form>
            </div>
        </div>

        <div class="practice_area">
            <h3 class="custom_color" title="The practice areas covered by an award or survey.">Practice Area/Industry <i class="filter_arrow"></i></h3>
            <div class="org-body">
                <form action="" name="">
                    <?php echo $sf_data->getRaw('survey_practice_areas_checkboxes') ?>
                </form>
            </div>
        </div>

        <div class="region">
            <h3 class="custom_color" title="The geographic area of acceptable candidates.">Region <i class="filter_arrow"></i></h3>
            <div class="org-body">
                <form action="" name="">
                    <?php echo $sf_data->getRaw('survey_regions_checkboxes') ?>
                </form>
            </div>
        </div>

        <div class="special_criteria">
            <h3 class="custom_color" title="Any special criteria or focus related to the award or survey.">Special Criteria <i class="filter_arrow"></i></h3>
            <div class="org-body">
                <form action="" name="">
                    <?php echo $sf_data->getRaw('survey_special_criterias_checkboxes') ?>
                </form>
            </div>
        </div>
    </div>

    <div class="deadline">
        <h3 class="custom_color" title="A way to filter by date future surveys or awards based on their submission deadline.">Deadline <i class="filter_arrow"></i></h3>
        <div class="org-body">
            <form action="" name="">
                <input checkbox_type="submission_deadline" type="checkbox" class="deadline_checkbox" col_num="11" value="this_month" name="deadline_checkbox" id="this_month" /><span>This month</span><br />
                <input checkbox_type="submission_deadline" type="checkbox" class="deadline_checkbox" col_num="11" value="this_quarter" name="deadline_checkbox" id="this_quarter" /><span>This quarter</span><br />
                <input checkbox_type="submission_deadline" type="checkbox" class="deadline_checkbox" col_num="11" value="next_quarter" name="deadline_checkbox" id="next_quarter" /><span>Next quarter</span><br />
                <input checkbox_type="submission_deadline" type="checkbox" class="deadline_checkbox" col_num="11" value="this_year" name="deadline_checkbox" id="this_year" /><span>This year</span><br />
                <input checkbox_type="submission_deadline" type="checkbox" class="deadline_checkbox" col_num="11" value="next_year" name="deadline_checkbox" id="next_year" /><span>Next year</span><br />
            </form>
        </div>
    </div>
    <div class="jsmap">

        <h3 class="custom_color jsmapclick_us_states" title="A way to filter by US States on a map" >US States Map<i class="filter_arrow"></i></h3>
        <h3 class="custom_color jsmapclick_us" title="A way to filter by US Regions on a map" >US Regions Map<i class="filter_arrow"></i></h3>
        <h3 class="custom_color jsmapclick" title="A way to filter by World Regions on a map" >World Regions Map<i class="filter_arrow"></i></h3>
    </div>
</div>

<div class="main-report-column">
    <div class="search-block">
        <fieldset class="disp-block">
            <legend class="custom_color" title="Select the fields you want to display in the results.">Display</legend>
            <form action="" name="" id="display_form" method="POST" target="_blank">
                <div class="first-column">
                    <input title="Year of the survey. Typically, one organization may run one specific survey only once a year. In very rare occasions a survey may run more than once in a year (ex. semi-annual or quarterly survey)." name="display[year]" display_name="year" type="checkbox" class="default_display_checkbox" col_num="1" value="1" checked />
                    <span title="Year of the survey. Typically, one organization may run one specific survey only once a year. In very rare occasions a survey may run more than once in a year (ex. semi-annual or quarterly survey).">Year</span><br />

                    <input title="The organization publishing the survey." name="display[organization]" display_name="organization" type="checkbox" class="default_display_checkbox" col_num="2" value="1" checked />
                    <span title="The organization publishing the survey.">Organization</span><br />

                    <input title="The name of the survey. One organization may be publishing multiple surveys each year." name="display[survey_name]" display_name="survey_name" type="checkbox" class="default_display_checkbox" col_num="3" value="1" checked />
                    <span title="The name of the survey. One organization may be publishing multiple surveys each year.">Award</span><br />
                </div>

                <div class="second-column">
                    <input title="The type of eligible candidates." name="display[candidate_type]" display_name="candidate_type" type="checkbox" class="not_default_display_checkbox" col_num="4" value="1" />
                    <span title="The type of eligible candidates.">Candidate Type</span><br />

                    <input title="Practice areas covered by the survey." name="display[practice_area]" display_name="practice_area" type="checkbox" class="not_default_display_checkbox" col_num="5" value="1" />
                    <span title="Practice areas covered by the survey.">Practice Area/Industry</span><br />

                    <input title="The focus of the geographic region of acceptable candidates." name="display[region]" display_name="region" type="checkbox" class="default_display_checkbox" col_num="7" value="1" checked />
                    <span title="The focus of the geographic region of acceptable candidates.">Region</span><br />
                </div>

                <div class="third-column">
                    <input title="City covered by the survey." name="display[city]" display_name="city" type="checkbox" class="not_default_display_checkbox" col_num="8" value="1" />
                    <span title="City covered by the survey.">City</span><br />

                    <input title="State covered by the survey." name="display[state]" display_name="state" type="checkbox" class="not_default_display_checkbox" col_num="9" value="1" />
                    <span title="State covered by the survey.">State</span><br />

                    <input title="Country covered by the survey." name="display[country]" display_name="country" type="checkbox" class="not_default_display_checkbox" col_num="10" value="1" />
                    <span title="Country covered by the survey.">Country</span><br />
                </div>

                <div class="fourth-column">
                    <input title="Eligibility." name="display[eligibility]" display_name="eligibility" type="checkbox" class="not_default_display_checkbox" col_num="12" value="1" />
                    <span title="Eligibility.">Eligibility</span><br />

                    <input title="Description." name="display[description]" display_name="description" type="checkbox" class="not_default_display_checkbox" col_num="13" value="1" />
                    <span title="Description.">Description</span><br />

                    <input title="Methodology." name="display[methodology]" display_name="methodology" type="checkbox" class="not_default_display_checkbox" col_num="14" value="1" />
                    <span title="Methodology.">Methodology</span><br />
                </div>

                <div class="fifth-column">
                    <input title="Submission deadline for the survey." name="display[submission_deadline]" display_name="submission_deadline" type="checkbox" class="default_display_checkbox" col_num="11" value="1" checked />
                    <span title="Submission deadline for the survey.">Deadline</span><br />

                    <input title="This is one or more special criteria to be identify a survey. For example: Minority women under 40." name="display[special_criteria]" display_name="special_criteria" type="checkbox" class="not_default_display_checkbox" col_num="6" value="1" />
                    <span title="This is one or more special criteria to be identify a survey. For example: Minority women under 40.">Special Criteria</span><br />
                </div>

                <div style="display: none;" id="hidden_filters_block">
                    <select name="filter[year][]" multiple="multiple" id="filter_year"><option value="0"></option></select>
                    <select name="filter[organization][]"  multiple="multiple" id="filter_organization"><option value="0"></option></select>
                    <select name="filter[survey_name][]"  multiple="multiple" id="filter_survey_name"><option value="0"></option></select>
                    <select name="filter[candidate_type][]"  multiple="multiple" id="filter_candidate_type"><option value="0"></option></select>
                    <select name="filter[practice_area][]"  multiple="multiple" id="filter_practice_area"><option value="0"></option></select>
                    <select name="filter[region][]"  multiple="multiple" id="filter_region"><option value="0"></option></select>
                    <select name="filter[submission_deadline][]"  multiple="multiple" id="filter_submission_deadline"><option value="0"></option></select>
                    <select name="filter[special_criteria][]"  multiple="multiple" id="filter_special_criteria"><option value="0"></option></select>
                    <input type="hidden" name="sort[field]" id="sort_field" value="none" />
                    <input type="hidden" name="sort[type]" id="sort_type" value="none" />
                </div>

            </form>
            <div class="display_management_links_div">
                <a href="#" class="display_management_links custom_link" id="default_display">Default</a>
                <a href="#" class="display_management_links custom_link correct_link" id="select_all_display">Select All</a>
                <a href="#" class="display_management_links custom_link correct_link" id="clear_all_display">Clear All</a>
            </div>
        </fieldset>
    </div>

    <div class="main-block">
        <div class="parent-block">
            <div id="report_surveys_table">
                <table id="report_surveys">
                    <thead>
                    <tr>
                        <th style="width:45px !important;"><input type="checkbox" style="float:left;margin-left:0px" id="table_checkbox_select_all" class="main_table_checkbox" />  <span style="margin-left:5px;border-left: 1px solid #d4ccb0;width:19px;height:34px;position:absolute;">&nbsp;</span></th>

                        <th style="width: 60px; min-width: 60px; max-width: 60px;">Year</th>

                        <th>Organization</th>
                        <th>Award</th>
                        <th>Candidate Type</th>
                        <th>Practice Area/Industry</th>
                        <th>Special Criteria</th>
                        <th>Region</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Country</th>
                        <th>Deadline</th>

                        <th>Eligibility</th>
                        <th>Description</th>
                        <th>Methodology</th>
                    </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="multiple_actions_block">
        <form id="print_form" target="_blank" method="POST" action="<?php echo url_for("@print_survey"); ?>" style="display: none;">
            <select name="surveys_for_print[]" multiple="multiple" id="surveys_for_print"></select>
        </form>
        <input type="button" id="multiple_print" class="btn btn-success" value="Print" />
        <input type="button" id="multiple_email" class="btn btn-success" value="E-mail" />
        <input type="button" id="multiple_save" class="btn btn-success" value="Save" />
    </div>

</div>
</div>
</section>
<input type="hidden" value="0" id="change_data_table" />

<?php include_partial("dashboard/survey_details_popup"); ?>
<?php include_partial("dashboard/survey_email_popup"); ?>
<?php include_partial("dashboard/survey_set_alert_popup"); ?>