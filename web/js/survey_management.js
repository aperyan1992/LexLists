/** 
 *  Script for "Survey Management" page
 */
$(document).ready(function() {

    /*$(".distance td").each(function(){
        if($(this).find(".admin_survey_management_input_text"))
        {
            //$(this).addClass("not_padding");
            //$(".distance td:not(.not_padding)").css({"padding-bottom" : "20px"});
            $(this).css({"padding-bottom" : "20px"});

        }


    });*/

    $('#s2id_lt_survey_survey_contact_id').css({"width": '434px'})
    $('#lt_survey_countries_list option:contains("United States of America")').prependTo('#lt_survey_countries_list');

    (function(){
        // Your base, I'm in it!
        var originalAddClassMethod = jQuery.fn.addClass;

        jQuery.fn.addClass = function(){
            // Execute the original method.
            var result = originalAddClassMethod.apply( this, arguments );

            // trigger a custom event
            jQuery(this).trigger('cssClassChanged');

            // return the original result
            return result;
        }
    })();

    (function(){
        // Your base, I'm in it!
        var originalAddClassMethod = jQuery.fn.removeClass;

        jQuery.fn.removeClass = function(){
            // Execute the original method.
            var result = originalAddClassMethod.apply( this, arguments );

            // trigger a custom event
            jQuery(this).trigger('cssClassChanged');

            // return the original result
            return result;
        }
    })();

        $("#s2id_lt_survey_countries_list").bind('cssClassChanged', function(){

            $('.select2-drop ul li:first-child div').addClass('borderbottomcity');
        });
    /**
     *  Init popups
     */

    initSurveyContactPopupWindow('dialog_form_survey_contact');
    initOrganizationPopupWindow('dialog_form_organization');
    initSurveyCityPopupWindow('dialog_form_city');
    initSurveySpecialCriteriaPopupWindow('dialog_form_special_criteria');
    initSurveyKeywordPopupWindow('dialog_form_keyword');

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

   /* $('#lt_survey_keywords').select2({
      tags: true,
    })*/
    $('.select2-container').each(function(){
        if($(this).find('ul li.select2-search-choice div').text() == "" || $(this).find('ul li div').text() == " ")
        {
            $(this).find('ul li.select2-search-choice').remove();
        }
    });

$("#add_keywords_link").click(function() {
        $("#dialog_form_keyword").dialog("open");

        return false;
    });

 $('#lt_survey_keywords').select2({
          // specify tags
          tags: false,
          separator: ";",
          allowClear: true,
        });
select2keywordvalues();

$('#s2id_lt_survey_keywords .select2-search-choice-close').click(function(){
    setTimeout(select2keywordvalues(),2000);
});
 $('#s2id_lt_survey_keywords .select2-input').attr('disabled',true);




});