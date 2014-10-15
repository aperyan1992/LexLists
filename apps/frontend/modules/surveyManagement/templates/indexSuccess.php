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
    <div id="sf_admin_bar" style="display: block">
        <?php include_partial('surveyManagement/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
    </div>

    <div id="sf_admin_content">
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
    .sf_admin_form_row
    {
        display:none;
    }
    .sf_admin_filter_field_organization_id, .sf_admin_filter_field_survey_name, .sf_admin_filter_field_year {
        display:block !important;
    }
    .sf_admin_list table {
        width: 56% !important;
    }
</style>