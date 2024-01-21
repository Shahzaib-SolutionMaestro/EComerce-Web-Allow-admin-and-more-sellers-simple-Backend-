<?php
session_start();

// Retrieve the session ID
$session_id = session_id();

// Retrieve the cart products for the current session ID
include("connection.php"); // Include your database connection

// Check if a product should be deleted from the cart
if (isset($_GET['delete'])) {
    $delete_product_id = $_GET['delete'];

    // Delete the product from the cart
    $delete_query = "DELETE FROM cart WHERE session_id = '$session_id' AND product_id = '$delete_product_id'";
    mysqli_query($con, $delete_query);
}

$query = "SELECT products.id, products.name, products.price, cart.quantity
          FROM cart
          INNER JOIN products ON cart.product_id = products.id
          WHERE cart.session_id = '$session_id'";
$result = mysqli_query($con, $query);

// Close the database connection
mysqli_close($con);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cart</title>
    <link rel="stylesheet" href="style/main.css">
</head>
<body>
    <h1>Cart</h1>

    <div class="cart-items">
        <?php if (mysqli_num_rows($result) > 0) : ?>
            <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                <div class="cart-item">
                    <h3><?php echo $row['name']; ?></h3>
                    <p>Price: <?php echo $row['price']; ?></p>
                    <p>Quantity: <?php echo $row['quantity']; ?></p>
                    <a href="cart.php?delete=<?php echo $row['id']; ?>">Delete</a>
                </div>
            <?php endwhile; ?>
        <?php else : ?>
            <p>No products in the cart.</p>
        <?php endif; ?>
    </div>

    <?php if (mysqli_num_rows($result) > 0) : ?>
        <form action="order_form.php" method="post">
            <input type="hidden" name="session_id" value="<?php echo $session_id; ?>"><br><br><br><br>

            <button type="submit">Order Now</button>
        </form>
    <?php endif; ?>
    
    <a href="index.php">Back to Home</a>

</body>
</html>
