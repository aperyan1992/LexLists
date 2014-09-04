/* 
 * Scripts for work with filters
 */

$(document).ready(function() {
    
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
