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
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Check the database for matching credentials
    include("connection.php"); // Include your database connection

    // Prepare and execute the query
    $query = "SELECT * FROM admins WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($con, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        // Login successful, set session variables
        $admin = mysqli_fetch_assoc($result);
        $_SESSION["admin_id"] = $admin["id"];
        $_SESSION["admin_username"] = $admin["username"];

        // Redirect to the admin dashboard or any other page
        header("Location: admin_dashboard.php");
        exit();
    } else {
        // Invalid login credentials
        $error_message = "Invalid username or password";
    }

    // Close the database connection
    mysqli_close($con);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="style/main.css">
</head>
<body>
    <div class="login-container">
    <li><a href="index.php">Back To Home</a></li><br><br>                                                                                                                                                                                                                                                                           
        <h1>Login</h1>
    
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <?php if (isset($error_message)) { ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php } ?>
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">Login</button>
        </form>
        <div class="register-link">
            <a href="register.php">Register as a Seller</a>
        </div>
    </div>
</body>
</html>