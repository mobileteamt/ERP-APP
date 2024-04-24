<?php 
    $cart = getCartDetails();
    $cart_total = 0;
    foreach($cart['cartData'] as $item){
        if($item['discount_status'] == 'yes' && $item['discounted_price']>0){
            $product_price = $item['discounted_price'];
        }
        else{
            $product_price = $item['price'];
        }
        $cart_total += $item['qty']*$product_price;
    }
?>

<?php $last_seg = getLastSegment();?>
<div class="card d-flex justify-content-between align-items-center flex-row px-3 py-2">
    <div class="cart-prices">
        <div class="total" id="cart-total"><strong>Total:</strong> <span class="amount"><?=$cart_total;?></span></div>
    </div>
    <div class="proceed-buttons">
        <?php if($last_seg == 'cart') { ?>
            <a type="button" class="btn btn-secondary mx-2" href="<?= base_url().'products'?>">Purchase More</a>
            <a type="button" class="btn btn-success" href="<?= base_url().'checkout'?>">Checkout</a>
        <?php } else { ?>
            <button type="submit" class="btn btn-success">Place Order</button>
        <?php } ?>
    </div>
</div>