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

// Define variables to store form data
$name = "";
$price = "";
$category = "";

// Define variable to store error messages
$errors = array();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $name = $_POST["name"];
    $price = $_POST["price"];
    $category = $_POST["category"];

    // Validate form fields
    if (empty($name)) {
        $errors[] = "Name is required";
    }

    if (empty($price)) {
        $errors[] = "Price is required";
    }

    if (empty($category)) {
        $errors[] = "Category is required";
    }

    // Process the product image
    $image = null;
    if ($_FILES["image"]["error"] == UPLOAD_ERR_OK) {
        $tmp_name = $_FILES["image"]["tmp_name"];
        $image = "uploads/" . $_FILES["image"]["name"];
        move_uploaded_file($tmp_name, $image);
    }

    // If no errors, insert the product into the database
    if (empty($errors)) {
        // Prepare the insert statement
        $insert_query = "INSERT INTO products (name, price, category, image) VALUES ('$name', '$price', '$category', '$image')";

        // Execute the insert statement
        mysqli_query($con, $insert_query);

        // Redirect to the manage products page
        header("Location: manage_products.php");
        exit();
    }
}

// Close the database connection
mysqli_close($con);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <link rel="stylesheet" href="style/main.css">
</head>
<body>
    <header>
        <h1>Add Product</h1>
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
        <h2>Add a New Product</h2>
        <?php
        // Display error messages, if any
        if (!empty($errors)) {
            echo "<div class='errors'>";
            foreach ($errors as $error) {
                echo "<p>$error</p>";
            }
            echo "</div>";
        }
        ?>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" enctype="multipart/form-data">
            <div class="form-group">
                <label for="name">Product Name:</label>
                <input type="text" name="name" id="name" value="<?php echo $name; ?>"><br><br><br>
            </div>
            <div class="form-group">
                <label for="price">Product Price:</label>
                <input type="text" name="price" id="price" value="<?php echo $price; ?>"><br><br>
            </div>
            <div class="form-group">
                <label for="category">Product Category:</label>
                <input type="text" name="category" id="category" value="<?php echo $category; ?>"><br><br><br>
            </div>
            <div class="form-group">
                <label for="image">Product Image:</label>
                <input type="file" name="image" id="image"><br><br><br>
            </div>
            <div class="form-group">
                <button type="submit">Add Product</button><br><br>
            </div>
        </form>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Admin Dashboard</p>
    </footer>
</body>
</html>
