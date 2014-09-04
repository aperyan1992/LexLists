<?php use_helper('I18N', 'Date') ?>
<?php include_partial('clientAdminUserManagement/assets') ?>

<div id="sf_admin_container">
    <h3><?php echo __('MANAGE USERS', array(), 'messages') ?></h3>

    <?php include_partial('clientAdminUserManagement/flashes') ?>

    <div id="additional_list_actions">
        <?php include_partial('clientAdminUserManagement/list_actions', array('helper' => $helper)) ?>
    </div>

    <div id="sf_admin_header">
        <?php include_partial('clientAdminUserManagement/list_header', array('pager' => $pager)) ?>
    </div>

    <div id="sf_admin_bar">
        <?php include_partial('clientAdminUserManagement/filters', array('form' => $filters, 'configuration' => $configuration)) ?>
    </div>

    <div id="sf_admin_content">
        <form id="admin_form_batch_actions" action="<?php echo url_for('sf_guard_user2_collection', array('action' => 'batch')) ?>" method="post">
            <?php include_partial('clientAdminUserManagement/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
            <ul class="sf_admin_actions">
                <?php include_partial('clientAdminUserManagement/list_batch_actions', array('helper' => $helper)) ?>
                <?php include_partial('clientAdminUserManagement/list_actions', array('helper' => $helper)) ?>
            </ul>
        </form>
    </div>

    <div id="sf_admin_footer">
        <?php include_partial('clientAdminUserManagement/list_footer', array('pager' => $pager)) ?>
    </div>
</div>
