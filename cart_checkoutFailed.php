<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'core/cart_functions.php';

$cartItems = getCartItems();
?>

<!doctype html>
<html lang="en">

<head>


    <?php
    $pageInfo = [
        "title" => "Order Failed",
    ];
    ?>

    <?php include_once "includes/head.php"; ?>

</head>

<body>

    <?php include_once "includes/nav.php"; ?>

    <!-- contact banner area srart -->
    <div class="contact-banner-area-start faq rts-section-gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- banner main inner contact areas start -->
                    <div class="banner-inner-area-contact-inner">
                        <h1 class="title skew-up-2">
                            <span>Order Failed</span>
                        </h1>
                    </div>
                    <!-- banner main inner contact areas end -->
                </div>
            </div>
        </div>
    </div>
    <!-- contact banner area end -->

    <!-- Checkout Area -->
    <section class="checkout_page">
        <div class="checkout_container">
            <h1 style="text-align: center; color:red;">
                There was a problem with your order. Please try again later!
            </h1>
            <div>
                <a href="index" class="rts-btn btn-primary checkout_btn mt-5" style="background: red;">
                    Return To <strong>HomePage</strong>
                </a>
            </div>
        </div>
    </section>
    <!-- Checkout Area -->


    <?php include_once "includes/footer.php"; ?>
    <?php include_once "includes/scripts.php"; ?>


</body>

</html>