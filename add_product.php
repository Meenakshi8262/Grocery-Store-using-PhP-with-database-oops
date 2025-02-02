<?php
// Include Inventory class
include('Inventory.php');

// Initialize Inventory object
$inventory = new Inventory();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['productName'];  // Get product name from form
    $price = $_POST['price'];  // Get price from form
    $quantity = (int)$_POST['quantity'];  // Get quantity from form

    // Add the new product to the inventory
    $inventory->addProduct($productName, $price, $quantity);

    // Redirect to the index page after adding the product
    header('Location: index.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product</title>
    <link rel="stylesheet" href="css/add_product.css">
</head>
<body>

    <!-- Header Section -->
    <header>
        <h1>Add New Product</h1>
    </header>

    <!-- Navigation Bar -->
    <nav>
        <a href="index.php">Home</a>
        <a href="update_product.php">Update Product Quantity</a>
        <a href="add_product.php">Add New Product</a>
        <a href="process_order.php">Place Order</a>
        <a href="sales_report.php">View Sales Report</a>
    </nav>

    <!-- Search Bar -->
    <div class="search-bar">
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search product by name">
        </form>
    </div>

    <!-- Form Container -->
    <div class="container">
        <h2>Add New Product</h2>

        <!-- Form to add a new product -->
        <form action="add_product.php" method="POST">
            <label for="productName">Product Name:</label>
            <input type="text" name="productName" required>

            <label for="price">Price:</label>
            <input type="number" name="price" step="0.01" required>

            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" required>

            <input type="submit" value="Add Product">
        </form>
    </div>

</body>
</html>
