/* 
 * Script for email sending
 */
$(document).ready(function() {

    /**
     *  Init popups
     */
    initSurveyEmailPopupWindow("dialog_form_survey__set_alert");

    /**
     * Send email message
     */
    $(document).on("click", ".set_an_alert_class", function() {
        var survey_id = $(this).attr("s_id");
        $("#dialog_form_survey__set_alert").dialog("open");

        /*// Get survey info
        $.ajax({
            url: "/dashboard/getSurveyInfo",
            type: "POST",
            data: {
                survey_id: $(this).attr("s_id")
            },
            dataType: "json",
            success: function(data) {
                $("#dialog_form_survey__set_alert").data(data).dialog("open");
            },
            error: function() {
                openErrorPopupWindow("dialog_error_alert", "Error !!!");
            }
        });
        
        // Close menu if exists
        if ($(this).hasClass("my_list_email_send")) {
            $(this).parents('ul.menu-dropdown').slideToggle();
        }*/

        return false;
    });



});