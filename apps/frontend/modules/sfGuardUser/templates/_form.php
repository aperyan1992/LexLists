<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<div class="sf_admin_form" id="user_form">
    <?php echo form_tag_for($form, '@sf_guard_user') ?>
        <table class="new_edit_table">
            <tfoot>
                <tr>
                    <td colspan="2">
                        <?php echo $form->renderHiddenFields(false) ?>      
                        
                        <input type="hidden" id="is_new_object" value="<?php echo ($form->isNew()) ? 'true' : $form->getObject()->getId() ?>" />
                        
                        <div class="admin_buttons_user_management_div">
                            <input type="button" value="Cancel" list_url="<?php echo url_for("@" . $helper->getUrlForAction('list')); ?>" class="cancel_admin_panel btn btn-success" />                          
                            <input type="submit" value="Save" form_name="users_for_superuser" class="save_button btn btn-success" />                            
                        </div>
                        
                        <?php // include_partial('sfGuardUser/form_actions', array('sf_guard_user' => $sf_guard_user, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
                    </td>
                </tr>
            </tfoot>
            <tbody>
                <div class="alert alert-success success_message" style="display: none;">Success! User has been added.</div>
                    
                <?php foreach ($configuration->getFormFields($form, $form->isNew() ? 'new' : 'edit') as $fieldset => $fields): ?>
                    <?php include_partial('sfGuardUser/form_fieldset', array('sf_guard_user' => $sf_guard_user, 'form' => $form, 'fields' => $fields, 'fieldset' => $fieldset)) ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </form>
</div>
