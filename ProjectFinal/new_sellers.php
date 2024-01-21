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

// Fetch the new sellers from the sellers table
$query_sellers = "SELECT * FROM sellers";
$result_sellers = mysqli_query($con, $query_sellers);

// Check if the "Allow" button is clicked
if (isset($_POST["allow"])) {
    // Get the selected sellers' IDs
    $allowed_sellers = $_POST["allowed_sellers"];

    // Insert the selected sellers into the admins table
    foreach ($allowed_sellers as $seller_id) {
        $insertQuery = "INSERT INTO admins (username, password) SELECT username, password FROM sellers WHERE id = $seller_id";
        mysqli_query($con, $insertQuery);
    }

    // Redirect to the admin dashboard or any other page
    header("Location: admin_dashboard.php");
    exit();
}

// Check if the "Delete" button is clicked
if (isset($_POST["delete"])) {
    // Get the selected sellers' IDs
    $deleted_sellers = $_POST["deleted_sellers"];

    // Delete the selected sellers from the sellers table
    foreach ($deleted_sellers as $seller_id) {
        $deleteQuery = "DELETE FROM sellers WHERE id = $seller_id";
        mysqli_query($con, $deleteQuery);
    }

    // Redirect to the sellers_pending page or any other page
    header("Location: sellers_pending.php");
    exit();
}

// Close the database connection
mysqli_close($con);
?>

<!DOCTYPE html>
<html>
<head>
    <title>New Sellers Allow/Delete</title>
    <link rel="stylesheet" href="style/main.css">
</head>
<body>
    <header>
        <h1>New Sellers</h1>
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
        <h2>New Sellers</h2>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <table class="seller-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Category</th>
                        <th>Username</th>
                        <th>Allow</th>
                        <th>Delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result_sellers)) { ?>
                        <tr>
                            <td><?php echo $row["name"]; ?></td>
                            <td><?php echo $row["email"]; ?></td>
                            <td><?php echo $row["address"]; ?></td>
                            <td><?php echo $row["category"]; ?></td>
                            <td><?php echo $row["username"]; ?></td>
                            <td><input type="checkbox" name="allowed_sellers[]" value="<?php echo $row["id"]; ?>"></td>
                            <td><input type="checkbox" name="deleted_sellers[]" value="<?php echo $row["id"]; ?>"></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="button-group">
                <button type="submit" name="allow">Allow</button>
                <button type="submit" name="delete">Delete</button>
            </div>
        </form>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Admin Dashboard</p>
    </footer>
</body>
</html>
