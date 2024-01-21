<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve the session ID from the session
    $session_id = session_id();

    // Retrieve the user data from the form
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone_number = $_POST["phone"];
    $address = $_POST["address"];
    $city = $_POST["city"];
    $comment = $_POST["comment"];
    
    // Get the current timestamp
    $created_at = date("Y-m-d H:i:s");

    // Include your database connection
    include("connection.php");

    // Insert the order information into the orders table
    $order_query = "INSERT INTO orders (product_id, quantity, name, email, phone_number, address, city, comment, created_at)
                    SELECT product_id, quantity, '$name', '$email', '$phone_number', '$address', '$city', '$comment', '$created_at'
                    FROM cart
                    WHERE session_id = '$session_id'";
     

    
    mysqli_query($con, $order_query);

    // Delete the cart items for the session ID
    $delete_query = "DELETE FROM cart WHERE session_id = '$session_id'";
    mysqli_query($con, $delete_query);
   
    // Close the database connection
    mysqli_close($con);
    header("Location: thank_you.php");

    // Redirect or display a success message
    
    exit();
} else {
    // Redirect to the index page or display an error message
    header("Location: index.php");
    exit();
}
?>
