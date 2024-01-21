<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION["admin_id"])) {
    // Redirect to the admin dashboard or any other page
    header("Location: admin_dashboard.php");
    exit();
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $email = $_POST["email"];
    $address = $_POST["address"];
    $category = $_POST["category"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Store the seller information in the sellers table
    include("connection.php"); // Include your database connection

    // Prepare and execute the query
    $sellersQuery = "INSERT INTO sellers (name, email, address, category, username, password) VALUES ('$name', '$email', '$address', '$category', '$username', '$password')";
    $sellersResult = mysqli_query($con, $sellersQuery);

    if (!$sellersResult) {
        // Registration failed, display error message and MySQL error
        $error_message = "Registration failed. Please try again.";
        echo "MySQL Error: " . mysqli_error($con);
        mysqli_close($con);
        exit();
    }

    // Registration successful, set session variables or display success message
    $_SESSION["registration_success"] = true;

    // Redirect to the sellers_pending page
    header("Location: sellers_pending.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register as a Seller</title>
    <link rel="stylesheet" href="style/main.css">
</head>
<body>
    <div class="register-container">
        <h1>Register as a Seller</h1>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <?php if (isset($error_message)) { ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php } ?>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <textarea id="address" name="address" required></textarea>
            </div>
            <div class="form-group">
                <label for="category">Product Category:</label>
                <input type="text" id="category" name="category" required>
            </div>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
