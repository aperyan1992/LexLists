<?php use_helper('I18N') ?>

<div class="signin_div">
    <h1><?php echo __('LOG IN', null, 'sf_guard') ?></h1>

    <?php echo get_partial('sfGuardAuth/signin_form', array('form' => $form)) ?>
</div>
