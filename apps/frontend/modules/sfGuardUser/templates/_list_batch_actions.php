<script>

    $(document).ready(function() {
        
        $('#batch_action_button').click(function() {
            var batch_actions_value = $('#batch_actions_select').val();
            
            if(batch_actions_value == "batchDelete") {
                openConfirmPopupWindow('dialog_cofirm_alert');                
                return false;
            }            
        })
        
    })

</script>

<li class="sf_admin_batch_actions_choice">
    <select name="batch_action" id="batch_actions_select">
        <option value=""><?php echo __('Choose an action', array(), 'sf_admin') ?></option>
        <option value="batchDelete"><?php echo __('Delete', array(), 'sf_admin') ?></option>
    </select>
    <?php $form = new BaseForm();
    if ($form->isCSRFProtected()): ?>
        <input type="hidden" name="<?php echo $form->getCSRFFieldName() ?>" value="<?php echo $form->getCSRFToken() ?>" />
    <?php endif; ?>
    <input class="btn btn-success" id="batch_action_button" type="submit" value="<?php echo __('go', array(), 'sf_admin') ?>" />
</li>
