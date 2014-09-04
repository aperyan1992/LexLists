<?php use_helper('I18N', 'Date') ?>
<?php include_partial('client/assets') ?>

<div id="sf_admin_container">
  <h3><?php echo __('EDIT CLIENT', array(), 'messages') ?></h3>

  <div id="sf_admin_header">
    <?php include_partial('client/form_header', array('lt_client' => $lt_client, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>

  <div id="sf_admin_content">
    <?php include_partial('client/form', array('lt_client' => $lt_client, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
  </div>

  <div id="sf_admin_footer">
    <?php include_partial('client/form_footer', array('lt_client' => $lt_client, 'form' => $form, 'configuration' => $configuration)) ?>
  </div>
</div>
