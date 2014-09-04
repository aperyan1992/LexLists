<?php use_helper('I18N', 'Date') ?>
<?php include_partial('client/assets') ?>

<div id="sf_admin_container">
    <h3><?php echo __('MANAGE CLIENTS', array(), 'messages') ?></h3>

    <?php include_partial('client/flashes') ?>

    <div id="additional_list_actions">
        <?php include_partial('client/list_actions', array('helper' => $helper)) ?>
    </div>

    <div id="sf_admin_header">
        <?php include_partial('client/list_header', array('pager' => $pager)) ?>
    </div>


    <div id="sf_admin_content">
        <form id="admin_form_batch_actions" action="<?php echo url_for('lt_client_collection', array('action' => 'batch')) ?>" method="post">
            <?php include_partial('client/list', array('pager' => $pager, 'sort' => $sort, 'helper' => $helper)) ?>
            <ul class="sf_admin_actions">
                <?php include_partial('client/list_batch_actions', array('helper' => $helper)) ?>
                <?php include_partial('client/list_actions', array('helper' => $helper)) ?>
            </ul>
        </form>
    </div>

    <div id="sf_admin_footer">
        <?php include_partial('client/list_footer', array('pager' => $pager)) ?>
    </div>
</div>
