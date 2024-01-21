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

// Retrieve the product list
$product_query = "SELECT * FROM products";
$product_result = mysqli_query($con, $product_query);

// Close the database connection
mysqli_close($con);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Products</title>
    <link rel="stylesheet" href="style/main.css">
</head>
<body>
    <header>
        <h1>Manage Products</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="add_product.php">Add Product</a></li>
                <li><a href="manage_products.php">Manage Products</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main class="container">
        <h2>Product List</h2>
        <?php
        if ($product_result && mysqli_num_rows($product_result) > 0) {
            echo "<table>";
            echo "<tr>";
            echo "<th>ID</th>";
            echo "<th>Name</th>";
            echo "<th>Price</th>";
            echo "<th>Category</th>";
            echo "<th>Image</th>";
            echo "<th>Action</th>";
            echo "</tr>";
            
            while ($product_row = mysqli_fetch_assoc($product_result)) {
                $product_id = $product_row['id'];
                $product_name = $product_row['name'];
                $product_price = $product_row['price'];
                $product_category = $product_row['category'];
                $product_image = $product_row['image'];

                echo "<tr>";
                echo "<td>$product_id</td>";
                echo "<td>$product_name</td>";
                echo "<td>$product_price</td>";
                echo "<td>$product_category</td>";
                echo "<td><img src='$product_image' alt='$product_name' width='100'></td>";
                echo "<td><a href='edit_product.php?id=$product_id'>Edit</a> | <a href='delete_product.php?id=$product_id'>Delete</a></td>";
                echo "</tr>";
            }
            
            echo "</table>";
        } else {
            echo "<p>No products available.</p>";
        }
        ?>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Admin Dashboard</p>
    </footer>
</body>
</html>
