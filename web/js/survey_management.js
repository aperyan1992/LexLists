/** 
 *  Script for "Survey Management" page
 */
$(document).ready(function() {

    /**
     *  Init popups
     */
    initSurveyContactPopupWindow('dialog_form_survey_contact');
    initOrganizationPopupWindow('dialog_form_organization');
    initSurveyCityPopupWindow('dialog_form_city');
    initSurveySpecialCriteriaPopupWindow('dialog_form_special_criteria');

    /**
     * Add new survey contact
     */
    $("#add_survey_contact_id_link").click(function() {
        $("#dialog_form_survey_contact").dialog("open");

        return false;
    });
    /**
     * END
     */

    /**
     * Add new organization
     */
    $("#add_organization_id_link").click(function() {
        $("#dialog_form_organization").dialog("open");

        return false;
    });
    /**
     * END
     */

    /**
     * Add new survey city
     */
    $("#add_cities_list_link").click(function() {
        $("#dialog_form_city").dialog("open");

        return false;
    });
    /**
     * END
     */

    /**
     * Add new special criteria
     */
    $("#add_special_criterias_list_link").click(function() {
        $("#dialog_form_special_criteria").dialog("open");

        return false;
    });
    /**
     * END
     */

});