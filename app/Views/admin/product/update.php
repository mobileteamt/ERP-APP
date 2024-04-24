<div class="form-wrap">
    <h3 class="pb-4">Edit Product</h3>
    <?= validation_list_errors() ?>
    <?php if( session()->getFlashdata('form-error') ){ ?>
        <div class="errors">
            <ul><li><?= session()->getFlashdata('form-error') ?></li></ul>
        </div>
    <?php } ?>
    <form action="<?= base_url()."admin/update_product" ?>" method="post">
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="<?= isset($product['name']) ? $product['name'] : old('name') ?>">
        </div>
        <div class="mb-3">
            <label for="quantity" class="form-label">Quantity</label>
            <input type="text" class="form-control" id="quantity" max="100" name="quantity" value="<?= isset($product['quantity']) ? $product['quantity'] : old('quantity')?>">
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="text" class="form-control" id="price" name="price" value="<?= isset($product['price']) ? $product['price'] : old('price')?>">
        </div>
        <div class="mb-3">
            <label class="form-label w-100">Discount Status</label>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="discount_status" id="dis_yes" value="yes" <?php if(isset($product['discount_status']) && isset($product['discount_status']) == 'yes'){ echo 'checked'; } ?>>
                <label class="form-check-label" for="dis_yes">Yes</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="discount_status" id="dis_no" value="no" <?php if(isset($product['discount_status'])) { if($product['discount_status'] == 'no'){ echo 'checked'; } } else { echo 'checked'; } ?>>
                <label class="form-check-label" for="dis_no">No</label>
            </div>
        </div>
        <div class="mb-3">
            <label for="discounted_price" class="form-label">Discounted Price</label>
            <input type="text" class="form-control" id="discounted_price" name="discounted_price" value="<?= isset($product['discounted_price']) ? $product['discounted_price'] : old('discounted_price')?>">
        </div>
        <div class="mb-3">
            <label class="form-label w-100">Status</label>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="status_yes" value="enable" <?php if(isset($product['status'])) { if($product['status'] == 'enable'){ echo 'checked'; } } else { echo 'checked'; } ?>>
                <label class="form-check-label" for="status_yes">Enable</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="status_no" value="disable" <?php if(isset($product['status']) && $product['status'] == 'disable'){ echo 'checked'; } ?>>
                <label class="form-check-label" for="status_no">Disable</label>
            </div>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4"><?= isset($product['description']) ? $product['description'] : old('description')?></textarea>
        </div>
        <input type="hidden" name="id" value="<?= $product['product_id']; ?>">
        <button type="submit" class="btn btn-primary">Submit</button>
        <a type="button" class="btn btn-secondary" href="<?= base_url()."admin/manage-products"; ?>">Cancel</a>
    </form> 
</div>