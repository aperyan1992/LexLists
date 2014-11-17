/* 
 *  Scripts for working with buttons and submits in admin panel
 */

/**
 * Show error messages
 */
function updateTips(o, t) {
    if(o.parent("td").find(".error_list").length > 0) {
      o.parent("td").find(".error_list").remove();
    }
    
    if(o.parent("td").children().get(1) != undefined) {
        o.parent("td").find("span").after('<ul class="error_list"><li>' + t + '</li></ul>');
    } else{
        o.parent("td").find("input").after('<ul class="error_list"><li>' + t + '</li></ul>');
    }    
}

/**
 * Check length of field
 */
function checkLength(o, n, min, max) {
    if (min !== false) {
        if (o.val().length == 0) {
            updateTips(o, "This field is required.");
            o.focus();
            return false;
        }
    }

    if (o.val().length > max || o.val().length < min) {
        if (min == false) {
            updateTips(o, "Length of " + n + " may not exceed " +
                    max + " characters.");
            o.focus();
            return false;
        } else {
            updateTips(o, "Length of " + n + " must be between " +
                    min + " and " + max + ".");
            o.focus();
            return false;
        }
    } else {
        return true;
    }
}

/**
 * Check valid password
 */
function checkValidPassword(password, username) {
    if($(password).val().indexOf($(username).val())<1)
    {
            var regex = /^.*(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@$#%^&*()+_|}]).*$/;
            //var regex = /(?=^.{8,25}$)(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&amp;*()_+}{&quot;:;'?\/&gt;.&lt;,])(?!.*\s).*$/i;
            if(regex.test($(password).val()))
            {
                return true;
            }
    }
    updateTips(password, "Password must be at least 8 characters long and not contain the user name or any other complete word. It must have at least one uppercase letter, one lowercase letter, one number and a symbol (ex. @$#%^&*()+_|} )");
    password.focus();
    $('.error_list').css('float','right');
      return false;

}

/**
 * Validation of field
 */
function checkRegexpAndUniqueEmailAddress(url, o, regexp, n, is_new_object) {
    if (!(regexp.test(o.val()))) {
        if (o.val().length == 0) {
            updateTips(o, "This field is required.");
            o.focus();
            return false;
        }

        updateTips(o, n);
        o.focus();
        return false;
    } else {
        if(checkUniqueEmailAddress(url, o, is_new_object)) {
            return true;
        } 
        
        return false;
    }
}

/**
 * Validation of regexp field
 */
function checkRegexp( o, regexp, n ) {
   if ( !( regexp.test( o.val() ) ) ) {
       if(o.val().length == 0) {
           return true;
       }
       
       o.addClass( "ui-state-error" );
       updateTips( o, n );
       o.focus();
       return false;
   } else {
       return true;
   }
}

/**
 * Check email address for uniqueness
 * 
 * @param {string} url              Name of module
 * @param {string} email_address    Email Address
 * @param {string} is_new_object    Is new object?
 * 
 * @returns {Boolean}
 */
function checkUniqueEmailAddress(url, email_address, is_new_object) {
    if(email_address.val().length != 0) {
        var check_flag = true;
        
        var user_id = "false";
        if(is_new_object !== false) {
            user_id = is_new_object;
        }
        
        $.ajax({
            url: "/" + url + "/checkUniqueEmailAddress",
            type: "POST",
            data: {
                email_address : email_address.val(),
                user_id       : user_id
            },
            async: false,
            dataType: "json",
            success: function(data) {
                if(data.status == "email_address_exist") {
                    check_flag = false;
                } else {
                    check_flag = true;
                }
            },
            error: function() {
                check_flag = false;
            }
        });
        
        if(check_flag == false) {
            updateTips(email_address, 'A user with the same Email Address already exists.');
            
            return false;
        } else {
            return true;
        }        
    }
    
    return false;
}

/**
 * Check client name for uniqueness
 * 
 * @param {string} client_name      Email Address
 * @param {string} is_new_object    Is new object?
 * 
 * @returns {Boolean}
 */
function checkUniqueClientName(client_name, is_new_object) {
    if(client_name.val().length != 0) {
        var check_flag = true;
        
        var client_id = "false";
        if(is_new_object !== false) {
            client_id = is_new_object;
        }
        
        $.ajax({
            url: "/client/checkUniqueClientName",
            type: "POST",
            data: {
                client_name : client_name.val(),
                client_id   : client_id
            },
            async: false,
            dataType: "json",
            success: function(data) {
                if(data.status == "client_name_exist") {
                    check_flag = false;
                } else {
                    check_flag = true;
                }
            },
            error: function() {
                check_flag = false;
            }
        });
        
        if(check_flag == false) {
            updateTips(client_name, 'A client with the same Name already exists.');
            
            return false;
        } else {
            return true;
        }        
    }
    
    return false;
}

/**
 * Check same password
 * 
 * @param {string} password         Password
 * @param {string} password_again   Password again
 * 
 * @returns {Boolean}
 */
function checkSamePassword( password, password_again ) {
    if(password.val().length != 0 && password_again.val().length != 0) {
        if(password.val() == password_again.val()) {
            return true;
        } else {
            updateTips(password, 'The two passwords must be the same.');
            
            return false;
        }
    }
    
    return false;
}

/**
 * Validating of user form
 * 
 * @param {string} url      Name of module
 */
function validateUserForm(url, list_url, is_new_object) {
    var client_id       = $("#sf_guard_user_client_id"),
        first_name      = $("#sf_guard_user_first_name"),                    
        last_name       = $("#sf_guard_user_last_name"),
        email_address   = $("#sf_guard_user_email_address"),
        password        = $("#sf_guard_user_password"),
        password_again  = $("#sf_guard_user_password_again"),
        is_active       = $("#sf_guard_user_is_active"),
        is_visible      = $("#sf_guard_user_is_visible"),
        group           = $("#sf_guard_user_groups_list"),
        user_form_fields = $([]).add(first_name)
                                .add(last_name)
                                .add(email_address)
                                .add(password)
                                .add(password_again);

    user_form_fields.parent("td").find("ul.error_list").remove();

    var bValid = true;    

    bValid = bValid && checkLength( first_name, "first name", 1, 255 );
    bValid = bValid && checkLength( last_name, "last name", 1, 255 );

    if(is_new_object != 'true') {
        bValid = bValid && checkRegexpAndUniqueEmailAddress( url, email_address, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "Email Address is invalid.", is_new_object );

        if(password.val().length != 0 || password_again.val().length != 0) {
          //  bValid = bValid && checkLength( password, "password", 1, 128 );
            //bValid = bValid && checkLength( password_again, "password again", 1, 128 );
            bValid = bValid && checkValidPassword( password, first_name );
            bValid = bValid && checkSamePassword( password, password_again );
        }
    } else {
        bValid = bValid && checkRegexpAndUniqueEmailAddress( url, email_address, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "Email Address is invalid.", false );

       // bValid = bValid && checkLength( password, "password", 1, 128 );
        //bValid = bValid && checkLength( password_again, "password again", 1, 128 );
        bValid = bValid && checkValidPassword( password, first_name );

        bValid = bValid && checkSamePassword( password, password_again );
    }

    if (bValid) {
        // Disable buttons
        $(".save_button, .cancel_admin_panel").attr("disabled", true);

        // Save client info
        $.ajax({
            url: "/" + url + "/saveUserInfo",
            type: "POST",
            data: {
                client_id      : client_id.val(),
                first_name     : first_name.val(),
                last_name      : last_name.val(),
                email_address  : email_address.val(),
                password       : password.val(),
                password_again : password_again.val(),
                is_active      : is_active.is(":checked"),
                is_visible     : is_visible.is(":checked"),
                group          : group.val(),
                is_new_object  : is_new_object
            },
            async: false,
            dataType: "json",
            success: function(data) {
                if(data.status = "success") {
                    user_form_fields.parent("td").find("ul.error_list").remove();

                    $('.success_message').show();

                    // Redirect to the list
                    setTimeout(function() {
                        document.location.href = list_url;
                    }, 2000);
                } else {
                    openErrorPopupWindow('dialog_error_alert', 'Error !!!');

                    // Activate buttons
                    $(".save_button, .cancel_admin_panel").attr("disabled", false);
                }
            },
            error: function(data) {
                openErrorPopupWindow('dialog_error_alert', 'Error !!!');

                // Activate buttons
                $(".save_button, .cancel_admin_panel").attr("disabled", false);
            }
        });
    }
}

$(document).ready(function() {
  
    /**
     *  Init select2
     */
    $("select").select2({ dropdownCssClass: 'ui-dialog', width: "resolve" });
    
    /**
     *  Init datapickers
     */
    $( ".admin_datapicker" ).datepicker({ dateFormat: "dd-M-yy" });
    
    /**
     *  Click on "Cancel" button
     */
    $(document).on("click", ".cancel_admin_panel", function() {
        var list_url = $(this).attr("list_url");

        document.location.href = list_url;
    });
    
    /**
     *  Click on "Save" button
     */
    $(document).on("click", ".save_button", function(erer) {
        var form_name = $(this).attr("form_name");
        var list_url = $('.cancel_admin_panel').attr("list_url");
        var is_new_object = $("#is_new_object").val();
        switch (form_name) {
            case "client" :
                var additional_modules = new Array();
                $.each($("input[name='lt_client[additional_modules_list][]']:checked"), function() {
                    additional_modules.push($(this).val());
                });
                
                var exclusive_reports = new Array();
                $.each($("input[name='lt_client[exclusive_reports_list][]']:checked"), function() {
                    exclusive_reports.push($(this).val());
                });
                
                var client_name = $("#lt_client_name"),
                    is_enabled  = $("#lt_client_is_enabled"),                    
                    client_form_fields = $([]).add(client_name).add(is_enabled);
                   
                client_form_fields.parent("td").find("ul.error_list").remove();

                var bValid = true;

                bValid = bValid && checkLength( client_name, "client name", 1, 500 );
                bValid = bValid && checkUniqueClientName(client_name, is_new_object);

                if (bValid) {
                    // Disable buttons
                    $(".save_button, .cancel_admin_panel").attr("disabled", true);

                    // Save client info
                    $.ajax({
                        url: "/client/saveClientInfo",
                        type: "POST",
                        data: {
                            client_name        : client_name.val(),
                            is_enabled         : is_enabled.is(":checked"),
                            additional_modules : additional_modules,
                            exclusive_reports  : exclusive_reports,
                            is_new_object      : is_new_object
                        },
                        async: false,
                        dataType: "json",
                        success: function(data) {
                            if(data.status = "success") {
                                client_form_fields.parent("td").find("ul.error_list").remove();

                                $('.success_message').show();
                                
                                // Redirect to the list
                                setTimeout(function() {
                                    document.location.href = list_url;
                                }, 2000);
                            } else {
                                openErrorPopupWindow('dialog_error_alert', 'Error !!!');

                                // Activate buttons
                                $(".save_button, .cancel_admin_panel").attr("disabled", false);
                            }
                        },
                        error: function(data) {
                            openErrorPopupWindow('dialog_error_alert', 'Error !!!');

                            // Activate buttons
                            $(".save_button, .cancel_admin_panel").attr("disabled", false);
                        }
                    });
                }
                    
                break;
            case "users_for_superuser" :
                validateUserForm("sfGuardUser", list_url, is_new_object);            
                
                break;
            case "users_for_client_admin" :
                validateUserForm("clientAdminUserManagement", list_url, is_new_object);
                                
                break;
            case "survey":
                var organization          = $("#lt_survey_organization_id"),
                    organization_url      = $("#lt_survey_organization_url"),
                    survey_name           = $("#lt_survey_survey_name"),
                    survey_year           = $("#lt_survey_year"),
                    survey_url            = $("#lt_survey_survey_url"),
                    frequency             = $("#lt_survey_frequency"),
                    submission_deadline   = $("#lt_survey_submission_deadline"),
                    survey_cities         = $("#lt_survey_cities_list"),
                    survey_states         = $("#lt_survey_states_list"),
                    survey_countries      = $("#lt_survey_countries_list"),
                    survey_region         = $("#lt_survey_survey_region_id"),
                    survey_description    = $("#lt_survey_survey_description"),
                    candidate_type        = $("#lt_survey_candidate_type"),
                    eligibility_criteria  = $("#lt_survey_eligibility_criteria"),
                    special_criterias     = $("#lt_survey_special_criterias_list"),
                    practice_areas        = $("#lt_survey_practice_areas_list"),
                    nomination            = $("#lt_survey_nomination"),
                    selection_methodology = $("#lt_survey_selection_methodology"),
                    self_nomination       = $("input[name='lt_survey[self_nomination]']:checked"),
                    fees                  = $("input[name='lt_survey[fees]']:checked"),
                    pay_for_play          = $("input[name='lt_survey[pay_for_play]']:checked"),
                    contact_id            = $("#lt_survey_survey_contact_id"),
                    survey_notes          = $("#lt_survey_survey_notes"),
                    staff_notes           = $("#lt_survey_staff_notes"),
                    survey_form_fields    = $([]).add(organization).add(organization_url).add(survey_name)
                                                  .add(survey_year).add(survey_url).add(frequency)
                                                  .add(submission_deadline).add(survey_cities).add(survey_states)
                                                  .add(survey_countries).add(survey_region).add(survey_description)
                                                  .add(candidate_type).add(eligibility_criteria).add(special_criterias)
                                                  .add(practice_areas).add(nomination).add(selection_methodology).add(self_nomination)
                                                  .add(fees).add(pay_for_play).add(contact_id)
                                                  .add(survey_notes).add(staff_notes);
                   
                survey_form_fields.parent("td").find("ul.error_list").remove();

                // Validation
                var bValid = true;
                bValid = bValid && checkLength( organization_url, "organization url", false, 255 );
                bValid = bValid && checkLength( survey_name, "survey name", false, 255 );
                bValid = bValid && checkLength( survey_url, "survey url", false, 255 );
                bValid = bValid && checkLength( survey_description, "survey description", false, 5000 );
                bValid = bValid && checkLength( eligibility_criteria, "eligibility criteria", false, 5000 );
                bValid = bValid && checkLength( nomination, "nomination", false, 5000 );
                bValid = bValid && checkLength( selection_methodology, "selection methodology", false, 5000 );
                bValid = bValid && checkLength( survey_notes, "survey notes", false, 5000 );
                bValid = bValid && checkLength( staff_notes, "staff notes", false, 5000 );
                
                if (bValid) {
                    // Disable buttons
                    $(".save_button, .cancel_admin_panel").attr("disabled", true);

                    // Save survey info
                    $.ajax({
                        url: "/surveyManagement/saveSurveyInfo",
                        type: "POST",
                        data: {
                            organization          : organization.val(),
                            organization_url      : organization_url.val(),
                            survey_name           : survey_name.val(),
                            survey_year           : survey_year.val(),
                            survey_url            : survey_url.val(),
                            frequency             : frequency.val(),
                            submission_deadline   : submission_deadline.val(),
                            survey_cities         : survey_cities.val(),
                            survey_states         : survey_states.val(),
                            survey_countries      : survey_countries.val(),
                            survey_region         : survey_region.val(),
                            survey_description    : survey_description.val(),
                            candidate_type        : candidate_type.val(),
                            eligibility_criteria  : eligibility_criteria.val(),
                            special_criterias     : special_criterias.val(),
                            practice_areas        : practice_areas.val(),
                            nomination            : nomination.val(),
                            selection_methodology : selection_methodology.val(),
                            self_nomination       : (self_nomination.val() == undefined) ? false : self_nomination.val(),
                            fees                  : (fees.val() == undefined) ? false : fees.val(),
                            pay_for_play          : (pay_for_play.val() == undefined) ? false : pay_for_play.val(),
                            contact_id            : contact_id.val(),
                            survey_notes          : survey_notes.val(),
                            staff_notes           : staff_notes.val(),
                            is_new_object         : is_new_object
                        },
                        async: false,
                        dataType: "json",
                        success: function(data) {
                            if(data.status = "success") {
                                survey_form_fields.parent("td").find("ul.error_list").remove();

                                $('.success_message').show();
                                
                                // Redirect to the list
                                setTimeout(function() {
                                    document.location.href = list_url;
                                }, 2000);
                            } else {
                                openErrorPopupWindow('dialog_error_alert', 'Error !!!');

                                // Activate buttons
                                $(".save_button, .cancel_admin_panel").attr("disabled", false);
                            }
                        },
                        error: function(data) {
                            openErrorPopupWindow('dialog_error_alert', 'Error !!!');

                            // Activate buttons
                            $(".save_button, .cancel_admin_panel").attr("disabled", false);
                        }
                    });
                }
                
                break;
        }
        
        return false;
    });

});


