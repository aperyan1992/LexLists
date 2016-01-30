
<?php use_helper('I18N', 'Date') ?>
<?php include_partial('surveyManagement/assets') ?>

<div id="sf_admin_container">
    <h3><?php echo __('MANAGE SURVEYS', array(), 'messages') ?></h3>

    <?php include_partial('surveyManagement/flashes') ?>

    <div id="additional_list_actions">
        <?php include_partial('surveyManagement/list_actions', array('helper' => $helper)) ?>
    </div>


    <div id="sf_admin_header">
        <?php include_partial('surveyManagement/list_header', array('pager' => $pager)) ?>
    </div>

    <div id="sf_admin_content">
        <?php include_partial('surveyManagement/filters', array('form' => $filters, 'configuration' => $configuration)) ?>

        <form id="admin_form_batch_actions" action="<?php echo url_for('lt_survey_collection', array('action' => 'batch')) ?>" method="post">
            <?php include_partial('surveyManagement/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
            <ul class="sf_admin_actions">
                <?php include_partial('surveyManagement/list_batch_actions', array('helper' => $helper)) ?>
                <?php include_partial('surveyManagement/list_actions', array('helper' => $helper)) ?>
            </ul>
        </form>
    </div>

    <div id="sf_admin_footer">
        <?php include_partial('surveyManagement/list_footer', array('pager' => $pager)) ?>
    </div>
</div>
<style>
    .sf_admin_filter_field_organization_id, .sf_admin_filter_field_survey_name, .sf_admin_filter_field_year {
        display:block !important;
    }
    .sf_admin_list table {
        width: 100% !important;
    }
    .sf_admin_form_row
    {
        display:none;
    }
    .sf_admin_form_row td, tfoot td {
        border:none;
    }
    .sf_admin_filter table{
        width: 77%;
        /*float: right;*/
    }
    .sf_admin_filter_field_organization_id{float:left; display:inline-block !important; }
    .sf_admin_filter_field_survey_name {float:right; display:inline-block !important; }
    .sf_admin_filter_field_year{float:left}
    tfoot > tr > td{
        text-align: center !important;
    }
    tfoot > tr > td > a{
        color:#ff6801 !important;
        margin-right: 15px;
    }
    tfoot > tr > td > input{
        background-color: #ff6801 ;
        color:#FFF !important;
        border:1px solid #ff6801;
        padding:3px;
    }
    #sf_admin_container .sf_admin_form_row {
        clear: left; !important;
    }
    #sf_admin_container td, #sf_admin_container th {
        max-width: 360px;
        padding: 0px 9px;
        border-bottom: none !important;
        border-top:none !important;
    }
    #sf_admin_container tr {
        border-left: none !important;
        border-right: none !important;
    }

    #lt_survey_filters_year, #lt_survey_filters_survey_name {
        margin-bottom: 10px !important;
    }

    #lt_survey_filters_year {
        margin-left: 50px;
        width: 188px !important;
    }
    #lt_survey_filters_year_is_empty {
        margin-left: 50px !important;
    }


</style>