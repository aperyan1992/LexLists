/*
 * Scripts for "My Lists" page
 */

$(document).ajaxStart(function() {
    $(".left-sidebar input:checkbox").prop("disabled", true);
});

$(document).ajaxStop(function() {
    $(".left-sidebar input:checkbox").prop("disabled", false);
});

$(document).ready(function() {

    $(document).on('click','.more',function(){        
        $(this).parent().next().show();
        $(this).parent().hide();
    });
    $(document).on('click','.less',function(){        
        $(this).parent().hide();
        $(this).parent().prev().show();
    });
    //var current_user_email_address ='';

var drop_down_menu_opened = false;
var drop_down_menu_closed = true;

    //****************** start calendar ************//

/*if( /iPhone|iPad|iPod/i.test(navigator.userAgent) ) {
    $('.dataTables_scrollBody').css({'overflow':'visible !important'});  
}*/


    var calendar = $("#calendar_div_my_list").calendar({
        events_source: '/mySurvey/calendarDates',
        tmpl_path: "/js/calendar/tmpls/",
        view: 'month',
        tmpl_cache: false,
        day: 'now',
        onAfterEventsLoad: function(events) {
            if(!events) {
                return;
            }
            var list = $('#eventlist');
            list.html('');

            $.each(events, function(key, val) {
                $(document.createElement('li'))
                    .html('<a href="' + val.url + '">' + val.title + '</a>')
                    .appendTo(list);
            });
        },
        onAfterViewLoad: function(view) {
            $('.page-header h3').text(this.getTitle());
            $('.btn-group button').removeClass('active');
            $('button[data-calendar-view="' + view + '"]').addClass('active');
        },
        classes: {
            months: {
                general: 'label'
            }
        }
    });


    (function($) {

        $('.btn-group button[data-calendar-nav]').each(function() {
            var $this = $(this);
            $this.click(function() {
                calendar.navigate($this.data('calendar-nav'));
            });
        });

        $('.btn-group button[data-calendar-view]').each(function() {
            var $this = $(this);
            $this.click(function() {
                calendar.view($this.data('calendar-view'));
            });
        });

        $('#first_day').change(function(){
            var value = $(this).val();
            value = value.length ? parseInt(value) : null;
            calendar.setOptions({first_day: value});
            calendar.view();
        });

        $('#language').change(function(){
            calendar.setLanguage($(this).val());
            calendar.view();
        });

        $('#events-in-modal').change(function(){
            var val = $(this).is(':checked') ? $(this).val() : null;
            calendar.setOptions({modal: val});
        });
        $('#events-modal .modal-header, #events-modal .modal-footer').click(function(e){
            //e.preventDefault();
            //e.stopPropagation();
        });
    }(jQuery));

    //dialog for calendar
    function initCalendarPopupWindow(element) {

        var myPos = { my: "center top", at: "center top+20", of: window };

        $("." + element).dialog({
            autoOpen: false,
            height: 'auto',
            width: 1000,
            modal: true,
            position:myPos,
            open: function() {
            },
            close: function() {
                $(this).dialog("close");
            }
        });
        $('.close_btn').on('click', function(){
            $("#" + element).dialog("close");
        });
    }
    initCalendarPopupWindow("dialog_for_calendar_my_list");

    $('.calendar_link').click(function(){
        $('#calendar_div').show();

        $('.dialog_for_calendar_my_list').dialog("option", "title", "LexLists: Calendar Deadlines" );

        $('.dialog_for_calendar_my_list').dialog("open");

    });





    //****************** end calendar ************//

    //hide last empty checkbox
    $('.region .org-body form input').each(function(){
        if(!$(this).attr('value'))
        {
            $(this).hide();
        }
    });

    $('.organization .org-body form input').each(function(){
        if(!$(this).attr('value'))
        {
            $(this).hide();
            $('.organization .org-body form').css({"margin-top":'-18px'});
        }
    });
    $("#report_surveys").show();
    var report_data_table = $("#report_surveys").dataTable({
        "sDom": '<"H"flr>t<"F"ip>',
        "bDestroy":true,
        "bJQueryUI": true,
        "bRetrieve": true,
        "aaSorting": [],
        "bProcessing": true,
        "sServerMethod": "POST",
        "sAjaxSource": "/mySurvey/getMySurveys",
        "bDeferRender": true,
        "iDisplayLength": 25,
        "aLengthMenu": [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, "All"]
        ],
        "sScrollX": "100%",
        "bScrollCollapse": true,
        "oLanguage": {
            "sInfo"      : "_END_ of _TOTAL_ entries",
            "sInfoEmpty" : "_END_ of _TOTAL_ entries",
            "sLengthMenu": "Display _MENU_"
        },
        "aoColumnDefs": [
            { "sClass": "datatable_td_align_center_checkboxes", "aTargets": [0]},
            { "sClass": "datatable_td_align_center", "aTargets": ["_all"]},            
            { "bVisible": false, "aTargets": [ 4,5,6,8,9,10,12,14,15,16 ] },
            { "bVisible": true, "aTargets": [ 0,1,2,3,7,11,13 ] },
            { "bSortable": false, "aTargets": [ 0 ] }
        ]

    });
    
    /**
     *  Add tooltip for search field in dataTable
     */
    $("#report_surveys_filter").find("label").attr("title", "Enter a keyword of interest (ex. Litigation) to refine the results.");

    // Filtering
    $(".other_filters_block input:checkbox").change(function() {
        filterByOtherParameters(report_data_table, $(this));                    
    });

    $(".deadline input:checkbox").on("change", function() {      
        if($(this).is(":checked")) {
            $(".deadline input:checkbox").prop("checked", false);
            $(this).prop("checked", true);
        } else {
            $(this).prop("checked", false);
            $(".deadline input:checkbox").prop("checked", false);                
        }
        
        report_data_table.fnDraw();
    });
    // End of filtering

    /**
     *  Display/Hide Columns
     */
    $("#display_form input:checkbox").change(function() {
        $("#change_data_table").val(0);
        
        var checked_count = 0;
        $("#display_form input:checkbox:checked").each(function(index, element) {
            checked_count++;
        });
        
        var report_data_table = $("#report_surveys").dataTable();
        
        var column_number = $(this).attr("col_num");
        var show_status   = $(this).is(":checked");

        // Get show status for static columns
        var static_col_show_status = true;
        if(checked_count == 0) {
            static_col_show_status = false;
        }   
        
        // Show/Hide static column
        showAndHideColumns(0, static_col_show_status, report_data_table);
        showAndHideColumns(13, static_col_show_status, report_data_table);
        //showAndHideColumns(17, static_col_show_status, report_data_table);

        showAndHideColumns(column_number, show_status, report_data_table); 
    });

    /**
     *  Display management links
     */
    $("#default_display").click(function() {
        $("#display_form .default_display_checkbox").each(function() {
            if(this.checked == false) {
                this.checked = true;

                var column_number = $(this).attr("col_num");

                // Show static column
                showAndHideColumns(0, true, report_data_table);
                showAndHideColumns(13, true, report_data_table);
                //showAndHideColumns(17, true, report_data_table);

                showAndHideColumns(column_number, true, report_data_table);
            }
        });

        $("#display_form .not_default_display_checkbox").each(function() {
            if(this.checked) {
                this.checked = false;

                var column_number = $(this).attr("col_num");

                // Show static column
                showAndHideColumns(0, true, report_data_table);
                showAndHideColumns(13, true, report_data_table);
                //showAndHideColumns(17, true, report_data_table);

                showAndHideColumns(column_number, false, report_data_table);
            }
        });

        return false;
    }); 

    $("#select_all_display").click(function() {
        $("#display_form input:checkbox").each(function() {
            if(this.checked == false) {
                this.checked = true;

                var column_number = $(this).attr("col_num");

                // Show static column
                showAndHideColumns(0, true, report_data_table);
                showAndHideColumns(13, true, report_data_table);
                //showAndHideColumns(17, true, report_data_table);
                
                // Show other columns
                showAndHideColumns(column_number, true, report_data_table);
            }
        });

        return false;
    });

    $("#clear_all_display").click(function() {
        $("#display_form input:checkbox").each(function() {
            if(this.checked) {
                this.checked = false;

                var column_number = $(this).attr("col_num");
                
                // Hide static column
                showAndHideColumns(0, false, report_data_table);
                showAndHideColumns(13, false, report_data_table);
                //showAndHideColumns(17, false, report_data_table);
                
                // Hide other columns
                showAndHideColumns(column_number, false, report_data_table);
            }
        });

        return false;
    });
    
    /**
     *  Construction of hidden filter form
     */    
    $(document).on("change", ".other_filters_block input:checkbox", function() {
        var filter_value = $(this).val();
        
        if(this.checked) {
            addCheckboxHiddenFilter($(this).attr("checkbox_type"), filter_value, true);
        } else {
            addCheckboxHiddenFilter($(this).attr("checkbox_type"), filter_value, false);
        }        
    });
    
    $(document).on("change", ".deadline_checkbox", function() {
        if(this.checked) {
            addDeadlineCheckboxHiddenFilter($(this).attr("checkbox_type"), $(this).attr("id"), true);
        } else {
            addDeadlineCheckboxHiddenFilter($(this).attr("checkbox_type"), $(this).attr("id"), false);
        }        
    });
    
    /**
     * Clear filters
     */
    $(document).on("click", "#clear_filters", function() {
        // Clear filter checkboxes
        $(".other_filters_block input:checkbox, .deadline input:checkbox").prop("checked", false);
        
        // Clear hidden filters
        $("#hidden_filters_block select").html('<option value="0"></option>');
        
        // Reset filters
        report_data_table.fnFilter('');
        var colCount = report_data_table.fnGetData(0).length;
        for (var i = 0; i <= colCount; i++) {
            report_data_table.fnFilter('', i);
        }

        return false;
    })
    /**
     * End of "Clear filters"
     */
    
    /**
     * DataTable checkboxes functionality
     */
    $(document).on("change", "#table_checkbox_select_all", function() {
      var check_status = $(this).is(":checked");
      
      $(".table_checkbox").prop("checked", check_status);
      
      return false;
    })
    /**
     * End of "DataTable checkboxes functionality"
     */
    
    /**
     *  Remove my survey from "My Lists" section
     */
    $(document).on("click", ".my_list_remove_survey", function() {
        var current_element  = $(this),
            my_survey_id     = current_element.attr("ms_id"),
            is_updated_flag  = current_element.attr("updated"),
            is_past_due_flag = current_element.attr("past_due"),
            parent_tr        = current_element.parents("tr").get(0),
            parent_tr_number = report_data_table.fnGetPosition(parent_tr);
        
        $("#admin_remove_my_survey_info")
                .attr("ms_id", my_survey_id)
                .attr("tr_number", parent_tr_number)
                .attr("is_updated", is_updated_flag)
                .attr("is_past_due", is_past_due_flag);
        
        $("#dialog_remove_my_survey_cofirm_alert").dialog("open");
        
        $(this).parents('ul.menu-dropdown').slideToggle();
        
        return false;
    });
    /**
     *  END
     */
    
    /**
     *  Click on bubbles in result table
     */
    $(document).on("click", ".table_bubble", function() {
        var current_element = $(this),
            bubble_type     = current_element.attr("bubble_type"),
            my_survey_id    = current_element.attr("ms_id");
            
        // Set flag to false in database
        setFlagOfMySurvey(my_survey_id, bubble_type, 0);    
        
        // Remove bubble
        current_element.remove();
    });
    /**
     *  END
     */

    /**
     *  Menu in result table
     */
    $(document).on('click', '.menu-drop-wrapper .menu_link', function(e) {
        e.preventDefault();
        

       


        //if($('.menu-dropdown').is(':hidden')){
            //$(this).siblings('.menu-dropdown').slideToggle(1);
        //}


 //drop-down menu for ipad
        //if( /iPhone|iPad|iPod/i.test(navigator.userAgent) ) {
            if(drop_down_menu_closed || !drop_down_menu_opened)
            {
                $(this).parent().find('.menu-dropdown').slideDown();
                drop_down_menu_opened = true;
                drop_down_menu_closed = false;
                if( /iPhone|iPad|iPod/i.test(navigator.userAgent) )
                {
                    $('.dataTables_scrollBody').css({"overflow":"visible"});
                }
            }
            else
            {
                $(this).parent().find('.menu-dropdown').slideUp();  
                drop_down_menu_closed = true;  
                drop_down_menu_opened = false;          
                $('.dataTables_scrollBody').css({"overflow":"auto"});
            }
        //}


       

        /*setTimeout(function(){ 
            if($('.menu-dropdown').is(':hidden')){
                alert('vis');
                $('.dataTables_scrollBody').css({"overflow":"visible"});
            }
            else
            {
                alert('auto')
                $('.dataTables_scrollBody').css({"overflow":"auto"});    
            }
        }, 2000);*/
        
        

                    
        makeMenusFixed();

        
        /*(function (elem) {
            var menu_hidden  = $(elem).siblings('.menu-dropdown:hidden');
                console.log(menu_hidden.length);
            if (menu_hidden.length > 0) {
                $('.menu-dropdown').hide();
                menu_hidden.slideDown();

                menu_hidden.mouseleave(function () {
                    menu_hidden.slideUp();
                });
            }
                
        })($(this));*/
        
    });

    /*$('body').on('click', function(){
        if ($('.menu-dropdown').css('display') == 'block' ) {
            $('.menu-dropdown').each(function(){
                $(this).slideUp();
            });
        }
    });*/

    /**
     *  END
     */
    $(document).on('mouseleave', '.menu-drop-wrapper', function(e) {
        if(!$('.menu-dropdown',this).is(':hidden')){
            $('.menu-dropdown',this).slideUp();
            drop_down_menu_closed = true;
            drop_down_menu_opened = false;
      
        }
    });

    /**
     *  Dynamic calculation of menu in result table
     */
    makeMenusFixed();
    $(window).scroll(function() {
        makeMenusFixed();
    });

    $(window).resize(function(){
        makeMenusFixed();
    });
    /**
     *  END
     */
});

