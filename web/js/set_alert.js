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
        window.survey_id = $(this).attr("s_id");
        get_survey_alerts(window.survey_id);
        $('#set_alert_form')[0].reset();
        $('.list_alerts').empty();
        $("#dialog_form_survey__set_alert").dialog("open");
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
                    allowClear:true,
                    data: arrEmails
                });
            },
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
    $('.ok_btn').on('click', function(){
        var data_for_send = $('#change_alert').serializeArray();
        send_changed_alert(data_for_send, window.survey_id);

    })
    $('#addemailcc').on('click', function(){
        var neweamil = $('.select2-match').text();
        $('.select2-match').remove();
        $('.select2-input').val('');
        $('.select2-drop').hide();
        $('.select2-input').attr('style','width:50px');
        if(neweamil!='')
        {
           // $('ul li:last-child').prev('<p>inch vor uzum es</p>')
            if(!$('.select2-search-choice').length)
            {
                $('.select2-choices').prepend('<li class="select2-search-choice">    <div>'+neweamil+'</div>    <a href="#" class="removeccemail select2-search-choice-close" tabindex="-1"></a></li>');
            }
            else
            $('.select2-container ul li:nth-last-child(2)').after('<li class="select2-search-choice">    <div>'+neweamil+'</div>    <a href="#" class="removeccemail select2-search-choice-close" tabindex="-1"></a></li>')

        }
    });
    $(document).on('click','.removeccemail',function(){
        $(this).parent().fadeOut(300, function(){
            this.remove();
        });
    })
    $(document).on('click','.removealert',function(){
        var alert_id =  $(this).attr('s_id');
        initDeleteAlertPopupWindow('dialog_delete_alert_cofirm_alert',alert_id);
        $("#dialog_delete_alert_cofirm_alert").dialog("open");
    });
    $('#set_alert_form').on('submit', function(){
        event.preventDefault();
        var cc_emails = new Array();
        $('.select2-search-choice div').each(function(){
            cc_emails.push($(this).text());
        });
        //cc_emails = cc_emails.serialize();
        var data_for_ajax = $( this ).serializeArray();
        data_for_ajax = $.merge(data_for_ajax,[{'cc_emails':cc_emails},{'name':'survey_id', 'value':survey_id}]);
        save_alert_details(data_for_ajax, window.survey_id)

    });
    $(document).on('click','.changealert',function(){
        $('.change_values').css('display','block');
        initSurveySetAlertPopupWindow("change_values");

        $('#change_alert_emails').val($(this).parent().parent().find('.alert_emails').text());
        $('.checkbox_update input').prop('checked', true);
        if($(this).attr('created_at')=='0000-00-00 00:00:00')
        {
            $('.checkbox_update input').prop('checked', false);
        }
        $('#to_me_change_alert').prop('checked', false);
        if($(this).attr('email_me')=='1')
        {
            $('#to_me_change_alert').prop('checked', true);
        }
        var strTimeFrames =  $(this).parent().parent().find('.timeframe_alert').text().split(" ");
        $('.select_day_change').val(strTimeFrames[0]);
        $('.select_month_change').val(strTimeFrames[1]);
        $('#change_alert_id').val($(this).attr('s_id'));

    });


    $('.close_button, .cancel_btn'). on("click", function(){
        $('.change_values').css('display','none');
    });



});



function send_changed_alert(data, survey_id)
{

    $.ajax({
        url: "/frontend_dev.php/mySurvey/changeAlert",
        type: "POST",
        data:{
            details:data
        },
        dataType: "json",
        beforeSend: function() {
            // Show blocker
            $("#display_blocker").show();
        },
        success: function(data) {
            get_survey_alerts(survey_id);
            $('.change_values').css('display','none');
            $("#display_blocker").hide();


        },
        error: function() {
            openErrorPopupWindow("dialog_error_alert", "Error !!!");
        }
    });
}
function remove_survey_alert(alert_id, survey_id)
{

    $.ajax({
        url: "/frontend_dev.php/mySurvey/RemoveSurveyAlert",
        type: "POST",
        data:{
            alert_id:alert_id
        },
        dataType: "json",
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
                console.log(data);
                $(data).each(function(){
                    if(this['created_at']=='0000-00-00 00:00:00')
                    {
                        var timeframe = this['time-frame']+' '+this['time-frame-type']+' before submission deadline';
                    }
                    else
                    {
                        var timeframe = 'Anytime the record is updated';
                    }
                    $('.list_alerts').append('<div style="float: left;width: 100%;border-bottom: 1px solid #D9D2B9;padding-bottom: 5px; border-top:none;"><div class="alert_value1 alert_emails">'
                        +this['cc_email']+'</div><div style="width: 288px" class="alert_value1 timeframe_alert">'
                        +timeframe+'</div><div style="width: 100px" class="alert_value1"><div class="changealert" created='
                        +this['created_at']+' email_me='+this['email_me']+' created_at='+this['created_at']+' s_id='+this['id']+'>Change</div><div class="removealert" s_id='
                        +this['id']+'>Remove</div></div></div>');
                });
            }
            else
            {
                $('.list_alerts').append('<div style="text-align: center;font-weight: bold;float:left;width: 100%; border: 1px solid #D9D2B9;">No Alert Set</div>');
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
    $('.close_btn').on('click', function(){
        $("#" + element).dialog("close");
    });
}

/**
 * Initialization of "Confirm" popup window in deleting an alert
 */
function initDeleteAlertPopupWindow(element, alert_id) {
    $("#" + element).dialog({
        autoOpen: false,
        height: 200,
        width: 500,
        modal: true,
        buttons: {
            "Cancel": function() {
                $(this).dialog("close");
                return false;
            },
            "OK": function() {
                $(this).dialog("close");
                remove_survey_alert(alert_id, window.survey_id);
            }
        }
    });
}