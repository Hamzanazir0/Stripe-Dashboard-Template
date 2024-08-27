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
        "title" => "Checkout",
    ];
    ?>

    <?php include_once "includes/head.php"; ?>

    <script src="https://js.stripe.com/v3/"></script>

    <!-- <style>
        .hidden {
            display: none;
        }
    </style> -->

</head>

<body>

    <?php include_once "includes/nav.php"; ?>

    <div class="row justify-content-center">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <b>Total $<?php echo $products[$product_id]["product_price"] . " " .  $products[$product_id]["product_billing"]  ?></b>
                </div>
                <div class="card-body">
                    <div id="paymentResponse" class="hidden"></div>
                    <form id="paymentFrm" class="hidden">
                        <div class="form-floating mb-2">
                            <input type="text" required name="name" id='paymentCardName' class="form-control" id="floatingemail" placeholder="email">
                            <label for="floatingPassword">Name</label>
                        </div>
                        <div class="form-floating mb-2">
                            <input type="email" required name="email" id='paymentCardEmail' class="form-control" id="floatingemail" placeholder="email">
                            <label for="floatingPassword">Email</label>
                        </div>
                        <?php
                        if (USE_STRIPE) { ?>
                            <div id="paymentElement">
                            </div>
                        <?php } else { ?>

                            <div class="card-form">
                                <div class="form-floating mb-2">
                                    <input type="tel" required name="cc_no" id="cc_no" class="form-control" maxlength="16" onkeyup="javascript:this.value=this.value.replace(/[^0-9]/g,'');" value="" placeholder="Card No">
                                    <label for="floatingPassword">Card Number</label>
                                </div>
                                <div class="row m-0">
                                    <div class="col-6 px-0 mx-0">
                                        <div class="form-floating mb-2 me-1">
                                            <select required class="form-control" name="cc_month" id="cc_month" maxlength="2" placeholder="Month(MM)">
                                                <option value="" selected="selected">Month(MM)</option>
                                                <?php for ($month = 01; $month < 13; $month = $month + 1) { ?>
                                                    <option value=<?= $month ?>><?= sprintf("%02d", $month); ?></option>
                                                <?php } ?>
                                            </select>
                                            <label for="floatingPassword">Month</label>
                                        </div>
                                    </div>
                                    <div class="col-6 px-0 mx-0">
                                        <div class="form-floating mb-2 ms-1">
                                            <select required class="form-control" name="cc_year" id="cc_year" maxlength="4" placeholder="Year(YYYY)">
                                                <option value="" selected="selected">Year(YYYY)</option>
                                                <?php $c_year = date('Y');
                                                for ($year = $c_year; $year < ($c_year + 11); $year = $year + 1) { ?>
                                                    <option value=<?= $year ?>> <?= $year ?> </option>
                                                <?php } ?>
                                            </select>
                                            <label for="floatingPassword">Year</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-floating mb-2">
                                    <input type="tel" required name="CVV" id="cvv" class="form-control" maxlength="3" onkeyup="javascript:this.value=this.value.replace(/[^0-9]/g,'');" placeholder="CVV" value="">
                                    <label for="floatingPassword">CVV</label>
                                </div>
                            </div>
                        <?php } ?>

                        <br>
                        <div class="text-center">
                            <?php
                            if (USE_STRIPE) { ?>
                                <button id="submitBtn" class="btn btn-success">
                                    <span id="paymentPayBtn">Pay Now</span>
                                </button>
                            <?php } else { ?>
                                <div id="checkout_error" class="alert alert-danger" role="alert">

                                </div>
                                <button id="submitBtn2" class="btn btn-success">
                                    <span id="paymentPayBtn2">Place Order</span>
                                </button>
                            <?php } ?>

                        </div>
                    </form>

                    <div id="frmProcess" class="hidden">
                        <span class="ring"></span><b> Processing...</b>
                    </div>

                    <div id="payReinit" class="hidden">
                        <button class="btn btn-primary" onClick="window.location.href=window.location.href.split('?')[0]"><i class="rload"></i>Re-initiate Payment</button>
                    </div>
                </div>
            </div>

        </div>

    </div>


    <?php include_once "includes/footer.php"; ?>
    <?php include_once "includes/scripts.php"; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ccNoInput = document.getElementById('cc_no');
            const expiryDateInput = document.getElementById('expiry_date');
            const csvCodeInput = document.getElementById('csv_code');

            ccNoInput.addEventListener('input', function(e) {
                let value = ccNoInput.value.replace(/\D/g, ''); // Remove all non-digit characters
                if (value.length > 16) value = value.slice(0, 16); // Limit to 16 digits

                // Insert a space after every 4 digits
                ccNoInput.value = value.replace(/(\d{4})/g, '$1 ').trim();
            });

            expiryDateInput.addEventListener('input', function(e) {
                let value = expiryDateInput.value.replace(/\D/g, ''); // Remove all non-digit characters
                if (value.length > 4) value = value.slice(0, 4); // Limit to 4 digits (MMYY)

                // Insert a slash after the month
                if (value.length > 2) {
                    value = value.slice(0, 2) + '/' + value.slice(2);
                }

                expiryDateInput.value = value;
            });

            expiryDateInput.addEventListener('blur', function() {
                const value = expiryDateInput.value;
                if (value.length === 5) {
                    const month = parseInt(value.slice(0, 2), 10);
                    const year = parseInt('20' + value.slice(3, 5), 10);
                    const currentYear = new Date().getFullYear();
                    const currentMonth = new Date().getMonth() + 1;

                    // Validate the month and year
                    if (month < 1 || month > 12 || year < currentYear || (year === currentYear && month < currentMonth)) {
                        alert('Invalid expiry date');
                        expiryDateInput.value = '';
                    }
                }
            });

            csvCodeInput.addEventListener('input', function(e) {
                let value = csvCodeInput.value.replace(/\D/g, ''); // Remove all non-digit characters
                if (value.length > 3) value = value.slice(0, 3); // Limit to 3 digits
                csvCodeInput.value = value;
            });
        });
    </script>

</body>

</html>