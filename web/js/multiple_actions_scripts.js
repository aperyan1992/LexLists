/* 
 * Script for "Multiple actions" on "Dashboard" page
 */
$(document).ready(function() {
   
    /**
     *  "Multiple print" action
     */
    $(document).on('click', '#multiple_print', function() {
        // Get checked checkboxes
        var checked_checkboxes = $('.table_checkbox:checked');
        
        // Check count of checked checkboxes
        if (checkCountOfCheckboxes(checked_checkboxes, 0, 20, 'print')) {
            // Clear drop down list in print form
            $('#print_form #surveys_for_print').html('<option value="0">0</option>')
            
            // Set survey IDs to hidden field
            checked_checkboxes.each(function() {
                $('#print_form #surveys_for_print').append('<option value="' + $(this).attr('s_id') + '" selected>' + $(this).attr('s_id') + '</option>')
            });

            uncheckCheckboxes(checked_checkboxes);
            
            // Print surveys
            $('#print_form').submit();
        }
        
        return false;
    })
    /**
     *  END
     */
    
    /**
     *  "Multiple e-mail" action
     */
    $(document).on('click', '#multiple_email', function() {
        // Get checked checkboxes
        var checked_checkboxes = $('.table_checkbox:checked');
        
        // Check count of checked checkboxes
        if (checkCountOfCheckboxes(checked_checkboxes, 0, 20, 'e-mail')) {
            // Get all survey IDs
            var survey_ids = getSurveyIds(checked_checkboxes);

            if(sendEmailToMe(survey_ids)) {
                uncheckCheckboxes(checked_checkboxes);
            }
        }
        
        return false;
    })
    /**
     *  END
     */
    
    /**
     *  "Multiple save" action
     */
    $(document).on('click', '#multiple_save', function() {
        // Get checked checkboxes
        var checked_checkboxes = $('.table_checkbox:checked');
        
        // Check count of checked checkboxes
        if (checkCountOfCheckboxes(checked_checkboxes, 0, 100, 'save')) {
            // Get all survey IDs
            var survey_ids = getSurveyIds(checked_checkboxes);

            if(multipleSaveSurveyToMyList(survey_ids)) {
                uncheckCheckboxes(checked_checkboxes);
            }
        }
        
        return false;
    })
    /**
     *  END
     */
    
});

/**
 * Uncheck checked checkboxes
 * 
 * @param {object}  checked_checkboxes      Object with all checked checkboxes
 */
function uncheckCheckboxes(checked_checkboxes) {
    checked_checkboxes.prop('checked', false);
    $('#table_checkbox_select_all').prop('checked', false);
}

/**
 * Get array with survey IDs from checked checkboxes
 * 
 * @param {object}  checked_checkboxes      Object with all checked checkboxes
 * 
 * @returns {array}     Array with survey IDs
 */
function getSurveyIds(checked_checkboxes) {
    return checked_checkboxes.map(function() {
        return $(this).attr('s_id');
    }).get();
}

/**
 * Check count of checked checkboxes
 * 
 * @param {object}  checked_checkboxes      Object with all checked checkboxes
 * @param {integer} min_count               Permitted minimum count of checked checkboxes
 * @param {integer} max_count               Permitted maximum count of checked checkboxes
 * @param {string}  action                  Action name
 * 
 * @returns {Boolean}
 */
function checkCountOfCheckboxes(checked_checkboxes, min_count, max_count, action) {
    var checkboxes_count = checked_checkboxes.length;        
    if(checkboxes_count > max_count) {
        openErrorPopupWindow('dialog_error_alert', "You may not " + action + " more than " + max_count + " entries.");
        return false;
    }
    if(checkboxes_count <= min_count) {
        openErrorPopupWindow('dialog_error_alert', "You must first select at least one record.");
        return false;
    }
    
    return true;
}

/**
 * Multiple saving of surveys to "My Lists" section
 * 
 * @param {array} survey_ids     Array with survey IDs
 */
function multipleSaveSurveyToMyList(survey_ids) {
    var status = false;
    
    $.ajax({
        url: "/mySurvey/multipleSaveSurveyToMyList",
        type: "POST",
        data: {
            survey_ids: survey_ids
        },
        dataType: "json",
        async: false,
        success: function(data) {
            if(data.status === 'success') {
                openConfirmWithCustomMessagePopupWindow('dialog_save_to_my_list_alert', 'This awards are added successfully to your "My Lists" section.');
            
                status = true;
            }            
        },
        error: function() {
            openErrorPopupWindow('dialog_error_alert', 'Error !!!');
        }
    });
    
    return status;
}