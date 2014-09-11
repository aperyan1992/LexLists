/** 
 *  Script for work with "Survey Details" popup
 */
$(document).ready(function() {

    /**
     *  Init popups
     */
    initSurveyDetailsPopupWindow('dialog_form_survey_details');
    initSurveyDetailsForMyListsPopupWindow('dialog_form_survey_details_for_my_lists');

    /**
     *  Init datatables
     */
    var notes_table = initMyAwardNotesDataTable("dialog_form_survey_details_for_my_lists_notes", null);

    /**
     *  Click on "Details" link on "Dashboard"
     */
    $(document).on("click", ".details_link", function() {
        // Get survey info
        $.ajax({
            url: "/dashboard/getSurveyInfo",
            type: "POST",
            data: {
                survey_id: $(this).attr("s_id")
            },
            dataType: "json",
            success: function(data) {
                $("#dialog_form_survey_details").data(data).dialog("open");
            },
            error: function() {
                openErrorPopupWindow('dialog_error_alert', 'Error !!!');
            }
        });

        return false;
    });
    
    /**
     *  Click on "Details" link on "My Lists" page
     */
    $(document).on("click", ".details_link_for_my_lists", function() {
        // Get survey info
        $.ajax({
            url: "/mySurvey/getSurveyInfo",
            type: "POST",
            data: {
                survey_id: $(this).attr("s_id")
            },
            dataType: "json",
            success: function(data) {
                var s_id = data.survey_id;
                
                $.getJSON("/mySurvey/getMySurveyNotes?s_id=" + s_id, null, function (json) {
                    notes_table.fnClearTable();
                    notes_table.fnAddData(json.aaData);
                    notes_table.fnDraw();
                });
                
                $("#dialog_form_survey_details_for_my_lists").data(data).dialog("open");
            },
            error: function() {
                openErrorPopupWindow('dialog_error_alert', 'Error !!!');
            }
        });

        return false;
    });
    
    /**
     *  Click on "Add Note" button on "My Lists" page
     */
    $(document).on('click', '#add_my_award_note', function() {
        var current_element = $(this);
        
        if($('#dialog_form_survey_details_for_my_lists_note').val() == '') {
            openErrorPopupWindow('dialog_error_alert', 'To add a note, first write a note in the NOTE field.');
            return false;
        }

        $.ajax({
            url : "/mySurvey/addMySurveyNote",
            type: "POST",
            data: { 
                survey_id: current_element.attr('s_id'), 
                note_text: $('#dialog_form_survey_details_for_my_lists_note').val()
            },
            dataType: "json",
            success: function(data){
                $('#dialog_form_survey_details_for_my_lists_notes').dataTable({
                    "bDestroy":true,
                    "bJQueryUI": true,
                    "bRetrieve": true,
                    "aaSorting": [],
                    "aoColumnDefs": [
                        { "sClass": "datatable_td_align_center", "aTargets": ["_all"]}
                    ],
                    "oLanguage": {
                        "sInfo": "_END_ of _TOTAL_ entries",
                        "sInfoEmpty": "_END_ of _TOTAL_ entries"
                    }
                }).fnAddData( [
                        data.created_at,
                        data.note_text,
                        data.user_first_name, ]
                );

                $('#dialog_form_survey_details_for_my_lists_note').val('');
            },
            error: function(data) {
                openErrorPopupWindow('dialog_error_alert', 'Error !!!');
            }
        });
    });

})

/**
 * Saving of survey to "My Lists" section
 * 
 * @param {integer} survey_id
 */
function saveSurveyToMyList(survey_id) {
    $.ajax({
        url: "/mySurvey/saveSurveyToMyList",
        type: "POST",
        data: {
            survey_id: survey_id
        },
        dataType: "json",
        success: function(data) {
            if (data.status === 'exists') {
                openErrorPopupWindow('dialog_error_alert', 'This award already exists in your "My Lists" section.');                
            } else {
                openConfirmWithCustomMessagePopupWindow('dialog_save_to_my_list_alert', 'Award has been saved under the "My Lists" section.');
            }            
        },
        error: function() {
            openErrorPopupWindow('dialog_error_alert', 'Error !!!');
        }
    });
}

/**
 * Save additional info about my survey
 * 
 * @param {integer} my_survey_id        ID of my survey
 * @param {integer} my_status           Number of My status
 * @param {integer} owner               ID of Owner
 */
function saveMySurveyAdditionalInfo(my_survey_id, my_status, owner, shared_with) {
    $.ajax({
        url: "/frontend_dev.php/mySurvey/saveMySurveyAdditionalInfo",
        type: "POST",
        data: {
            my_survey_id: my_survey_id,
            my_status   : my_status,
            owner       : owner,
            shared_with : shared_with
        },
        dataType: "json",
        success: function(data) {
            
        },
        error: function() {
            openErrorPopupWindow('dialog_error_alert', 'Error !!!');
        }
    });
}

/**
 * Initialization of "Survey Details" popup window
 */
