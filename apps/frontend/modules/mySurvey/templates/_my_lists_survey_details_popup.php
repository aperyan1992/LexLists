<div id="dialog_form_survey_details_for_my_lists" class="popup1" style="display:none" title="Award Information">
    <form>
        <table style="">
            <tr>
                <th align="right">Year:</th>
                <td id="dialog_year"></td>
            </tr>
            <tr>
                <th align="right">Organization:</th>
                <td id="dialog_organization"></td>
            </tr>
            <tr>
                <th align="right">Award:</th>
                <td id="dialog_survey_name"></td>
                <td id="dialog_survey_name_hidden" style="display:none;"></td>
            </tr>
            <tr>
                <th align="right">Submission Deadline:</th>
                <td id="dialog_submission_deadline"></td>
            </tr>
            <tr>
                <th align="right">Type:</th>
                <td id="dialog_candidate_type"></td>
            </tr>
            <tr>
                <th align="right">Special Criteria(s):</th>
                <td id="dialog_special_criterias"></td>
            </tr>
            <!-- <tr>
                <th align="right" valign="top">Eligibility:</th>
                <td id="dialog_eligibility_notes"></td>
            </tr> -->
            <tr>
                <th align="right">Practice Area(s):</th>
                <td id="dialog_practice_areas"></td>
            </tr>
            <tr>
                <th align="right">Geographic Area:</th>
                <td id="dialog_geographic_area"></td>
            </tr>
            <tr>
                <th align="right" valign="top">Description:</th>
                <td id="dialog_description"></td>
                <td id="dialog_description_1" style="display:none;"></td>
            </tr>
            <!-- <tr>
                <th align="right" valign="top">Methodology:</th>
                <td id="dialog_submission_methodology"></td>
            </tr>
            <tr>
                <th align="right" valign="top">How to Apply:</th>
                <td id="dialog_nomination"></td>
            </tr> -->
            <tr>
                <th align="right">Frequency:</th>
                <td id="dialog_frequency"></td>
            </tr>
            <tr>
                <th align="right">Contact Person:</th>
                <td id="dialog_contact_person"></td>
            </tr>
            <tr>
                <td colspan="2"><hr/></td>
            </tr>
            <tr>
                <th>
                    <label for="dialog_form_survey_details_for_my_lists_my_status" title="Your intention of pursuing this award.">My Status: </label>
                </th>
                <td>
                    <div class="radio">
                        <div class="inline_block_display">
                            <input type="radio" name="dialog_form_survey_details_for_my_lists_my_status" id="dialog_form_survey_details_for_my_lists_my_status_1" value="1" />
                            <label for="dialog_form_survey_details_for_my_lists_my_status_1">Definite</label>
                        </div>
                        <div class="inline_block_display margin_left_40">
                            <input type="radio" name="dialog_form_survey_details_for_my_lists_my_status" id="dialog_form_survey_details_for_my_lists_my_status_2" value="2" />
                            <label for="dialog_form_survey_details_for_my_lists_my_status_2">Maybe</label>
                        </div>
                    </div>
                </td>
            </tr>
            <tr>
                <th>
                    <label for="dialog_form_survey_details_for_my_lists_owner" title="Designate the owner -the responsible person- for this award. By default the owner is you. If you assign it to someone else, it will remain under your own saved list (with a different owner) and will also appear on the new owner's saved list. Removing an award you have assigned to someone else only removes the entry from your own saved list.">Owner: </label>
                </th>
                <td>
                    <select id="dialog_form_survey_details_for_my_lists_owner" style="width: 505px;"></select>
                </td>
            </tr>
            <tr>
                <th>
                    <label for="dialog_form_survey_details_for_my_lists_share" title="Share this award with other users on LexLists. The award will also appear on their My List.">Share: </label>
                </th>
                <td>
                    <select multiple="multiple" id="dialog_form_survey_details_for_my_lists_share" style="width: 505px;"></select>
                </td>
            </tr>
            <tr>
                <th class="top_vertical_align">
                    <label for="dialog_form_survey_details_for_my_lists_note" title="Anything you want to remember about this award.">Note: </label>
                </th>
                <td>
                    <input type="hidden" id="dialog_my_survey_id">
                    <textarea id="dialog_form_survey_details_for_my_lists_note" maxlength="100" style="width: 380px; margin-bottom: 0 !important;" rows="2"></textarea>
                    <input type="button" id="add_my_award_note" class="btn btn-success" value="Add Note" style="vertical-align: bottom;" />
                </td>
            </tr>
            <tr>
                <td colspan="2" style="padding-left: 0 !important;">
                    <table id="dialog_form_survey_details_for_my_lists_notes">
                        <thead>
                            <tr>
                                <th style="width: 130px !important;">Date</th>
                                <th style="width: 424px !important;">Notes</th>
                                <th style="width: 130px !important;">User</th>
                            </tr>                            
                        </thead>
                        <tbody></tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="padding-left: 0 !important; padding-top: 10px; font-size: 10px;">
                    <b>ID:</b> <span id="dialog_survey_id"></span>
                    <b>Created:</b> <span id="dialog_created_date"></span>
                    <b>Updated:</b> <span id="dialog_updated_date"></span>
                </td>
            </tr>
        </table>
    </form>
</div>