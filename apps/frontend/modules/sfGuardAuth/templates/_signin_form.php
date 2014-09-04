<?php use_helper('I18N') ?>

<form action="<?php echo url_for('@sf_guard_signin') ?>" method="post">
    <table>
        <tbody>
            <tr>
                <th>
                    <?php echo $form['username']->renderLabel(array(), array("title" => "Your email address.")) ?>
                </th>
                <td>                    
                    <?php echo $form['username'] ?>
                    <?php echo $form['username']->renderError() ?>
                </td>
            </tr>
            <tr>
                <th>
                    <?php echo $form['password']->renderLabel(array(), array("title" => "Your password.")) ?>
                </th>
                <td>
                    <?php echo $form['password'] ?>
                    <?php echo $form['password']->renderError() ?>
                </td>
            </tr>
            <tr>
                <th>
                    <?php echo $form['remember']->renderLabel(array(), array("title" => "Remember me.")) ?>
                </th>
                <td>
                    <?php echo $form['remember'] ?>
                    <?php echo $form['remember']->renderError() ?>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2">
                    <?php echo $form->renderHiddenFields(false) ?>
                    <input type="submit" class="login_button btn btn-success" value="<?php echo __('Login', null, 'sf_guard') ?>" />

                    <?php $routes = $sf_context->getRouting()->getRoutes() ?>
                    <?php if (isset($routes['sf_guard_forgot_password'])): ?>
                        <div class="forgot_password_link_div">
                            <a id="forgot_password_link" class="custom_link" href="<?php echo url_for('@sf_guard_forgot_password') ?>"><?php echo __('Forgot your password?', null, 'sf_guard') ?></a>
                        </div>
                    <?php endif; ?>

                    <?php if (isset($routes['sf_guard_register'])): ?>
                        &nbsp; <a href="<?php echo url_for('@sf_guard_register') ?>"><?php echo __('Want to register?', null, 'sf_guard') ?></a>
                    <?php endif; ?>
                </td>
            </tr>
        </tfoot>
    </table>
</form>