<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

function addToCart($id, $price)
{
    $_SESSION['cart'] = array();
    $_SESSION['cart'][$id] = $price;
}

function removeFromCart()
{
    $_SESSION['cart'] = array();
}

function getCartItems()
{
    return $_SESSION['cart'];
}

function emptyCart()
{
    $_SESSION['cart'] = array();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $id = $_POST['id'];
    $price = $_POST['price'];

    if ($action == 'add') {
        addToCart($id, $price);
    } elseif ($action == 'remove') {
        removeFromCart();
    }

    header("Location: cart.php");
    exit();
}
