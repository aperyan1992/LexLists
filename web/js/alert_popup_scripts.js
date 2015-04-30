/**
 * Fix of "Object" supporting in IE 7/8
 */
// From https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Object/keys
if (!Object.keys) {
  Object.keys = (function () {
    'use strict';
    var hasOwnProperty = Object.prototype.hasOwnProperty,
        hasDontEnumBug = !({toString: null}).propertyIsEnumerable('toString'),
        dontEnums = [
          'toString',
          'toLocaleString',
          'valueOf',
          'hasOwnProperty',
          'isPrototypeOf',
          'propertyIsEnumerable',
          'constructor'
        ],
        dontEnumsLength = dontEnums.length;

    return function (obj) {
      if (typeof obj !== 'object' && (typeof obj !== 'function' || obj === null)) {
        throw new TypeError('Object.keys called on non-object');
      }

      var result = [], prop, i;

      for (prop in obj) {
        if (hasOwnProperty.call(obj, prop)) {
          result.push(prop);
        }
      }

      if (hasDontEnumBug) {
        for (i = 0; i < dontEnumsLength; i++) {
          if (hasOwnProperty.call(obj, dontEnums[i])) {
            result.push(dontEnums[i]);
          }
        }
      }
      return result;
    };
  }());
}

if (!Array.prototype.indexOf) {
    Array.prototype.indexOf = function (searchElement, fromIndex) {
      if ( this === undefined || this === null ) {
        throw new TypeError( '"this" is null or not defined' );
      }

      var length = this.length >>> 0; // Hack to convert object.length to a UInt32

      fromIndex = +fromIndex || 0;

      if (Math.abs(fromIndex) === Infinity) {
        fromIndex = 0;
      }

      if (fromIndex < 0) {
        fromIndex += length;
        if (fromIndex < 0) {
          fromIndex = 0;
        }
      }

      for (;fromIndex < length; fromIndex++) {
        if (this[fromIndex] === searchElement) {
          return fromIndex;
        }
      }

      return -1;
    };
  }
  
/****************************************************************************/

/* 
 *  Work with error popups
 */
var confirm_choise = false;

$(document).ready(function() {
    
    /**
     *  Init tooltips
     */
    $(document).tooltip({ position: { my: "left+20 top", at: "left bottom" } });
    
    /**
     * Check if user is not authorized
     */
    $(document).bind(
      'ajaxSuccess', 
      function(event, request, settings) {
      if (request.getResponseHeader('NOT_AUTHORIZED') === '499') {
          window.location.reload();
      };
    });
    
    $(document).bind(
      'ajaxError', 
      function(event, request, settings) {
      if (request.getResponseHeader('NOT_AUTHORIZED') === '499') {
          window.location.reload();
      };
    });
    
    // Init popup windows
    initErrorPopupWindow('dialog_error_alert');
    initErrorPopupWindow('dialog_save_to_my_list_alert');
    initAdminConfirmPopupWindow('dialog_cofirm_alert');
    initDeleteReminderLogConfirmPopupWindow('dialog_delete_reminder_log_cofirm_alert');
    initDeleteSurveyConfirmPopupWindow('dialog_delete_survey_cofirm_alert');
    initAdminDeleteMatterForeverConfirmPopupWindow('dialog_admin_delete_matter_cofirm_alert');
    initAdminDeleteMatterConfirmPopupWindow('dialog_cofirm_with_message_alert');
    initAdminDeletePracticeGroupAssociationConfirmPopupWindow('dialog_admin_delete_practice_group_association_cofirm_alert');
    initLockedWarningPopup('dialog_locked_warning');
    initCloneSurveyConfirmPopupWindow('dialog_clone_survey_cofirm_alert');
    initRemoveMySurveyConfirmPopupWindow('dialog_remove_my_survey_cofirm_alert');
    
});

/**
 * Initialization of "Error" popup window
 */
function initErrorPopupWindow(element) {
    $("#" + element).dialog({
        autoOpen: false,
        height: 200,
        width: 500,
        modal: true,
        buttons: {
            "OK": function() {
                $(this).dialog("close");
            }
        }
    });
}

/**
 * Initialization of "Confirm" popup window in generated admin modules
 */
function initAdminConfirmPopupWindow(element) {
    $("#" + element).dialog({
        autoOpen: false,
        height: 200,
        width: 500,
        modal: true,
        buttons: {
            "Cancel": function() {
                $(this).dialog("close");
            },
            "OK": function() {
                $('#admin_form_batch_actions').submit();

                $(this).dialog("close");
            }            
        }
    });
}

/**
 * Initialization of "Delete Reminder Log Confirm" popup window
 */
