<?php
use CodeIgniter\CodeIgniter;
use CodeIgniter\HTTP\URI;

if (!function_exists('getCartDetails')) {

    function getCartDetails(){
        $db = model('CartModel');
        $cart_count = $db->getCartCount();

        $cartData = $db->getCartByCookie();
        return ['cart_count'=>$cart_count,'cartData'=>$cartData];
    }
}

if (!function_exists('getLastSegment')) {

    function getLastSegment(){
        $current_url = current_url(true);
        $uri = new URI($current_url);
        $url_segments = $uri->getSegments();
        return end($url_segments);
    }
}

if (!function_exists('checkAdminUser')) {

    function checkAdminUser(){
        $db = model('UserModel');
        return $db->checkAdminUser();
    }
}


