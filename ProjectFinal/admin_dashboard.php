<?php
session_start();

// Check if the admin is logged in
if (!isset($_SESSION["admin_id"]) && !isset($_SESSION["admin_username"])) {
    // Redirect to the login page
    header("Location: login.php");
    exit();
}

// Retrieve the admin details
$admin_id = $_SESSION["admin_id"];
$admin_username = $_SESSION["admin_username"];

// Include your database connection
include("connection.php");

// Fetch the total number of sellers
$query_sellers = "SELECT COUNT(*) AS total_sellers FROM sellers";
$result_sellers = mysqli_query($con, $query_sellers);
$row_sellers = mysqli_fetch_assoc($result_sellers);
$total_sellers = $row_sellers["total_sellers"];

// Fetch the total number of products
$query_products = "SELECT COUNT(*) AS total_products FROM products";
$result_products = mysqli_query($con, $query_products);
$row_products = mysqli_fetch_assoc($result_products);
$total_products = $row_products["total_products"];

// Close the database connection
mysqli_close($con);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style/main.css">
</head>
<body>
    <header>
        <h1>Admin Dashboard</h1>
        <nav>
            <ul>
            <li><a href="index.php">Home</a></li>
                <li><a href="admin_dashboard.php">Dashboard</a></li>
                <li><a href="add_product.php">Add Product</a></li>
                <li><a href="manage_products.php">Manage Products</a></li>
                <li><a href="new_sellers.php">New Sellers </a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main class="container">
        <h2>Welcome, <?php echo $admin_username; ?>!</h2>
        <div class="stats">
            <div class="stat">
                <h3>Total Sellers</h3>
                <p><?php echo $total_sellers; ?></p>
            </div>
            <div class="stat">
                <h3>Total Products</h3>
                <p><?php echo $total_products; ?></p>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Admin Dashboard</p>
    </footer>
</body>
</html>
