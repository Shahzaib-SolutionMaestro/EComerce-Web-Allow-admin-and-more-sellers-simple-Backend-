<?php
session_start();

// Check if the product ID is provided
if (isset($_GET['product_id'])) {
    $product_id = $_GET['product_id'];

    // Retrieve the session ID
    $session_id = session_id();

    // Add the product to the cart table
    include("connection.php"); // Include your database connection

    // Check if the product is already in the cart for the current session
    $check_query = "SELECT * FROM cart WHERE session_id = '$session_id' AND product_id = '$product_id'";
    $check_result = mysqli_query($con, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Update the quantity if the product is already in the cart
        $update_query = "UPDATE cart SET quantity = quantity + 1 WHERE session_id = '$session_id' AND product_id = '$product_id'";
        mysqli_query($con, $update_query);
    } else {
        // Insert the product into the cart table
        $insert_query = "INSERT INTO cart (session_id, product_id, quantity) VALUES ('$session_id', '$product_id', 1)";
        mysqli_query($con, $insert_query);
    }

    // Close the database connection
    mysqli_close($con);

    // Redirect back to the index page
    header("Location: index.php");
    exit();
}

// Retrieve the session ID
$session_id = session_id();

// Retrieve the cart count for the current session
include("connection.php"); // Include your database connection

$cart_count = 0;
$cart_query = "SELECT SUM(quantity) AS total_quantity FROM cart WHERE session_id = '$session_id'";
$cart_result = mysqli_query($con, $cart_query);

if ($cart_result && mysqli_num_rows($cart_result) > 0) {
    $cart_row = mysqli_fetch_assoc($cart_result);
    $cart_count = $cart_row['total_quantity'];
}

// Retrieve the product list
$product_query = "SELECT * FROM products";
$product_result = mysqli_query($con, $product_query);

// Close the database connection
mysqli_close($con);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Larton Accessories</title>
    <link rel="stylesheet" href="style/main.css">
</head>
<body>
    <header>
        <h1>Larton Accessories</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="cart.php">Cart <?php echo ($cart_count > 0) ? "(" . $cart_count . ")" : ""; ?></a></li>
                <li><a href="login.php">Add Products</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main class="container">
        <h2>Available Products</h2>
        <?php
        if ($product_result && mysqli_num_rows($product_result) > 0) {
            while ($product_row = mysqli_fetch_assoc($product_result)) {
                $product_id = $product_row['id'];
                $product_name = $product_row['name'];
                $product_price = $product_row['price'];
                $product_image = $product_row['image'];

                echo "<div class='product'>";
                echo "<img src='$product_image' alt='$product_name'>";
                echo "<h3>$product_name</h3>";
                echo "<p>Price: $product_price</p>";
                echo "<div>";
                echo "<button onclick=\"addToCart($product_id)\">Add to Cart</button>";
                echo "<input type='number' id='product_$product_id' value='1' min='1'>";
                echo "</div>";
                echo "</div>";
            }
        } else {
            echo "<p>No products available.</p>";
        }
        ?>
    </main>

    <script>
        function addToCart(productId) {
            var quantity = document.getElementById('product_' + productId).value;
            window.location.href = 'index.php?product_id=' + productId + '&quantity=' + quantity;
        }

    
    </script>

    <footer>
        <div class="footer-links">
            <ul>
                <li><a href="about.php">About Us</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <li><a href="terms.php">Terms and Conditions</a></li>
                <li><a href="privacy.php">Privacy Policy</a></li>
            </ul>
        </div>
        <div class="footer-info">
            <p>&copy; <?php echo date("Y"); ?> Larton Accessories. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
