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

<!-- Header -->
<header id="header">
    <div class="container">
        <div class="row">

            <!-- Logo -->
            <div id="logo" class="span3 logo_margin_left">
                <a href="<?php echo url_for("@homepage"); ?>"><img src="/images/LexListsLogoDemo.jpg" alt="LexLists"></a>
            </div>

            <!-- Menu -->
            <?php if($sf_user->isAuthenticated()) : ?>
                <div id="navigation" class="span3 offset6 navigation_margin_right">
                    <nav class="pull-right">
                        <ul class="navigation_ul">
                            <li class="first_menu_block">
                                <a class="custom_link correct_custom_link" href="<?php echo url_for("@sf_guard_signout") ?>">Logout</a>
                            </li>
                            <li class="first_menu_block">
                                <a class="custom_link correct_custom_link disable" href="#">Settings</a>
                                <ul class="submenu">
                                    <?php if($sf_user->hasCredential("superuser")) : ?>
                                        <li>
                                            <a class="custom_main_link correct_custom_link last_menu_link disable" href="#">Accounts</a>
                                            <ul>
                                                <li><a class="custom_link correct_custom_link" href="<?php echo url_for("@lt_client"); ?>">Manage Client Accounts</a></li>
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
                                <a class="custom_link correct_custom_link" href="<?php echo url_for("@my_list") ?>">My List</a>
                            </li>
                            <li class="current-menu-item first_menu_block">
                                        <span id="hi_username">
                                            <?php echo $sf_user->getGuardUser()->getFirstName() . " " . $sf_user->getGuardUser()->getLastName() ?> 
                                        </span>
                            </li>
                        </ul>
                        <ul id="today_time">
                            <li>
                                        <span>
                                            Today is <?php echo date('F j, Y') ?>
                                        </span>
                            </li>
                        </ul>

                    </nav>
                </div>
            <?php endif; ?>

        </div>
    </div>
</header><!-- #header -->

<!-- Main Content -->
<section id="body">

    <div class="container">
        <div class="row">
            <?php if($sf_user->isAuthenticated()) : ?>
                <div class="tabbable tabs-top">
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

                        <li class="<?php echo $dashboard_active_class ?>"><a href="<?php echo url_for("@homepage"); ?>" data-toggle="tab">Dashboard</a></li>

                        <li class="<?php echo $help_active_class ?> right_tab"><a href="<?php echo url_for("@help_page"); ?>" data-toggle="tab">Help</a></li>
                        <li class="<?php echo $my_lists_active_class ?> right_tab tab_correct">
                            <?php include_component('mySurvey', 'mySurveysBubbles') ?>
                            <a href="<?php echo url_for("@my_list"); ?>" data-toggle="tab">My List</a>
                        </li>
                        <li class="<?php echo $manage_system_active_class ?> right_tab tab_correct"><a href="#" data-toggle="tab">Settings</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="recent">
                            <?php echo $sf_content ?>
                        </div>
                    </div>
                </div>

            <?php else : ?>
                <?php echo $sf_content ?>
            <?php endif; ?>
        </div>
    </div>
</section><!-- #body -->

<!-- Footer -->
<footer id="footer">

    <div id="copyright">
        <div class="container">
            <div class="row">
                <div class="span8">Copyright 2012-2014 LexLists by LexSource. All Rights Reserved.</div>
            </div>
        </div>
    </div><!-- #copyright -->

</footer><!-- #footer -->

<div id="display_blocker" style="display: none;">
    <div class="blocker_ajax_loader">
        Setting Alert... <img src="/images/ajax-loader2.gif" />
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