<h1>creating an account</h1>


<form action="#" method="post">
    <div class="row">
        <div class="col">
            <label for="firstname">Firstname</label>
            <input type="text" name="firstname" id="firstname" class="form-control" placeholder="First name">
        </div>
        <div class="col">
            <label for="lastname">Lastname</label>
            <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Last name">
        </div>
    </div>
    <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" name="email" id="email" class="form-control" aria-describedby="emailHelp" placeholder="Enter email">
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
    </div>
    <div class="form-group">
        <label for="password">Password Confirme</label>
        <input type="password" name="password" class="form-control" id="password" placeholder="Password">
    </div>
    <div class="form-group">
        <label for="passwordConfirm">Password</label>
        <input type="password" name="passwordConfirm" class="form-control" id="passwordConfirm" placeholder="confirme your Password">
    </div>
    <button type="submit" class="btn btn-primary"> Submit </button>
</form>

<h1>creating an account</h1>


<form action="#" method="post">
    <div class="row">
        <div class="col">
            <div class="form-group">
                <label for="firstname">Firstname</label>
                <input type="text" name="firstname" id="firstname" value="<?= $model->firstname ?>" class="form-control<?= $model->hasError('firstname') ? ' is-invalid' : '' ?>" placeholder="First name">
                <div class="invalid-feedback">
                    <?= $model->getFirstError('firstname') ?>
                </div>
            </div>
        </div>
        <div class="col">
            <label for="lastname">Lastname</label>
            <input type="text" name="lastname" id="lastname" value="<?= $model->firstname ?>" class="form-control" placeholder="Last name">
        </div>
    </div>
    <div class="form-group">
        <label for="email">Email address</label>
        <input type="email" name="email" id="email" class="form-control" aria-describedby="emailHelp" placeholder="Enter email">
        <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
    </div>
    <div class="form-group">
        <label for="password">Password Confirme</label>
        <input type="password" name="password" class="form-control" id="password" placeholder="Password">
    </div>
    <div class="form-group">
        <label for="passwordConfirm">Password</label>
        <input type="password" name="passwordConfirm" class="form-control" id="passwordConfirm" placeholder="confirme your Password">
    </div>
    <button type="submit" class="btn btn-primary"> Submit </button>
</form>

<h1>create an account</h1>
<?php $form = App\core\form\Form::begin() ?>
<?= $form->field($model, 'firstname', 'text'); ?>
<?= $form->field($model, 'lastname', 'text'); ?>
<?= $form->field($model, 'email', 'email'); ?>
<?= $form->field($model, 'password', 'password'); ?>
<?= $form->field($model, 'passwordConfirm', 'passord'); ?>
<button type="submit" class="btn btn-primary">Submit</button>
<?php App\core\form\Form::end() ?>