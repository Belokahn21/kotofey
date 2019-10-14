<input id="username" style="display:none" type="text" name="fakeusernameremembered">
<input id="password" style="display:none" type="password" name="fakepasswordremembered">
<?php echo $form->field($user, 'phone')->textInput(['autocomplete' => 'off']); ?>
<?php echo $form->field($user, 'email')->textInput(['autocomplete' => 'off']); ?>
<?php echo $form->field($user, 'new_password')->passwordInput(['autocomplete' => 'off']) ?>