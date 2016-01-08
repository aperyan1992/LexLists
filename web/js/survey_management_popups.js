/* 
 * Script for popup windows on "Survey Management" page
 */

/**
 * Initialization of "Survey Contact" popup window
 */
function initSurveyContactPopupWindow(element) {
    var first_name = $("#first_name_" + element),
        email      = $("#email_" + element),
        last_name  = $("#last_name_" + element),
        phone      = $("#phone_number_" + element),
        allFields  = $([]).add(first_name).add(email).add(last_name).add(phone);

    $("#" + element).dialog({
        autoOpen: false,
        height: 'auto',
        width: 615,
        modal: true,
        buttons: {
            Cancel: function() {
                $(this).dialog("close");
                allFields.val("").removeClass("ui-state-error").removeClass("ui-state-highlight");
                $("#dialog_form_survey_contact .error_list li").text("");
            },
            "Save": function() {
                var bValid = true;
                allFields.removeClass("ui-state-error");
                allFields.parent("td").find("ul li").text('');
                
                bValid = bValid && checkLength(first_name, "first name", 1, 145);
                bValid = bValid && checkLength(last_name, "last name", 1, 145);
                bValid = bValid && checkLength(email, "email", 1, 80);

                bValid = bValid && checkRegexp(email, /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i, "Email Address is invalid.");

                bValid = bValid && checkLength(phone, "phone", false, 100);

                if (bValid) {
                    var response_status = true;
                  
                    // Save survey contact
                    $.ajax({
                        url: "/surveyManagement/addSurveyContact",
                        type: "POST",
                        data: {
                            first_name        : first_name.val(),
                            last_name         : last_name.val(),
                            email             : email.val(),
                            phone             : phone.val()
                        },
                        async: false,
                        dataType: "json",
                        success: function(data) {
                            if (data.error == "email") {
                                openErrorPopupWindow('dialog_error_alert', 'Contact with this email address is already exists.');
                                response_status = false;
                            } else {
                                var full_name = data.last_name + 
                                                ", " + 
                                                data.first_name + 
                                                " (Email: " + 
                                                data.email_address + 
                                                ", Phone: " + 
                                                data.phone_number + 
                                                ")";
                                        
                                $("#lt_survey_survey_contact_id").append( 
                                    $('<option value="' + data.id + '">' + full_name + '</option>')
                                );

                                $("#lt_survey_survey_contact_id option[value='" + data.id + "']").prop("selected", true);

                                $("#lt_survey_survey_contact_id").select2({ dropdownCssClass: 'ui-dialog', width: "resolve" });
                            }
                        },
                        error: function(data) {
                            openErrorPopupWindow('dialog_error_alert', 'Error !!!');
                        }
                    });

                    if(response_status) {
                      $(this).dialog("close");
                      allFields.val("").removeClass("ui-state-error").removeClass("ui-state-highlight");
                      $("#dialog_form_survey_contact .error_list li").text("");
                    }
                }
            }
        },
        close: function() {
            allFields.val("").removeClass("ui-state-error").removeClass("ui-state-highlight");
            $("#dialog_form_survey_contact .error_list li").text("");
        }
    });
}

/**
 * Initialization of "Organization" popup window
 */