function isHoverMyListMenu(element) {
    return element.is(':hover');
}

/**
 *  Dynamic calculation of menu width in result table
 */
function makeMenusFixed() {
    $('.menu_link').each(function(){
        var menuLinkTopPos = $(this).offset().top - $(window).scrollTop();
        var menuLinkLeftPos = $(this).offset().left;
        $(this).siblings('.menu-dropdown').css({
            'top': menuLinkTopPos + 'px',
            'left': menuLinkLeftPos +190+ 'px',
            'marginTop' : '15px'
        });
    });
}

/**
 * Save flag(is_updated|is_deadline_past) of my survey in database
 * 
 * @param {integer}     my_survey_id        IF of my survey
 * @param {string}      bubble_type         Type of bubble
 * @param {integer}     flag                Flag (0|1)
 */
function setFlagOfMySurvey(my_survey_id, bubble_type, flag) {
    $.ajax({
        url: "/mySurvey/setFlagByClick",
        type: "POST",
        data: {
            my_survey_id: my_survey_id,
            bubble_type : bubble_type,
            flag        : 0
        },
        dataType: "json",
        async: false,
        success: function(data) {
            // Decrease number in main bubble
            var main_bubble = $("#my_surveys_" + bubble_type + "_amount"),
                new_number  = parseInt(main_bubble.text()) - 1;

            main_bubble.text(new_number);

            if (new_number === 0) {
                main_bubble.addClass("hide");

                if (bubble_type === "past_dues") {
                    $("#my_surveys_updated_amount").removeClass("from-left");
                }
            }                
        },
        error: function() {
            openErrorPopupWindow("dialog_error_alert", "Error !!!");
        }
    });
}

