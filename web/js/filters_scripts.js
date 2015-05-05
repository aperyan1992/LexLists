/* 
 * Scripts for work with filters
 */

$(document).ready(function() {

    // $('#calendar_div a').attr("href='javascript:void(0)'").click(function(){
    //     alert("yeeeees");
    // });

    $('.calendar_link').click(function(){

        var data = {title:"Calendar"};
        $.ajax({
            url: "/dashboard/calendar",
            type: "POST",
            data: data,
            dataType: "json",
            success: function(data) {
               
            }            
        });
    });

    $('.btn-group button:contains(Year)').click(function(){
        var data = {title:"Year", button:1};
        $.ajax({
            url: "/dashboard/calendar",
            type: "POST",
            data: data,
            dataType: "json",
            success: function(data) {
               
            }            
        });
    });
    $('.btn-group button:contains(Month)').click(function(){
        var data = {title:"Month", button:1};
        $.ajax({
            url: "/dashboard/calendar",
            type: "POST",
            data: data,
            dataType: "json",
            success: function(data) {
               
            }            
        });
    });
    $('.btn-group button:contains(Week)').click(function(){
        var data = {title:"Week", button:1};
        $.ajax({
            url: "/dashboard/calendar",
            type: "POST",
            data: data,
            dataType: "json",
            success: function(data) {
               
            }            
        });
    });

    // var cancelmapname = '';
    // $('.btn-group button').each(function(){
    //     if($(this).attr('data-calendar-view') == 'year')
    //     {
    //         cancelmapname = $(this).attr("id"); 
    //         var data = {title:cancelmapname};
    //         $.ajax({
    //             url: "/dashboard/cancelMapLog",
    //             type: "POST",
    //             data: data,
    //             dataType: "json",
    //             success: function(data) {
                   
    //             }            
    //         });
                      
    //     }
    // });

    $('.jsmapclick_us_states').click(function(){
        var data = {title:"US States Map"} ; 

        $.ajax({
            url: "/dashboard/setMapsLog",
            type: "POST",
            data: data,
            dataType: "json",
            success: function(data) {
               
            }            
        });
    });
    $('.jsmapclick_us').click(function(){
        var data = {title:"US Regions Map"} ; 

        $.ajax({
            url: "/dashboard/setMapsLog",
            type: "POST",
            data: data,
            dataType: "json",
            success: function(data) {
               
            }            
        });
    }); 
    $('.jsmapclick').click(function(){
        var data = {title:"World Regions Map"} ; 

        $.ajax({
            url: "/dashboard/setMapsLog",
            type: "POST",
            data: data,
            dataType: "json",
            success: function(data) {
               
            }            
        });
    });

    

    $('#default_display').on('click', function(){

        var data = {title:$(this).text(), filter_action:'Display Box Filter - '} ; 

        $.ajax({
            url: "/dashboard/setFilterLog",
            type: "POST",
            data: data,
            dataType: "json",
            success: function(data) {
               
            }            
        });
        
    });
    $('#select_all_display').on('click', function(){

        var data = {title:$(this).text(), filter_action:'Display Box Filter - '} ; 

        $.ajax({
            url: "/dashboard/setFilterLog",
            type: "POST",
            data: data,
            dataType: "json",
            success: function(data) {
               
            }            
        });
        
    });
    $('#clear_all_display').on('click', function(){

        var data = {title:$(this).text(), filter_action:'Display Box Filter - '} ; 

        $.ajax({
            url: "/dashboard/setFilterLog",
            type: "POST",
            data: data,
            dataType: "json",
            success: function(data) {
               
            }            
        });
        
    });

    // $('#clear_filters').click( function(){
    //     var data = {title:$(this).text(), filter_action:'Left Sidebar Filter - '} ; 

    //     $.ajax({
    //         url: "/dashboard/setFilterLog",
    //         type: "POST",
    //         data: data,
    //         dataType: "json",
    //         success: function(data) {
               
    //         }            
    //     });
        
    // });


    $(document).on('change','#report_surveys_years_filter input',function(){
        var current = {current:$(this).val()};
        $.ajax({
            url: "/dashboard/setTextSearchLog",
            type: "POST",
            data: current,
            dataType: "json",
            success: function(data) {
               
            }            
        });   
        
    });

    $('.search-block input:checkbox').on("change", function(){
        if($(this).is(":checked")) {            
            var data = {title:$(this).next().text(), filter_action:'Select | '} ;           
        }
        else
        {
            var data = {title:$(this).next().text(), filter_action:'Unselect | '};
        }
         $.ajax({
            url: "/dashboard/setFilterLog",
            type: "POST",
            data: data,
            dataType: "json",
            success: function(data) {
               
            }            
        });
    });

    $('.left-sidebar input:checkbox').on("change", function(){
        if($(this).is(":checked")) {
            var filter_name = $(this).parent().parent().parent().attr("class");
            filter_name = filter_name.charAt(0).toUpperCase() + filter_name.substr(1);
            var data = {title:$(this).next().text(), filter_action:'Select | '+filter_name+': '} ;           
        }
        else
        {
            var filter_name = $(this).parent().parent().parent().attr("class");
            filter_name = filter_name.charAt(0).toUpperCase() + filter_name.substr(1);
            var data = {title:$(this).next().text(), filter_action:'Unselect | '+filter_name+': '};
        }
        $.ajax({
            url: "/dashboard/setFilterLog",
            type: "POST",
            data: data,
            dataType: "json",
            success: function(data) {
               
            }            
        });
    });

    // $(document).on('click', '#dialog_organization a', function () {
        
    //     var data = {title:$('#dialog_organization a').attr("href"), id:$('#dialog_survey_id').text(), word:'Organization: '};

    //     $.ajax({
    //         url: "/dashboard/setURLLog",
    //         type: "POST",
    //         data: data,
    //         dataType: "json",
    //         success: function(data) {
               
    //         }            
    //     });
    // });
    // $(document).on('click', '#dialog_survey_name a', function () {
        
    //     var data = {title:$('#dialog_survey_name a').attr("href"), id:$('#dialog_survey_id').text(), word:'Award: '};

    //     $.ajax({
    //         url: "/dashboard/setURLLog",
    //         type: "POST",
    //         data: data,
    //         dataType: "json",
    //         success: function(data) {
               
    //         }            
    //     });
    // });
    
   $('.other_filters_block h3').add('.deadline h3').click(function(){

        var orgDropDown = $(this).siblings('.org-body');
        if(orgDropDown.hasClass('visible')){
            orgDropDown.slideUp().removeClass('visible');
            $(this).removeClass('arrow-down');
        }else{
            $(this).addClass('arrow-down');
            orgDropDown.slideDown().addClass('visible');
        }

    }); 
    
});
