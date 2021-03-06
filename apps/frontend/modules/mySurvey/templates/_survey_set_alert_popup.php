<div id="dialog_form_survey__set_alert" class="popup1"  style="display:none" title="Set Alert">

    <div class="content">
        <form id="set_alert_form">
        <div class="area">
             <div class="left_block tooltip2">
                 <span> Organization: </span>
                
             </div>

            <div class="right_block">
                 <span class="orgjson"></span>
            </div>
        </div>
        <div class="area" style="margin-top: -16px;">
             <div class="left_block tooltip2">
                 <span> Survey Name: </span>
                
             </div>

            <div class="right_block">
                 <span class="srvjson"></span>
            </div>
        </div>

        <div style="width: 100%; height: 0px; margin-left: -14px; border-top: 1px solid #E2DDC9; position: absolute; top:45px;"></div>

        <div class="area">
             <div class="left_block tooltip2">
                 <span> To: </span>
                 <span class="toolclass">
                Send the alert to me.
            </span>
             </div>

            <div class="right_block">
                 <input type="checkbox" class="tomemail" name="to_me" id="to_me_dialog_form_survey_email" checked /><span class="to_me_label"></span>
            </div>
        </div>
        <div class="area ">
             <div class="left_block tooltip2" style="margin-top: 5px !important;">
                 <span class="toolclass">Others to include in the alert.</span>
                 <span>Cc:</span>
            </div>

            <div class="right_block">
                <!-- <textarea type="text" id="to_dialog_form_survey_set_alert2" style="width: 400px !important;"></textarea> -->
                <input style="width: 400px; padding: 0 !important;" placeholder="&nbsp;  Click to select or type address and press Enter" type="text" name="to" id="to_dialog_form_survey_set_alert2" class="text ui-widget-content ui-corner-all special_height"/>

                <!--<span class="tooltip2 addemailclass"><span class="toolclass"><strong>If the user is not already available from the pull-down, type-in the email and then press Add</span></strong>
                    <a style="color: #ff6801;font-weight: 700;margin-left: 5px;" href="#" id="addemailcc">Add</a>
                </span>-->
            </div>
        </div>
        <div class="area">
            <div class="left_block tooltip2">
                <span class="toolclass">Set the time you want to receive the alert with respect to the submission deadline. Pick a number and then the time-frame from the pull-downs.</span>                <span>When:</span>
            </div>

            <div class="right_block">
                <select name="time-frame" class="select_day">
                    <option></option>
                    <?php for($i=1;$i<31;$i++)
                    {
                        echo '<option>'.$i.'</option>';
                    }
                    ?>
                </select>

                <select name="time-frame-type" class="select_month">
                    <option></option>
                    <option>Day(s)</option>
                    <option>Week(s)</option>
                    <option>Month(s)</option>
                </select>
                <span>before submission deadline</span>
            </div>
        </div>
        <div class="area">
            <div class="left_block">

            </div>

            <div class="right_block tooltip2">
                <span class="toolclass">Notify me whenever this record is updated.</span>
                <input type="checkbox" name="updated" id="notify_me_checkbox" style="margin-top: -1px !important;"  />
                <span>Anytime the record is updated</span>
            </div>
        </div>
        <div class="area">
            <div class="left_block">

            </div>

            <div class="right_block">

                <div class="setalert_button">
                    <input type="submit" value="Set Alert" style="height: 28px;">
                </div>
                <div class="close_btn">
                    <input type="button" value="Cancel" style="height: 28px;">
                </div>

            </div>

        </div>
            <div class="table_values" style="float:left;width:585px">
                <div>
                    <div class="value1">
                        <p>Notify</p>
                        <div class="arrows">
                            <span class="up_arrow"></span>
                            <span class="down_arrow"></span>
                        </div>
                    </div>
                    <div class="value2">
                        <p>When</p>
                        <div class="arrows">
                            <span class="up_arrow"></span>
                            <span class="down_arrow"></span>
                        </div>
                    </div>
                    <div class="value3">
                        <div class="arrows">
                            <span class="up_arrow"></span>
                            <span class="down_arrow"></span>
                        </div>
                    </div>
                </div>

                <div class="list_alerts" style="float:left;width: 99.7%;border:1px solid #D9D2B9;border-bottom: none;border-top:none; color: gray;">

                </div>
                <div class="add_remove">

                </div>
                <div style="clear: both"></div>
            </div>
        </form>
    </div>
    <div class="change_values">

        <div class="change_alert">
            <p>Change the Alert</p>
            <div class="close_button">
                <span class="close_img"> X </span>
            </div>
        </div>
        <table>
            <form id="change_alert">
                <input id="change_alert_id" type="hidden" name="alert_id"/>
            <tr>
                <td>
                    <label for="to_dialog_form_survey_set_alert" title="Notify">Notify </label>
                    <div class="additional_checkbox_block">

                        <input type="checkbox" name="to_me" id="to_me_change_alert" checked /><span class="to_me_label">Me</span>
                    </div>
                </td>
                <td >
                    <label for="cc" title="Notify">Cc: </label>
                    <div class="alert_textarea">
                        <textarea name="to" id="change_alert_emails" class="text ui-widget-content ui-corner-all" style="width: 392px; height:32px; margin-top:16px;border-radius: 0px;"></textarea>
                    </div>
                </td>
            </tr>
            <tr>
                <td>

                    <label for="select_data" style="margin-left: 10px; margin-top: 12px; width: 70px;">When:</label>

                    <div style="width: 75%; float: right; margin-top: -26px;">
                        <select name="time-frame" class="select_day_change" style="width:60px;border-radius: 3px;">
                            <?php for($i=1;$i<31;$i++)
                            {
                                echo '<option>'.$i.'</option>';
                            }
                            ?>
                        </select>

                        <select name="time-frame-type" class="select_month_change" style="width: 150px;border-radius: 3px;">
                            <option>Day(s)</option>
                            <option>Week(s)</option>
                            <option>Month(s)</option>
                        </select>
                    </div>
                    <div class="checkbox_update" style="margin-left: 150px;">
                        <input type="checkbox" name=""  />
                        <label for="checkbox_title" style="font-weight: normal !important;">Anytime the record is updated</label>
                    </div>
                </td>
            </tr>

            <tr>
                <td> <div class="row_line"></div></td>
            </tr>

            <tr>
                <td>
                    <div class="ok_btn">
                        <input type="button" value="OK" style="height: 28px;">
                    </div>
                    <div class="cancel_btn">
                        <input type="button" value="Cancel" style="height: 28px;">
                    </div>
                </td>
            </tr>
        </form>

        </table>
    </div>
