<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ERP APP</title>
        <link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?= base_url() ?>assets/css/main.css" rel="stylesheet">
    </head>
    <body>
        <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" id="csrf_token" />
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <?php $lastSeg = getLastSegment(); ?>
            <div class="container">
                <a class="navbar-brand" href="<?= base_url() ?>">ERP APP</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarText">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="<?= base_url() ?>">Home</a>
                        </li>
                        <?php if($lastSeg!='cart' && $lastSeg!='checkout'){ ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url().'products' ?>">Products</a>
                        </li>
                        <?php } ?>
                    </ul>
                    
                    <span class="navbar-text">
                        <?php  
                        if($lastSeg!='cart' && $lastSeg!='checkout'){
                        ?>
                            <button type="button" class="btn btn-dark">
                                <?php $cartData = getCartDetails(); ?>
                                <a class="text-white" href="<?= base_url().'cart'?>"><span class="card-text">Card</span> <span class="badge text-bg-light" id="cart-count"><?=$cartData['cart_count'];?></span></a>
                            </button>
                        <?php } ?>
                    </span>
                </div>
            </div>
        </nav>
        <div class="container mb-4">
            <?php if( session()->getFlashdata('success') ){ ?>
                <div class="success_msg flash-message"><?= session()->getFlashdata('success') ?></div>
            <?php } ?>
            <?php if( session()->getFlashdata('error') ){ ?>
                <div class="error_msg flash-message"><?= session()->getFlashdata('error') ?></div>
            <?php } ?>
<!-- End of header -->