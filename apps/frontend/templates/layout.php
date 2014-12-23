<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <?php include_http_metas() ?>
        <?php include_metas() ?>
        <?php include_title() ?>        
        <link rel="shortcut icon" href="/favicon.ico" />
        <?php include_stylesheets() ?>
        <?php include_javascripts() ?>
        <!--[if lt IE 9]>
            <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
    </head>
    <body id="home">

    <div class="container-fluid" style="/*border: 1px solid #ff6801;*/ padding: 0; background-color: #36A9E1; border-bottom: 3px solid #1E8FC6">
        <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0">
            <!-- Logo -->
            <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" style="background-color: #1E8FC6; padding: 0; height: 55px">
                <a href="<?php echo url_for("@homepage"); ?>"><img src="/images/LexListsLogoDemo2.png" alt="LexLists" style="height: 40px; margin-left: 20%;"></a>
            </div>
            <div class="col-xs-12 col-sm-9 col-md-9 col-lg-9" style="padding: 0">
                <!-- Menu -->
                <?php  if($sf_user->isAuthenticated()) : ?>

                    <div class="col-md-6 col-lg-6"> </div>

                    <div id="navigation" class=" col-xs-12 col-sm-12 col-md-6 col-lg-6" style="height: 55px; padding: 0">
                        <nav class="col-xs-12 col-sm-12 col-md-12 col-lg-12 pull-right" style="padding: 0">
                            <ul class="col-xs-12 col-sm-12 col-md-12 col-lg-12 navigation_ul pull-right" >
                                <li class="first_menu_block">
                                    <a class="color_white" href="<?php echo url_for("@sf_guard_signout") ?>" >Logout</a>
                                </li>
                                <li class="first_menu_block">
                                    <a class="disable color_white" href="#">Settings</a>
                                    <ul class="submenu">
                                        <?php if($sf_user->hasCredential("superuser")) : ?>
                                            <li>
                                                <a class="custom_main_link correct_custom_link last_menu_link disable" href="#">Accounts</a>
                                                <ul>
                                                    <li><a class="custom_link correct_custom_link" href="<?php echo url_for("@lt_client"); ?>" >Manage Client Accounts</a></li>
                                                    <li><a class="custom_link correct_custom_link last_menu_link" href="<?php echo url_for("@sf_guard_user"); ?>">Manage Users</a></li>
                                                </ul>
                                            </li>
                                            <li>
                                                <a class="custom_main_link correct_custom_link last_menu_link disable" href="#">Surveys</a>
                                                <ul>
                                                    <li><a class="custom_link correct_custom_link last_menu_link" href="<?php echo url_for("@lt_survey"); ?>">Manage Surveys</a></li>
                                                </ul>
                                            </li>
                                            <li>
                                                <a class="custom_main_link correct_custom_link last_menu_link disable" href="#">Data</a>
                                                <ul>
                                                    <li><a class="custom_link correct_custom_link last_menu_link" href="<?php echo url_for("dataload/index"); ?>">Data upload(csv)</a></li>
                                                </ul>
                                            </li>
                                        <?php elseif($sf_user->hasCredential("client admin")) : ?>
                                            <?php $sf_user->setAttribute('clientAdminUserManagement.filters', array("client_id" => $sf_user->getGuardUser()->getClientId()), 'admin_module'); ?>
                                            <li>
                                                <a class="custom_main_link correct_custom_link last_menu_link disable" href="#">Accounts</a>
                                                <ul>
                                                    <li><a class="custom_link correct_custom_link last_menu_link" href="<?php echo url_for("@sf_guard_user2"); ?>">Manage Users</a></li>
                                                </ul>
                                            </li>
                                        <?php elseif($sf_user->hasCredential("client user")) : ?>
                                            <li>
                                                <a class="custom_link correct_custom_link last_menu_link" href="<?php echo url_for("@basic_user"); ?>">Password</a>
                                            </li>
                                        <?php endif; ?>
                                    </ul>
                                </li>
                                <li class="first_menu_block">
                                    <a class="color_white" href="<?php echo url_for("@my_list") ?>">My List</a>
                                </li>
                                <li class="current-menu-item first_menu_block">
                                        <span id="hi_username">
                                            <?php echo $sf_user->getGuardUser()->getFirstName() . " " . $sf_user->getGuardUser()->getLastName() ?>
                                        </span>
                                </li>
                            </ul>

                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="col-sm-5 col-md-5 col-lg-5"></div>
                                    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
                                    <ul id="today_time" class="pull-right" style="color: #fff !important;">
                                        <li>
                                                <span>
                                                    Today is <?php echo date('F j, Y') ?>
                                                </span>
                                        </li>
                                    </ul>
                                    </div>
                            </div>
                        </nav>
                    </div>

                <?php endif; ?>

            </div>

        </div>
        </div>
    </div>


    <div class="container-fluid" style="padding: 0">

        <!--<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border: 1px solid; padding: 0">-->


            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="/*border: 1px solid red;*/ padding: 0">

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0">

                    <ul class="nav nav-tabs">

                        <?php if($sf_user->isAuthenticated()) : ?>
                            <div class="tabbable tabs-top col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0">
                                <ul class="nav nav-tabs">
                                    <?php
                                    switch ($sf_context->getInstance()->getRouting()->getCurrentRouteName()) {
                                        case "lt_survey" :
                                        case "lt_survey_new" :
                                        case "lt_survey_edit" :
                                        case "lt_survey_create" :
                                        case "lt_survey_update" :
                                        case "lt_client" :
                                        case "lt_client_new" :
                                        case "lt_client_edit" :
                                        case "lt_client_create" :
                                        case "lt_client_update" :
                                        case "sf_guard_user" :
                                        case "sf_guard_user_edit" :
                                        case "sf_guard_user_new" :
                                        case "sf_guard_user_create" :
                                        case "sf_guard_user_update" :
                                        case "sf_guard_user2" :
                                        case "sf_guard_user2_edit" :
                                        case "sf_guard_user2_new" :
                                        case "sf_guard_user2_create" :
                                        case "sf_guard_user2_update" :
                                        case "basic_user" :
                                            $dashboard_active_class     = "";
                                            $my_lists_active_class      = "";
                                            $manage_system_active_class = "active visible_tab";
                                            $help_active_class          = "";
                                            break;

                                        case "help_page" :
                                            $dashboard_active_class     = "";
                                            $my_lists_active_class      = "";
                                            $manage_system_active_class = " invisible_tab";
                                            $help_active_class          = "active";
                                            break;

                                        case "my_list" :
                                            $dashboard_active_class     = "";
                                            $my_lists_active_class      = "active";
                                            $manage_system_active_class = " invisible_tab";
                                            $help_active_class          = "";
                                            break;

                                        case "homepage" :
                                        default :
                                            $dashboard_active_class     = "active";
                                            $my_lists_active_class      = "";
                                            $manage_system_active_class = " invisible_tab";
                                            $help_active_class          = "";
                                            break;
                                    }
                                    ?>
                                    <li class="<?php echo $dashboard_active_class ?>" style="margin-left: 25px"><a href="<?php echo url_for("@homepage"); ?>" data-toggle="tab" class="button_style">Dashboard</a></li>
                                    <li class="<?php echo $help_active_class ?> right_tab" style="margin-right: 25px"><a href="<?php echo url_for("@help_page"); ?>" data-toggle="tab" class="button_style">Help</a></li>
                                    <li class="<?php echo $my_lists_active_class ?> right_tab tab_correct">
                                        <?php include_component('mySurvey', 'mySurveysBubbles') ?>
                                        <a href="<?php echo url_for("@my_list"); ?>" data-toggle="tab" class="button_style">My List</a>
                                    </li>
                                    <li class="<?php echo $manage_system_active_class ?> right_tab tab_correct"><a href="#" data-toggle="tab" class="button_style">Settings</a></li>

                                </ul>
                                <div class="tab-content col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0">
                                    <div class="tab-pane active col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0" id="recent">
                                        <?php echo $sf_content ?>
                                    </div>
                                </div>
                            </div>

                        <?php else : ?>
                            <?php echo $sf_content ?>
                        <?php endif; ?>
                    </ul>

                </div>

            </div>

