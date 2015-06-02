<?php if ($field->isPartial()): ?>
    <?php include_partial('surveyManagement/' . $name, array('form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?>
<?php elseif ($field->isComponent()): ?>
    <?php include_component('surveyManagement', $name, array('form' => $form, 'attributes' => $attributes instanceof sfOutputEscaper ? $attributes->getRawValue() : $attributes)) ?>
<?php else: ?>
  <tr style="<?php echo ($name == 'eligibility_criteria' || $name == 'nomination' || $name == 'selection_methodology' || $name == 'self_nomination' || $name == 'fees' || $name == 'pay_for_play')? "display: none;" : "" ?>" class="distance">
      <th style="padding-bottom:20px;">  
          <?php if ($help = $form[$name]->renderHelp()): ?>
            <?php echo $form[$name]->renderLabel($label, array("title" => $form->getWidgetSchema()->getHelp($name))) ?>
          <?php else : ?>
            <?php echo $form[$name]->renderLabel($label) ?>
          <?php endif; ?>
      </th>
      <td style="padding-bottom:20px;">  
          <?php if($attributes instanceof sfOutputEscaper) : ?>
            <?php $attributes = $attributes->getRawValue(); ?>
          <?php endif; ?>

          <?php if($name=='practice_areas_list')
          {
              echo '<select style="width: 281px; height: 16px; margin-bottom: 0 !important;" name="lt_survey[practice_areas_list][]" multiple="multiple" id="lt_survey_practice_areas_list">
                   <option value="5">Administrative</option>
                   <option value="51">Arbitration & Alternative Dispute Resolution</option>
                   <option value="52">Antitrust and Competition</option>
                   <option value="5">Aviation</option>
                   <option value="53"> Banking & Finance</option>
                   <option value="54">Bankruptcy</option>
                   <option value="58">M&A</option>
                   <option value="55">Civil Rights</option>
                   <option value="57">Construction</option>
                   <option value="57">Corporate Crime & Investigations</option>
                   <option value="55">Corporate</option>
                   <option value="52">Criminal Law</option>
                   <option value="54">Education Law</option>
                   <option value="7385">Employment Law</option>
                   <option value="586">Energy & Natural Resources</option>
                   <option value="5">Environmental</option>
                   <option value="38385">Family Law</option>
                   <option value="5">Healthcare</option>
                   <option value="5282">Immigration</option>
                   <option value="5435">Insurance</option>
                   <option value="4535">Intellectual Property</option>
                   <option value="35">International Law</option>
                   <option value="4535">Life Sciences</option>
                   <option value="275">Litigation</option></option>
                   <option value="83785">Media & Entertainment</option>
                   <option value="57822452">Poverty Law</option>
                   <option value="452455">Private Equity</option>
                   <option value="24525">Public Law & Policy</option>
                   <option value="8855">Real Estate</option>
                   <option value="453455">Regulatory</option>
                   <option value="985">Security & Data Privacy</option>
                   <option value="35">Trusts & Estates</option>
                   <option value="6585">Tax</option>
                   <option value="8385">Transportation</option>
                   <option value="5838"> Telecommunications </option>
          </select>
          ';
          }
          else
          {
            echo $form[$name]->render($attributes);
          } ?>            

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