function initSurveyDetailsPopupWindow(element) {
    $("#" + element).dialog({
        autoOpen: false,
        height: 'auto',
        width: 615,
        modal: true,
        open: function() {
            // Set survey info into popup table 
            for (var item in $("#" + element).data()) {
                $("#dialog_" + item).html($(this).data(item));
            }
        },
        buttons: {
            "Print": function() {
                // Clear drop down list in print form
                $('#print_form #surveys_for_print').html('<option value="0">0</option>')

                // Set survey ID to hidden field
                $('#print_form #surveys_for_print').append('<option value="' + $(this).data("survey_id") + '" selected>' + $(this).data("survey_id") + '</option>')

                // Print surveys
                $('#print_form').submit();
            },
            "E-mail": function() {
                // Send email message
                sendEmailToMe([$(this).data("survey_id")]);
            },
            "Save": function() {
                // Save survey to my list
                saveSurveyToMyList($(this).data("survey_id"));
            },
            "Close": function() {
                $(this).dialog("close");
            }
        },
        close: function() {
            $(this).dialog("close");
        }
    });
}

/**
 * Initialization of "Survey Details" popup window on "My Lists" page
 */
function initSurveyDetailsForMyListsPopupWindow(element) {
    var my_status = $('#dialog_form_survey_details_for_my_lists input[name="dialog_form_survey_details_for_my_lists_my_status"]'),
        owner     = $('#dialog_form_survey_details_for_my_lists_owner'),
        share     = $('#dialog_form_survey_details_for_my_lists_share'),
        note      = $('#dialog_form_survey_details_for_my_lists_note');        
    
    $("#" + element).dialog({
        autoOpen: false,
        height: 'auto',
        width: 715,
        modal: true,
        open: function() {
            // Clear fields
            my_status.prop("checked", false);
            note.val("");
            
            // Set survey info into popup table 
            for (var item in $("#" + element).data()) {
                $("#dialog_" + item).html($(this).data(item));
            }
            
            // Set value of "My Status" field
            $('#dialog_form_survey_details_for_my_lists_my_status_' + $(this).data('my_status')).prop("checked", true);
            
            // Set owners list in dropdown selectbox  
            $('#dialog_form_survey_details_for_my_lists_owner').html('');
            if(Object.keys($(this).data('owners')).length > 0) {                
                for (var key in $(this).data('owners')) {       
                    var selected = '';
                    if(key === $(this).data('owner')) {
                        selected = 'selected';
                    }
                    $('#dialog_form_survey_details_for_my_lists_owner').append( 
                        $('<option value="' + key + '" ' + selected + '>' + $(this).data('owners')[key] + '</option>')
                    );
                }
            }

            // Set share with in dropdown selectbox
            $('#dialog_form_survey_details_for_my_lists_share').html('');
            if(Object.keys($(this).data('share_with_list_user')).length > 0) {
                for (var key in $(this).data('share_with_list_user')) {

                    if (key === $(this).data('owner')) {
                        continue;
                    }

                    var selected = '';

                    if(Object.keys($(this).data('owners')).length > 0) {
                        for (var key_share in $(this).data('share_with')) {

                            if(key_share === key) {
                                selected = 'selected';
                            }
                        }
                    }

                    $('#dialog_form_survey_details_for_my_lists_share').append(
                        $('<option value="' + key + '" ' + selected + '>' + $(this).data('share_with_list_user')[key] + '</option>')
                    );
                }
            }
            
            // Add attribute with "Survey ID" in "Add Note" button
            $("#add_my_award_note").attr("s_id", $(this).data('survey_id'));
            
            // Reinit select2
            $("#dialog_form_survey_details_for_my_lists_owner").select2({ dropdownCssClass: 'ui-dialog', width: "resolve" });
            $("#dialog_form_survey_details_for_my_lists_share").select2({ dropdownCssClass: 'ui-dialog', width: "resolve" });
        },
        buttons: {
            "Print": function() {
                // Clear drop down list in print form
                $('#print_form #surveys_for_print').html('<option value="0">0</option>')

                // Set survey ID to hidden field
                $('#print_form #surveys_for_print').append('<option value="' + $(this).data("survey_id") + '" selected>' + $(this).data("survey_id") + '</option>')

                // Print surveys
                $('#print_form').submit();
            },
            "E-mail": function() {
                // Send email message
                sendEmailToMe([$(this).data("survey_id")]);
            },
            "Cancel": function() {
                $(this).dialog("close");
            },
            "Close": function() {
                // Save additonal info about my survey
                saveMySurveyAdditionalInfo($(this).data("my_survey_id"), $('input[name="dialog_form_survey_details_for_my_lists_my_status"]:checked').val(), owner.val(), share.val())
                
                $(this).dialog("close");
            }
        },
        close: function() {
            $(this).dialog("close");
        }
    });
}

/**
 * Init data table for notes of my award
 * 
 * @param {string}  table_id    ID of data table
 * @param {integer} ms_id       Id of my survey
 */
function initMyAwardNotesDataTable(table_id, ms_id) {
    return $('#' + table_id).dataTable({
        "sDom": 't<"F"ip>',
        "bDestroy":true,
        "bJQueryUI": true,
        "bRetrieve": true,
        "aaSorting": [],
        "aoColumnDefs": [
            { "sClass": "datatable_td_align_center", "aTargets": ["_all"]}
        ],
        "bDeferRender": true,
        "iDisplayLength": 10,
        "oLanguage": {
            "sInfo": "_END_ of _TOTAL_ entries",
            "sInfoEmpty": "_END_ of _TOTAL_ entries",
            "sEmptyTable": "No Notes have been added"
        }
    });
}