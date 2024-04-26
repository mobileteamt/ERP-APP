<?php 
$admin_exist = checkAdminUser();
if($admin_exist){ ?>
    <form class="login-form form-common" method="post" action="<?= base_url().'admin/login_user'; ?>">
        <h3 class="pb-3 text-center">Login</h3>
        <?= validation_list_errors() ?>
        <?php if( session()->getFlashdata('form-error') ){ ?>
            <div class="errors">
                <ul><li><?= session()->getFlashdata('form-error') ?></li></ul>
            </div>
        <?php } ?>
        <?php if( session()->getFlashdata('form-success') ){ ?>
            <div class="success_msg">
                <?= session()->getFlashdata('form-success') ?></li>
            </div>
        <?php } ?>
        <div class="mb-3">
            <label for="email" class="form-label">Email Address<span class="required">*</span></label>
            <input type="text" class="form-control" id="email" name="email" value="">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password<span class="required">*</span></label>
            <input type="password" class="form-control" id="password" name="password" value="">
        </div>
        <div class="d-flex align-items-center justify-content-between">
            <button type="submit" class="btn btn-primary">Login</button>
        </div>
    </form>
<?php }
else{ ?>
    <h4 class="text-center mb-4">It seems that you haven't created your admin account.</h4>
    <form class="signup-form form-common" method="post" action="<?= base_url().'admin/signup'; ?>">
        <h5 class="pb-3 text-center">Create Account</h5>
        <?= validation_list_errors() ?>
        <?php if( session()->getFlashdata('form-error') ){ ?>
            <div class="errors">
                <ul><li><?= session()->getFlashdata('form-error') ?></li></ul>
            </div>
        <?php } ?>
        <div class="mb-3">
            <label for="username" class="form-label">Username<span class="required">*</span></label>
            <input type="text" class="form-control" id="username" name="username" value="<?=old('username');?>">
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email Address<span class="required">*</span></label>
            <input type="text" class="form-control" id="email" name="email" value="<?=old('email');?>">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password<span class="required">*</span></label>
            <input type="password" class="form-control" id="password" name="password" value="">
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirm Password<span class="required">*</span></label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" value="">
        </div>
        <div class="d-flex align-items-center justify-content-between">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
<?php } ?>