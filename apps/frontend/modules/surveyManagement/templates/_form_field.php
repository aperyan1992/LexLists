<?php if ($field->isPartial()): ?>
    <?php include_partial('surveyManagement/' . $name, array('form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?>
<?php elseif ($field->isComponent()): ?>
    <?php include_component('surveyManagement', $name, array('form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?>
<?php else: ?>
  <tr class="distance">
      <th>            
          <?php if ($help = $form[$name]->renderHelp()): ?>
            <?php echo $form[$name]->renderLabel($label, array("title" => $form->getWidgetSchema()->getHelp($name))) ?>
          <?php else : ?>
            <?php echo $form[$name]->renderLabel($label) ?>
          <?php endif; ?>
      </th>
      <td>  
          <?php if($attributes instanceof sfOutputEscaper) : ?>
            <?php $attributes = $attributes->getRawValue(); ?>
          <?php endif; ?>

          <?php echo $form[$name]->render($attributes) ?>            

          <?php if(array_key_exists("with_add_new_link", $attributes) !== FALSE) : ?>
              <?php include_partial("surveyManagement/add_new_link", array('field_name' => $name)); ?>
          <?php endif; ?>
        
          <?php if(count($attributes) > 0 && array_key_exists("required", $attributes) !== FALSE) : ?>
              <span class="required_input_admin">*</span>
          <?php endif; ?>

          <?php echo $form[$name]->renderError() ?>
      </td>
  </tr>    
<?php endif; ?>