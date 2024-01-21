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

    // Retrieve the product details
    $select_query = "SELECT * FROM products WHERE id = '$product_id'";
    $result = mysqli_query($con, $select_query);

    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);
        $product_name = $product['name'];
        $product_price = $product['price'];
        $product_category = $product['category'];
        // Add more fields if needed

        // Handle form submission for updating the product
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve the form data
            $updated_name = $_POST["name"];
            $updated_price = $_POST["price"];
            $updated_category = $_POST["category"];
            // Add more fields if needed

            // Update the product in the database
            $update_query = "UPDATE products SET name = '$updated_name', price = '$updated_price', category = '$updated_category' WHERE id = '$product_id'";
            mysqli_query($con, $update_query);

            // Redirect back to the manage products page
            header("Location: manage_products.php");
            exit();
        }
    } else {
        // Product not found, redirect to the manage products page
        header("Location: manage_products.php");
        exit();
    }
} else {
    // Product ID not provided, redirect to the manage products page
    header("Location: manage_products.php");
    exit();
}

// Close the database connection
mysqli_close($con);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <link rel="stylesheet" href="style/main.css">
</head>
<body>
    <header>
        <h1>Edit Product</h1>
        <nav>
            <ul>
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="add_product.php">Add Product</a></li>
                <li><a href="manage_products.php">Manage Products</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main class="container">
        <h2>Edit Product: <?php echo $product_name; ?></h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?id=' . $product_id; ?>">
            <div class="form-group">
                <label for="name">Product Name:</label>
                <input type="text" name="name" id="name" value="<?php echo $product_name; ?>">
            </div>
            <div class="form-group">
                <label for="price">Product Price:</label>
                <input type="text" name="price" id="price" value="<?php echo $product_price; ?>">
            </div>
            <div class="form-group">
                <label for="category">Product Category:</label>
                <input type="text" name="category" id="category" value="<?php echo $product_category; ?>">
            </div>
            <!-- Add more fields
