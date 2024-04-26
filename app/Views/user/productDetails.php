<div class="card mb-3 mt-5 border-0">
    <div class="row g-0">
        <div class="col-md-4">
            <img src="<?= base_url()."assets/img/no-img.jpg"?>" class="product-image" alt="...">
        </div>
        <div class="col-md-8">
            <div class="card-body">
                <h5 class="card-title"><?= $product['name']; ?></h5>
                <div class="card-text pb-2">Rs. <?= $product['discount_status'] == 'yes' && $product['discounted_price'] > 0 ? $product['discounted_price'] : $product['price']; ?></div>
                <div class="qtySection qtSection_product_details">
                    <div class="pb-2">Quantity</div>
                    <div class="qty input-group mb-3 qty-wrap">
                        <button class="minus btn btn-secondary" type="button" id="minus" data-section="product_details" data-this-id="<?=$product['product_id']?>">-</button>
                        <input type="text" data-section="product_details" class="form-control quantity count qtyCount_<?=$product['product_id']?>" value="1" name="quantity" data-value="1">
                        <button class="plus btn btn btn-secondary" type="button" id="plus" data-section="product_details" data-this-id="<?=$product['product_id']?>">+</button>
                    </div>
                </div>
                <p class="card-text"><?= $product['description']; ?></p>
                <button class="btn btn-success add_to_cart" data-qty="" data-product-id="<?=$product['product_id'];?>" data-section="product_details">Add to Cart</button>
                <a type="button" href="<?= base_url()."cart/"?>" class="btn btn-success">Go to Cart</a>
            </div>
        </div>
    </div>
</div>