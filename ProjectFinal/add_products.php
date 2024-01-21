<?php
session_start();

// Check if the administrator is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
    
}

// Add product functionality
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process the form submission to add the product to the database
    // Retrieve the product details from the form fields and perform necessary database operations
    // ...

    // Redirect back to the product list or show a success message
    header("Location: index.php");
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <link rel="stylesheet" href="style/main.css">
</head>
<body>
    <div class="add-product-container">
        <h2>Add Product</h2>
        <form method="POST" action="">
        </form>
    </div>
</body>
</html>
