<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'core/cart_functions.php';

$cartItems = getCartItems();
emptyCart();
?>

<!doctype html>
<html lang="en">

<head>


    <?php
    $pageInfo = [
        "title" => "Order Success",
    ];
    ?>

    <?php include_once "includes/head.php"; ?>

</head>

<body>

    <?php include_once "includes/nav.php"; ?>

    <h1>Order Success </h1>

    <!-- Checkout Area -->
    <section class="checkout_page">

        <?php if (empty($cartItems)) : ?>
            <script>
                window.location.href = "cart.php";
            </script>
        <?php else : ?>
            <div class="checkout_container">
                <div>
                    <h1><strong style="color: green">Congratulations!</strong> Your Order Has Been Succesfully Placed.</h1>
                    <legend>Order Item</legend>
                    <div class="card">
                        <address>
                            <div class="d-flex justify-content-around">
                                <div class="flex-1 item_name">
                                    <?= $cartItems['name'] ?>
                                </div>
                                <div class="flex-1 text-end item_price">
                                    $<?= $cartItems['price'] ?> <span>/ <?= $cartItems['billing'] ?></span>
                                </div>
                            </div>
                        </address>
                    </div>
                </div>

                <div>
                    <a href="index" class="btn btn-primary mt-5 w-100">
                        Return To <strong>HomePage</strong>
                    </a>
                </div>
            </div>

        <?php endif; ?>
    </section>
    <!-- Checkout Area -->


    <?php include_once "includes/footer.php"; ?>
    <?php include_once "includes/scripts.php"; ?>


</body>

</html>