/** 
 *  Script for work with "Survey Details" popup
 */
$(document).ready(function() {

    $('#dialog_form_survey_details_for_my_lists_my_status_1').change(function(){

        if($(this).attr('checked', 'checked')) 
        {
            var data = {
                title:"Definite", 
                survey_name:$('#dialog_survey_name_hidden').text(), 
                organization:$('#dialog_organization a').text(), 
                survey_id:$('#dialog_survey_id').text()
            } ; 

            $.ajax({
                url: "/mySurvey/setCheckedRadioLog",
                type: "POST",
                data: data,
                dataType: "json",
                success: function(data) {
                   
                }            
            });
        } 
    });

    $("#dialog_form_survey_details_for_my_lists_owner").on('change', function(){
        //console.log("___________"+$(this).val());
        $.ajax({
            url: "/mySurvey/SaveOwner",
            type: "POST",
            data:  {prev_owner_id:$(this).attr('owner_id'),
                    owner_id:$(this).val(),
                    survey_id:$(this).attr('s_id')},
            dataType: "json",
            success: function(data) {
               if(data.status == 'updated')
               {
                alert('Owner has been updated');
               }
            }            
        });
    });

    $("#dialog_form_survey_details_for_my_lists_share").on('change', function(){
        //alert($("#s2id_dialog_form_survey_details_for_my_lists_share ul li div").text());
        $.ajax({
            url: "/mySurvey/SaveShare",
            type: "POST",
            data:  {share_id:$("#s2id_dialog_form_survey_details_for_my_lists_share ul li div").text(),
                    survey_id:$('#dialog_survey_id').text(),
                    my_survey_id:$('#dialog_my_survey_id').text(),
                    user_id:$('#dialog_form_survey_details_for_my_lists_share').val()},
            dataType: "json",
            success: function(data) {
               if(data.status == 'shared')
               {
                alert('The Award has been shared');
               }
            }            
        });
    });

    $('#dialog_form_survey_details_for_my_lists_my_status_2').change(function(){

        if($(this).attr('checked', 'checked')) 
        {
            var data = {
                title:"Maybe",
                survey_name:$('#dialog_survey_name_hidden').text(), 
                organization:$('#dialog_organization a').text(), 
                survey_id:$('#dialog_survey_id').text()
            } ; 

            $.ajax({
                url: "/mySurvey/setCheckedRadioLog",
                type: "POST",
                data: data,
                dataType: "json",
                success: function(data) {
                   
                }            
            });
        } 
    });

    // $('#add_my_award_note').click(function(){

    //     if($('#s2id_dialog_form_survey_details_for_my_lists_share ul li div').length > 0) 
    //     {
    //         var notes_array = $('#dialog_form_survey_details_for_my_lists_notes tbody tr:last-child').text();

    //         var data = {
    //             title:"Share",
    //             survey_name:$('#dialog_survey_name_hidden').text(), 
    //             organization:$('#dialog_organization a').text(), 
    //             survey_id:$('#dialog_survey_id').text(),
    //             shared_with_user:$('#s2id_dialog_form_survey_details_for_my_lists_share ul li div').text(),
    //             shared_notes: notes_array
    //         } ; 

    //         $.ajax({
    //             url: "/mySurvey/setCheckedRadioLog",
    //             type: "POST",
    //             data: data,
    //             dataType: "json",
    //             success: function(data) {
                   
    //             }            
    //         });
    //     } 
    // });

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

                if($('#s2id_dialog_form_survey_details_for_my_lists_share ul li div').length > 0) 
                {
                    var notes_array = $('#dialog_form_survey_details_for_my_lists_notes tbody tr:last-child').text();

                    var data = {
                        title:"Share",
                        survey_name:$('#dialog_survey_name_hidden').text(), 
                        organization:$('#dialog_organization a').text(), 
                        survey_id:$('#dialog_survey_id').text(),
                        shared_with_user:$('#s2id_dialog_form_survey_details_for_my_lists_share ul li div').text(),
                        shared_notes: notes_array
                    } ; 

                    $.ajax({
                        url: "/mySurvey/setCheckedRadioLog",
                        type: "POST",
                        data: data,
                        dataType: "json",
                        success: function(data) {
                           
                        }            
                    });
                } 
        
            },
            error: function(data) {
                openErrorPopupWindow('dialog_error_alert', 'Error !!!');
            }
        });
    });

})


function closeForLogDashboard(survey_id, survey_name, organization)
{
    $.ajax({
        url: "/dashboard/closeForLog",
        type: "POST",
        data: {
            my_survey_id: survey_id,
            my_survey_name: survey_name,
            organization: organization
        },
        dataType: "json",
        success: function(data) {
            
        }
    });
}

