<?php
include_once "../core/login_check.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <?php
    $pageInfo = [
        "title" => "Confirmation",
    ];
    ?>
    <?php include "includes/head.php"; ?>
</head>

<body>

    <body>

        <?php
        $order_details
        ?>


        <?php include "includes/header.php"; ?>



        <div class="order-details d-flex justify-content-center">
            <div class="card">
                <h1 class="success">Success</h1>
                <p>Hi <span id="name"></span>,<br>
                    We received your purchase request;<br /> we'll be in touch shortly!</p>
            </div>
        </div>



        <!-- Writing Customer Name -->
        <script>
            $(document).ready(function() {
                console.log("Hello Confirmation Page");
                let name = sessionStorage.getItem('name');
                if (!name) {
                    window.location.href = "./pricing";
                }
                $('#name').html(name);
            });
        </script>



        <?php include "includes/footer.php"; ?>


        <?php include "includes/scripts.php"; ?>


    </body>

</html>