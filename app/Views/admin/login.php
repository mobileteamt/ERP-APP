
<form class="login-form form-common" method="post" action="<?= base_url().'admin/login_user'; ?>">
    <h3 class="pb-3 text-center">Login</h3>
    <?= validation_list_errors() ?>
    <?php if( session()->getFlashdata('form-error') ){ ?>
        <div class="errors">
            <ul><li><?= session()->getFlashdata('form-error') ?></li></ul>
        </div>
    <?php } ?>
    <div class="mb-3">
        <label for="email" class="form-label">Email Address<span class="required">*</span></label>
        <input type="text" class="form-control" id="email" name="email" value="<?php if(isset($_POST['email'])){ echo $_POST['email']; } ?>">
    </div>
    <div class="mb-3">
        <label for="mobile" class="form-label">Password<span class="required">*</span></label>
        <input type="password" class="form-control" id="password" name="password" value="">
    </div>
    <div class="d-flex align-items-center justify-content-between">
        <button type="submit" class="btn btn-primary">Login</button>
        <!--<div>New user? <a href="signup.php" class="login-link">Sign Up</a></div>-->
    </div>
</form>