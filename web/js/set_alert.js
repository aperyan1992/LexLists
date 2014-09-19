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
        $('.list_alerts').empty();
        $("#dialog_form_survey__set_alert").dialog("open");
        $(document).on('click','.removealert',function(){
            var alert_id =  $(this).attr('s_id');
            remove_survey_alert(alert_id, survey_id);
        });
        // Get email list
        $.ajax({
            url: "/frontend_dev.php/mySurvey/GetAllEmails",
            type: "POST",
            dataType: "json",
            success: function(data) {
                var arrEmails = new Array();
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
        get_survey_alerts(survey_id);
        
        // Close menu if exists
        if ($(this).hasClass("set_an_alert_class")) {
            $(this).parents('ul.menu-dropdown').slideToggle();
        }
        $('#set_alert_form').on('submit', function(){
            event.preventDefault();
            var cc_emails = new Array();
            $('.select2-search-choice div').each(function(){
                cc_emails.push($(this).text());
            });
            //cc_emails = cc_emails.serialize();
            var data_for_ajax = $( this ).serializeArray();
            data_for_ajax = $.merge(data_for_ajax,[{'cc_emails':cc_emails},{'name':'survey_id', 'value':survey_id}]);
            save_alert_details(data_for_ajax, survey_id)

        });

        return false;
    });
    $(document).on('click','.changealert',function(){
        //$(".change_values").fadeIn();
        $('.change_values').css('display','block');
        $('#to_me_dialog_form_survey_email').attr("disabled", 'disabled');
        initSurveySetAlertPopupWindow("change_values");

    });


    $('.close_button'). on("click", function(){

        $('.change_values').css('display','none');
    });



});

function remove_survey_alert(alert_id, survey_id)
{
    $.ajax({
        url: "/frontend_dev.php/mySurvey/RemoveSurveyAlert",
        type: "POST",
        data:{
            alert_id:alert_id
        },
        dataType: "json",
        beforeSend: function() {
            // Show blocker
            $("#display_blocker").show();
        },
        success: function(data) {
            get_survey_alerts(survey_id);
        },
        error: function() {
            openErrorPopupWindow("dialog_error_alert", "Error !!!");
        }
    });
}
function get_survey_alerts(survey_id)
{
    $('.list_alerts').empty();
    $.ajax({
        url: "/frontend_dev.php/mySurvey/GetAllAlerts",
        type: "POST",
        data:{
            survey_id:survey_id
        },
        dataType: "json",
        beforeSend: function() {
            // Show blocker
            $("#display_blocker").show();
        },
        success: function(data) {
            if(data!='error')
            {
                $(data).each(function(){
                    $('.list_alerts').append('<div style="border: 2px solid #D9D2B9;padding-bottom: 5px; border-top:none;"><div class="alert_value1">'+this['cc_email']+'</div><div class="alert_value1">'+this['time-frame']+' '+this['time-frame-type']+'</div><div class="alert_value1"><div class="changealert" s_id='+this['id']+'>Change</div><div class="removealert" s_id='+this['id']+'>Remove</div></div></div>');
                });
                $('.pagecount').text(data.length);
                $('.pagecountof').text(data.length);
            }
            else
            {
                $('.list_alerts').append('<div>No Alert Set</div>');
            }
            $("#display_blocker").hide();

        },
        error: function() {
            openErrorPopupWindow("dialog_error_alert", "Error !!!");
        }
    });
}
function save_alert_details(data_for_send, survey_id)
{
    $.ajax({
        url: "/frontend_dev.php/mySurvey/SaveAlertDetails",
        type: "POST",
        data: {
            details: data_for_send
        },
        dataType: "json",
        beforeSend: function() {
            // Show blocker
            $("#display_blocker").show();
        },
        success: function(data) {
            // Hide blocker
            get_survey_alerts(survey_id);
            $("#display_blocker").hide();
            return true;
        },
        error: function() {
            openErrorPopupWindow("dialog_error_alert", "Alert saving failed. Try again.");

            // Hide blocker
            $("#display_blocker").hide();
            return false;
        }
    });
}
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