<?php if($cart_data){ ?>
    <h3 class="mt-3">Cart</h3>
    <?php foreach($cart_data as $product){ ?>
        <div class="card mb-3 mt-4" id="cart_<?=$product['cart_id'];?>">
            <div class="row g-0">
                <div class="col-md-3 img-wrap">
                    <img src="<?= base_url()."assets/img/no-img.jpg"?>" class="product-image cart-img" alt="...">
                </div>
                <div class="col-md-9">
                    <div class="card-body">
                        <h5 class="card-title"><a class="text-dark text-decoration-none" href="<?=base_url().'product/'.$product['slug']?>"><?= $product['name']; ?></a></h5>
                        <div class="card-text pb-2">Rs. <?= $product['discount_status'] == 'yes' && $product['discounted_price'] > 0 ? $product['discounted_price'] : $product['price']; ?></div>
                        <!-- <div class="card-text pb-2">Quantity: <?= $product['qty']; ?></div> -->
                        <div class="qtySection qtSection_cart">
                            <div class="qty input-group mb-3 qty-wrap">
                                <button class="minus btn btn-secondary" type="button" id="minus" data-section="cart" data-cart-id="<?=$product['cart_id'];?>" data-this-id="<?=$product['product_id']?>">-</button>
                                <input type="text" data-section="cart" class="form-control quantity count qtyCount_<?=$product['product_id']?>" value="<?=$product['qty']?>" name="quantity" data-value="1">
                                <button class="plus btn btn btn-secondary" type="button" id="plus" data-section="cart" data-cart-id="<?=$product['cart_id'];?>" data-this-id="<?=$product['product_id']?>" data-max="<?=$product['quantity']?>">+</button>
                            </div>
                        </div>
                        <a onclick="deleteCart(<?php echo $product['cart_id'];?>);" class="btn-pointer"><span class="badge text-bg-danger">Remove</span></a>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <?= $this->include('layouts/user/cartDetails'); ?>
<?php } else {?>
    <h4 class="text-center py-4 mt-4">Your cart is empty.</h4>
    <div class="text-center"><a type="button" class="btn btn-dark" href="<?= base_url().'products'?>">Pick new items</a><div>
<?php } ?>