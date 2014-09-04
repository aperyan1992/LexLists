<h3>CHANGE YOUR PASSWORD</h3>

<?php if($sf_user->hasFlash('notice')) : ?>
  <div class="alert alert-success">
    <?php echo $sf_user->getFlash('notice'); ?>
  </div>
<?php endif; ?>

<form action="<?php echo url_for('@basic_user') ?>" method="post" <?php $basic_user_form->isMultipart() and print 'enctype="multipart/form-data" ' ?>>
<?php if (!$basic_user_form->getObject()->isNew()): ?>
<input type="hidden" name="sf_method" value="put" />
<?php endif; ?>
    <table>
        <tfoot>
            <tr>
                <td colspan="2">
                    <?php echo $basic_user_form->renderHiddenFields(false) ?>                    
                    <input class="btn btn-success" type="submit" value="Save" />
                </td>
            </tr>
        </tfoot>
        <tbody>
            <tr>
                <th>
                    <?php echo $basic_user_form['password']->renderLabel() ?>
                </th>
                <td>                    
                    <?php echo $basic_user_form['password'] ?>
                    <span class="required_input">*</span>
                    <?php echo $basic_user_form['password']->renderError() ?>
                </td>
            </tr>
            <tr>
                <th>
                    <?php echo $basic_user_form['password_again']->renderLabel() ?>
                </th>
                <td>
                    <?php echo $basic_user_form['password_again'] ?>
                    <span class="required_input">*</span>
                    <?php echo $basic_user_form['password_again']->renderError() ?>
                </td>
            </tr>            
        </tbody>
    </table>
</form>