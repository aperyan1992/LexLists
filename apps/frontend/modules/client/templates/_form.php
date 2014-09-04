<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<div class="sf_admin_form" id="client_form">
    <?php echo form_tag_for($form, '@lt_client') ?>
        <table class="new_edit_table">
            <tfoot>
                <tr>
                    <td colspan="2">
                        <?php echo $form->renderHiddenFields(false) ?>   
                        
                        <input type="hidden" id="is_new_object" value="<?php echo ($form->isNew()) ? 'true' : $form->getObject()->getId() ?>" />
                        
                        <div class="admin_buttons_div">
                            <input type="button" value="Cancel" list_url="<?php echo url_for("@" . $helper->getUrlForAction('list')); ?>" class="cancel_admin_panel btn btn-success" />                          
                            <input type="submit" value="Save" form_name="client" class="btn btn-success save_button" />                            
                        </div>
                        
                        <?php // include_partial('client/form_actions', array('lt_client' => $lt_client, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
                    </td>
                </tr>
            </tfoot>
            <tbody>
                <div class="alert alert-success success_message" style="display: none;">Success! Client has been added.</div>
                    
                <?php foreach ($configuration->getFormFields($form, $form->isNew() ? 'new' : 'edit') as $fieldset => $fields): ?>
                    <?php include_partial('client/form_fieldset', array('lt_client' => $lt_client, 'form' => $form, 'fields' => $fields, 'fieldset' => $fieldset)) ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </form>
</div>
