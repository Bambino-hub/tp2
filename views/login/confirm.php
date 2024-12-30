<h1>confirmation d'inscription </h1>
<?php $form = App\core\form\Form::begin() ?>
<?= $form->field($model, 'email', 'email'); ?>
<?= $form->field($model, 'password', 'password'); ?>
<?= $form->field($model, 'number', 'number'); ?>
<button type="submit" class="btn btn-primary">Submit</button>
<?php App\core\form\Form::end() ?>