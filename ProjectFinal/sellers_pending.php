<?php
session_start();

// Check if the seller is logged in
if (!isset($_SESSION["seller_id"]) && !isset($_SESSION["seller_username"])) {
    // Redirect to the login page
    header("Location: login.php");
    exit();
}

// Include your database connection
include("connection.php");

// Fetch the seller's information
$seller_id = $_SESSION["seller_id"];
$query_seller = "SELECT * FROM sellers WHERE id = $seller_id";
$result_seller = mysqli_query($con, $query_seller);
$row_seller = mysqli_fetch_assoc($result_seller);

// Close the database connection
mysqli_close($con);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Seller Registration Pending</title>
    <link rel="stylesheet" href="style/main.css">
</head>
<body>
    <header>
        <h1>Seller Registration Pending</h1>
        <nav>
            <ul>
            <li><a href="index.php">Home</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
                <li><a href="products.php">Products</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main class="container">
        <h2>Welcome, <?php echo $row_seller["name"]; ?>!</h2>
        <p>Your registration is currently under process. Please wait for approval from the admin.</p>
        <p>Once your registration is approved, you will be able to access the seller dashboard and manage your products.</p>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Seller Dashboard</p>
    </footer>
</body>
</html>
