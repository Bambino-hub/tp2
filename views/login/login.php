<h1> se connecté !!!!</h1>

<?php $form = App\core\form\Form::begin() ?>
<?= $form->field($model, 'email', 'email'); ?>
<?= $form->field($model, 'password', 'password'); ?>
<button type="submit" class="btn btn-primary">Submit</button>
<?php App\core\form\Form::end() ?>