function initOrganizationPopupWindow(element) {
    var organization = $("#organization_" + element),
        allFields  = $([]).add(organization);

    $("#" + element).dialog({
        autoOpen: false,
        height: 'auto',
        width: 670,
        modal: true,
        buttons: {
            Cancel: function() {
                $(this).dialog("close");
                allFields.val("").removeClass("ui-state-error").removeClass("ui-state-highlight");
                $("#" + element + " .error_list li").text("");
            },
            "Save": function() {                
                var bValid = true;
                allFields.removeClass("ui-state-error");
                allFields.parent("td").find("ul li").text('');
                
                bValid = bValid && checkLength(organization, "organization", 1, 255);

                if (bValid) {
                    var response_status = true;
                  
                    // Save organization
                    $.ajax({
                        url: "/surveyManagement/addOrganization",
                        type: "POST",
                        data: {
                            organization : organization.val()
                        },
                        async: false,
                        dataType: "json",
                        success: function(data) {
                            if (data.error == "exists") {
                                openErrorPopupWindow('dialog_error_alert', 'This organization is already exists.');
                                response_status = false;
                            } else {    
                                $("#lt_survey_organization_id").append( 
                                    $('<option value="' + data.id + '">' + data.organization + '</option>')
                                );

                                $("#lt_survey_organization_id option[value='" + data.id + "']").prop("selected", true);

                                $("#lt_survey_organization_id").select2({ dropdownCssClass: 'ui-dialog', width: "resolve" });
                            }
                        },
                        error: function(data) {
                            openErrorPopupWindow('dialog_error_alert', 'Error !!!');
                        }
                    });

                    if(response_status) {
                      $(this).dialog("close");
                      allFields.val("").removeClass("ui-state-error").removeClass("ui-state-highlight");
                      $("#" + element + " .error_list li").text("");
                    }
                }
            }
        },
        close: function() {
            allFields.val("").removeClass("ui-state-error").removeClass("ui-state-highlight");
            $("#" + element + " .error_list li").text("");
        }
    });
}

/**
 * Initialization of "Survey City" popup window
 */
function initSurveyCityPopupWindow(element) {
    var survey_city = $("#survey_city_" + element),
        allFields  = $([]).add(survey_city);

    $("#" + element).dialog({
        autoOpen: false,
        height: 'auto',
        width: 550,
        modal: true,
        buttons: {
            Cancel: function() {
                $(this).dialog("close");
                allFields.val("").removeClass("ui-state-error").removeClass("ui-state-highlight");
                $("#" + element + " .error_list li").text("");
            },
            "Save": function() {                
                var bValid = true;
                allFields.removeClass("ui-state-error");
                allFields.parent("td").find("ul li").text('');
                
                bValid = bValid && checkLength(survey_city, "survey city", 1, 255);

                if (bValid) {
                    var response_status = true;
                  
                    // Save survey city
                    $.ajax({
                        url: "/surveyManagement/addSurveyCity",
                        type: "POST",
                        data: {
                            survey_city : survey_city.val()
                        },
                        async: false,
                        dataType: "json",
                        success: function(data) {
                            if (data.error == "exists") {
                                openErrorPopupWindow('dialog_error_alert', 'This city is already exists.');
                                response_status = false;
                            } else {    
                                $("#lt_survey_cities_list").append( 
                                    $('<option value="' + data.id + '">' + data.city + '</option>')
                                );

                                $("#lt_survey_cities_list option[value='" + data.id + "']").prop("selected", true);

                                $("#lt_survey_cities_list").select2({ dropdownCssClass: 'ui-dialog', width: "resolve" });
                            }
                        },
                        error: function(data) {
                            openErrorPopupWindow('dialog_error_alert', 'Error !!!');
                        }
                    });

                    if(response_status) {
                      $(this).dialog("close");
                      allFields.val("").removeClass("ui-state-error").removeClass("ui-state-highlight");
                      $("#" + element + " .error_list li").text("");
                    }
                }
            }
        },
        close: function() {
            allFields.val("").removeClass("ui-state-error").removeClass("ui-state-highlight");
            $("#" + element + " .error_list li").text("");
        }
    });
}

/**
 * Initialization of "Survey Special Criteria" popup window
 */
