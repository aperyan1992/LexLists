/* 
 * Script for email sending
 */
$(document).ready(function() {
    /**
     *  Init popups
     */
    initSurveySetAlertPopupWindow("dialog_form_survey__set_alert");

    /**
     * Send email message
     */
    $(document).on("click", ".set_an_alert_class", function() {
        var survey_id = $(this).attr("s_id");

        $("#dialog_form_survey__set_alert").dialog("open");

        // Get email list
        $.ajax({
            url: "/frontend_dev.php/mySurvey/GetAllEmails",
            type: "POST",
            dataType: "json",
            success: function(data) {
                var arrEmails = new Array();
               // console.log(data);
                for(var i = 0;i< data.length;i++)
                {
                    arrEmails.push({id:i,text:data[i]})

                }

                $('#to_dialog_form_survey_set_alert2').select2({
                    createSearchChoice:function(term, data) { if ($(data).filter(function() { return this.text.localeCompare(term)===0; }).length===0) {return {id:term, text:term};} },
                    multiple: true,
                    data: arrEmails
                });            },
            error: function() {
                openErrorPopupWindow("dialog_error_alert", "Error !!!");
            }
        });
        
        // Close menu if exists
        if ($(this).hasClass("set_an_alert_class")) {
            $(this).parents('ul.menu-dropdown').slideToggle();
        }
        return false;
    });
    $('.change').on("click", function(){
        //$(".change_values").fadeIn();
        $('.change_values').css('display','block');
        $('#to_me_dialog_form_survey_email').attr("disabled", 'disabled');
        initSurveySetAlertPopupWindow("change_values");

    });

    $('.close_button'). on("click", function(){

        $('.change_values').css('display','none');
    });


});

function initSurveySetAlertPopupWindow(element) {

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
        /*buttons: {
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
            $(this).dialog("close");
        }
    });
}