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

            $('#us_west').hide();
            $('#small_us_west').hide();
            $('#us_south').hide();
            $('#midwest').hide();
            $('#northeast').hide();

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


        //******* start world map *******//
            $('.jsmapclick').click(function(){

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

            jQuery('#container_us').vectorMap({
                map: 'usa_en',
                backgroundColor: null,
                color: '#0468B0',
                hoverOpacity: 1,
                selectedColor: '#666666',
                enableZoom: true,
                showTooltip: true,
                selectedRegion: 'MO'
            });

            var west_ids = "#jqvmap1_wy, #jqvmap1_wa, #jqvmap1_mt, #jqvmap1_id, #jqvmap1_or, #jqvmap1_ca, #jqvmap1_nv, #jqvmap1_ut, #jqvmap1_co, #jqvmap1_mt, #jqvmap1_nm, #jqvmap1_ak, #jqvmap1_hi, #jqvmap1_az";
            var south_ids = "#jqvmap1_dc, #jqvmap1_tx, #jqvmap1_ok, #jqvmap1_la, #jqvmap1_ar, #jqvmap1_ms, #jqvmap1_fl, #jqvmap1_al, #jqvmap1_tn, #jqvmap1_ky, #jqvmap1_sc, #jqvmap1_va, #jqvmap1_wv, #jqvmap1_md, #jqvmap1_de, #jqvmap1_ga, #jqvmap1_nc";
            var midwest_ids = "#jqvmap1_nd, #jqvmap1_sd, #jqvmap1_ne, #jqvmap1_ks, #jqvmap1_mn, #jqvmap1_ia, #jqvmap1_mo, #jqvmap1_il, #jqvmap1_wi, #jqvmap1_mi, #jqvmap1_in, #jqvmap1_oh, #jqvmap1_mi";
            var northeast_ids = "#jqvmap1_vt, #jqvmap1_nj, #jqvmap1_pa, #jqvmap1_ny, #jqvmap10_vt, #jqvmap1_ct, #jqvmap1_ri, #jqvmap1_ma, #jqvmap1_nh, #jqvmap1_me";

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
                    }
                }

            });

            $('.jsmapclick_us').click(function(){

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
                $('.dialog_for_map').dialog( "option", "title", "LexLists: US States" );

                $('#container_us_states').show();
                $('#container_us').hide();
                $('#container').hide();

                $('.dialog_for_map').dialog("open");
                search_states = [];
                sel = [];
                state_idx = 0;

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
                if(!openedmap)
                {
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
                            console.log(search_states);

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


            var report_data_table = $("#report_surveys").dataTable({
                "autoWidth":true,
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
                    { "sClass": "datatable_td_align_center", "aTargets": ["_all"]},
                    { "bVisible": false, "aTargets": [ 4,5,6,8,9,10,12,13,14 ] },
                    { "bVisible": true, "aTargets": [ 0,1,2,3,7,11 ] },
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

            $("#region_selected").on("click", function() {
                var region;
                $('.region_checkbox').prop('checked',false);
                if(region_name!='')
                {
                    var i=0;
                    while(region_name[i])
                    {
                        $('input[value="'+region_name[i]+'"]').click();
                        i++;
                    }
                }
                if(region_name_us!='')
                {
                    var i=0;
                    while(region_name_us[i])
                    {
                        $('input[value="US '+region_name_us[i]+'"]').click();
                        i++;
                    }

                    $(west_ids).css({"stroke":"#818181", "stroke-width": "1px", "fill": "#57A0C1"});
                    $(south_ids).css({"stroke":"#818181", "stroke-width": "1px", "fill": "#57A0C1"});
                    $(midwest_ids).css({"stroke":"#818181", "stroke-width": "1px", "fill": "#57A0C1"});
                    $(northeast_ids).css({"stroke":"#818181", "stroke-width": "1px", "fill": "#57A0C1"});

                    $('.region_title p').html('');
                }

                if(search_states.length !=0)
                {
                    var str = '';
                    $(search_states).each(function(val){
                        str += $(this)[0]+'|';
                    });
                    str = str.slice(0,-1);
                    filterReportDataTable(report_data_table,str,9);
                    console.log(str);
                }
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

                $('.dialog_for_map').dialog("close");

            });

            $('#region_cancel').click(function(){

                $(west_ids).css({"stroke":"#818181", "stroke-width": "1px", "fill": "#57A0C1"});
                $(south_ids).css({"stroke":"#818181", "stroke-width": "1px", "fill": "#57A0C1"});
                $(midwest_ids).css({"stroke":"#818181", "stroke-width": "1px", "fill": "#57A0C1"});
                $(northeast_ids).css({"stroke":"#818181", "stroke-width": "1px", "fill": "#57A0C1"});

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

                $('.dialog_for_map').dialog("close");
            });

            $('.ui-icon-closethick').click(function(){

                $(west_ids).css({"stroke":"#818181", "stroke-width": "1px", "fill": "#57A0C1"});
                $(south_ids).css({"stroke":"#818181", "stroke-width": "1px", "fill": "#57A0C1"});
                $(midwest_ids).css({"stroke":"#818181", "stroke-width": "1px", "fill": "#57A0C1"});
                $(northeast_ids).css({"stroke":"#818181", "stroke-width": "1px", "fill": "#57A0C1"});

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
                //showAndHideColumns(15, static_col_show_status, report_data_table);

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
                        //showAndHideColumns(15, true, report_data_table);

                        showAndHideColumns(column_number, true, report_data_table);
                    }
                });

                $("#display_form .not_default_display_checkbox").each(function() {
                    if(this.checked) {
                        this.checked = false;

                        var column_number = $(this).attr("col_num");

                        // Show static column
                        showAndHideColumns(0, true, report_data_table);
                        //showAndHideColumns(15, true, report_data_table);

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
                        //showAndHideColumns(15, true, report_data_table);

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
                        //showAndHideColumns(15, false, report_data_table);

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
