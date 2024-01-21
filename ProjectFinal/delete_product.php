<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION["admin_id"]) && !isset($_SESSION["admin_username"])) {
    // Redirect to the login page
    header("Location: login.php");
    exit();
}

// Include your database connection
include("connection.php");

// Check if the product ID is provided
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Delete the product from the database
    $delete_query = "DELETE FROM products WHERE id = '$product_id'";
    mysqli_query($con, $delete_query);
}

// Redirect back to the manage products page
header("Location: manage_products.php");
exit();