function initDeleteReminderLogConfirmPopupWindow(element) {
    $("#" + element).dialog({
        autoOpen: false,
        height: 200,
        width: 500,
        modal: true,
        buttons: {
            "Cancel": function() {
                $(this).dialog("close");
            },
            "OK": function() {
                var survey_id            = $("#survey_id").val();
                var reminders_log_table  = init4ColumnDataTableWithRemoving('#reminders_logs');
                var activity_survey_logs = init3ColumnDataTableForActivityLogs("#survey_logs", survey_id);
                
                var reminder_id = $('#reminder_log_info').attr("r_id");
                var tr_number   = $('#reminder_log_info').attr('tr_number');

                $.ajax({
                    url : "/survey/deleteReminder",
                    type: "POST",
                    data: { 
                        reminder_id: reminder_id
                    },
                    dataType: "json",
                    success: function(){
                        reminders_log_table.fnDeleteRow(tr_number);
                        activity_survey_logs.fnDestroy();
                        init3ColumnDataTableForActivityLogs("#survey_logs", survey_id);
                    },
                    error: function(data) {
                        openErrorPopupWindow('dialog_error_alert', 'Error !!!');
                    }
                });

                $(this).dialog("close");
            }            
        }
    });
}

/**
 * Initialization of "Delete Survey Confirm" popup window
 */
function initDeleteSurveyConfirmPopupWindow(element) {
    $("#" + element).dialog({
        autoOpen: false,
        height: 200,
        width: 500,
        modal: true,
        buttons: {
            "Cancel": function() {
                $(this).dialog("close");
            },
            "OK": function() {
                document.location.href = $("#delete_survey_page").val();

                $(this).dialog("close");
            }            
        }
    });
}

/**
 * Initialization of "Clone Survey Confirm" popup window
 */
function initCloneSurveyConfirmPopupWindow(element) {
    $("#" + element).dialog({
        autoOpen: false,
        height: 200,
        width: 500,
        modal: true,
        buttons: {
            "Cancel": function() {
                $(this).dialog("close");
            },
            "OK": function() {
                document.location.href = $("#clone_survey_page").val();

                $(this).dialog("close");
            }            
        }
    });
}

/**
 * Initialization of "Admin Delete Matter Confirm" popup window
 */
function initAdminDeleteMatterForeverConfirmPopupWindow(element) {
    $("#" + element).dialog({
        autoOpen: false,
        height: 200,
        width: 500,
        modal: true,
        buttons: {
            "Cancel": function() {
                $(this).dialog("close");
            },
            "OK": function() {
                var matters_table = initMattersManagementTable("#matters_management_table");
                var matter_id     = $('#admin_delete_matter_forever_info').attr("m_id");
                var tr_number     = $('#admin_delete_matter_forever_info').attr('tr_number');

                $.ajax({
                    url : "/matterManagement/removeMatterForever",
                    type: "POST",
                    data: {
                        matter_id : matter_id
                    },
                    async: false,
                    dataType: "json",
                    success: function(data){
                        if(data.status == 'associated_matter') {
                            openErrorPopupWindow('dialog_error_alert', "You can’t delete this matter forever as there are a survey(s) associated with it. Please disassociate the matter from the survey(s) and try again.");
                            return false;
                        } else if(data.status == 'associated_matter_version') {
                            openErrorPopupWindow('dialog_error_alert', "You can’t delete this matter forever as there are a matter version(s) associated with surveys. Please disassociate the matter(s) from the survey(s) and try again.");
                            return false;
                        } else {
                            matters_table.fnDeleteRow(tr_number);
                        }
                    },
                    error: function(data) {
                        openErrorPopupWindow('dialog_error_alert', 'Error !!!');
                    }
                });

                $(this).dialog("close");
            }            
        }
    });
}

/**
 * Initialization of "Admin Delete Matter Confirm" popup window
 */
function initAdminDeleteMatterConfirmPopupWindow(element) {
    $("#" + element).dialog({
        autoOpen: false,
        height: 250,
        width: 500,
        modal: true,
        buttons: {
            "Cancel": function() {
                $(this).dialog("close");
            },
            "OK": function() {
                var matters_table = initMattersManagementTable("#matters_management_table");
                var matter_id     = $('#admin_delete_matter_info').attr("m_id");
                var tr_number     = $('#admin_delete_matter_info').attr('tr_number');
                var matter_action = $('#admin_delete_matter_info').attr('matter_action');

                $.ajax({
                    url : "/matterManagement/removeOrRestoreMatter",
                    type: "POST",
                    data: {
                        matter_id       : matter_id,
                        matter_action   : matter_action
                    },
                    async: false,
                    dataType: "json",
                    success: function(data){
                        if(data.status == "success_reload") {
                            matters_table.fnDestroy();
                            matters_table = initMattersManagementTable("#matters_management_table");
                        } else {
                            matters_table.fnUpdate( data.action_links, tr_number, 5 );
                        }                    
                    },
                    error: function(data) {
                        openErrorPopupWindow('dialog_error_alert', 'Error !!!');
                    }
                });

                $(this).dialog("close");
            }            
        }
    });
}

