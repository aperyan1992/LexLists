<?php use_helper('I18N', 'Date') ?>
<?php include_partial('clientAdminUserManagement/assets') ?>

<div id="sf_admin_container">
  <h3><?php echo __('EDIT USER', array(), 'messages') ?></h3>

  <div id="sf_admin_header">
    <?php include_partial('clientAdminUserManagement/form_header', array('sf_guard_user' => $sf_guard_user, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <?php include_partial('clientAdminUserManagement/form', array('sf_guard_user' => $sf_guard_user, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('clientAdminUserManagement/form_footer', array('sf_guard_user' => $sf_guard_user, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>
</div>
