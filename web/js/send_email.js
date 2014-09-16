/* 
 * Script for email sending
 */
$(document).ready(function() {

    /**
     *  Init popups
     */
    initSurveyEmailPopupWindow("dialog_form_survey_email");

    /**
     * Send email message
     */
    $(document).on("click", ".email_link, .my_list_email_send", function() {
        var survey_id = $(this).attr("s_id");

        // Get survey info
        $.ajax({
            url: "/dashboard/getSurveyInfo",
            type: "POST",
            data: {
                survey_id: $(this).attr("s_id")
            },
            dataType: "json",
            success: function(data) {
                $("#dialog_form_survey_email").data(data).dialog("open");
            },
            error: function() {
                openErrorPopupWindow("dialog_error_alert", "Error !!!");
            }
        });
        
        // Close menu if exists
        if ($(this).hasClass("my_list_email_send")) {
            $(this).parents('ul.menu-dropdown').slideToggle();
        }

        return false;
    });

    /**
     * Enable/Disable "To" text field
     */
    $(document).on("change", "#to_me_dialog_form_survey_email", function() {
        var checked_status = $(this).is(":checked");

        $("#to_dialog_form_survey_email").prop("disabled", checked_status).focus();
    });
    /********************************/

});

/**
 * Sending of email message to current user
 *
 * @param {array} survey_ids   Array with survey IDs
 */
function sendEmailToMe(survey_ids) {
    $.ajax({
        url: "/dashboard/sendEmail",
        type: "POST",
        data: {
            survey_ids: survey_ids
        },
        dataType: "json",
        beforeSend: function() {
            // Show blocker
            $("#display_blocker").show();
        },
        success: function(data) {
            // Hide blocker
            $("#display_blocker").hide();
        },
        error: function() {
            openErrorPopupWindow("dialog_error_alert", "Message sending failed. Try again.");

            // Hide blocker
            $("#display_blocker").hide();
        }
    });
}

/**
 * Sending of email message to another user
 *
 * @param {array}   survey_ids        Array with survey IDs
 * @param {string}  email_address     Email address
 * @param {string}  message           Message
 */
function sendEmailToAnotherUser(survey_ids, email_address, message) {
    $.ajax({
        url: "/dashboard/sendEmail",
        type: "POST",
        data: {
            survey_ids    : survey_ids,
            email_address : email_address,
            message       : message
        },
        dataType: "json",
        beforeSend: function() {
            // Show blocker
            $("#display_blocker").show();
        },
        success: function(data) {
            // Hide blocker
            $("#display_blocker").hide();
        },
        error: function() {
            openErrorPopupWindow("dialog_error_alert", "Message sending failed. Try again.");

            // Hide blocker
            $("#display_blocker").hide();
        }
    });
}

/**
 * Initialization of "Survey Email" popup window
 */
function initSurveyEmailPopupWindow(element) {

    var to_email_address = $("#to_dialog_form_survey_email"),
        to_me_flag       = $("#to_me_dialog_form_survey_email"),
        message          = $("#message_dialog_form_survey_email"),
        text_fields      = $([]).add(to_email_address).add(message);

    $("#" + element).dialog({
        autoOpen: false,
        height: 'auto',
        width: 615,
        modal: true,
        open: function() {
            // Set survey info into popup table
            for (var item in $("#" + element).data()) {
                $("#dialog_email_" + item).html($(this).data(item));
            }
        },
   /*     buttons: {
            "Cancel": function() {
                text_fields.val("");
                to_me_flag.prop("checked", true);
                $(this).dialog("close");
            },
            "Send": function() {
                var bValid = true;

                // Validation of email address if "me" checkbox is unchecked
                if(!to_me_flag.is(":checked")) {
                    bValid = bValid && checkLength(to_email_address);
                    bValid = bValid && checkRegexp(to_email_address, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
                }

                if (bValid) {
                    // Send email message
                    sendEmailToAnotherUser([$(this).data("survey_id")], to_email_address.val(), message.val());

                    text_fields.val("");
                    to_me_flag.prop("checked", true);
                    $(this).dialog("close");
                } else {
                    openErrorPopupWindow("dialog_error_alert", "Email address is empty or invalid.");
                }
            }
        },*/
        close: function() {
            text_fields.val("");
            to_me_flag.prop("checked", true);
            $(this).dialog("close");
        }
    });
}

/**
 * Check length of field
 */
function checkLength(o) {
    if (o.val().length == 0) {
        return false;
    }

    return true;
}

/**
 * Validation of field
 */
function checkRegexp(o, regexp) {
    if (!(regexp.test(o.val()))) {
        return false;
    }

    return true;
}