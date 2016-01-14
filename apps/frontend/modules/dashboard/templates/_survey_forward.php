<div id="dialog_form_survey_forward" class="popup1" style="display:none" title="Forward the selection(s) to:">

    <table style="">
        <tr>
            <th>
                <label for="to_dialog_form_survey_email" title="To.">To: </label>
            </th>

            <td>
                    <input style="width: 330px; padding-left: 8px !important; margin-bottom: 13px !important;" placeholder="Enter email address" type="text" name="to" id="to_dialog_form_survey_forward" class=" select2 to_dialog_form_survey_forward text ui-widget-content ui-corner-all special_height"/>
                <div style="display:none" id="dialog_email_user_email_hidden"></div>
            </td>
        </tr>
        <tr>
            <th><label>Cc:</label></th>
            <td>
                <input style="margin-bottom: 13px;" type="checkbox" name="to_me" id="to_me_dialog_form_survey_forward" class="timemail" checked />
                <span  class="to_me_label_forward" id="dialog_forward_user_email"></span>
                <div style="display:none" id="dialog_forward_user_email_hidden"></div>
                <!-- <a style="color: #ff6801;font-weight: 700;margin-left: 1px;" href="#" id="addemailcc2">Add</a>-->
            </td>
        </tr>
        <tr style="margin-top: 10px;">
            <th class="top_vertical_align">
                <label for="message_dialog_form_survey_email" title="Message (optional).">Message: </label>
            </th>
            <td>
                <textarea style="width: 81.3%; padding-left: 8px;" placeholder="Enter your message (optional)" name="message" id="message_dialog_form_survey_forward" class="text ui-widget-content ui-corner-all" rows="4"></textarea>
            </td>
        </tr>
        <span id="email_validate_error" style="margin-left: 175px; color: red; display: none;">Not a valid Email address !</span>
    </table>

</div>