<?php
// check if session started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

define("USE_STRIPE", false); // true = stripe checkout(Need API Keys Below) ; false = normal checkout without stripe

define('STRIPE_API_KEY', 'aaaaaaaaaaaaaaaaaaaaa');
define('STRIPE_PUBLISHABLE_KEY', 'aaaaaaaaaaaaaaaa');


define("DB_HOST", "localhost");
define("DB_NAME", "dashboard");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "");


define("SITE_NAME", "Dashboard Site");
define("CORP_NAME", "Dashboard LLC");
define("PHONE", "555-555-5555");
define("SUPPORT_EMAIL", "support@dashboardsite.com");
define("ADDRESS", "1234 Main St");


// Contact Form Controls
define("SMTP", false); // set to true for SMTP or false for default php mail
// If SMTP is enabled use the settings below
define("SMTP_HOST", "Host_Name_Of_SMTP_Server");        // Write SMTP host name in String
define("SMTP_PORT", 465);                               // Write SMTP Port as Number not as String
define("SMTP_SECURITY", "ssl");                         // Write SMTP Security like ssl or tls
define("SMTP_USERNAME", "Username_For_SMTP_Account");   // Write SMTP Username in String
define("SMTP_PASSWORD", "Password_For_SMTP_Account");   // Write SMTP Password in String
define("SMTP_TO_EMAIL", "Admin_Recieving_Email");       // Email Address where you will receive all messages



$products = [
    [
        "product_name" => "Basic Plan",
        "product_price" => "29.99",
        "product_billing" => "Per Month",
        "product_description" => "Enjoy the most basic plan",
        "product_features" => array(
            "Feature 1",
            "Feature 2",
            "Feature 3",
            "Feature 4"
        ),
        "primary" => false
    ],
    [
        "product_name" => "Business Plan",
        "product_price" => "69.8",
        "product_billing" => "Per Month",
        "product_description" => "Enjoy our advanced features",
        "product_features" => array(
            "Feature 1",
            "Feature 2",
            "Feature 3",
            "Feature 4"
        ),
        "primary" => true
    ],
    [
        "product_name" => "Luxury Plan",
        "product_price" => "139.98",
        "product_billing" => "Per Month",
        "product_description" => "Enjoy the most professional plan",
        "product_features" => array(
            "Feature 1",
            "Feature 2",
            "Feature 3",
            "Feature 4"
        ),
        "primary" => false
    ]
];


// convert the price to 2 decimal places
foreach ($products as $ind => $product) {
    $price = $product["product_price"];
    $price = number_format((float)$price, 2, '.', '');
    $products[$ind]["product_price"] = $price;
}