function initSurveySpecialCriteriaPopupWindow(element) {
    var survey_special_criteria = $("#survey_special_criteria_" + element),
        allFields  = $([]).add(survey_special_criteria);

    $("#" + element).dialog({
        autoOpen: false,
        height: 'auto',
        width: 550,
        modal: true,
        buttons: {
            Cancel: function() {
                $(this).dialog("close");
                allFields.val("").removeClass("ui-state-error").removeClass("ui-state-highlight");
                $("#" + element + " .error_list li").text("");
            },
            "Save": function() {                
                var bValid = true;
                allFields.removeClass("ui-state-error");
                allFields.parent("td").find("ul li").text('');
                
                bValid = bValid && checkLength(survey_special_criteria, "survey special criteria", 1, 255);

                if (bValid) {
                    var response_status = true;
                  
                    // Save survey city
                    $.ajax({
                        url: "/surveyManagement/addSurveySpecialCriteria",
                        type: "POST",
                        data: {
                            survey_special_criteria : survey_special_criteria.val()
                        },
                        async: false,
                        dataType: "json",
                        success: function(data) {
                            if (data.error == "exists") {
                                openErrorPopupWindow('dialog_error_alert', 'This special criteria is already exists.');
                                response_status = false;
                            } else {    
                                $("#lt_survey_special_criterias_list").append( 
                                    $('<option value="' + data.id + '">' + data.special_criteria + '</option>')
                                );

                                $("#lt_survey_special_criterias_list option[value='" + data.id + "']").prop("selected", true);

                                $("#lt_survey_special_criterias_list").select2({ dropdownCssClass: 'ui-dialog', width: "resolve" });
                            }
                        },
                        error: function(data) {
                            openErrorPopupWindow('dialog_error_alert', 'Error !!!');
                        }
                    });

                    if(response_status) {
                      $(this).dialog("close");
                      allFields.val("").removeClass("ui-state-error").removeClass("ui-state-highlight");
                      $("#" + element + " .error_list li").text("");
                    }
                }
            }
        },
        close: function() {
            allFields.val("").removeClass("ui-state-error").removeClass("ui-state-highlight");
            $("#" + element + " .error_list li").text("");
        }
    });

}

function initSurveyKeywordPopupWindow(element) {
    var keyword = $("#survey_keyword_dialog_form_keyword"),
        allFields  = $([]).add(keyword);

    $("#" + element).dialog({
        autoOpen: false,
        height: 'auto',
        width: 550,
        modal: true,
        buttons: {
            Cancel: function() {
                $(this).dialog("close");
                allFields.val("").removeClass("ui-state-error").removeClass("ui-state-highlight");
                $("#" + element + " .error_list li").text("");
            },
            "Save": function() {                
                /*var bValid = true;
                allFields.removeClass("ui-state-error");
                allFields.parent("td").find("ul li").text('');
                
                bValid = bValid && checkLength(keyword, "survey keyword", 1, 250);

                if (bValid) {
                    var response_status = true;
                    var dataArray = $("#lt_survey_keywords").select2('data');
                    dataArray.push({'id':keyword.val(),"text": keyword.val() });

                    $("#lt_survey_keywords").select2("data", dataArray);
                    select2keywordvalues();

                      $(this).dialog("close");
                      allFields.val("").removeClass("ui-state-error").removeClass("ui-state-highlight");
                      $("#" + element + " .error_list li").text("");
                    
                }*/
                var bValid = true;
                allFields.removeClass("ui-state-error");
                allFields.parent("td").find("ul li").text('');

                bValid = bValid && checkLength(keyword, "survey keyword", 1, 250);

                if (bValid) {


                        $("#lt_survey_keywords").append(
                            $('<option value="' + keyword.val() + '">' + keyword.val() + '</option>')
                        );

                        $("#lt_survey_keywords option[value='" + keyword.val() + "']").prop("selected", true);

                        $("#lt_survey_keywords").select2({ dropdownCssClass: 'ui-dialog', width: "resolve" });



                        $(this).dialog("close");
                        allFields.val("").removeClass("ui-state-error").removeClass("ui-state-highlight");
                        $("#" + element + " .error_list li").text("");

                }
            }
        },
        close: function() {
            allFields.val("").removeClass("ui-state-error").removeClass("ui-state-highlight");
            $("#" + element + " .error_list li").text("");
        }
    });
    }