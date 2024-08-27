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

    <h1>Order Failed</h1>

    <!-- Checkout Area -->
    <section class="checkout_page">
        <div class="checkout_container">
            <h1 style="text-align: center; color:red;">
                There was a problem with your order. Please try again later!
            </h1>
            <div>
                <a href="index" class="btn btn-primary mt-5 w-100">
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