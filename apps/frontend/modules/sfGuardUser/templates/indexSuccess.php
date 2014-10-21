<?php use_helper('I18N', 'Date') ?>
<?php include_partial('sfGuardUser/assets') ?>
<div id="sf_admin_container">
    <h3><?php echo __('MANAGE USERS', array(), 'messages') ?></h3>

    <?php include_partial('sfGuardUser/flashes') ?>

    <div id="additional_list_actions">
        <?php include_partial('sfGuardUser/list_actions', array('helper' => $helper)) ?>
    </div>

    <div id="sf_admin_header">
        <?php include_partial('sfGuardUser/list_header', array('pager' => $pager)) ?>
        <?php include_partial('sfGuardUser/filters', array('form' => $filters, 'configuration' => $configuration)) ?>

    </div>



    <div id="sf_admin_content">
        <form id="admin_form_batch_actions" action="<?php echo url_for('sf_guard_user_collection', array('action' => 'batch')) ?>" method="post">

            <?php include_partial('sfGuardUser/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
            <ul class="sf_admin_actions">
                <?php include_partial('sfGuardUser/list_batch_actions', array('helper' => $helper)) ?>
                <?php include_partial('sfGuardUser/list_actions', array('helper' => $helper)) ?>
            </ul>
        </form>
    </div>

    <div id="sf_admin_footer">
        <?php include_partial('sfGuardUser/list_footer', array('pager' => $pager)) ?>
    </div>
</div>
<style>
    .sf_admin_form_row
    {
        display:none;
    }
    .sf_admin_filter_field_last_name, .sf_admin_filter_field_username, .sf_admin_filter_field_client_id {
        display:block !important;
    }
    .sf_admin_form_row td, tfoot td {
        border:none;
    }
    .sf_admin_filter table{
        width: 77%;
        /*float: right;*/
    }
    .sf_admin_filter_field_last_name{float:left; display:inline-block !important; }
    .sf_admin_filter_field_username {float:right; display:inline-block !important; }
    .sf_admin_filter_field_client_id{float:left}
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
     border-bottom: none !important;
     border-top:none !important;
    }
    #sf_admin_container tr {
        border-left: none !important;
        border-right: none !important;
    }
</style>
