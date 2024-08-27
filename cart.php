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
                            <span>Shopping Cart</span>
                        </h1>
                    </div>
                    <!-- banner main inner contact areas end -->
                </div>
            </div>
        </div>
    </div>
    <!-- contact banner area end -->

    <!-- Cart Area -->
    <section class="cart_container">
        <?php if (empty($cartItems)) : ?>
            <p class="text-center">Your cart is empty.</p>
        <?php else : ?>
            <div class="container">
                <div class="row d-flex justify-content-center align-items-center">
                    <div class="col-10">
                        <?php foreach ($cartItems as $id => $price) : ?>
                            <div class="card rounded-3 mb-4">
                                <div class="card-body p-4">
                                    <div class="row d-flex justify-content-between align-items-center">
                                        <div class="col-md-3 col-lg-3 col-xl-6">
                                            <p class="lead fw-normal mb-2 plan_name"><?php echo htmlspecialchars($id); ?></p>
                                        </div>
                                        <div class="col-md-3 col-lg-2 col-xl-5 text-end">
                                            <h5 class="mb-0 plan_price">$<?php echo htmlspecialchars($price); ?> <span>/ month</span></h5>
                                        </div>
                                        <div class="col-md-1 col-lg-1 col-xl-1 text-end plan_remove">
                                            <form action="cart.php" method="post">
                                                <input type="hidden" name="action" value="remove">
                                                <button type="submit"><i class="fas fa-trash fa-lg"></i></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <a href="cart_checkout.php" data-mdb-button-init data-mdb-ripple-init class="rts-btn btn-primary-2 checkoutPage_btn text-center">Proceed to Pay</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </section>
    <!-- Cart Area -->


    <?php include_once "includes/footer.php"; ?>
    <?php include_once "includes/scripts.php"; ?>

</body>

</html>