/**
 * Filtering by other parameters
 * 
 * @param {object} data_table       DataTable object
 * @param {object} element          Filter element object
 */
function filterByOtherParameters(data_table, element) {
    var filter_column = "0";
    if($("#change_data_table").val() == "0") {
        filter_column = element.attr("col_num");
    }

    var current_class = element.attr("class");

    var filter_value = $('.' + current_class + ':checked').map(function () {
        return this.value;
    }).toArray().join('|');

    if($("#change_data_table").val() == "1" && $("#filter_year").val() != "0") {
        if(filter_value == "") {
            filter_value = $("#filter_year").val();
        } else {
            filter_value = filter_value + '|' + $("#filter_year").val();
        }
    }

    filterReportDataTable(data_table, filter_value, filter_column);
}

/**
 * Add hidden filter for deadline field
 * 
 * @param {string}  hidden_filter_id                ID of filter field
 * @param {string}  hidden_filter_value             Value of filter field
 * @param {bool}    hidden_filter_selected_flag     Selected flag for filter field
 */
function addDeadlineCheckboxHiddenFilter(hidden_filter_id, hidden_filter_value, hidden_filter_selected_flag) {
    if(hidden_filter_selected_flag) {
        $("#filter_" + hidden_filter_id).html('<option value="' + hidden_filter_value + '" selected="selected">' + hidden_filter_value + '</option>');
    } else {
        $("#filter_" + hidden_filter_id).html('<option value=""></option>');
    }        
}

