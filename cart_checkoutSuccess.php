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

    <!-- contact banner area srart -->
    <div class="contact-banner-area-start faq rts-section-gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- banner main inner contact areas start -->
                    <div class="banner-inner-area-contact-inner">
                        <h1 class="title skew-up-2">
                            <span>Order Success</span>
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

        <?php if (empty($cartItems)) : ?>
            <script>
                window.location.href = "cart_view";
            </script>
        <?php else : ?>
            <div class="checkout_container">
                <?php foreach ($cartItems as $id => $price) : ?>
                    <div>
                        <h1><strong style="color: var(--color-primary);">Congratulations!</strong> Your Order Has Been Succesfully Placed.</h1>

                        <legend>Order Item</legend>
                        <div class="card">
                            <address>
                                <div class="d-flex justify-content-around">
                                    <div class="flex-1 item_name">
                                        <?php echo htmlspecialchars($id); ?>
                                    </div>
                                    <div class="flex-1 text-end item_price">
                                        $<?php echo htmlspecialchars($price); ?> <span>/ month</span>
                                    </div>
                                </div>
                            </address>
                        </div>
                    </div>

                    <div>
                        <a href="index" class="rts-btn btn-primary checkout_btn mt-5">
                            Return To <strong>HomePage</strong>
                        </a>
                    </div>

                <?php endforeach; ?>
            </div>

        <?php endif; ?>
    </section>
    <!-- Checkout Area -->


    <?php include_once "includes/footer.php"; ?>
    <?php include_once "includes/scripts.php"; ?>


</body>

</html>