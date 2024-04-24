<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>ERP APP | Admin</title>
        <link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?= base_url() ?>assets/css/main.css" rel="stylesheet">
    </head>
    <body>
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container">
                <a class="navbar-brand" href="<?= base_url().'admin' ?>">ADMIN</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarText">
                    <?php if(session()->has('user_id')){ ?>
                    <ul class="navbar-nav me-auto mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="<?= base_url().'admin' ?>">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url().'admin/manage-products' ?>">Products</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">Users</a>
                        </li>
                    </ul>
                    <?php } ?>
                    <?php if(session()->has('user_id')){ ?>
                        <span class="navbar-text">
                            <ul class="navbar-nav me-auto mb-lg-0">
                                <li><a class="nav-link" href="<?= base_url().'admin/logout' ?>">Logout</a></li>
                            </ul>
                        </span>
                    <?php } ?>
                </div>
            </div>
        </nav>
        <div class="container pt-4 mb-5">
            <?php if( session()->getFlashdata('success') ){ ?>
                <div class="success_msg flash-message"><?= session()->getFlashdata('success') ?></div>
            <?php } ?>
            <?php if( session()->getFlashdata('error') ){ ?>
                <div class="error_msg flash-message"><?= session()->getFlashdata('error') ?></div>
            <?php } ?>
            
<!-- End of header -->