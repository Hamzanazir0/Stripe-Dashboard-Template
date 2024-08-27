<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require 'core/cart_functions.php';

$cartItems = getCartItems();
if (!isset($cartItems['id'])) {
    header("Location: pricing.php");
}
$product_id = $cartItems['id'];
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

    <style>
        .hidden {
            display: none;
        }
    </style>

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
        // Get API Key
        let STRIPE_PUBLISHABLE_KEY = "<?php echo STRIPE_PUBLISHABLE_KEY; ?>";

        // Create an instance of the Stripe object and set your publishable API key
        const stripe = Stripe(STRIPE_PUBLISHABLE_KEY);

        // Define card elements
        let elements;

        // Select payment form element
        const paymentFrm = document.querySelector("#paymentFrm");

        // Get payment_intent_client_secret param from URL
        const clientSecretParam = new URLSearchParams(window.location.search).get(
            "payment_intent_client_secret"
        );

        // Check whether the payment_intent_client_secret is already exist in the URL
        setProcessing(true);
        if (!clientSecretParam) {
            setProcessing(false);

            // Create an instance of the Elements UI library and attach the client secret
            initialize();
        }

        // Check the PaymentIntent creation status
        checkStatus();

        // Attach an event handler to payment form
        paymentFrm.addEventListener("submit", handleSubmit);

        // Fetch a payment intent and capture the client secret
        let payment_intent_id;
        async function initialize() {
            console.log("initialize");
            const {
                id,
                clientSecret
            } = await fetch("payment_init.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    request_type: "create_payment_intent",
                    product_id: "<?php echo $product_id; ?>",
                    product_price: "<?php echo $products[$product_id]["product_price"]; ?>",
                    product_name: "<?php echo $products[$product_id]["product_name"]; ?>",
                }),
            }).then((r) => {
                return r.json();
            });

            const appearance = {
                theme: "stripe",
                rules: {
                    ".Label": {
                        fontWeight: "bold",
                        textTransform: "uppercase",
                    },
                },
            };

            elements = stripe.elements({
                clientSecret,
                appearance
            });

            const paymentElement = elements.create("payment");
            paymentElement.mount("#paymentElement");

            payment_intent_id = id;
        }

        let CustomerId = "";

        // Card form submit handler
        async function handleSubmit(e) {
            e.preventDefault();
            setLoading(true);

            let customer_name = document.getElementById("paymentCardName").value;
            let customer_email = document.getElementById("paymentCardEmail").value;

            const {
                id,
                customer_id
            } = await fetch("payment_init.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    request_type: "create_customer",
                    payment_intent_id: payment_intent_id,
                    name: customer_name,
                    email: customer_email,
                }),
            }).then((r) => {
                return r.json();
            });

            const {
                error
            } = await stripe.confirmPayment({
                elements,
                confirmParams: {
                    // Make sure to change this to your payment completion page
                    // return_url: window.location.href + "?customer_id=" + customer_id,
                    return_url: window.location.href + "?customer_id=" + customer_id,
                },
            });

            // This point will only be reached if there is an immediate error when
            // confirming the payment. Otherwise, your customer will be redirected to
            // your `return_url`. For some payment methods like iDEAL, your customer will
            // be redirected to an intermediate site first to authorize the payment, then
            // redirected to the `return_url`.
            if (error.type === "card_error" || error.type === "validation_error") {
                showMessage(error.message);
            } else {
                showMessage("An unexpected error occured.");
            }

            setLoading(false);
        }



        // Fetch the PaymentIntent status after payment submission
        async function checkStatus() {
            console.log("Inside Check Status");
            const clientSecret = new URLSearchParams(window.location.search).get(
                "payment_intent_client_secret"
            );
            const customerID = new URLSearchParams(window.location.search).get(
                "customer_id"
            );
            if (!clientSecret) {
                console.log("Client secret not found in URL");
                return;
            }

            const {
                paymentIntent
            } = await stripe.retrievePaymentIntent(clientSecret);

            if (paymentIntent) {
                console.log("Inside PaymentIntent");
                switch (paymentIntent.status) {
                    case "succeeded":
                        console.log("Intent Successful");
                        // Post the transaction info to the server-side script and redirect to the payment status page
                        fetch("payment_init.php", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json"
                                },
                                body: JSON.stringify({
                                    request_type: "payment_insert",
                                    payment_intent: paymentIntent,
                                    customer_id: customerID,
                                    product_id: "<?php echo $product_id; ?>",
                                    product_price: "<?php echo $products[$product_id]["product_price"]; ?>",
                                    product_name: "<?php echo $products[$product_id]["product_name"]; ?>",
                                }),
                            })
                            .then((response) => response.json())
                            .then((data) => {
                                // console.log("Before IF");
                                if (data.payment_txn_id) {
                                    console.log("TXN Id Found");
                                    window.location.href =
                                        "cart_checkoutSuccess.php?pid=" + data.payment_txn_id;
                                } else {
                                    console.log("TXN Id not found");
                                    showMessage(data.error);
                                    setReinit();
                                }
                            })
                            .catch((e) => {
                                console.log("Fetch Error");
                                console.log(e);
                            });

                        break;
                    case "processing":
                        console.log("Intent Processing");
                        showMessage("Your payment is processing.");
                        setReinit();
                        break;
                    case "requires_payment_method":
                        console.log("Intent Payment Method not successfull");
                        showMessage("Your payment was not successful, please try again.");
                        setReinit();
                        break;
                    default:
                        console.log("Running Default Case");
                        showMessage("Something went wrong.");
                        setReinit();
                        break;
                }
            } else {
                console.log("Outside Intent Something Wrong");
                showMessage("Something went wrong.");
                setReinit();
            }
        }

        // Display message
        function showMessage(messageText) {
            const messageContainer = document.querySelector("#paymentResponse");

            messageContainer.classList.remove("hidden");
            messageContainer.textContent = messageText;

            setTimeout(function() {
                messageContainer.classList.add("hidden");
                messageText.textContent = "";
            }, 5000);
        }

        // Show a spinner on payment submission
        function setLoading(isLoading) {
            if (isLoading) {
                // Disable the button and show a spinner
                document.querySelector("#submitBtn").disabled = true;
                document.querySelector("#paymentPayBtn").textContent = "Processing...";
            } else {
                // Enable the button and hide spinner
                document.querySelector("#submitBtn").disabled = false;
                document.querySelector("#paymentPayBtn").textContent = "Pay";
            }
        }

        // Show a spinner on payment form processing
        function setProcessing(isProcessing) {
            if (isProcessing) {
                paymentFrm.classList.add("hidden");
                document.querySelector("#frmProcess").classList.remove("hidden");
            } else {
                paymentFrm.classList.remove("hidden");
                document.querySelector("#frmProcess").classList.add("hidden");
            }
        }

        // Show payment re-initiate button
        function setReinit() {
            document.querySelector("#frmProcess").classList.add("hidden");
            document.querySelector("#payReinit").classList.remove("hidden");
        }
    </script>

    <script src="assets/dist/js/checkout.js"></script>

</body>

</html>