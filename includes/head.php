<?php include_once "config/config.php" ?>

<?php  ob_start(); ?>

<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.png" />
<title><?= isset($pageInfo['title']) ? $pageInfo['title'] . " - " . SITE_NAME : SITE_NAME ?></title>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
