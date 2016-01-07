<?php if ($field->isPartial()): ?>
    <?php include_partial('surveyManagement/' . $name, array('form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?>
<?php elseif ($field->isComponent()): ?>
    <?php include_component('surveyManagement', $name, array('form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?>
<?php else: ?>
    <?php if($name == "submission_deadline" || $name == "survey_description" || $name == "practice_areas_list" || $name == "keywords" || $name == "survey_contact_id" || $name == "survey_notes" || $name == "staff_notes" || $name == "status"): ?>
        <div class="one_col col-md-12 col-lg-12 col-sm-12">
            <div style="<?php echo ($name == 'eligibility_criteria' || $name == 'nomination' || $name == 'selection_methodology' || $name == 'self_nomination' || $name == 'fees' || $name == 'pay_for_play')? "display: none;" : "" ?>" class="distance col-md-6 col-lg-6 col-sm-6">
                  <?php if ($help = $form[$name]->renderHelp()): ?>
                    <?php echo $form[$name]->renderLabel($label, array("title" => $form->getWidgetSchema()->getHelp($name))) ?>
                  <?php else : ?>
                    <?php echo $form[$name]->renderLabel($label) ?>
                  <?php endif; ?>
              <div style="padding-bottom:20px;">
                  <?php
                  if($attributes instanceof sfOutputEscaper) : ?>
                    <?php $attributes = $attributes->getRawValue(); ?>
                  <?php endif; ?>
                    <?php echo $form[$name]->render($attributes);                     ?>

                  <?php if(array_key_exists("with_add_new_link", $attributes) !== FALSE OR
                  $name=='keywords') : ?>
                      <?php include_partial("surveyManagement/add_new_link", array('field_name' => $name)); ?>
                  <?php endif; ?>

                  <?php if(count($attributes) > 0 && array_key_exists("required", $attributes) !== FALSE) : ?>
                      <span class="required_input_admin">*</span>
                  <?php endif; ?>
                  <?php echo $form[$name]->renderError() ?>
              </div>
            </div>
        </div>
    <?php else: ?>
        <div style="<?php echo ($name == 'eligibility_criteria' || $name == 'nomination' || $name == 'selection_methodology' || $name == 'self_nomination' || $name == 'fees' || $name == 'pay_for_play')? "display: none;" : "" ?>" class="distance col-md-6 col-lg-6 col-sm-6 <?php echo ($name == 'is_legal' || $name == 'is_list')? "legal_list" : "" ?>">
            <?php if ($help = $form[$name]->renderHelp()): ?>
                <?php echo $form[$name]->renderLabel($label, array("title" => $form->getWidgetSchema()->getHelp($name))) ?>
            <?php else : ?>
                <?php echo $form[$name]->renderLabel($label) ?>
            <?php endif; ?>
            <div style="padding-bottom:20px;">
                <?php
                if($attributes instanceof sfOutputEscaper) : ?>
                    <?php $attributes = $attributes->getRawValue(); ?>
                <?php endif; ?>
                <?php echo $form[$name]->render($attributes);                     ?>

                <?php if(array_key_exists("with_add_new_link", $attributes) !== FALSE OR
                    $name=='keywords') : ?>
                    <?php include_partial("surveyManagement/add_new_link", array('field_name' => $name)); ?>
                <?php endif; ?>

                <?php if(count($attributes) > 0 && array_key_exists("required", $attributes) !== FALSE) : ?>
                    <span class="required_input_admin">*</span>
                <?php endif; ?>
                <?php echo $form[$name]->renderError() ?>
            </div>
        </div>
    <?php endif; ?>
<?php if($i=="6" || $i=="11" || $i=="13" || $i=="17" || $i=="24" || $i=="25"): ?> <div class="hr_line col-md-12 col-lg-12 col-sm-12" style="border-bottom: solid lightgrey 1px;"></div> <?php endif; endif; ?>
