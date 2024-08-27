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
        "title" => "Cart",
    ];
    ?>

    <?php include_once "includes/head.php"; ?>

</head>

<body class="cart_page">

    <?php include_once "includes/nav.php"; ?>

    <section class="cart_container">
        <?php if (empty($cartItems)) : ?>
            <div class="container">
                <h1>Cart</h1>
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-10">
                        <div class="card rounded-3 mb-4">
                            <div class="card-body p-4">
                                <div class="row d-flex justify-content-between align-items-center">
                                    <div class="col">
                                        <p class="mb-2 text-center">Your cart is empty.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="pricing" class="btn btn-primary w-100">Product Page</a>
                    </div>
                </div>
            </div>
        <?php else : ?>
            <div class="container">
                <h1>Cart</h1>
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-10">
                        <div class="card rounded-3 mb-4">
                            <div class="card-body p-4">
                                <div class="row d-flex justify-content-between align-items-center">
                                    <div class="col-md-3 col-lg-3 col-xl-6">
                                        <p class="m-0"><span class="alert alert-primary"><?= $cartItems['name'] ?></span></p>
                                    </div>
                                    <div class="col-md-3 col-lg-2 col-xl-5 text-end">
                                        <p class="m-0">$<?= $cartItems['price'] ?> <span>/ <?= $cartItems['billing'] ?></span></p>
                                    </div>
                                    <div class="col-md-1 col-lg-1 col-xl-1 text-end plan_remove">
                                        <form action="core/cart_functions.php" method="post">
                                            <input type="hidden" name="action" value="remove">
                                            <button type="submit" class="clear_btn">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                                    <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5m-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5M4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06m6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528M8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="cart_checkout.php" class="btn btn-primary text-center w-100">Proceed to Checkout</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </section>


    <?php include_once "includes/footer.php"; ?>
    <?php include_once "includes/scripts.php"; ?>

</body>

</html>