function closeForLog(survey_id, survey_name, organization)
{
    $.ajax({
        url: "/mySurvey/closeForLog",
        type: "POST",
        data: {
            my_survey_id: survey_id,
            my_survey_name: survey_name,
            organization: organization
        },
        dataType: "json",
        success: function(data) {
            
        }
    });
}
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
            survey_id: survey_id,
            organization: $('#dialog_organization a').text()
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
            openErrorPopupWindow('dialog_error_alert', 'Error !!!!');
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
            "E-mail Me": function() {
                // Send email message
                sendEmailToMeDashboard([$(this).data("survey_id")]);
            },
            "Save": function() {
                // Save survey to my list
                saveSurveyToMyList($(this).data("survey_id"));
            },
            "Close": function() {
                closeForLogDashboard($('#dialog_survey_id').text(), $('#dialog_survey_name_hidden').text(), $('#dialog_organization').text());

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
            var owner_id = $(this).data('owner');  
            // Set owners list in dropdown selectbox  
            $('#dialog_form_survey_details_for_my_lists_owner').html('');
            if(Object.keys($(this).data('owners')).length > 0) {  
             var newobjarray = [];  

            for (var key in $(this).data('owners')) {   
                  var temparr = [];
                  temparr['string'] = $(this).data('owners')[key];
                  temparr['key'] = key;
                  newobjarray.push(temparr);
                  }
            var sortedarray2 = newobjarray.sort(function(a, b){
                        if(a['string'].toLowerCase() < b['string'].toLowerCase()) return -1;
                        if(a['string'].toLowerCase() > b['string'].toLowerCase()) return 1;
                        return 0;
                    }); 
                    var slectedcheck = false; 

                    $('#dialog_form_survey_details_for_my_lists_owner').append(
                        $('<option value="0">Nobody</option>') 
                    );

            sortedarray2.forEach(function(value){
                 var selected = '';                
                    if(value['key'] == owner_id) {
                        
                        selected = 'selected';
                        slectedcheck = true;
                    }                       
                    $('#dialog_form_survey_details_for_my_lists_owner').append( 
                        $('<option value="' + value['key'] + '" ' + selected + '>' + value['string'] + '</option>')
                    );
            });
            if(!slectedcheck){
                    // $('#dialog_form_survey_details_for_my_lists_owner').prepend( 
                    //     $('<option></option>')
                    // );
            }
        }   
           
            var shared_id = $(this).data('share_with');
            // Set share with in dropdown selectbox
            $('#dialog_form_survey_details_for_my_lists_share').html('');
            if(Object.keys($(this).data('share_with_list_user')).length > 0) {
                 var newobjarray = [];  

            for (var key in $(this).data('share_with_list_user')) {   
                  var temparr = [];
                  temparr['string'] = $(this).data('share_with_list_user')[key];
                  temparr['key'] = key;
                  newobjarray.push(temparr);
                  }
            var sortedarray = newobjarray.sort(function(a, b){
                        if(a['string'].toLowerCase() < b['string'].toLowerCase()) return -1;
                        if(a['string'].toLowerCase() > b['string'].toLowerCase()) return 1;
                        return 0;
                    });  
                    //console.log($(this).data('shared_with_user_id'));       
            sortedarray.forEach(function(value){
                /*  if (value['key'] === $(this).data('owner')) {
                        continue;
                    }
*/
                    var selected = '';

                        for (var key_share in shared_id) {

                            if(key_share === value['key']) {
                                selected = 'selected';
                            }
                        }

                    $('#dialog_form_survey_details_for_my_lists_share').append(
                        $('<option value="' + value['key'] + '" user_id ="'+ value['key'] +'" ' + selected + '>' + value['string'] + '</option>')
                    );
            });                
        }
            
            // Add attribute with "Survey ID" in "Add Note" button
            $("#add_my_award_note").attr("s_id", $(this).data('survey_id'));
            $("#dialog_form_survey_details_for_my_lists_owner").attr("s_id", $(this).data('survey_id'));
            $("#dialog_form_survey_details_for_my_lists_owner").attr("owner_id", $(this).data('owner'));
            
            // Reinit select2
            /*$("#dialog_form_survey_details_for_my_lists_owner").select2(
                {
                 dropdownCssClass: 'ui-dialog',
                  width: "resolve",
                  placeholder: 'Select an Owner',               
                 
                   });*/

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
            "E-mail Me": function() {
                // Send email message
             
                sendEmailToMeMyList([$(this).data("survey_id")]);
            },
            "Cancel": function() {

                var data = {title:$(this).data("survey_id")};

                $.ajax({
                    url: "/mySurvey/cancelMyListLog",
                    type: "POST",
                    data: data,
                    dataType: "json",
                    success: function(data) {
                       
                    }            
                });

                $(this).dialog("close");
            },
            "Close": function() {
                closeForLog($('#dialog_survey_id').text(), $('#dialog_survey_name_hidden').text(), $('#dialog_organization').text());
                //console.log(owner.attr("owner_id"));
                // Save additonal info about my survey
                //saveMySurveyAdditionalInfo($(this).data("my_survey_id"), $('input[name="dialog_form_survey_details_for_my_lists_my_status"]:checked').val(), owner.val(), share.val())
                
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