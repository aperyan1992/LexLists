<?php use_stylesheets_for_form($form) ?>
<?php use_javascripts_for_form($form) ?>

<div class="sf_admin_form" id="survey_form">
    <?php echo form_tag_for($form, '@lt_survey') ?>
        <table class="new_edit_table">
            <tfoot>
                <tr>
                    <td colspan="2">
                        <?php echo $form->renderHiddenFields(false) ?>   
                        
                        <input type="hidden" id="is_new_object" value="<?php echo ($form->isNew()) ? 'true' : $form->getObject()->getId() ?>" />
                        
                        <div class="admin_buttons_div" style="width: 702px !important;">
                            <input type="button" value="Cancel" list_url="<?php echo url_for("@" . $helper->getUrlForAction('list')); ?>" class="cancel_admin_panel btn btn-success" />                          
                            <input type="submit" value="Save" form_name="survey" class="btn btn-success save_button" />
                        </div>
                        
                        <?php // include_partial('surveyManagement/form_actions', array('lt_survey' => $lt_survey, 'form' => $form, 'configuration' => $configuration, 'helper' => $helper)) ?>
                    </td>
                </tr>
            </tfoot>
            <tbody>
                <div class="alert alert-success success_message" style="display: none;">Success! Survey has been added.</div>
                    
                <?php foreach ($configuration->getFormFields($form, $form->isNew() ? 'new' : 'edit') as $fieldset => $fields): ?>
                    <?php    include_partial('surveyManagement/form_fieldset', array('lt_survey' => $lt_survey, 'form' => $form, 'fields' => $fields, 'fieldset' => $fieldset)) ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </form>
</div>

<div style="display: none;">
    <?php include_partial("surveyManagement/add_survey_contact_popup"); ?>
    <?php include_partial("surveyManagement/add_survey_organization_popup"); ?>
    <?php include_partial("surveyManagement/add_survey_city_popup"); ?>
    <?php include_partial("surveyManagement/add_survey_special_criteria_popup"); ?>
    <?php include_partial("surveyManagement/add_new_keyword_popup"); ?>
</div>