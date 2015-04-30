/* 
 * Scripts for work with filters
 */

$(document).ready(function() {

    

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

    $('#clear_filters').on('click', function(){
        var data = {title:$(this).text(), filter_action:'Left Sidebar Filter - '} ; 

        $.ajax({
            url: "/dashboard/setFilterLog",
            type: "POST",
            data: data,
            dataType: "json",
            success: function(data) {
               
            }            
        });
        
    });


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
            var data = {title:$(this).next().text(), filter_action:'Display Box Checked Filter - '} ;           
        }
        else
        {
            var data = {title:$(this).next().text(), filter_action:'Display Box Unchecked Filter - '};
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
            var data = {title:$(this).next().text(), filter_action:'Left Sidebar Checked Filter - '} ;           
        }
        else
        {
            var data = {title:$(this).next().text(), filter_action:'Left Sidebar Unchecked Filter - '};
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
