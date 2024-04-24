<div class="d-flex justify-content-between align-items-center">
    <h3 class="py-4">Products</h3>
</div>

<?php if(isset($products) && count($products)>0){ ?>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        <?php foreach($products as $product) { ?>
            <div class="col">
                <div class="card h-100" id="site_product_<?=$product['product_id']?>">
                    <img src="<?= base_url()."assets/img/no-img.jpg"?>" class="product-img pt-2 pb-2" alt="...">
                    <div class="card-body product-details">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="details">
                                <h5 class="card-title"><a class="fw-semibold text-decoration-none text-success" href="<?= base_url()."product/".$product['slug']?>"><?= $product['name']; ?></a></h5>
                                <div class="card-text pb-3">Rs. <?= $product['discount_status'] == 'yes' && $product['discounted_price'] > 0 ? $product['discounted_price'] : $product['price']; ?></div>
                            </div>
                            <a type="button" href="<?= base_url()."product/".$product['slug'];?>" class="btn btn-dark btn-sm">View More</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
<?php } ?>