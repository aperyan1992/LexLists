/*
 * Scripts for "Dashboard" page
 */

$(document).ajaxStart(function() {
    $(".left-sidebar input:checkbox").prop("disabled", true);
});

$(document).ajaxStop(function() {
    $(".left-sidebar input:checkbox").prop("disabled", false);
});

$(document).ready(function() {
    var region_name = '';


    function initMapPopupWindow(element) {
        var myPos = { my: "center top", at: "center top+150", of: window };

        $("." + element).dialog({
            autoOpen: false,
            height: 'auto',
            width: 615,
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
    initMapPopupWindow("dialog_for_map");
    $('#vmap').vectorMap({
        map: 'usa_en',
        backgroundColor: 'lightgray',
        color: '#FFF',
        hoverColor: '#999999',
        selectedColor: '#666666',
        enableZoom: true,
        showTooltip: true,
        selectedRegion: 'MO'
    });
    $('.jsmapclick').click(function(){
        $('.dialog_for_map').dialog("open");

    });

    //west
    $('#jqvmap1_wy, #jqvmap1_wa, #jqvmap1_mt, #jqvmap1_id, #jqvmap1_or, #jqvmap1_ca, #jqvmap1_nv, #jqvmap1_ut, #jqvmap1_co, #jqvmap1_mt, #jqvmap1_nm, #jqvmap1_ak, #jqvmap1_hi, #jqvmap1_az').click(function(){
        $('#jqvmap1_wy, #jqvmap1_wa, #jqvmap1_mt, #jqvmap1_id, #jqvmap1_or, #jqvmap1_ca, #jqvmap1_nv, #jqvmap1_ut, #jqvmap1_co, #jqvmap1_mt, #jqvmap1_nm, #jqvmap1_ak, #jqvmap1_hi, #jqvmap1_az').css({"stroke":"#d95901", "stroke-width": "4px", "fill": "#ffa767"});

        $('#jqvmap1_nd, #jqvmap1_sd, #jqvmap1_ne, #jqvmap1_ks, #jqvmap1_mn, #jqvmap1_ia, #jqvmap1_mo, #jqvmap1_il, #jqvmap1_wi, #jqvmap1_mi, #jqvmap1_in, #jqvmap1_oh, #jqvmap1_mi ').css({"stroke":"#818181", "stroke-width": "4px", "fill": "white"});
        $('#jqvmap1_nj, #jqvmap1_pa, #jqvmap1_ny, #jqvmap1_vt, #jqvmap1_ct, #jqvmap1_ri, #jqvmap1_ma, #jqvmap1_nh, #jqvmap1_me').css({"stroke":"#818181", "stroke-width": "4px", "fill": "white"});
        $('#jqvmap1_tx, #jqvmap1_ok, #jqvmap1_la, #jqvmap1_ar, #jqvmap1_ms, #jqvmap1_fl, #jqvmap1_al, #jqvmap1_tn, #jqvmap1_ky, #jqvmap1_sc, #jqvmap1_va, #jqvmap1_wv, #jqvmap1_md, #jqvmap1_de, #jqvmap1_ga, #jqvmap1_nc').css({"stroke":"#818181", "stroke-width": "4px", "fill": "white"});

        region_name = "West";
        $('.region_title p').html("US West");
    });

    //midwest
    $('#jqvmap1_nd, #jqvmap1_sd, #jqvmap1_ne, #jqvmap1_ks, #jqvmap1_mn, #jqvmap1_ia, #jqvmap1_mo, #jqvmap1_il, #jqvmap1_wi, #jqvmap1_mi, #jqvmap1_in, #jqvmap1_oh, #jqvmap1_mi ').click(function(){
        $('#jqvmap1_nd, #jqvmap1_sd, #jqvmap1_ne, #jqvmap1_ks, #jqvmap1_mn, #jqvmap1_ia, #jqvmap1_mo, #jqvmap1_il, #jqvmap1_wi, #jqvmap1_mi, #jqvmap1_in, #jqvmap1_oh, #jqvmap1_mi ').css({"stroke":"#d95901", "stroke-width": "4px", "fill": "#ffa767"});

        $('#jqvmap1_wy, #jqvmap1_wa, #jqvmap1_mt, #jqvmap1_id, #jqvmap1_or, #jqvmap1_ca, #jqvmap1_nv, #jqvmap1_ut, #jqvmap1_co, #jqvmap1_mt, #jqvmap1_nm, #jqvmap1_ak, #jqvmap1_hi, #jqvmap1_az').css({"stroke":"#818181", "stroke-width": "4px", "fill": "white"});
        $('#jqvmap1_nj, #jqvmap1_pa, #jqvmap1_ny, #jqvmap1_vt, #jqvmap1_ct, #jqvmap1_ri, #jqvmap1_ma, #jqvmap1_nh, #jqvmap1_me').css({"stroke":"#818181", "stroke-width": "4px", "fill": "white"});
        $('#jqvmap1_tx, #jqvmap1_ok, #jqvmap1_la, #jqvmap1_ar, #jqvmap1_ms, #jqvmap1_fl, #jqvmap1_al, #jqvmap1_tn, #jqvmap1_ky, #jqvmap1_sc, #jqvmap1_va, #jqvmap1_wv, #jqvmap1_md, #jqvmap1_de, #jqvmap1_ga, #jqvmap1_nc').css({"stroke":"#818181", "stroke-width": "4px", "fill": "white"});

        region_name = "Midwest";
        $('.region_title p').html("US Midwest");
    });

    //north-east
    $('#jqvmap1_nj, #jqvmap1_pa, #jqvmap1_ny, #jqvmap1_vt, #jqvmap1_ct, #jqvmap1_ri, #jqvmap1_ma, #jqvmap1_nh, #jqvmap1_me').click(function(){
        $('#jqvmap1_nj, #jqvmap1_pa, #jqvmap1_ny, #jqvmap1_vt, #jqvmap1_ct, #jqvmap1_ri, #jqvmap1_ma, #jqvmap1_nh, #jqvmap1_me').css({"stroke":"#d95901", "stroke-width": "4px", "fill": "#ffa767"});

        $('#jqvmap1_nd, #jqvmap1_sd, #jqvmap1_ne, #jqvmap1_ks, #jqvmap1_mn, #jqvmap1_ia, #jqvmap1_mo, #jqvmap1_il, #jqvmap1_wi, #jqvmap1_mi, #jqvmap1_in, #jqvmap1_oh, #jqvmap1_mi ').css({"stroke":"#818181", "stroke-width": "4px", "fill": "white"});
        $('#jqvmap1_wy, #jqvmap1_wa, #jqvmap1_mt, #jqvmap1_id, #jqvmap1_or, #jqvmap1_ca, #jqvmap1_nv, #jqvmap1_ut, #jqvmap1_co, #jqvmap1_mt, #jqvmap1_nm, #jqvmap1_ak, #jqvmap1_hi, #jqvmap1_az').css({"stroke":"#818181", "stroke-width": "4px", "fill": "white"});
        $('#jqvmap1_tx, #jqvmap1_ok, #jqvmap1_la, #jqvmap1_ar, #jqvmap1_ms, #jqvmap1_fl, #jqvmap1_al, #jqvmap1_tn, #jqvmap1_ky, #jqvmap1_sc, #jqvmap1_va, #jqvmap1_wv, #jqvmap1_md, #jqvmap1_de, #jqvmap1_ga, #jqvmap1_nc').css({"stroke":"#818181", "stroke-width": "4px", "fill": "white"});

        region_name = "Northeast";
        $('.region_title p').html("US Northeast");
    });

    //south
    $('#jqvmap1_tx, #jqvmap1_ok, #jqvmap1_la, #jqvmap1_ar, #jqvmap1_ms, #jqvmap1_fl, #jqvmap1_al, #jqvmap1_tn, #jqvmap1_ky, #jqvmap1_sc, #jqvmap1_va, #jqvmap1_wv, #jqvmap1_md, #jqvmap1_de, #jqvmap1_ga, #jqvmap1_nc').click(function(){
        $('#jqvmap1_tx, #jqvmap1_ok, #jqvmap1_la, #jqvmap1_ar, #jqvmap1_ms, #jqvmap1_fl, #jqvmap1_al, #jqvmap1_tn, #jqvmap1_ky, #jqvmap1_sc, #jqvmap1_va, #jqvmap1_wv, #jqvmap1_md, #jqvmap1_de, #jqvmap1_ga, #jqvmap1_nc').css({"stroke":"#d95901", "stroke-width": "4px", "fill": "#ffa767"});

        $('#jqvmap1_nd, #jqvmap1_sd, #jqvmap1_ne, #jqvmap1_ks, #jqvmap1_mn, #jqvmap1_ia, #jqvmap1_mo, #jqvmap1_il, #jqvmap1_wi, #jqvmap1_mi, #jqvmap1_in, #jqvmap1_oh, #jqvmap1_mi ').css({"stroke":"#818181", "stroke-width": "4px", "fill": "white"});
        $('#jqvmap1_nj, #jqvmap1_pa, #jqvmap1_ny, #jqvmap1_vt, #jqvmap1_ct, #jqvmap1_ri, #jqvmap1_ma, #jqvmap1_nh, #jqvmap1_me').css({"stroke":"#818181", "stroke-width": "4px", "fill": "white"});
        $('#jqvmap1_wy, #jqvmap1_wa, #jqvmap1_mt, #jqvmap1_id, #jqvmap1_or, #jqvmap1_ca, #jqvmap1_nv, #jqvmap1_ut, #jqvmap1_co, #jqvmap1_mt, #jqvmap1_nm, #jqvmap1_ak, #jqvmap1_hi, #jqvmap1_az').css({"stroke":"#818181", "stroke-width": "4px", "fill": "white"});

        region_name = "South";
        $('.region_title p').html("US South");
    });


    var report_data_table = $("#report_surveys").dataTable({
        "sDom": '<"H"flr>t<"F"ip>',
        "bDestroy":true,
        "bJQueryUI": true,
        "bRetrieve": true,
        "aaSorting": [],
        "bProcessing": true,
        "sServerMethod": "POST",
        "sAjaxSource": "/dashboard/getSurveys",
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
            { "bVisible": false, "aTargets": [ 4,5,6,8,9,10,12,13,14 ] },
            { "bVisible": true, "aTargets": [ 0,1,2,3,7,11,15 ] },
            { "bSortable": false, "aTargets": [ 0,15 ] }
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

    $("#region_selected").on("click", function() {
        $('.region_checkbox').prop('checked',false);
        if(!$('input[value="US '+region_name+'"]').is(":checked"))
        {
            $('input[value="US '+region_name+'"]').click();
        }
        $('.dialog_for_map').dialog("close");

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
        showAndHideColumns(15, static_col_show_status, report_data_table);

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
                showAndHideColumns(15, true, report_data_table);

                showAndHideColumns(column_number, true, report_data_table);
            }
        });

        $("#display_form .not_default_display_checkbox").each(function() {
            if(this.checked) {
                this.checked = false;

                var column_number = $(this).attr("col_num");

                // Show static column
                showAndHideColumns(0, true, report_data_table);
                showAndHideColumns(15, true, report_data_table);

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
                showAndHideColumns(15, true, report_data_table);
                
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
                showAndHideColumns(15, false, report_data_table);
                
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
});

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

                case "next_quarter" :
                    var next_quarter    = Math.floor((current_date_object.getMonth() / 3));
                    var begin_date = new Date(current_date_object.getFullYear(), next_quarter * 3, 1);

                    //first_date  = dateFormat(begin_date, "dd-mmm-yyyy");
                    first_date   = dateFormat(new Date(begin_date.getFullYear(), begin_date.getMonth() + 3, 0), "dd-mmm-yyyy");
                    last_date   = dateFormat(new Date(begin_date.getFullYear(), begin_date.getMonth() + 6, 0), "dd-mmm-yyyy");

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