/**
 * Add hidden filter for fields
 * 
 * @param {string}  hidden_filter_id                ID of filter field
 * @param {string}  hidden_filter_value             Value of filter field
 * @param {bool}    hidden_filter_selected_flag     Selected flag for filter field
 */
function addCheckboxHiddenFilter(hidden_filter_id, hidden_filter_value, hidden_filter_selected_flag) {
    if(hidden_filter_selected_flag) {
        if($("#filter_" + hidden_filter_id + " option[value='" + hidden_filter_value + "']").val() == undefined) {
            $("#filter_" + hidden_filter_id).append('<option value="' + hidden_filter_value + '" selected="selected">' + hidden_filter_value + '</option>');
        }
    } else {
        $("#filter_" + hidden_filter_id + " option[value='" + hidden_filter_value + "']").remove();
    }        
}

/**
 * Show/Hide columns
 *  
 * @param {integer}     column_number       Number of column
 * @param {bool}        show_status         Show status
 * @param {object}      report_data_table   Object of data table
 */
function showAndHideColumns(column_number, show_status, report_data_table) {
    var bVis = report_data_table.fnSettings().aoColumns[column_number].bVisible;
    
    if((show_status && !bVis) || (!show_status && bVis)) {
        report_data_table.fnSetColumnVis(column_number, show_status);
    }
}