<!--            <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9" style="border: 1px solid red; padding: 0; height: 500px">

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> </div>

            </div>-->

       <!-- </div>-->
    </div>


    <footer class="container-fluid" style="padding: 0; background-color: #36A9E1 !important">

        <div id="copyright" class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="background-color: #36A9E1; border: 1px solid #36A9E1">
            <div class="container">
                <div class="row" >
                    <div class="span8">Copyright 2012-2014 LexLists by LexSource. All Rights Reserved.</div>
                </div>
            </div>
        </div>

    </footer>
        <!-- Main Content -->
        <!--<section id="body">
            
            <div class="container">
                <div class="row">
                    <?php /*if($sf_user->isAuthenticated()) : */?>
                        <div class="tabbable tabs-top">
                            <ul class="nav nav-tabs">                                
                                <?php
/*                                    switch ($sf_context->getInstance()->getRouting()->getCurrentRouteName()) {
                                        case "lt_survey" :
                                        case "lt_survey_new" :
                                        case "lt_survey_edit" :
                                        case "lt_survey_create" :
                                        case "lt_survey_update" :
                                        case "lt_client" :
                                        case "lt_client_new" :
                                        case "lt_client_edit" :
                                        case "lt_client_create" :
                                        case "lt_client_update" :
                                        case "sf_guard_user" :
                                        case "sf_guard_user_edit" :
                                        case "sf_guard_user_new" :
                                        case "sf_guard_user_create" :
                                        case "sf_guard_user_update" :
                                        case "sf_guard_user2" :
                                        case "sf_guard_user2_edit" :
                                        case "sf_guard_user2_new" :
                                        case "sf_guard_user2_create" :
                                        case "sf_guard_user2_update" :
                                        case "basic_user" :                                        
                                            $dashboard_active_class     = "";
                                            $my_lists_active_class      = "";
                                            $manage_system_active_class = "active visible_tab";
                                            $help_active_class          = "";
                                            break;

                                        case "help_page" :
                                            $dashboard_active_class     = "";
                                            $my_lists_active_class      = "";
                                            $manage_system_active_class = " invisible_tab";
                                            $help_active_class          = "active";
                                            break;
                                        
                                        case "my_list" : 
                                            $dashboard_active_class     = "";
                                            $my_lists_active_class      = "active";
                                            $manage_system_active_class = " invisible_tab";
                                            $help_active_class          = "";
                                            break;
                                        
                                        case "homepage" :                                        
                                        default :
                                            $dashboard_active_class     = "active";
                                            $my_lists_active_class      = "";
                                            $manage_system_active_class = " invisible_tab";
                                            $help_active_class          = "";
                                            break;
                                    } 
                                */?>
                              
                                <li class="<?php /*echo $dashboard_active_class */?>"><a href="<?php /*echo url_for("@homepage"); */?>" data-toggle="tab">Dashboard</a></li>
                                
                                <li class="<?php /*echo $help_active_class */?> right_tab"><a href="<?php /*echo url_for("@help_page"); */?>" data-toggle="tab">Help</a></li>
                                <li class="<?php /*echo $my_lists_active_class */?> right_tab tab_correct">
                                    <?php /*include_component('mySurvey', 'mySurveysBubbles') */?>
                                    <a href="<?php /*echo url_for("@my_list"); */?>" data-toggle="tab">My List</a>
                                </li>
                                <li class="<?php /*echo $manage_system_active_class */?> right_tab tab_correct"><a href="#" data-toggle="tab">Settings</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="recent">
                                    <?php /*echo $sf_content */?>
                                </div>
                            </div>
                        </div>                    
                    
                    <?php /*else : */?>
                        <?php /*echo $sf_content */?>
                    <?php /*endif; */?>
                </div>
            </div>
        </section>--><!-- #body-->
        
        <!-- Footer -->
        <!--<footer id="footer">

            <div id="copyright">
                <div class="container">
                    <div class="row">
                        <div class="span8">Copyright 2012-2014 LexLists by LexSource. All Rights Reserved.</div>
                    </div>
                </div>
            </div><!-- #copyright

        </footer><!-- #footer -->
        
        <div id="display_blocker" style="display: none;">
          <div class="blocker_ajax_loader">
            Sending message... <img src="/images/ajax-loader2.gif" />
          </div>
        </div>
        
    </body>
    <!--<body>-->
        
    <!--</body>-->
</html>

<script>

$(document).ready(function() {
    
    $("#navigation .disable").click(function() {
        return false;
    }); 
    
});

</script>

<?php include_partial('dashboard/alert_popups'); ?>
