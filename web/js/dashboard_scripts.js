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
    $(document).on('click','input[value="US (All States)"]',function(){
        var arrUS = ['US Mid-Atlantic','US Midwest','US Northeast','US South','US West'];
        if($(this).is(':checked'))
        {
            $(arrUS).each(function(key, value){
                console.log($('input[value="'+value+'"]'));
                $('input[value="'+value+'"]').prop("checked", true) ;
            });
        }
        else
        {
            $(arrUS).each(function(key, value){
                $('input[value="'+value+'"]').prop("checked", false) ;
            });
        }
    })

    $('#report_surveys').on( 'ini' +
        't.dt', function () {

        oTable = $('#report_surveys').dataTable();



        /* Filter immediately */
        var year = new Date().getFullYear();
        oTable.fnFilter( year, 1 );
        oTable.fnFilter( 'Legal', 15 );
        $("#"+year).prop( "checked", true );
        $(".is_legal_checkbox:first-child").prop( "checked", true );
    });

    $(document).on('click', '#dialog_organization a', function () {
        
        var data = {title:$('#dialog_organization a').attr("href"), id:$('#dialog_survey_id').text(), word:'Organization: '};

        $.ajax({
            url: "/dashboard/setURLLog",
            type: "POST",
            data: data,
            dataType: "json",
            success: function(data) {
               
            }            
        });
    });  

    $(document).on('click', '#dialog_survey_name a', function () {
        
        var data = {title:$('#dialog_survey_name a').attr("href"), id:$('#dialog_survey_id').text(), word:'Award: '};

        $.ajax({
            url: "/dashboard/setURLLog",
            type: "POST",
            data: data,
            dataType: "json",
            success: function(data) {
               
            }            
        });
    });

    $(document).on('click','.more',function(){        
        $(this).parent().next().show();
        $(this).parent().hide();
    });
    $(document).on('click','.less',function(){        
        $(this).parent().hide();
        $(this).parent().prev().show();
    });
    $('.year div').show();
    $('.area_legal_business div').show();


    //*************************** Calendar start *****************************//

    var calendar = $("#calendar_div").calendar({
        events_source: '/dashboard/calendarDates',
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

    //*********************** calendar end **********************************//


//hide first empty checkbox
    $('.region .org-body form input').each(function(){
        if(!$(this).attr('value'))
        {
            $(this).hide();
            $('.region .org-body form').css({"margin-top":'-18px'});
        }
    });

    $('.organization .org-body form input').each(function(){
        if(!$(this).attr('value'))
        {
            $(this).hide();
            $('.organization .org-body form').css({"margin-top":'-18px'});
        }
    });


    var region_name = [];
    var region_name_us = [];
    var region_title = [];
    var first = 0;
    var first_m = 0;
    var first_ctrl = 0;
    $('.region_title p').html('');
    var selected_reg_north_america = false;
    var selected_reg_south_america = false;
    var selected_reg_europe = false;
    var selected_reg_asia = false;
    var selected_reg_africa = false;
    var selected_reg_australia = false;

    var sel = [];
    var state_idx = 0;


    $('#container').hide();
    $('#container_us').hide();
    $('#container_us_states').hide();
    $('#calendar_div').hide();

    $('#us_west').hide();
    $('#small_us_west').hide();
    $('#us_south').hide();
    $('#midwest').hide();
    $('#northeast').hide();
    $('#mid_atlantic').hide();

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
    initCalendarPopupWindow("dialog_for_calendar");


    //dialog for map
    function initMapPopupWindow(element) {

        var myPos = { my: "center top", at: "center top+20", of: window };

        $("." + element).dialog({
            autoOpen: false,
            height: 'auto',
            width: 815,
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


    //
    $('.calendar_link').click(function(){

        // var data = {title:"Calendar"};
        // $.ajax({
        //     url: "/dashboard/calendar",
        //     type: "POST",
        //     data: data,
        //     dataType: "json",
        //     success: function(data) {
               
        //     }            
        // });

        $('#calendar_div').show();

        $('.dialog_for_calendar').dialog("option", "title", "LexLists: Calendar Deadlines" );



        $('.dialog_for_calendar').dialog("open");


    });
    //


//******* start world map *******//
    $('.jsmapclick').click(function(){
        $('.state_line_NH').hide();
        $('.state_line_MA').hide();
        $('.state_line_RI').hide();
        $('.state_line_CT').hide();
        $('.state_line_NJ').hide();
        $('.state_line_DE').hide();
        $('.state_line_MD').hide();
        $('.state_line_DC').hide();
        $('.state_line_DC_letters').hide();
        $('.dc_transparent').hide();
        $('.dc_blue').hide();
        $('.dc_orange').hide();
        $('.dc_hover').hide();


        $('.dialog_for_map').dialog("option", "title", "LexLists: World Regions" );

        $('#container').show();
        $('#container_us').hide();
        $('#container_us_states').hide();

        $('#us_west').hide();
        $('#small_us_west').hide();
        $('#us_south').hide();
        $('#midwest').hide();
        $('#northeast').hide();

        $(function () {


            // Prepare demo data
            var data = [
                {
                    "hc-key": "eu",
                    "value": 0
                },
                {
                    "hc-key": "oc",
                    "value": 1
                },
                {
                    "hc-key": "af",
                    "value": 2
                },
                {
                    "hc-key": "as",
                    "value": 3
                },
                {
                    "hc-key": "na",
                    "value": 4
                },
                {
                    "hc-key": "sa",
                    "value": 5
                }
            ];

            // Initiate the chart
            $('#container').highcharts('Map', {

                title : {
                    text : ''
                },

                mapNavigation: {
                    enabled: false,
                    buttonOptions: {
                        verticalAlign: 'bottom'
                    }
                },

                colorAxis: {
                    min: 0
                },
                exporting: {
                    buttons: {

                        exportButton: {
                            enabled: false
                        },
                        printButton: {
                            enabled: false
                        }
                    }

                },

                series : [{
                    data : data,
                    mapData: Highcharts.maps['custom/world-continents'],
                    joinBy: 'hc-key',
                    color: 'red',
                    /*name: 'Region',*/
                    states: {
                        hover: {

                            color: '#ffa767'
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        format: '{point.name}'
                    }

                }]
            });
        });


        $('.dialog_for_map').dialog("open");

        $('.highcharts-legend').hide();
        $('.highcharts-button').hide();

        $('.highcharts-name-north-america, .highcharts-name-south-america, .highcharts-name-europe, .highcharts-name-asia, .highcharts-name-africa, .highcharts-name-australia').css({"fill": "#57A0C2"});

        $('.highcharts-name-north-america').click(function(e){
            $('.highcharts-name-north-america').css({"fill": "#ffa767"});
            var isCtrlPressed_north_america = e.ctrlKey;

            if(selected_reg_north_america == true && !isCtrlPressed_north_america)
            {
                selected_reg_north_america = false;
                $('.highcharts-name-north-america').css({"fill": "#57A0C1"});
                var idx_name = region_name.indexOf("North America");
                if (idx_name != -1) {
                    region_name.splice(idx_name, 1);
                }
            }
            else
            {
                var data = {title:'North America', search:'Search World Regions Map: '};
                $.ajax({
                    url: "/dashboard/setWorldRegionsMapsLog",
                    type: "POST",
                    data: data,
                    dataType: "json",
                    success: function(data) {
                       
                    }            
                });

                selected_reg_north_america = true;

                if(isCtrlPressed_north_america && first_m!=0)
                {selected_reg_north_america = true;
                    if($.inArray("North America", region_name) == -1)
                    {
                        $('.highcharts-name-north-america').css({"fill": "#ffa767"});
                        region_name.push("North America");
                    }
                    else
                    {
                        $('.highcharts-name-north-america').css({"fill": "#57A0C1"});
                        var idx_name = region_name.indexOf("North America");
                        if (idx_name != -1) {
                            region_name.splice(idx_name, 1);
                        }
                    }
                }
                else
                {
                    first_m++;
                    selected_reg_north_america = true;
                    $('.highcharts-name-north-america').css({"fill": "#ffa767"});
                    $('.highcharts-name-australia').css({"fill": "#57A0C1"});
                    $('.highcharts-name-south-america').css({"fill": "#57A0C1"});
                    $('.highcharts-name-europe').css({"fill": "#57A0C1"});
                    $('.highcharts-name-asia').css({"fill": "#57A0C1"});
                    $('.highcharts-name-africa').css({"fill": "#57A0C1"});

                    region_name = [];
                    region_name[0] = "North America";
                }
            }
        });

        $('.highcharts-name-south-america').click(function(e){
            $('.highcharts-name-south-america').css({"fill": "#ffa767"});
            var isCtrlPressed_south_america = e.ctrlKey;

            if(selected_reg_south_america == true && !isCtrlPressed_south_america)
            {
                selected_reg_south_america = false;
                $('.highcharts-name-south-america').css({"fill": "#57A0C1"});
                var idx_name = region_name.indexOf("South America");
                if (idx_name != -1) {
                    region_name.splice(idx_name, 1);
                }
            }
            else
            {
                var data = {title:'South America', search:'Search World Regions Map: '};
                $.ajax({
                    url: "/dashboard/setWorldRegionsMapsLog",
                    type: "POST",
                    data: data,
                    dataType: "json",
                    success: function(data) {
                       
                    }            
                });

                selected_reg_south_america = true;

                if(isCtrlPressed_south_america && first_m!=0)
                {
                    selected_reg_south_america = true;
                    if($.inArray("South America", region_name) == -1)
                    {
                        $('.highcharts-name-south-america').css({"fill": "#ffa767"});
                        region_name.push("South America");
                    }
                    else
                    {
                        $('.highcharts-name-south-america').css({"fill": "#57A0C1"});

                        var idx_name = region_name.indexOf("South America");
                        if (idx_name != -1) {
                            region_name.splice(idx_name, 1);
                        }
                    }
                }
                else
                {
                    first_m++;
                    selected_reg_south_america = true;
                    $('.highcharts-name-south-america').css({"fill": "#ffa767"});
                    $('.highcharts-name-north-america').css({"fill": "#57A0C1"});
                    $('.highcharts-name-australia').css({"fill": "#57A0C1"});
                    $('.highcharts-name-europe').css({"fill": "#57A0C1"});
                    $('.highcharts-name-asia').css({"fill": "#57A0C1"});
                    $('.highcharts-name-africa').css({"fill": "#57A0C1"});

                    region_name = [];
                    region_name[0] = "South America";
                }
            }
        });

        $('.highcharts-name-europe').click(function(e){
            $('.highcharts-name-europe').css({"fill": "#ffa767"});
            var isCtrlPressed_europe = e.ctrlKey;
            if(selected_reg_europe == true && !isCtrlPressed_europe)
            {
                selected_reg_europe = false;
                $('.highcharts-name-europe').css({"fill": "#57A0C1"});
                var idx_name = region_name.indexOf("Europe");
                if (idx_name != -1) {
                    region_name.splice(idx_name, 1);
                }
            }
            else
            {
                var data = {title:'Europe', search:'Search World Regions Map: '};
                $.ajax({
                    url: "/dashboard/setWorldRegionsMapsLog",
                    type: "POST",
                    data: data,
                    dataType: "json",
                    success: function(data) {
                       
                    }            
                });

                selected_reg_europe = true;

                if(isCtrlPressed_europe && first_m!=0)
                {
                    selected_reg_europe = true;
                    if($.inArray("Europe", region_name) == -1)
                    {
                        $('.highcharts-name-europe').css({"fill": "#ffa767"});
                        region_name.push("Europe");
                    }
                    else
                    {
                        $('.highcharts-name-europe').css({"fill": "#57A0C1"});

                        var idx_name = region_name.indexOf("Europe");
                        if (idx_name != -1) {
                            region_name.splice(idx_name, 1);
                        }
                    }
                }
                else
                {
                    first_m++;
                    selected_reg_europe = true;
                    $('.highcharts-name-europe').css({"fill": "#ffa767"});
                    $('.highcharts-name-north-america').css({"fill": "#57A0C1"});
                    $('.highcharts-name-south-america').css({"fill": "#57A0C1"});
                    $('.highcharts-name-asia').css({"fill": "#57A0C1"});
                    $('.highcharts-name-africa').css({"fill": "#57A0C1"});
                    $('.highcharts-name-australia').css({"fill": "#57A0C1"});

                    region_name = [];
                    region_name[0] = "Europe";
                }
            }
        });

        $('.highcharts-name-asia').click(function(e){
            $('.highcharts-name-asia').css({"fill": "#ffa767"});
            var isCtrlPressed_asia = e.ctrlKey;
            if(selected_reg_asia == true && !isCtrlPressed_asia)
            {
                selected_reg_asia = false;
                $('.highcharts-name-asia').css({"fill": "#57A0C1"});
                var idx_name = region_name.indexOf("Asia");
                if (idx_name != -1) {
                    region_name.splice(idx_name, 1);
                }
            }
            else
            {
                var data = {title:'Asia', search:'Search World Regions Map: '};
                $.ajax({
                    url: "/dashboard/setWorldRegionsMapsLog",
                    type: "POST",
                    data: data,
                    dataType: "json",
                    success: function(data) {
                       
                    }            
                });

                selected_reg_asia = true;

                if(isCtrlPressed_asia && first_m!=0)
                {
                    selected_reg_asia = true;
                    if($.inArray("Asia", region_name) == -1)
                    {
                        $('.highcharts-name-asia').css({"fill": "#ffa767"});
                        region_name.push("Asia");
                    }
                    else
                    {
                        $('.highcharts-name-asia').css({"fill": "#57A0C1"});
                        var idx_name = region_name.indexOf("Asia");
                        if (idx_name != -1) {
                            region_name.splice(idx_name, 1);
                        }
                    }
                }
                else
                {
                    first_m++;
                    selected_reg_asia = true;
                    $('.highcharts-name-asia').css({"fill": "#ffa767"});
                    $('.highcharts-name-north-america').css({"fill": "#57A0C1"});
                    $('.highcharts-name-south-america').css({"fill": "#57A0C1"});
                    $('.highcharts-name-europe').css({"fill": "#57A0C1"});
                    $('.highcharts-name-africa').css({"fill": "#57A0C1"});
                    $('.highcharts-name-australia').css({"fill": "#57A0C1"});

                    region_name = [];
                    region_name[0] = "Asia";
                }
            }
        });

        $('.highcharts-name-africa').click(function(e){
            $('.highcharts-name-africa').css({"fill": "#ffa767"});
            var isCtrlPressed_africa = e.ctrlKey;
            if(selected_reg_africa == true && !isCtrlPressed_africa)
            {
                selected_reg_africa = false;
                $('.highcharts-name-africa').css({"fill": "#57A0C1"});
                var idx_name = region_name.indexOf("Africa");
                if (idx_name != -1) {
                    region_name.splice(idx_name, 1);
                }
            }
            else
            {
                var data = {title:'Africa', search:'Search World Regions Map: '};
                $.ajax({
                    url: "/dashboard/setWorldRegionsMapsLog",
                    type: "POST",
                    data: data,
                    dataType: "json",
                    success: function(data) {
                       
                    }            
                });

                selected_reg_africa = true;
                if(isCtrlPressed_africa && first_m!=0)
                {
                    selected_reg_africa = true;
                    if($.inArray("Africa", region_name) == -1)
                    {
                        $('.highcharts-name-africa').css({"fill": "#ffa767"});
                        region_name.push("Africa");
                    }
                    else
                    {
                        $('.highcharts-name-africa').css({"fill": "#57A0C1"});
                        var idx_name = region_name.indexOf("Africa");
                        if (idx_name != -1) {
                            region_name.splice(idx_name, 1);
                        }
                    }
                }
                else
                {

                    first_m++;
                    selected_reg_africa = true;
                    $('.highcharts-name-africa').css({"fill": "#ffa767"});
                    $('.highcharts-name-north-america').css({"fill": "#57A0C1"});
                    $('.highcharts-name-south-america').css({"fill": "#57A0C1"});
                    $('.highcharts-name-europe').css({"fill": "#57A0C1"});
                    $('.highcharts-name-asia').css({"fill": "#57A0C1"});
                    $('.highcharts-name-australia').css({"fill": "#57A0C1"});

                    region_name = [];
                    region_name[0] = "Africa";
                }
            }
        });

        $('.highcharts-name-australia').click(function(e){
            $('.highcharts-name-australia').css({"fill": "#ffa767"});
            var isCtrlPressed_australia = e.ctrlKey;
            if(selected_reg_australia == true && !isCtrlPressed_australia)
            {
                selected_reg_australia = false;
                $('.highcharts-name-australia').css({"fill": "#57A0C1"});
                var idx_name = region_name.indexOf("Australia");
                if (idx_name != -1) {
                    region_name.splice(idx_name, 1);
                }
            }
            else
            {
                var data = {title:'Australia', search:'Search World Regions Map: '};
                $.ajax({
                    url: "/dashboard/setWorldRegionsMapsLog",
                    type: "POST",
                    data: data,
                    dataType: "json",
                    success: function(data) {
                       
                    }            
                });

                selected_reg_australia = true;
                if(isCtrlPressed_australia && first_m!=0)
                {
                    selected_reg_australia = true;
                    if($.inArray("Australia", region_name) == -1)
                    {
                        $('.highcharts-name-australia').css({"fill": "#ffa767"});
                        region_name.push("Australia");
                    }
                    else
                    {
                        $('.highcharts-name-australia').css({"fill": "#57A0C1"});
                        var idx_name = region_name.indexOf("Australia");
                        if (idx_name != -1) {
                            region_name.splice(idx_name, 1);
                        }
                    }
                }
                else
                {

                    first_m++;
                    selected_reg_australia = true;
                    $('.highcharts-name-australia').css({"fill": "#ffa767"});
                    $('.highcharts-name-north-america').css({"fill": "#57A0C1"});
                    $('.highcharts-name-south-america').css({"fill": "#57A0C1"});
                    $('.highcharts-name-europe').css({"fill": "#57A0C1"});
                    $('.highcharts-name-asia').css({"fill": "#57A0C1"});
                    $('.highcharts-name-africa').css({"fill": "#57A0C1"});

                    region_name = [];
                    region_name[0] = "Australia";
                }
            }
        });
    });
    //******* end world map *******//

    //******* start us map *******//

    var west_ids = "#jqvmap1_wy, #jqvmap1_wa, #jqvmap1_mt, #jqvmap1_id, #jqvmap1_or, #jqvmap1_ca, #jqvmap1_nv, #jqvmap1_ut, #jqvmap1_co, #jqvmap1_mt, #jqvmap1_nm, #jqvmap1_ak, #jqvmap1_hi, #jqvmap1_az";
    var south_ids = "#jqvmap1_tx, #jqvmap1_ok, #jqvmap1_la, #jqvmap1_ar, #jqvmap1_ms, #jqvmap1_fl, #jqvmap1_al, #jqvmap1_tn, #jqvmap1_ky, #jqvmap1_sc, #jqvmap1_ga, #jqvmap1_nc";
    var midwest_ids = "#jqvmap1_nd, #jqvmap1_sd, #jqvmap1_ne, #jqvmap1_ks, #jqvmap1_mn, #jqvmap1_ia, #jqvmap1_mo, #jqvmap1_il, #jqvmap1_wi, #jqvmap1_mi, #jqvmap1_in, #jqvmap1_oh, #jqvmap1_mi";
    var northeast_ids = "#jqvmap1_vt, #jqvmap10_vt, #jqvmap1_ct, #jqvmap1_ri, #jqvmap1_ma, #jqvmap1_nh, #jqvmap1_me";
    var mid_atlantic_ids = "#jqvmap1_ny, #jqvmap1_pa, #jqvmap1_nj, #jqvmap1_wv, #jqvmap1_md, #jqvmap1_de, #jqvmap1_dc, #jqvmap1_va";

    $(west_ids).hover(
        function() {
        $(west_ids).css({"opacity": "0.7"});
    }, function() {
        $(west_ids).css({"opacity": "1"});
    });

    $(south_ids).hover(
        function() {
            $(south_ids).css({"opacity": "0.7"});
        }, function() {
            $(south_ids).css({"opacity": "1"});
        });

    $(midwest_ids).hover(
        function() {
            $(midwest_ids).css({"opacity": "0.7"});
        }, function() {
            $(midwest_ids).css({"opacity": "1"});
        });

    $(northeast_ids).hover(
        function() {
            $(northeast_ids).css({"opacity": "0.7"});
        }, function() {
            $(northeast_ids).css({"opacity": "1"});
        });

    $(mid_atlantic_ids).hover(
        function() {
            $(mid_atlantic_ids).css({"opacity": "0.7"});
        }, function() {
            $(mid_atlantic_ids).css({"opacity": "1"});
        });

//west
    $(west_ids + ', #west_title').click(function(e){
        var isCtrlPressed_west = e.ctrlKey;

        if( $('#us_west').is(':visible'))
        {
            $(west_ids).css({"stroke":"#818181", "stroke-width": "0", "fill": "#57A0C1"});
            $('#us_west').hide();
            $('#small_us_west').hide();

            var idx_name = region_name_us.indexOf("West");
            if (idx_name != -1) {
                region_name_us.splice(idx_name, 1);
            }

            var idx_title = region_title.indexOf("&nbsp;&nbsp;&nbsp;&nbsp; US West");
            if (idx_title != -1) {
                region_title.splice(idx_title, 1);
                $('.region_title p').html(region_title);
            }
        }
        else
        {
            var data = {title:'US West', search:'Search US Regions Map: '};
            $.ajax({
                url: "/dashboard/setUSRegionsMapsLog",
                type: "POST",
                data: data,
                dataType: "json",
                success: function(data) {
                   
                }            
            });

            $(west_ids).css({"stroke":"#ffa767", "stroke-width": "0", "fill": "#ffa767"});
            $('#us_west').show();
            $('#small_us_west').show();

            if(isCtrlPressed_west && first!=0)
            {
                if($.inArray("West", region_name_us) == -1)
                {
                    $(west_ids).css({"stroke":"#ffa767", "stroke-width": "0", "fill": "#ffa767"});
                    $('#us_west').show();
                    $('#small_us_west').show();
                    region_name_us.push("West");
                    region_title.push("&nbsp;&nbsp;&nbsp;&nbsp; US West");
                    $('.region_title p').html(region_title);
                }
                else
                {
                    $(west_ids).css({"stroke":"#818181", "stroke-width": "0", "fill": "#57A0C1"});
                    $('#us_west').hide();
                    $('#small_us_west').hide();

                    var idx_name = region_name_us.indexOf("West");
                    if (idx_name != -1) {
                        region_name_us.splice(idx_name, 1);
                    }

                    var idx_title = region_title.indexOf("&nbsp;&nbsp;&nbsp;&nbsp; US West");
                    if (idx_title != -1) {
                        region_title.splice(idx_title, 1);
                        $('.region_title p').html(region_title);
                    }
                }
            }
            else
            {
                first++;
                $(south_ids).css({"stroke":"#818181", "stroke-width": "0", "fill": "#57A0C1"});
                $(midwest_ids).css({"stroke":"#818181", "stroke-width": "0", "fill": "#57A0C1"});
                $(northeast_ids).css({"stroke":"#818181", "stroke-width": "0", "fill": "#57A0C1"});
                $(mid_atlantic_ids).css({"stroke":"#818181", "stroke-width": "0", "fill": "#57A0C1"});

                region_name_us = [];
                region_title = [];
                region_name_us[0] = "West";
                region_title[0] = "&nbsp;&nbsp;&nbsp;&nbsp; US West";
                $('.region_title p').html(region_title);

                $('#us_west').show();
                $('#small_us_west').show();
                $('#us_south').hide();
                $('#midwest').hide();
                $('#northeast').hide();
                $('#mid_atlantic').hide();
            }
        }
    });

    //midwest
    $(midwest_ids + ', #midwest_title').click(function(e){
        var isCtrlPressed_midwest = e.ctrlKey;

        if( $('#midwest').is(':visible'))
        {
            $(midwest_ids).css({"stroke":"#818181", "stroke-width": "0", "fill": "#57A0C1"});
            $('#midwest').hide();

            var idx_name = region_name_us.indexOf("Midwest");
            if (idx_name != -1) {
                region_name_us.splice(idx_name, 1);
            }

            var idx_title = region_title.indexOf("&nbsp;&nbsp;&nbsp;&nbsp; US Midwest");
            if (idx_title != -1) {
                region_title.splice(idx_title, 1);
                $('.region_title p').html(region_title);
            }
        }
        else
        {
            var data = {title:'US Midwest', search:'Search US Regions Map: '};
            $.ajax({
                url: "/dashboard/setUSRegionsMapsLog",
                type: "POST",
                data: data,
                dataType: "json",
                success: function(data) {
                   
                }            
            });

            $(midwest_ids).css({"stroke":"#ffa767", "stroke-width": "0", "fill": "#ffa767"});
            $('#midwest').show();

            if(isCtrlPressed_midwest && first!=0)
            {
                if($.inArray("Midwest", region_name_us) == -1)
                {
                    $(midwest_ids).css({"stroke":"#ffa767", "stroke-width": "0", "fill": "#ffa767"});
                    $('#midwest').show();
                    region_name_us.push("Midwest");
                    region_title.push("&nbsp;&nbsp;&nbsp;&nbsp; US Midwest");
                    $('.region_title p').html(region_title);
                }
                else
                {
                    $(midwest_ids).css({"stroke":"#818181", "stroke-width": "0", "fill": "#57A0C1"});
                    $('#midwest').hide();

                    var idx_name = region_name_us.indexOf("Midwest");
                    if (idx_name != -1) {
                        region_name_us.splice(idx_name, 1);
                    }

                    var idx_title = region_title.indexOf("&nbsp;&nbsp;&nbsp;&nbsp; US Midwest");
                    if (idx_title != -1) {
                        region_title.splice(idx_title, 1);
                        $('.region_title p').html(region_title);
                    }
                }
            }
            else
            {
                first++;
                $(south_ids).css({"stroke":"#818181", "stroke-width": "0", "fill": "#57A0C1"});
                $(west_ids).css({"stroke":"#818181", "stroke-width": "0", "fill": "#57A0C1"});
                $(northeast_ids).css({"stroke":"#818181", "stroke-width": "0", "fill": "#57A0C1"});
                $(mid_atlantic_ids).css({"stroke":"#818181", "stroke-width": "0", "fill": "#57A0C1"});

                region_name_us = [];
                region_title = [];
                region_name_us[0] = "Midwest";
                region_title[0] = "&nbsp;&nbsp;&nbsp;&nbsp; US Midwest";
                $('.region_title p').html(region_title);

                $('#us_west').hide();
                $('#small_us_west').hide();
                $('#us_south').hide();
                $('#midwest').show();
                $('#northeast').hide();
                $('#mid_atlantic').hide();
            }
        }
    });

    //north-east
    $(northeast_ids + ', #northeast_title').click(function(e){
        var isCtrlPressed_northeast = e.ctrlKey;

        if( $('#northeast').is(':visible'))
        {
            $(northeast_ids).css({"stroke":"#818181", "stroke-width": "0", "fill": "#57A0C1"});
            $('#northeast').hide();

            var idx_name = region_name_us.indexOf("Northeast");
            if (idx_name != -1) {
                region_name_us.splice(idx_name, 1);
            }

            var idx_title = region_title.indexOf("&nbsp;&nbsp;&nbsp;&nbsp; US Northeast");
            if (idx_title != -1) {
                region_title.splice(idx_title, 1);
                $('.region_title p').html(region_title);
            }
        }
        else
        {
            var data = {title:'US Northeast', search:'Search US Regions Map: '};
            $.ajax({
                url: "/dashboard/setUSRegionsMapsLog",
                type: "POST",
                data: data,
                dataType: "json",
                success: function(data) {
                   
                }            
            });

            $(northeast_ids).css({"stroke":"#ffa767", "stroke-width": "0", "fill": "#ffa767"});
            $('#northeast').show();

            if(isCtrlPressed_northeast && first!=0)
            {
                if($.inArray("Northeast", region_name_us) == -1)
                {
                    $(northeast_ids).css({"stroke":"#ffa767", "stroke-width": "0", "fill": "#ffa767"});
                    $('#northeast').show();
                    region_name_us.push("Northeast");
                    region_title.push("&nbsp;&nbsp;&nbsp;&nbsp; US Northeast");
                    $('.region_title p').html(region_title);
                }
                else
                {
                    $(northeast_ids).css({"stroke":"#818181", "stroke-width": "0", "fill": "#57A0C1"});
                    $('#northeast').hide();

                    var idx_name = region_name_us.indexOf("Northeast");
                    if (idx_name != -1) {
                        region_name_us.splice(idx_name, 1);
                    }

                    var idx_title = region_title.indexOf("&nbsp;&nbsp;&nbsp;&nbsp; US Northeast");
                    if (idx_title != -1) {
                        region_title.splice(idx_title, 1);
                        $('.region_title p').html(region_title);
                    }
                }
            }
            else
            {
                first++;
                $(south_ids).css({"stroke":"#818181", "stroke-width": "0", "fill": "#57A0C1"});
                $(west_ids).css({"stroke":"#818181", "stroke-width": "0", "fill": "#57A0C1"});
                $(midwest_ids).css({"stroke":"#818181", "stroke-width": "0", "fill": "#57A0C1"});
                $(mid_atlantic_ids).css({"stroke":"#818181", "stroke-width": "0", "fill": "#57A0C1"});


                region_name_us = [];
                region_title = [];
                region_name_us[0] = "Northeast";
                region_title[0] = "&nbsp;&nbsp;&nbsp;&nbsp; US Northeast";
                $('.region_title p').html(region_title);

                $('#us_west').hide();
                $('#small_us_west').hide();
                $('#us_south').hide();
                $('#midwest').hide();
                $('#northeast').show();
                $('#mid_atlantic').hide();
            }
        }

    });

    //mid atlantic
    $(mid_atlantic_ids + ', #mid_atlantic_title').click(function(e){
        var isCtrlPressed_northeast = e.ctrlKey;

        if( $('#mid_atlantic').is(':visible'))
        {
            $(mid_atlantic_ids).css({"stroke":"#818181", "stroke-width": "0", "fill": "#57A0C1"});
            $('#mid_atlantic').hide();

            var idx_name = region_name_us.indexOf("Mid-Atlantic");
            if (idx_name != -1) {
                region_name_us.splice(idx_name, 1);
            }

            var idx_title = region_title.indexOf("&nbsp;&nbsp;&nbsp;&nbsp; US Mid-Atlantic");
            if (idx_title != -1) {
                region_title.splice(idx_title, 1);
                $('.region_title p').html(region_title);
            }
        }
        else
        {
            var data = {title:'US Mid-Atlantic', search:'Search US Regions Map: '};
            $.ajax({
                url: "/dashboard/setUSRegionsMapsLog",
                type: "POST",
                data: data,
                dataType: "json",
                success: function(data) {
                   
                }            
            });

            $(mid_atlantic_ids).css({"stroke":"#ffa767", "stroke-width": "0", "fill": "#ffa767"});

            $('#mid_atlantic').show();

            if(isCtrlPressed_northeast && first!=0)
            {
                if($.inArray("Mid-Atlantic", region_name_us) == -1)
                {
                    $(mid_atlantic_ids).css({"stroke":"#ffa767", "stroke-width": "0", "fill": "#ffa767"});
                    $('#mid_atlantic').show();
                    region_name_us.push("Mid-Atlantic");
                    region_title.push("&nbsp;&nbsp;&nbsp;&nbsp; US Mid-Atlantic");
                    $('.region_title p').html(region_title);
                }
                else
                {
                    $(mid_atlantic_ids).css({"stroke":"#818181", "stroke-width": "0", "fill": "#57A0C1"});
                    $('#mid_atlantic').hide();

                    var idx_name = region_name_us.indexOf("Mid-Atlantic");
                    if (idx_name != -1) {
                        region_name_us.splice(idx_name, 1);
                    }

                    var idx_title = region_title.indexOf("&nbsp;&nbsp;&nbsp;&nbsp; US Mid-Atlantic");
                    if (idx_title != -1) {
                        region_title.splice(idx_title, 1);
                        $('.region_title p').html(region_title);
                    }
                }
            }
            else
            {
                first++;
                $(south_ids).css({"stroke":"#818181", "stroke-width": "0", "fill": "#57A0C1"});
                $(west_ids).css({"stroke":"#818181", "stroke-width": "0", "fill": "#57A0C1"});
                $(midwest_ids).css({"stroke":"#818181", "stroke-width": "0", "fill": "#57A0C1"});
                $(northeast_ids).css({"stroke":"#818181", "stroke-width": "0", "fill": "#57A0C1"});

                region_name_us = [];
                region_title = [];
                region_name_us[0] = "Mid-Atlantic";
                region_title[0] = "&nbsp;&nbsp;&nbsp;&nbsp; US Mid-Atlantic";
                $('.region_title p').html(region_title);

                $('#us_west').hide();
                $('#small_us_west').hide();
                $('#us_south').hide();
                $('#midwest').hide();
                $('#northeast').hide();
                $('#mid_atlantic').show();
            }
        }

    });

    //south
    $(south_ids + ', #south_title').click(function(e){
        var isCtrlPressed_south = e.ctrlKey;

        if( $('#us_south').is(':visible'))
        {
            $(south_ids).css({"stroke":"#818181", "stroke-width": "0", "fill": "#57A0C1"});
            $('#us_south').hide();

            var idx_name = region_name_us.indexOf("South");
            if (idx_name != -1) {
                region_name_us.splice(idx_name, 1);
            }

            var idx_title = region_title.indexOf("&nbsp;&nbsp;&nbsp;&nbsp; US South");
            if (idx_title != -1) {
                region_title.splice(idx_title, 1);
                $('.region_title p').html(region_title);
            }
        }
        else
        {

            var data = {title:'US South', search:'Search US Regions Map: '};
            $.ajax({
                url: "/dashboard/setUSRegionsMapsLog",
                type: "POST",
                data: data,
                dataType: "json",
                success: function(data) {
                   
                }            
            });

            $(south_ids).css({"stroke":"#ffa767", "stroke-width": "0", "fill": "#ffa767"});
            $('#us_south').show();

            if(isCtrlPressed_south && first !=0)
            {
                if($.inArray("South", region_name_us) == -1)
                {
                    $(south_ids).css({"stroke":"#ffa767", "stroke-width": "0", "fill": "#ffa767"});
                    $('#us_south').show();
                    region_name_us.push("South");
                    region_title.push("&nbsp;&nbsp;&nbsp;&nbsp; US South");
                    $('.region_title p').html(region_title);
                }
                else
                {
                    $(south_ids).css({"stroke":"#818181", "stroke-width": "0", "fill": "#57A0C1"});
                    $('#us_south').hide();

                    var idx_name = region_name_us.indexOf("South");
                    if (idx_name != -1) {
                        region_name_us.splice(idx_name, 1);
                    }

                    var idx_title = region_title.indexOf("&nbsp;&nbsp;&nbsp;&nbsp; US South");
                    if (idx_title != -1) {
                        region_title.splice(idx_title, 1);
                        $('.region_title p').html(region_title);
                    }
                }
            }
            else
            {
                first++;
                $(northeast_ids).css({"stroke":"#818181", "stroke-width": "0", "fill": "#57A0C1"});
                $(west_ids).css({"stroke":"#818181", "stroke-width": "0", "fill": "#57A0C1"});
                $(midwest_ids).css({"stroke":"#818181", "stroke-width": "0", "fill": "#57A0C1"});
                $(mid_atlantic_ids).css({"stroke":"#818181", "stroke-width": "0", "fill": "#57A0C1"});

                region_name_us = [];
                region_title = [];
                region_name_us[0] = "South";
                region_title[0] = "&nbsp;&nbsp;&nbsp;&nbsp; US South";
                $('.region_title p').html(region_title);

                $('#us_west').hide();
                $('#small_us_west').hide();
                $('#us_south').show();
                $('#midwest').hide();
                $('#northeast').hide();
                $('#mid_atlantic').hide();
            }
        }

    });

    $('.jsmapclick_us').click(function(){

        $('.state_line_NH').hide();
        $('.state_line_MA').hide();
        $('.state_line_RI').hide();
        $('.state_line_CT').hide();
        $('.state_line_NJ').hide();
        $('.state_line_DE').hide();
        $('.state_line_MD').hide();
        $('.state_line_DC').hide();
        $('.state_line_DC_letters').hide();
        $('.dc_transparent').hide();
        $('.dc_blue').hide();
        $('.dc_orange').hide();
        $('.dc_hover').hide();

        $('.dialog_for_map').dialog( "option", "title", "LexLists: US Regions" );

        $('#container_us').show();
        $('#container').hide();
        $('#container_us_states').hide();

        $('#us_west').hide();
        $('#small_us_west').hide();
        $('#us_south').hide();
        $('#midwest').hide();
        $('#northeast').hide();

        $('.dialog_for_map').dialog("open");

        $(west_ids).css({"stroke":"#818181", "stroke-width": "1px", "fill": "#57A0C1"});
        $(south_ids).css({"stroke":"#818181", "stroke-width": "1px", "fill": "#57A0C1"});
        $(midwest_ids).css({"stroke":"#818181", "stroke-width": "1px", "fill": "#57A0C1"});
        $(northeast_ids).css({"stroke":"#818181", "stroke-width": "1px", "fill": "#57A0C1"});

        $('.region_title p').html('');

        region_name = '';
        region_name_us = '';
        region_title = '';

        first = 0;
        first_ctrl = 0;

    });
    //*******end us map *******//

    //*******start us states map *******//

    var openedmap=false;

    var search_states = [];
    $('.jsmapclick_us_states').click(function(){

        $('.state_line_NH').show();
        $('.state_line_MA').show();
        $('.state_line_RI').show();
        $('.state_line_CT').show();
        $('.state_line_NJ').show();
        $('.state_line_DE').show();
        $('.state_line_MD').show();
        $('.state_line_DC').show();
        $('.state_line_DC_letters').show();
        $('.dc_blue').show();


        $('.dialog_for_map').dialog( "option", "title", "LexLists: US States" );

        $('#container_us_states').show();
        $('#container_us').hide();
        $('#container').hide();

        $('.dialog_for_map').dialog("open");
        search_states = [];
        sel = [];
        state_idx = 0;

        $('.highcharts-data-labels.highcharts-tracker g').css({"opacity": '1'});

        $('.highcharts-legend').css({'display': 'none'});
        $('.highcharts-button').css({'display': 'none'});
        $('.highcharts-container svg>text').css({'display': 'none'});
        $('.highcharts-container svg rect').css({'fill': '#FAFAFA'});
        $('.highcharts-container svg path').css({'fill': '#57A0C1'});
        $('.highcharts-container svg path').hover(
        function(){
            $(this).css({'fill-opacity': '0.7'});
        },function(){
            $(this).css({'fill-opacity': '1'});
        });

        $('.highcharts-data-labels g:nth-child(20)').attr('transform', 'translate(718,79)');
        $('.highcharts-data-labels g:nth-child(20)').hover(function(){
            $('.highcharts-name-new-hampshire').css({'fill-opacity': '0.7'});
        },function(){
            $('.highcharts-name-new-hampshire').css({'fill-opacity': '1'});

        });

        $('.highcharts-data-labels g:nth-child(3)').attr('transform', 'translate(718,97)');
        $('.highcharts-data-labels g:nth-child(3)').hover(function(){
            $('.highcharts-name-massachusetts').css({'fill-opacity': '0.7'});
        },function(){
            $('.highcharts-name-massachusetts').css({'fill-opacity': '1'});

        });

        $('.highcharts-data-labels g:nth-child(2)').attr('transform', 'translate(718,115)');
        $('.highcharts-data-labels g:nth-child(2)').hover(function(){
            $('.highcharts-name-rhode-island').css({'fill-opacity': '0.7'});
        },function(){
            $('.highcharts-name-rhode-island').css({'fill-opacity': '1'});

        });

        $('.highcharts-data-labels g:nth-child(4)').attr('transform', 'translate(718,133)');
        $('.highcharts-data-labels g:nth-child(4)').hover(function(){
            $('.highcharts-name-connecticut').css({'fill-opacity': '0.7'});
        },function(){
            $('.highcharts-name-connecticut').css({'fill-opacity': '1'});

        });

        $('.highcharts-data-labels g:nth-child(1)').attr('transform', 'translate(718,150)');
        $('.highcharts-data-labels g:nth-child(1)').hover(function(){
            $('.highcharts-name-new-jersey').css({'fill-opacity': '0.7'});
        },function(){
            $('.highcharts-name-new-jersey').css({'fill-opacity': '1'});

        });

        $('.highcharts-data-labels g:nth-child(7)').attr('transform', 'translate(718,168)');
        $('.highcharts-data-labels g:nth-child(7)').hover(function(){
            $('.highcharts-name-delaware').css({'fill-opacity': '0.7'});
        },function(){
            $('.highcharts-name-delaware').css({'fill-opacity': '1'});

        });

        $('.highcharts-data-labels g:nth-child(5)').attr('transform', 'translate(718,185)');
        $('.highcharts-data-labels g:nth-child(5)').hover(function(){
            $('.highcharts-name-maryland').css({'fill-opacity': '0.7'});
        },function(){
            $('.highcharts-name-maryland').css({'fill-opacity': '1'});

        });

        $('.dc_blue, .state_line_DC_letters').hover(function(){
            $('.dc_hover').show();

        },function(){
            $('.dc_hover').hide();

        });

        if(!openedmap)
        {
            $('.state_line_NH').show();
            $('.state_line_MA').show();
            $('.state_line_RI').show();
            $('.state_line_CT').show();
            $('.state_line_NJ').show();
            $('.state_line_DE').show();
            $('.state_line_MD').show();
            $('.state_line_DC').show();
            $('.state_line_DC_letters').show();
            $('.dc_blue').show();

            $('.dc_blue, .dc_hover, .state_line_DC_letters, .dc_transparent').click(function(){

                var x = $('.highcharts-name-district-of').attr('class').substring(17).split(" ")[0];
                if(sel[x]==true)
                {

                    $('.dc_orange').hide();
                    $('.dc_transparent').hide();
                    sel[x] = false;
                    $('.highcharts-name-district-of').css({"fill": "#57A0C1"});
                    for(var i=0; i<search_states.length; i++)
                    {
                        state_idx = $.inArray($('.highcharts-name-delaware').attr('class').substring(17).split(" ")[0], search_states[i]);
                        if(state_idx !== -1)
                        {
                            state_idx = search_states[i].indexOf($('.highcharts-name-district-of').attr('class').substring(17).split(" ")[0]);
                            search_states[i].splice(state_idx, 1);
                        }
                    }
                }
                else
                {                   
                    $('.dc_hover').hide();
                    $('.dc_orange').show();
                    $('.dc_transparent').show();
                    sel[x] = true;
                    $('.highcharts-name-district-of').css({"fill": "#ffa767"});
                    search_states.push($('.highcharts-name-district-of').attr('class').substring(17).split(" "));
                    //console.log(search_states);

                    var stateforlog = $('.highcharts-name-district-of').attr('class').substring(17).split(" ")[0];
                    stateforlog = stateforlog+"-columbia";                    
                    var data = {title:stateforlog, search:'Search US States Map: '};
                    $.ajax({
                        url: "/dashboard/setStatesMapsLog",
                        type: "POST",
                        data: data,
                        dataType: "json",
                        success: function(data) {
                           
                        }            
                    });

                }
                openedmap = true;
            });

            $('.highcharts-data-labels g:nth-child(7) text tspan:last-child').click(function(){

                var x = $('.highcharts-name-delaware').attr('class').substring(17).split(" ")[0];
                if(sel[x]==true)
                {
                    sel[x] = false;
                    $('.highcharts-name-delaware').css({"fill": "#57A0C1"});
                    for(var i=0; i<search_states.length; i++)
                    {
                        state_idx = $.inArray($('.highcharts-name-delaware').attr('class').substring(17).split(" ")[0], search_states[i]);
                        if(state_idx !== -1)
                        {
                            state_idx = search_states[i].indexOf($('.highcharts-name-delaware').attr('class').substring(17).split(" ")[0]);
                            search_states[i].splice(state_idx, 1);
                        }
                    }
                }
                else
                {
                    sel[x] = true;
                    $('.highcharts-name-delaware').css({"fill": "#ffa767"});
                    search_states.push($('.highcharts-name-delaware').attr('class').substring(17).split(" "));
                    //console.log(search_states);

                    var stateforlog = $('.highcharts-name-delaware').attr('class').substring(17).split(" ")[0];                    
                    var data = {title:stateforlog, search:'Search US States Map: '};
                    $.ajax({
                        url: "/dashboard/setStatesMapsLog",
                        type: "POST",
                        data: data,
                        dataType: "json",
                        success: function(data) {
                           
                        }            
                    });

                }
                openedmap = true;

            });

            $('.highcharts-data-labels g:nth-child(1) text tspan:last-child').click(function(){

                var x = $('.highcharts-name-new-jersey').attr('class').substring(17).split(" ")[0];
                if(sel[x]==true)
                {
                    sel[x] = false;
                    $('.highcharts-name-new-jersey').css({"fill": "#57A0C1"});
                    for(var i=0; i<search_states.length; i++)
                    {
                        state_idx = $.inArray($('.highcharts-name-new-jersey').attr('class').substring(17).split(" ")[0], search_states[i]);
                        if(state_idx !== -1)
                        {
                            state_idx = search_states[i].indexOf($('.highcharts-name-new-jersey').attr('class').substring(17).split(" ")[0]);
                            search_states[i].splice(state_idx, 1);
                        }
                    }
                }
                else
                {
                    sel[x] = true;
                    $('.highcharts-name-new-jersey').css({"fill": "#ffa767"});
                    search_states.push($('.highcharts-name-new-jersey').attr('class').substring(17).split(" "));
                    //console.log(search_states);

                    var stateforlog = $('.highcharts-name-new-jersey').attr('class').substring(17).split(" ")[0];                    
                    var data = {title:stateforlog, search:'Search US States Map: '};
                    $.ajax({
                        url: "/dashboard/setStatesMapsLog",
                        type: "POST",
                        data: data,
                        dataType: "json",
                        success: function(data) {
                           
                        }            
                    });

                }
                openedmap = true;

            });

            $('.highcharts-data-labels g:nth-child(2) text tspan:last-child').click(function(){

                var x = $('.highcharts-name-rhode-island').attr('class').substring(17).split(" ")[0];
                if(sel[x]==true)
                {
                    sel[x] = false;
                    $('.highcharts-name-rhode-island').css({"fill": "#57A0C1"});
                    for(var i=0; i<search_states.length; i++)
                    {
                        state_idx = $.inArray($('.highcharts-name-rhode-island').attr('class').substring(17).split(" ")[0], search_states[i]);
                        if(state_idx !== -1)
                        {
                            state_idx = search_states[i].indexOf($('.highcharts-name-rhode-island').attr('class').substring(17).split(" ")[0]);
                            search_states[i].splice(state_idx, 1);
                        }
                    }
                }
                else
                {
                    sel[x] = true;
                    $('.highcharts-name-rhode-island').css({"fill": "#ffa767"});
                    search_states.push($('.highcharts-name-rhode-island').attr('class').substring(17).split(" "));
                    //console.log(search_states);

                    var stateforlog = $('.highcharts-name-rhode-island').attr('class').substring(17).split(" ")[0];                    
                    var data = {title:stateforlog, search:'Search US States Map: '};
                    $.ajax({
                        url: "/dashboard/setStatesMapsLog",
                        type: "POST",
                        data: data,
                        dataType: "json",
                        success: function(data) {
                           
                        }            
                    });

                }
                openedmap = true;

            });

            $('.highcharts-data-labels g:nth-child(3) text tspan:last-child').click(function(){

                var x = $('.highcharts-name-massachusetts').attr('class').substring(17).split(" ")[0];
                if(sel[x]==true)
                {
                    sel[x] = false;
                    $('.highcharts-name-massachusetts').css({"fill": "#57A0C1"});
                    for(var i=0; i<search_states.length; i++)
                    {
                        state_idx = $.inArray($('.highcharts-name-massachusetts').attr('class').substring(17).split(" ")[0], search_states[i]);
                        if(state_idx !== -1)
                        {
                            state_idx = search_states[i].indexOf($('.highcharts-name-massachusetts').attr('class').substring(17).split(" ")[0]);
                            search_states[i].splice(state_idx, 1);
                        }
                    }
                }
                else
                {
                    sel[x] = true;
                    $('.highcharts-name-massachusetts').css({"fill": "#ffa767"});
                    search_states.push($('.highcharts-name-massachusetts').attr('class').substring(17).split(" "));
                    //console.log(search_states);

                    var stateforlog = $('.highcharts-name-massachusetts').attr('class').substring(17).split(" ")[0];                    
                    var data = {title:stateforlog, search:'Search US States Map: '};
                    $.ajax({
                        url: "/dashboard/setStatesMapsLog",
                        type: "POST",
                        data: data,
                        dataType: "json",
                        success: function(data) {
                           
                        }            
                    });

                }
                openedmap = true;

            });

            $('.highcharts-data-labels g:nth-child(4) text tspan:last-child').click(function(){

                var x = $('.highcharts-name-connecticut').attr('class').substring(17).split(" ")[0];
                if(sel[x]==true)
                {
                    sel[x] = false;
                    $('.highcharts-name-connecticut').css({"fill": "#57A0C1"});
                    for(var i=0; i<search_states.length; i++)
                    {
                        state_idx = $.inArray($('.highcharts-name-connecticut').attr('class').substring(17).split(" ")[0], search_states[i]);
                        if(state_idx !== -1)
                        {
                            state_idx = search_states[i].indexOf($('.highcharts-name-connecticut').attr('class').substring(17).split(" ")[0]);
                            search_states[i].splice(state_idx, 1);
                        }
                    }
                }
                else
                {
                    sel[x] = true;
                    $('.highcharts-name-connecticut').css({"fill": "#ffa767"});
                    search_states.push($('.highcharts-name-connecticut').attr('class').substring(17).split(" "));
                    //console.log(search_states);

                    var stateforlog = $('.highcharts-name-connecticut').attr('class').substring(17).split(" ")[0];                    
                    var data = {title:stateforlog, search:'Search US States Map: '};
                    $.ajax({
                        url: "/dashboard/setStatesMapsLog",
                        type: "POST",
                        data: data,
                        dataType: "json",
                        success: function(data) {
                           
                        }            
                    });

                }
                openedmap = true;

            });

            $('.highcharts-data-labels g:nth-child(5) text tspan:last-child').click(function(){

                var x = $('.highcharts-name-maryland').attr('class').substring(17).split(" ")[0];
                if(sel[x]==true)
                {
                    sel[x] = false;
                    $('.highcharts-name-maryland').css({"fill": "#57A0C1"});
                    for(var i=0; i<search_states.length; i++)
                    {
                        state_idx = $.inArray($('.highcharts-name-maryland').attr('class').substring(17).split(" ")[0], search_states[i]);
                        if(state_idx !== -1)
                        {
                            state_idx = search_states[i].indexOf($('.highcharts-name-maryland').attr('class').substring(17).split(" ")[0]);
                            search_states[i].splice(state_idx, 1);
                        }
                    }
                }
                else
                {
                    sel[x] = true;
                    $('.highcharts-name-maryland').css({"fill": "#ffa767"});
                    search_states.push($('.highcharts-name-maryland').attr('class').substring(17).split(" "));
                    //console.log(search_states);

                    var stateforlog = $('.highcharts-name-maryland').attr('class').substring(17).split(" ")[0];                    
                    var data = {title:stateforlog, search:'Search US States Map: '};
                    $.ajax({
                        url: "/dashboard/setStatesMapsLog",
                        type: "POST",
                        data: data,
                        dataType: "json",
                        success: function(data) {
                           
                        }            
                    });

                }
                openedmap = true;

            });

            $('.highcharts-data-labels g:nth-child(20) text tspan:last-child').click(function(){

                var x = $('.highcharts-name-new-hampshire').attr('class').substring(17).split(" ")[0];
                if(sel[x]==true)
                {
                    sel[x] = false;
                    $('.highcharts-name-new-hampshire').css({"fill": "#57A0C1"});
                    for(var i=0; i<search_states.length; i++)
                    {
                        state_idx = $.inArray($('.highcharts-name-new-hampshire').attr('class').substring(17).split(" ")[0], search_states[i]);
                        if(state_idx !== -1)
                        {
                            state_idx = search_states[i].indexOf($('.highcharts-name-new-hampshire').attr('class').substring(17).split(" ")[0]);
                            search_states[i].splice(state_idx, 1);
                        }
                    }
                }
                else
                {
                    sel[x] = true;
                    $('.highcharts-name-new-hampshire').css({"fill": "#ffa767"});
                    search_states.push($('.highcharts-name-new-hampshire').attr('class').substring(17).split(" "));
                    //console.log(search_states);

                    var stateforlog = $('.highcharts-name-new-hampshire').attr('class').substring(17).split(" ")[0];                    
                    var data = {title:stateforlog, search:'Search US States Map: '};
                    $.ajax({
                        url: "/dashboard/setStatesMapsLog",
                        type: "POST",
                        data: data,
                        dataType: "json",
                        success: function(data) {
                           
                        }            
                    });

                }
                openedmap = true;

            });

            $('#container_us_states svg path').click(function(){
                var x = $(this).attr('class').substring(17).split(" ")[0];
                if(sel[x]==true)
                {
                    sel[x] = false;
                    $(this).css({"fill": "#57A0C1"});
                    for(var i=0; i<search_states.length; i++)
                    {
                        state_idx = $.inArray($(this).attr('class').substring(17).split(" ")[0], search_states[i]);
                        if(state_idx !== -1)
                        {
                            state_idx = search_states[i].indexOf($(this).attr('class').substring(17).split(" ")[0]);
                            search_states[i].splice(state_idx, 1);
                        }
                    }
                    
                }
                else
                {
                    sel[x] = true;
                    $(this).css({"fill": "#ffa767"});
                    search_states.push($(this).attr('class').substring(17).split(" "));
                    
                    var stateforlog = $(this).attr('class').substring(17).split(" ")[0];                    
                    var data = {title:stateforlog, search:'Search US States Map: '};
                    $.ajax({
                        url: "/dashboard/setStatesMapsLog",
                        type: "POST",
                        data: data,
                        dataType: "json",
                        success: function(data) {
                           
                        }            
                    });

                }
                openedmap = true;

            });
        }

    });

    $(function () {

        $.getJSON('http://www.highcharts.com/samples/data/jsonp.php?filename=us-population-density.json&callback=?', function (data) {

            // Make codes uppercase to match the map data
            $.each(data, function () {
                this.code = this.code.toUpperCase();
            });

            // Instanciate the map
            $('#container_us_states').highcharts('Map', {


                title : {
                    text : ''
                },
                mapNavigation: {
                    enabled: false
                },
                states: {
                    hover: {

                        color: '#ffa767',
                        fillopacity: 0.7,
                        halo: {
                            fillopacity: 0.7
                        }
                    }
                },
                series : [{
                    data : data,
                    mapData: Highcharts.maps['countries/us/us-all'],
                    joinBy: ['postal-code', 'code'],
                    dataLabels: {
                        enabled: true,
                        color: 'white',
                        format: '{point.code}'
                    },
                    name: 'Population density',
                    tooltip: {
                        pointFormat: '{point.code}: {point.value}/km²'
                    },
                    states: {
                        hover: {

                            color: '#ffa767',
                            fillopacity: 0.7,
                            halo: {
                                fillopacity: 0.7
                            }
                        }
                    }
                }]
            });
        });
    });

//*******end us states map *******//
    $("#report_surveys").show();
    //$("#report_surveys_years").show();
    /*var report_data_table_years = $("#report_surveys_years").dataTable({
        
        responsive: true,
        "autoWidth": false,
        "sDom": '<"H"flr>t<"F"ip>',
        "bDestroy":true,
        "bJQueryUI": true,
        "bRetrieve": true,
        "aaSorting": [],
        "bProcessing": true,
        "sServerMethod": "POST",
        "sAjaxSource": "/dashboard/GetSurveysByYear",
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
            { "sClass": "datatable_td_align_center", "aTargets": ["_all"]},
            { "bVisible": false, "aTargets": [ 4,5,6,8,9,10,12,13,14,15, 16, 17 ] },
            { "bVisible": true, "aTargets": [ 0,1,2,3,7,11 ] },
            { "bSortable": false, "aTargets": [ 0 ] }
        ]
    });*/
    var report_data_table = $("#report_surveys").dataTable({
        "bAutoWidth": false,
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
            [10, 25, 50, 100],
            [10, 25, 50, 100]
        ],
        "sScrollX": "100%",
        "bScrollCollapse": true,
        "oLanguage": {
            "sInfo"      : "_END_ of _TOTAL_ entries",
            "sInfoEmpty" : "_END_ of _TOTAL_ entries",
            "sLengthMenu": "Display _MENU_"
        },
        "aoColumnDefs": [
            { "sClass": "datatable_td_align_center", "aTargets": ["_all"]},
            { "bVisible": false, "aTargets": [ 4,5,6,8,9,10,12,13,14,15 ] },
            { "bVisible": true, "aTargets": [ 0,1,2,3,7,11 ] },
            { "bSortable": false, "aTargets": [ 0 ] }
        ],        
    });
    window.table = report_data_table;
    /*$(document).on('change', '#report_surveys', function() {
        alert('something changed inside #myDiv div');
    });*/


 var update_size = function() {
    $(report_data_table).css({ width: $(report_data_table).parent().width() });
    report_data_table.fnAdjustColumnSizing();  
    //$(report_data_table_years).css({ width: $(report_data_table_years).parent().width() });
    //report_data_table_years.fnAdjustColumnSizing();
  }

  $(window).resize(function() {
    clearTimeout(window.refresh_size);
    window.refresh_size = setTimeout(function() { update_size(); }, 250);
  });


    //$('#report_surveys').hide();
    //$('#report_surveys_wrapper').hide();

    /**
     *  Add tooltip for search field in dataTable
     */
    $("#report_surveys_filter").find("label").attr("title", "Enter a keyword of interest (ex. Litigation) to refine the results.");

    // Filtering
    $(".other_filters_block input:checkbox").change(function() {

        /*$('#report_surveys_years').hide();
        $('#report_surveys_years_wrapper').hide();
        $('#report_surveys_wrapper').show();
        $('#report_surveys').show();*/

        //filterByOtherParameters(report_data_table_years, $(this));
        filterByOtherParameters(report_data_table, $(this));
    });
    
    $("#region_selected").click(function() {
        //$('#clear_filters').click();
        // Clear filter checkboxes
        $(".other_filters_block input:checkbox, .deadline input:checkbox").prop("checked", false);

        // Clear hidden filters
        $("#hidden_filters_block select").html('<option value="0"></option>');

        // Reset filters
        //report_data_table_years.fnFilter('');
        report_data_table.fnFilter('');
        var colCount = report_data_table.fnGetData(0).length;
        for (var i = 0; i <= colCount; i++) {
            report_data_table.fnFilter('', i);
        }

        var region;
        $('.region_checkbox').prop('checked',false);
        if(region_name.length !=0)
        {
            var i=0;
            while(region_name[i])
            {
                $('input[value="'+region_name[i]+'"]').click();
                i++;
            }

            var data = {title:region_name} ; 
            $.ajax({
                url: "/dashboard/setWorldRegionsMapsLog",
                type: "POST",
                data: data,
                dataType: "json",
                success: function(data) {
                   
                }            
            });

        }
        if(region_name_us.length !=0)
        {
            var i=0;
            while(region_name_us[i])
            {
                $('input[value="US '+region_name_us[i]+'"]').click();
                i++;
            }

            var data = {title:region_name_us} ; 
            $.ajax({
                url: "/dashboard/setUSRegionsMapsLog",
                type: "POST",
                data: data,
                dataType: "json",
                success: function(data) {
                   
                }            
            });

            $(west_ids).css({"stroke":"#818181", "stroke-width": "1px", "fill": "#57A0C1"});
            $(south_ids).css({"stroke":"#818181", "stroke-width": "1px", "fill": "#57A0C1"});
            $(midwest_ids).css({"stroke":"#818181", "stroke-width": "1px", "fill": "#57A0C1"});
            $(northeast_ids).css({"stroke":"#818181", "stroke-width": "1px", "fill": "#57A0C1"});
            $(mid_atlantic_ids).css({"stroke":"#818181", "stroke-width": "1px", "fill": "#57A0C1"});

            $('.region_title p').html('');
        }

        if(search_states.length !=0)
        {
            var str = '';
            $(search_states).each(function(val){

                var temp_val = $(this)[0];
                if(temp_val.indexOf("-")!==-1)
                {
                    temp_val = temp_val.replace('-', " ");
                }
                str += temp_val+'|';
            });
            str = str.slice(0,-1);
            filterReportDataTable(report_data_table,str,9);
            var data = {title:search_states} ; 
            $.ajax({
                url: "/dashboard/setStatesMapsLog",
                type: "POST",
                data: data,
                dataType: "json",
                success: function(data) {
                   
                }            
            });
            //console.log(search_states);

        }

        search_states = [];
        sel = [];
        state_idx = 0;

        region_name = [];
        region_name_us = [];
        region_title = [];
        first = 0;
        first_m = 0;
        first_ctrl = 0;
        $('.region_title p').html('');

        $('#container').hide();
        $('#container_us').hide();
        $('#container_us_states').hide();

        $('#container_us_states svg g path').css({"fill": "#57A0C1"});

        $('#us_west').hide();
        $('#small_us_west').hide();
        $('#us_south').hide();
        $('#midwest').hide();
        $('#northeast').hide();
        $('#mid_atlantic').hide();

       /* $('#report_surveys_years').hide();
        $('#report_surveys_years_wrapper').hide();
        $('#report_surveys_wrapper').show();
        $('#report_surveys').show();*/
        
        $('.dialog_for_map').dialog("close");
    });

    $('#region_cancel').click(function(){
        var cancelmapname = '';
        $('.dialog_for_map div').each(function(){
            if($(this).attr('style') == 'display: block;')
            {
                cancelmapname = $(this).attr("id"); 
                var data = {title:cancelmapname};
                $.ajax({
                    url: "/dashboard/cancelMapLog",
                    type: "POST",
                    data: data,
                    dataType: "json",
                    success: function(data) {
                       
                    }            
                });
                          
            }
        });
       
        
        

        $(west_ids).css({"stroke":"#818181", "stroke-width": "1px", "fill": "#57A0C1"});
        $(south_ids).css({"stroke":"#818181", "stroke-width": "1px", "fill": "#57A0C1"});
        $(midwest_ids).css({"stroke":"#818181", "stroke-width": "1px", "fill": "#57A0C1"});
        $(northeast_ids).css({"stroke":"#818181", "stroke-width": "1px", "fill": "#57A0C1"});
        $(mid_atlantic_ids).css({"stroke":"#818181", "stroke-width": "1px", "fill": "#57A0C1"});

        region_name = '';
        region_name_us = '';
        region_title = '';
        first = 0;
        first_m = 0;
        first_ctrl = 0;
        $('.region_title p').html('');

        $('#container').hide();
        $('#container_us').hide();
        $('#container_us_states').hide();

        $('#container_us_states svg g path').css({"fill": "#57A0C1"});

        $('#us_west').hide();
        $('#small_us_west').hide();
        $('#us_south').hide();
        $('#midwest').hide();
        $('#northeast').hide();
        $('#mid_atlantic').hide();

        $('.dialog_for_map').dialog("close");
    });   

    $('.ui-icon-closethick').click(function(){
        
        $(west_ids).css({"stroke":"#818181", "stroke-width": "1px", "fill": "#57A0C1"});
        $(south_ids).css({"stroke":"#818181", "stroke-width": "1px", "fill": "#57A0C1"});
        $(midwest_ids).css({"stroke":"#818181", "stroke-width": "1px", "fill": "#57A0C1"});
        $(northeast_ids).css({"stroke":"#818181", "stroke-width": "1px", "fill": "#57A0C1"});
        $(mid_atlantic_ids).css({"stroke":"#818181", "stroke-width": "1px", "fill": "#57A0C1"});

        region_name = '';
        region_name_us = '';
        region_title = '';
        first = 0;
        first_m = 0;
        first_ctrl = 0;
        $('.region_title p').html('');

        $('#container').hide();
        $('#container_us').hide();
        $('#container_us_states').hide();

        $('#container_us_states svg g path').css({"fill": "#57A0C1"});

        $('#us_west').hide();
        $('#small_us_west').hide();
        $('#us_south').hide();
        $('#midwest').hide();
        $('#northeast').hide();
        $('#mid_atlantic').hide();

        
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
       // report_data_table_years.fnDraw();
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
        //var report_data_table_years = $("#report_surveys_years").dataTable();

        var column_number = $(this).attr("col_num");
        var show_status   = $(this).is(":checked");

        // Get show status for static columns
        var static_col_show_status = true;
        if(checked_count == 0) {
            static_col_show_status = false;
        }

        // Show/Hide static column
        showAndHideColumns(0, static_col_show_status, report_data_table);
        //showAndHideColumns(0, static_col_show_status, report_data_table_years);
        //showAndHideColumns(15, static_col_show_status, report_data_table);

        showAndHideColumns(column_number, show_status, report_data_table);
        //showAndHideColumns(column_number, show_status, report_data_table_years);
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
                //showAndHideColumns(0, true, report_data_table_years);
                //showAndHideColumns(15, true, report_data_table);

                showAndHideColumns(column_number, true, report_data_table);
               // showAndHideColumns(column_number, true, report_data_table_years);
            }
        });

        $("#display_form .not_default_display_checkbox").each(function() {
            if(this.checked) {
                this.checked = false;

                var column_number = $(this).attr("col_num");

                // Show static column
                showAndHideColumns(0, true, report_data_table);
                //showAndHideColumns(0, true, report_data_table_years);
                //showAndHideColumns(15, true, report_data_table);

                showAndHideColumns(column_number, false, report_data_table);
                //showAndHideColumns(column_number, false, report_data_table_years);
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
                //showAndHideColumns(0, true, report_data_table_years);
                //showAndHideColumns(15, true, report_data_table);

                // Show other columns
                showAndHideColumns(column_number, true, report_data_table);
                //showAndHideColumns(column_number, true, report_data_table_years);
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
                //showAndHideColumns(0, false, report_data_table_years);
                //showAndHideColumns(15, false, report_data_table);

                // Hide other columns
                showAndHideColumns(column_number, false, report_data_table);
                //showAndHideColumns(column_number, false, report_data_table_years);
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

        var data = {title:$(this).text(), filter_action:'Left Sidebar Filter - '} ; 

        $.ajax({
            url: "/dashboard/setFilterLog",
            type: "POST",
            data: data,
            dataType: "json",
            success: function(data) {
               
            }            
        });

        // Clear filter checkboxes
        $(".other_filters_block input:checkbox, .deadline input:checkbox").prop("checked", false);

        // Clear hidden filters
        $("#hidden_filters_block select").html('<option value="0"></option>');

        // Reset filters
        //report_data_table_years.fnFilter('');
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
   // $('#report_surveys_years thead tr th:first-child').css('width', '42px');
   $('.dataTable thead tr th:first-child').css('width', '42px');
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