/**
 * Filtering of report table
 * 
 * @param {object}  filter_data_table       Object of data table
 * @param {string}  filter_value            Filter value
 * @param {integer} filter_column           Filter column
 */
function filterReportDataTable(filter_data_table, filter_value, filter_column) {
    filter_data_table.fnFilter( filter_value, filter_column, true, false );
}

$.fn.dataTableExt.afnFiltering.push(
    function( oSettings, aData, iDataIndex ) {
        if($(".deadline_checkbox:checked").val() != undefined) {
            var current_date_object = new Date();
            
            var first_date, last_date;
            
            switch($(".deadline_checkbox:checked").val()) {
                case "this_month" :
                    first_date = dateFormat(new Date(current_date_object.getFullYear(), current_date_object.getMonth(), 1), "dd-mmm-yyyy");
                    last_date  = dateFormat(new Date(current_date_object.getFullYear(), current_date_object.getMonth() + 1, 0), "dd-mmm-yyyy");

                    break;
                case "this_quarter" :                  
                    var quarter    = Math.floor((current_date_object.getMonth() / 3));
                    var begin_date = new Date(current_date_object.getFullYear(), quarter * 3, 1);
                    
                    first_date  = dateFormat(begin_date, "dd-mmm-yyyy");
                    last_date   = dateFormat(new Date(begin_date.getFullYear(), begin_date.getMonth() + 3, 0), "dd-mmm-yyyy");

                    break;
                case "this_year" :
                    var current_year = current_date_object.getFullYear();
                    first_date       = dateFormat(new Date( current_year, 0, 1 ), "dd-mmm-yyyy");
                    last_date        = dateFormat(new Date( current_year + 1, 0, 0 ), "dd-mmm-yyyy");

                    break;
                case "next_year" :
                    var next_year = current_date_object.getFullYear() + 1;
                    first_date    = dateFormat(new Date( next_year, 0, 1 ), "dd-mmm-yyyy");
                    last_date     = dateFormat(new Date( next_year + 1, 0, 0 ), "dd-mmm-yyyy");

                    break;
            }
            
            if(aData[11] !== '- - -' && new Date(Date.fromString(aData[11])).getTime() >= new Date(Date.fromString(first_date)).getTime() && new Date(Date.fromString(aData[11])).getTime() <= new Date(Date.fromString(last_date)).getTime()) {
                return true;
            }

        } else {
            return true;
        }

        return false;
    }
);