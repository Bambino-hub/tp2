<h1>create an account</h1>
<?php $form = App\core\form\Form::begin() ?>
<div class="row">
    <div class="col">
        <?= $form->field($model, 'firstname', 'text'); ?>
    </div>
    <div class="col">
        <?= $form->field($model, 'lastname', 'text'); ?>
    </div>
</div>
<?= $form->field($model, 'email', 'email'); ?>
<?= $form->field($model, 'password', 'password'); ?>
<?= $form->field($model, 'passwordConfirm', 'passord'); ?>
<button type="submit" class="btn btn-primary">Submit</button>
<?php App\core\form\Form::end() ?>