<!--            <tr>-->
<!--                <th class="top_vertical_align">-->
<!--                    <label for="message_dialog_form_survey_email" title="Message (optional).">Message: </label>-->
<!--                </th>-->
<!--                <td>-->
<!--                    <textarea placeholder="Enter your message (optional)" name="message" id="message_dialog_form_survey_email" class="text ui-widget-content ui-corner-all" rows="4"></textarea>-->
<!--                </td>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <th colspan="2"><hr/></th>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <th align="right">Year:</th>-->
<!--                <td id="dialog_email_year"></td>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <th align="right">Organization:</th>-->
<!--                <td id="dialog_email_organization"></td>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <th align="right">Award:</th>-->
<!--                <td id="dialog_email_survey_name"></td>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <th align="right">Submission Deadline:</th>-->
<!--                <td id="dialog_email_submission_deadline"></td>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <th align="right">Type:</th>-->
<!--                <td id="dialog_email_candidate_type"></td>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <th align="right">Special Criteria(s):</th>-->
<!--                <td id="dialog_email_special_criterias"></td>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <th align="right" valign="top">Eligibility:</th>-->
<!--                <td id="dialog_email_eligibility_notes"></td>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <th align="right">Practice Area(s):</th>-->
<!--                <td id="dialog_email_practice_areas"></td>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <th align="right">Geographic Area:</th>-->
<!--                <td id="dialog_email_geographic_area"></td>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <th align="right" valign="top">Description:</th>-->
<!--                <td id="dialog_email_description"></td>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <th align="right" valign="top">Methodology:</th>-->
<!--                <td id="dialog_email_submission_methodology"></td>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <th align="right" valign="top">How to Apply:</th>-->
<!--                <td id="dialog_email_nomination"></td>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <th align="right">Frequency:</th>-->
<!--                <td id="dialog_email_frequency"></td>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <th align="right">Contact Person:</th>-->
<!--                <td id="dialog_email_contact_person"></td>-->
<!--            </tr>-->
<!--            <tr>-->
<!--                <td colspan="2" style="padding-left: 0 !important; padding-top: 10px; font-size: 10px;">-->
<!--                    <b>ID:</b> <span id="dialog_email_survey_id"></span>-->
<!--                    <b>Created:</b> <span id="dialog_email_created_date"></span>-->
<!--                    <b>Updated:</b> <span id="dialog_email_updated_date"></span>-->
<!--                </td>-->
<!--            </tr>-->
<!--        </table>-->
<!--    </form>-->

    <div class="dialog_for_calendar_my_list" style="display: none; overflow: hidden;" title="">

        <div class="page-header">

            <div class="pull-right form-inline">
                <div class="btn-group">
                    <button class="btn btn-warning" data-calendar-nav="prev">&lt;&lt; Prev</button>
                    <button class="btn" data-calendar-nav="today">Today</button>
                    <button class="btn btn-warning" data-calendar-nav="next">Next &gt;&gt;</button>
                </div>
                <div class="btn-group">
                    <button class="btn btn-warning" data-calendar-view="year">Year</button>
                    <button class="btn btn-warning active" data-calendar-view="month">Month</button>
                    <button class="btn btn-warning" data-calendar-view="week">Week</button>
                    <!--<button class="btn btn-warning" data-calendar-view="day">Day</button>-->
                </div>
            </div>

            <h3></h3>
        </div>

        <div id="calendar_div_my_list" style="padding-left: 45px;padding-right: 45px;padding-bottom: 15px;">
        </div>
        <form action="/index.php/print_calendar_list" target="_blank" method="post" id="print_calendar_form_my_list">
            <input id="month_hidden_list" type="hidden" name="month" value="">
            <input id="calendar_type_list" type="hidden" name="calendar_type" value="">
            <button class="print_calendar" id="print_calendar" >Print</button>
        </form>

    </div>
</div>


