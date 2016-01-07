<?php if ($field->isPartial()): ?>
    <?php include_partial('client/' . $name, array('form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?>
<?php elseif ($field->isComponent()): ?>
    <?php include_component('client', $name, array('form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?>
<?php else: ?>
    <tr>
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

            <?php if(count($attributes) > 0 && array_search("required", $attributes)) : ?>
                <span class="required_input_admin">*</span>
            <?php endif; ?>

            <?php echo $form[$name]->renderError() ?>
        </td>
    </tr>

<?php endif; ?>
