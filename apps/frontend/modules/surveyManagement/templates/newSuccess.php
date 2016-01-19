<?php use_helper('I18N', 'Date') ?>

<?php include_partial('surveyManagement/assets') ?>

<div id="sf_admin_container">
    <h3><?php echo __('ADD NEW SURVEY', array(), 'messages') ?></h3>

    <div id="sf_admin_header">
      <?php include_partial('surveyManagement/form_header', array('lt_survey' => $lt_survey, 'form' => $form, 'configuration' => $configuration)) ?>
    </div>

    <div id="sf_admin_content">
      <?php include_partial('surveyManagement/form', array('lt_survey' => $lt_survey, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
    </div>

    <div id="sf_admin_footer">
      <?php include_partial('surveyManagement/form_footer', array('lt_survey' => $lt_survey, 'form' => $form, 'configuration' => $configuration)) ?>
    </div>
</div>