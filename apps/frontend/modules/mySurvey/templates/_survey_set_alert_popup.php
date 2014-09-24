<div id="dialog_form_survey__set_alert" class="popup1" title="Set Alert">

    <form id="set_alert_form">
        <table style="">

                <tr>
                    <td>
                    <label for="to_dialog_form_survey_set_alert" title="To.">To: </label>
                    <div class="additional_checkbox_block">
                        <input type="checkbox" name="to_me" id="to_me_dialog_form_survey_email" checked /><span class="to_me_label">Me</span>
                    </div>
                    </td>
                <td >
                    <label for="textarea_title" title="">Cc: </label>
                    <input type="text" id="to_dialog_form_survey_set_alert2" style="width: 300px !important;"/>
                    <label for="text_link" title=""><a href="#">Add</a> </label>
                </td>
                </tr>


            <tr>
                <td>
                    <label for="select_data">When:</label>
                    <select name="time-frame" class="select_day">
                        <?php for($i=1;$i<31;$i++)
                            {
                                echo '<option>'.$i.'</option>';
                            }
                        ?>
                    </select>

                    <select name="time-frame-type" class="select_month">
                        <option>Day(s)</option>
                        <option>Week(s)</option>
                        <option>Month(s)</option>
                    </select>
                    <label for="before_submission">before submission deadline</label>
                </td>
            </tr>

            <tr>
                <td>
                    <div class="checkbox_update">
                        <input type="checkbox" name="updated"  />
                        <label for="checkbox_title">Anytime the record is updated</label>
                    </div>
                </td>
            </tr>

            <tr>
                <td style="float:right;margin-bottom: 10px">
                    <div class="close_btn">
                        <input type="button" value="Cancel">
                    </div>
                    <div class="setalert_button">
                        <input type="submit" value="Set Alert">
                    </div>
                </td>
            </tr>
        </table>
    </form>

        <div class="table_values">
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

            <div class="list_alerts">
<!--                <p> No alerts have been set </p>-->
               <!-- <table class="tabel_listvalues" >
                    <tbody>
                    <tr>
                        <td><p>No alerts set</p></td>
                        <td><p></p></td>
                        <td><center><span class="change">Change</span> <br> <span class="remove">Remove</span></center></td>
                    </tr>
                    </tbody>
                </table>-->
            </div>
            <div class="add_remove">
               <!-- <p><span class="pagecount"></span> of <span class="pagecountof">0</span> entries</p>
                <div>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>-->
            </div>
            <div style="clear: both"></div>
        </div>



    <div class="change_values">

        <div class="change_alert">
            <p> Change an alert</p>
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
                    <div class="alert_textarea">
                        <textarea name="to" id="change_alert_emails" class="text ui-widget-content ui-corner-all"></textarea>
                    </div>
                </td>
            </tr>
            <tr>
                <td>

                    <label for="select_data">When:</label>
                    <select name="time-frame" class="select_day_change">
                        <?php for($i=1;$i<31;$i++)
                        {
                            echo '<option>'.$i.'</option>';
                        }
                        ?>
                    </select>

                    <select name="time-frame-type" class="select_month_change">
                        <option>Day(s)</option>
                        <option>Week(s)</option>
                        <option>Month(s)</option>
                    </select>
                    <div class="checkbox_update">
                        <input type="checkbox" name=""  />
                        <label for="checkbox_title">Anytime the record is updated</label>
                    </div>
                </td>
            </tr>

            <tr>
                <td> <div class="row_line"></div></td>
            </tr>

            <tr>
                <td>
                    <div class="ok_btn">
                        <input type="button" value="OK">
                    </div>
                    <div class="cancel_btn">
                        <input type="button" value="Cancel">
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
</div>


