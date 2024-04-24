<div class="d-flex justify-content-between align-items-center">
    <h3 class="py-3">Checkout</h3>
    <a type="button" class="btn btn-secondary" href="<?= base_url().'cart'?>">Back</a>
</div>

<?= validation_list_errors() ?>
<?php if( session()->getFlashdata('form-error') ){ ?>
    <div class="errors">
        <ul><li><?= session()->getFlashdata('form-error') ?></li></ul>
    </div>
<?php } ?>
<form class="mt-2 mb-5" action="<?= base_url().'place_order'?>" method="post">
    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="firstname" class="form-label">Firstname<span class="required">*</span></label>
            <input type="text" class="form-control" id="firstname" name="firstname" value="<?=old('firstname')?>">
        </div>
        <div class="mb-3 col-md-6">
            <label for="lastname" class="form-label">Lastname<span class="required">*</span></label>
            <input type="text" class="form-control" id="lastname" name="lastname" value="<?=old('lastname')?>">
        </div>
    </div>
    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="email" class="form-label">Email address<span class="required">*</span></label>
            <input type="text" class="form-control" id="email" name="email" value="<?=old('email')?>">
        </div>
        <div class="mb-3 col-md-6">
            <label for="mobile" class="form-label">Mobile<span class="required">*</span></label>
            <input type="text" class="form-control" id="mobile" name="mobile" value="<?=old('mobile')?>">
        </div>
    </div>
    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="city" class="form-label">City<span class="required">*</span></label>
            <input type="text" class="form-control" id="city" name="city" value="<?=old('city')?>">
        </div>
        <div class="mb-3 col-md-6">
            <label for="pincode" class="form-label">Pincode<span class="required">*</span></label>
            <input type="text" class="form-control" id="pincode" name="pincode" value="<?=old('pincode')?>">
        </div>
    </div>
    <div class="row">
        <div class="mb-3 col-md-6">
            <label for="state" class="form-label">State</label>
            <input type="text" class="form-control" id="state" name="state" value="<?=old('state')?>">
        </div>
        <div class="mb-3 col-md-6">
            <label for="country" class="form-label">Country</label>
            <input type="text" class="form-control" id="country" name="country" value="<?=old('country')?>">
        </div>
    </div>
    <div class="row">
        <div class="mb-3 col-md-12">
            <label for="address" class="form-label">Shipping Address<span class="required">*</span></label>
            <input type="text" class="form-control" id="address" name="shipping_address" value="<?=old('shipping_address')?>">
        </div>
    </div>
    <div class="mt-4">
        <?= $this->include('layouts/user/cartDetails'); ?>
    </div>
</form>