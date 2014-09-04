<?php if ($field->isPartial()): ?>
    <?php include_partial('clientAdminUserManagement/' . $name, array('form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?>
<?php elseif ($field->isComponent()): ?>
    <?php include_component('clientAdminUserManagement', $name, array('form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?>
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
          
            <?php if($name == "groups_list") : ?>
                <?php if(sfContext::getInstance()->getRouting()->getCurrentRouteName() == 'sf_guard_user2_edit' || sfContext::getInstance()->getRouting()->getCurrentRouteName() == 'sf_guard_user2_update') : ?>
                    <?php echo $form[$name]->render($attributes) ?>
                <?php else : ?>
                    <select title="Group." name="sf_guard_user[groups_list]" id="sf_guard_user_groups_list" style="width: 333px !important; height: 16px;">
                        <option value="2">Admin</option>
                        <option value="3" selected>User</option>
                    </select>
                <?php endif; ?>

            <?php else : ?>
                <?php echo $form[$name]->render($attributes) ?>
            <?php endif; ?>
            
            <?php if(count($attributes) > 0 && array_search("required", $attributes)) : ?>
                <?php if(sfContext::getInstance()->getRouting()->getCurrentRouteName() == 'sf_guard_user2_edit' || !sfContext::getInstance()->getRouting()->getCurrentRouteName() == 'sf_guard_user2_update') : ?>
                    <?php if($name != 'password' && $name != 'password_again') : ?>
                        <span class="required_input_admin">*</span>
                    <?php endif; ?>
                <?php else : ?>
                    <span class="required_input_admin">*</span>
                <?php endif; ?>
            
            <?php endif; ?>
            
            <?php echo $form[$name]->renderError() ?>
        </td>
    </tr>
<?php endif; ?>
