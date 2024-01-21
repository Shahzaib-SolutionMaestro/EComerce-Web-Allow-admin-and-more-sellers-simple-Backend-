<?php
session_start();

// Check if the order details are submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the order information
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $comment = $_POST['comment'];

    // Save the order information in the database (assuming you have a connection already established)
    include("connection.php");

    // Insert the order details into the "orders" table
    $insert_query = "INSERT INTO orders (product_id, quantity, name, email, phone_number, address, city, comment) VALUES ('$product_id', '$quantity', '$name', '$email', '$phone_number', '$address', '$city', '$comment')";
    mysqli_query($con, $insert_query);

    // Close the database connection
    mysqli_close($con);
} 

?>

<!DOCTYPE html>
<html>
<head>
    <title>Thank You</title>
    <link rel="stylesheet" href="style/main.css">
</head>
<body>
    <header>
        <h1>Thank You</h1>
    </header>

    <main class="container">
        <h2>Thank you for your order!</h2>
        <p>We appreciate your business. Your order has been received and will be processed shortly.</p>
        <p>Order Details:</p>
        <ul>
            <?php
            // Retrieve the order details from the "orders" table
            include("connection.php");

            $select_query = "SELECT * FROM orders ORDER BY created_at DESC LIMIT 1";
            $result = mysqli_query($con, $select_query);

            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $product_id = $row['product_id'];
                $quantity = $row['quantity'];
                $name = $row['name'];
                $email = $row['email'];
                $phone_number = $row['phone_number'];
                $address = $row['address'];
                $city = $row['city'];
                $comment = $row['comment'];

                echo "<li><strong>Product ID:</strong> " . $product_id . "</li>";
                echo "<li><strong>Quantity:</strong> " . $quantity . "</li>";
                echo "<li><strong>Name:</strong> " . $name . "</li>";
                echo "<li><strong>Email:</strong> " . $email . "</li>";
                echo "<li><strong>Phone Number:</strong> " . $phone_number . "</li>";
                echo "<li><strong>Address:</strong> " . $address . "</li>";
                echo "<li><strong>City:</strong> " . $city . "</li>";
                echo "<li><strong>Comment:</strong> " . $comment . "</li>";
            }
            ?>
        </ul>
        <p>A confirmation email will be sent to <?php echo $email; ?>.</p>
        <li><a href="index.php">Back To Home</a></li><br><br>   
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Thank You Page</p>
    </footer>
</body>
</html>
