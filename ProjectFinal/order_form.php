

<!DOCTYPE html>
<html>
<head>
    <title>Order Information</title>
    <link rel="stylesheet" href="style/main.css">
</head>
<body>
    <header>
        <h1>Order Information</h1>
    </header>

    <main class="container">
        <form action="submit_orders.php" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>

            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" required><br><br>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required><br><br>

            <label for="city">City:</label>
            <input type="text" id="city" name="city" required><br><br>

            <label for="comment">Comment:</label>
            <textarea id="comment" name="comment"></textarea><br><br>

            <input type="submit" value="Submit Order"><br><br>
        </form>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> Order Information Form</p>
    </footer>
</body>
</html>
