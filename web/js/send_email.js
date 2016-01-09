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
    $(document).on("click", ".email_link", function() {
        

        var survey_id = $(this).attr("s_id");

        // Get survey info
        $.ajax({
            url: "/dashboard/getSurveyInfo",
            type: "POST",
            data: {
                survey_id: survey_id,
                email:'1'
            },
            dataType: "json",
            success: function(data1) {
                $.ajax({
                    url: "/frontend_dev.php/mySurvey/GetAllEmails",
                    type: "POST",
                    dataType: "json",
                    success: function(data) {
                        var arrEmails = new Array();
                        var to_me = data['me'];
                        data = data.array;
                        console.log(data);
                        for(var i = 0;i< data.length;i++)
                        {
                            arrEmails.push({id:i,text:data[i].f_name+' '+data[i].l_name+' ('+data[i].email+')'});
                        }
                        window.arrEmails = arrEmails;
                        $('#to_dialog_form_survey_email').select2({                            
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
                console.log(data1);
                $("#dialog_form_survey_email").data(data1).dialog("open");

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
    
    $(document).on("click", ".my_list_email_send", function() {
        

        var survey_id = $(this).attr("s_id");

        // Get survey info
        $.ajax({
            url: "/mySurvey/getSurveyInfo",
            type: "POST",
            data: {
                survey_id: survey_id,
                email:'1'
            },
            dataType: "json",
            success: function(data1) {
                $.ajax({
                    url: "/frontend_dev.php/mySurvey/GetAllEmails",
                    type: "POST",
                    dataType: "json",
                    success: function(data) {
                        var arrEmails = new Array();
                        var to_me = data['me'];
                        data = data.array;
                        console.log(data);
                        for(var i = 0;i< data.length;i++)
                        {
                            arrEmails.push({id:i,text:data[i].f_name+' '+data[i].l_name+' ('+data[i].email+')'});
                        }
                        window.arrEmails = arrEmails;
                        $('#to_dialog_form_survey_email').select2({                            
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
                console.log(data1);
                $("#dialog_form_survey_email").data(data1).dialog("open");

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

    $(document).on("click", "#multiple_forward", function() {
        var checked_checkboxes = $('.table_checkbox:checked');

        // Check count of checked checkboxes
        if (checkCountOfCheckboxes(checked_checkboxes, 0, 20, 'e-mail')) {
            // Get all survey IDs
            initSurveyForwardPopupWindow("dialog_form_survey_forward");
            $("#dialog_form_survey_forward").dialog("open");
        }

        return false;

    });


    /**
     * Enable/Disable "To" text field
     */
    $(document).on("change", "#to_me_dialog_form_survey_email", function() {
        var checked_status = $(this).is(":checked");

        //$("#to_dialog_form_survey_email").prop("disabled", checked_status).focus();
    });
    /********************************/

    $('#addemailcc2').on('click', function(){
        var neweamil = $('.select2-match').text();
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        $('.select2-match').remove();
        $('.select2-input').val('');
        $("#to_dialog_form_survey_email").select2('close');
        $('.select2-input').attr('style','width:50px');
        if(neweamil!='')
        {
            if(!emailReg.test(neweamil)) {
                openErrorPopupWindow("dialog_error_alert", "Email address is not valid, please enter a valid email address!");
            }
            else
            {
            if(!$('.select2-search-choice').length)
            {
                $('.select2-choices').prepend('<li class="select2-search-choice">    <div>'+neweamil+'</div>    <a href="#" class="removeccemail select2-search-choice-close" tabindex="-1"></a></li>');
            }
            else
                $('.select2-container ul li:nth-last-child(2)').after('<li class="select2-search-choice">    <div>'+neweamil+'</div>    <a href="#" class="removeccemail select2-search-choice-close" tabindex="-1"></a></li>')
            }

        }
    });
    $(document).on('click','.removeccemail',function(){
        $(this).parent().fadeOut(300, function(){
            this.remove();
        });
    });
    $(document).on('click','.removealert',function(){
        var alert_id =  $(this).attr('s_id');
        initDeleteAlertPopupWindow('dialog_delete_alert_cofirm_alert',alert_id);
        $("#dialog_delete_alert_cofirm_alert").dialog("open");
    });



    $('.ui-button-text').on('submit', function(){
        event.preventDefault();
        var check=true;
        var cc_emails = new Array();
        $('.select2-search-choice div').each(function(){
            cc_emails.push($(this).text());
        });
        if($('.select_day').val().length==0 || $('.select_month').val().length==0)
        {
            if(!$("input[name='updated']").is(":checked"))
            {
                $('#dialog_save_alert_validation').dialog('open');
                check=false;
            }
        }
        if( cc_emails.length==0 && !$(".tomemail").is(":checked"))
        {

            $('#dialog_save_alert_validation2').dialog('open');
            check=false;
        }

        if(check)
        {
            //cc_emails = cc_emails.serialize();
            var data_for_ajax = $( this ).serializeArray();
            data_for_ajax = $.merge(data_for_ajax,[{'cc_emails':cc_emails},{'name':'survey_id', 'value':survey_id}]);
            save_alert_details(data_for_ajax, window.survey_id)
        }

    });


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
            survey_ids: survey_ids,
            survey_name: $('#dialog_email_survey_name_hidden').text(),
            organization: $('#dialog_email_organization a').text(),
            email_me: 1
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

function sendEmailToMeDashboard(survey_ids) {
    $.ajax({
        url: "/dashboard/sendEmail",
        type: "POST",
        data: {
            survey_ids: survey_ids,
            survey_name: $('#dialog_survey_name_hidden').text(),
            organization: $('#dialog_organization a').text(),
            email_me: 1
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
function sendEmailToMeMyList(survey_ids) {
    $.ajax({
        url: "/mySurvey/sendEmail",
        type: "POST",
        data: {
            survey_ids: survey_ids,
            survey_name: $('#dialog_survey_name_hidden').text(),
            organization: $('#dialog_organization a').text(),
            email_me: 1
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
function sendEmailToAnotherUser(survey_ids, email_address) {
    $.ajax({
        url: "/dashboard/sendEmail",
        type: "POST",
        data: {
            survey_ids    : survey_ids,
            email_address : email_address,
            survey_name   : $('#dialog_email_survey_name_hidden').text(),
            organization  : $('#dialog_email_organization a').text(),
            email_me      : 0
        },
        dataType: "json",
        beforeSend: function() {
            // Show blocker
            $("#display_blocker").show();
        },
        success: function(data) {
            // Hide blocker
            $("#display_blocker").hide();
            $("#dialog_form_survey_forward").dialog("close");
        },
        error: function() {
            openErrorPopupWindow("dialog_error_alert", "Message sending failed. Try again.");

            // Hide blocker
            $("#display_blocker").hide();
        }
    });
}

function cancelEmailLog(survey_id, survey_name, organization){
     $.ajax({
        url: "/dashboard/cancelEmailLog",
        type: "POST",
        data: {
            survey_id    : survey_id,            
            survey_name   : survey_name,
            organization  : organization
        },
        dataType: "json",
       
        success: function(data) {
           
        },
        error: function() {
          
        }
    });
}

/**
 * Initialization of "Survey Email" popup window
 */
function initSurveyEmailPopupWindow(element) {
    var to_email_address = $("#dialog_email_user_email_hidden"),
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
        buttons: {
            "Cancel": function() {
                cancelEmailLog($('#dialog_email_survey_id').text(), $('#dialog_email_survey_name_hidden').text(), $('#dialog_email_organization').text());
                text_fields.val("");
                to_me_flag.prop("checked", true);
                $(this).dialog("close");
            },
            "Send": function() {
                var bValid = true;

                // Validation of email address if "me" checkbox is unchecked
               /* if(!to_me_flag.is(":checked")) {
                    bValid = bValid && checkLength(to_email_address);
                    bValid = bValid && checkRegexp(to_email_address, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
                }*/
                var emailaddr = null;
                if($(".timemail").is(":checked"))
                {
                    emailaddr = to_email_address.text();
                }
                var cc_emails = new Array();
                $('.select2-search-choice div').each(function(){
                    cc_emails.push($(this).text());
                });
                if( cc_emails.length==0 && !$(".timemail").is(":checked"))
                {
                    bValid = false;
                }
                if (bValid) {
                        // Send email message
                        sendEmailToAnotherUser([$(this).data("survey_id")], emailaddr, message.val(),cc_emails);

                        text_fields.val("");
                        to_me_flag.prop("checked", true);
                        $(this).dialog("close");
                    } else {
                        openErrorPopupWindow("dialog_error_alert", "Warning! You must have at least one recipient to send an email.");
                    }
                }

        },
        close: function() {
            text_fields.val("");
            to_me_flag.prop("checked", true);
            $(this).dialog("close");
        }
    });
}

function initSurveyForwardPopupWindow(element) {
    var to_email_address = $("#dialog_email_user_email_hidden"),
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
        buttons: {
            "Cancel": function() {
                cancelEmailLog($('#dialog_email_survey_id').text(), $('#dialog_email_survey_name_hidden').text(), $('#dialog_email_organization').text());
                text_fields.val("");
                to_me_flag.prop("checked", true);
                $(this).dialog("close");
            },
            "Send": function() {
                var checked_checkboxes = $('.table_checkbox:checked');
                var email_address = $('.to_dialog_form_survey_forward').val();
                // Check count of checked checkboxes
                var survey_ids = getSurveyIds(checked_checkboxes);
                var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
                if(expr.test(email_address))
                {
                    if(sendEmailToAnotherUser(survey_ids, email_address)) {
                        uncheckCheckboxes(checked_checkboxes);
                    }
                    $('#email_validate_error').hide();
                }
                else
                {
                    $('#email_validate_error').show();
                    return false;
                }
            }

        },
        close: function() {
            text_fields.val("");
            to_me_flag.prop("checked", true);
            $(this).dialog("close");
        }
    });
}

function ValidateEmail(email) {
    var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    return expr.test(email);
};

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