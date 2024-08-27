<?php
include_once "../core/login_check.php";
?>

<!DOCTYPE html>
<html lang="en">

<?php

include_once "../config/config.php";
include_once "../core/db_connection.php";

$payment_ref_id = $statusMsg = '';
$status = 'error';

$payment_ref_id = '';
$txn_id = '';
$paid_amount = '';
$paid_amount_currency = '';
$payment_status = '';
$customer_name = '';
$customer_email = '';
$itemName = '';
$itemPrice = '';
$currency = '';


// Check whether the payment ID is not empty 
if (!empty($_GET['pid'])) {
    $payment_txn_id  = base64_decode($_GET['pid']);

    // Fetch transaction data from the database 

    $sqlQ = "SELECT * FROM transactions WHERE txn_id = '$payment_txn_id'";
    $result = mysqli_query($conn, $sqlQ) or die(mysqli_error($conn));


    if (mysqli_num_rows($result) > 0) {
        // Get transaction details 
        // $stmt->bind_result($payment_ref_id, $txn_id, $paid_amount, $paid_amount_currency, $payment_status, $customer_name, $customer_email);
        // $stmt->fetch();

        $row = mysqli_fetch_assoc($result);

        $payment_ref_id = $row['id'];
        $txn_id = $row['txn_id'];
        $paid_amount = $row['paid_amount'];
        $paid_amount_currency = $row['paid_amount_currency'];
        $payment_status = $row['payment_status'];
        $customer_name = $row['customer_name'];
        $customer_email = $row['customer_email'];
        $itemName = $row['item_name'];
        $itemPrice = $row['item_price'];
        $currency = $row['item_price_currency'];


        $status = 'success';
        $statusMsg = 'Your Payment has been Successful!';
    } else {
        $statusMsg = "Transaction has been failed!";
    }
} else {
    header("Location: index.php");
    exit;
}


?>

<head>

    <?php
    $pageInfo = [
        "title" => "Pricing",
    ];
    ?>
    <?php include "includes/head.php"; ?>
</head>



<body>

    <?php include "includes/header.php"; ?>
    <div class="dashboard payment-status-page px-0">
        <div class="row">

            <?php include "includes/nav.php"; ?>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">

                <div class="row justify-content-center mt-5">

                    <div class="col-lg-4">

                        <div class="card mb-4">

                            <div class="card-header">
                                <h5>Payment Status: <?php echo $statusMsg; ?></h5>
                            </div>
                            <div class="card-body">

                                <?php if (!empty($payment_ref_id)) { ?>

                                    <h4>Payment Information</h4>
                                    <p><b>Reference Number:</b> <?php echo $payment_ref_id; ?></p>
                                    <p><b>Transaction ID:</b> <?php echo $txn_id; ?></p>
                                    <p><b>Paid Amount:</b> <?php echo $paid_amount . ' ' . $paid_amount_currency; ?></p>
                                    <p><b>Payment Status:</b> <?php echo $payment_status; ?></p>

                                    <h4>Customer Information</h4>
                                    <p><b>Name:</b> <?php echo $customer_name; ?></p>
                                    <p><b>Email:</b> <?php echo $customer_email; ?></p>

                                    <h4>Product Information</h4>
                                    <p><b>Name:</b> <?php echo $itemName; ?></p>
                                    <p><b>Price:</b> <?php echo $itemPrice . ' ' . $currency; ?></p>
                                <?php } else { ?>
                                    <h1 class="error">Your Payment been failed!</h1>
                                    <p class="error"><?php echo $statusMsg; ?></p>
                                <?php } ?>


                            </div>

                            <div class="card-footer text-center">
                                <a href="index.php" class="btn btn-primary">Purchase New Product</a>
                            </div>

                        </div>

                    </div>

                </div>



            </main>
        </div>
    </div>


    <?php include "includes/scripts.php"; ?>
</body>

</html>