/**
 * Initialization of "Admin Delete Matter Confirm" popup window
 */
function initAdminDeletePracticeGroupAssociationConfirmPopupWindow(element) {
    $("#" + element).dialog({
        autoOpen: false,
        height: 200,
        width: 500,
        modal: true,
        buttons: {
            "Cancel": function() {
                $(this).dialog("close");
            },
            "OK": function() {
                var practice_group_id = $("#admin_delete_practice_group_association_info").attr('pg_id');
                
                $.ajax({
                    url : "/practiceGroupManagement/deleteAssociatedPracticeGroup",
                    type: "POST",
                    data: { 
                        practice_group_id: practice_group_id
                    },
                    dataType: "json",
                    success: function(data){
                        if(data.status == "pg_used") {
                            openErrorPopupWindow('dialog_error_alert', 'This practice group is used in surveys.');
                        } else {
                            var page_url = $("#page_url").val();

                            document.location.href = page_url;
                        }                    
                    },
                    error: function() {
                        openErrorPopupWindow('dialog_error_alert', 'Error !!!');
                    }
                });

                $(this).dialog("close");
            }            
        }
    });
}

/**
 * Initialization of "Remove My Survey Confirm" popup window
 */
function initRemoveMySurveyConfirmPopupWindow(element) {
    $("#" + element).dialog({
        autoOpen: false,
        height: 250,
        width: 500,
        modal: true,
        buttons: {
            "No, cancel": function() {
                $(this).dialog("close");
            },
            "Yes, remove from My List": function() {
                var my_surveys_table = $("#report_surveys").dataTable();
                var my_survey_id     = $('#admin_remove_my_survey_info').attr("ms_id");
                var tr_number        = $('#admin_remove_my_survey_info').attr('tr_number');
                var is_updated_flag  = parseInt($('#admin_remove_my_survey_info').attr('is_updated'));
                var is_past_due_flag = parseInt($('#admin_remove_my_survey_info').attr('is_past_due'));                
                
                // Set flag to false in database
                if (is_updated_flag === 1) {
                    setFlagOfMySurvey(my_survey_id, 'updated', 0);
                }
                if (is_past_due_flag === 1) {
                    setFlagOfMySurvey(my_survey_id, 'past_dues', 0);
                }
                
                $.ajax({
                    url : "/mySurvey/removeFromMyList",
                    type: "POST",
                    data: {
                        my_survey_id: my_survey_id
                    },
                    async: false,
                    dataType: "json",
                    success: function(data){
                        if(data.status == "success") {
                            my_surveys_table.fnDeleteRow(tr_number);
                        }  
                    },
                    error: function(data) {
                        openErrorPopupWindow('dialog_error_alert', 'Error !!!');
                    }
                });

                $(this).dialog("close");
            }            
        }
    });
}

/**
 * Initialization of "Locked warning message" popup window
 */
function initLockedWarningPopup(element) {
    $("#" + element).dialog({
        autoOpen: false,
        height: 300,
        width: 600,
        modal: true,
        buttons: {
            "Cancel, let me copy some items": function() {
                $(this).dialog("close");
            },
            "OK, forget my updates and reload the survey": function() {
                location.reload();
            }
        }
    });
}

/**
 * Open "Error" popup window
 * 
 * @param {string} element          ID of popup block
 * @param {string} error_message    Error message
 */
function openErrorPopupWindow(element, error_message) {
    $('#error_popup_text').text(error_message);
    $("#" + element).dialog("open");    
    return false;
}

/**
 * Open "Confirm" popup window
 * 
 * @param {string} element          ID of popup block
 */
function openConfirmPopupWindow(element) {
    $("#" + element).dialog("open");    
    return false;
}

/**
 * Open "Confirm" popup window with custom message
 * 
 * @param {string} element          ID of popup block
 */
function openConfirmWithCustomMessagePopupWindow(element, message) {
    $('#confirm_with_message').text(message);
    $("#" + element).dialog("open");    
    return false;
}

/**
 * Submit of general form
 */
function generalFormSubmit(button_name) {
    $(".candidate_form_buttons_div").find("#save_and_close_flag").remove();
    
    var general_form_id = $(document).find("div.ui-accordion-content-active").attr("general_form_id");
    if(general_form_id == undefined) {
        general_form_id = "add_survey_form";
        $("." + general_form_id).submit();
    } else {
        if(button_name == "_save_and_close") {
            $(".candidate_form_buttons_div").append('<input type="hidden" name="_save_and_close" value="1" id="save_and_close_flag" />');
        }
        
        $("#" + general_form_id).submit();
    }    
}
