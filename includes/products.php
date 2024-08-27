<div class="row row-cols-1 row-cols-md-3 mb-3 text-center">

    <?php
    foreach ($products as $ind => $product) {
    ?>

        <div class="col">
            <div class="card mb-4 rounded-3 shadow-sm <?php echo $product["primary"] ? 'border-primary' : '' ?>">
                <div class="card-header py-3 <?php echo $product["primary"] ? ' text-white bg-primary border-primary' : '' ?>">
                    <h4 class="my-0 fw-normal"><?php echo  $product["product_name"] ?></h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">$<?php echo $product["product_price"] ?><small class="text-muted fw-light">/<?php echo $product["product_billing"] ?></small></h1>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li><?php echo $product["product_description"] ?></li>

                    </ul>

                    <?php

                    $requestURI = $_SERVER['REQUEST_URI'];
                    $requestURIArr = explode("/", $requestURI);

                    foreach ($requestURIArr as $key => $value) {
                        if ($value == "dashboard") {
                            $link = "payment-form?product=" . $ind;
                            break;
                        } else {
                            $link = "dashboard/payment-form?product=" . $ind;
                        }
                    }

                    ?>
                    <a href="<?php echo $link ?>" class="w-100 btn btn-lg <?php echo $product["primary"] ? 'btn-primary' : 'btn-outline-primary' ?>">Buy Now</a>
                </div>
            </div>
        </div>

    <?php
    }
    ?>


</div>