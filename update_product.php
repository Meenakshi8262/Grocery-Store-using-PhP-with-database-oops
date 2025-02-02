<?php
// Include Inventory class
include('Inventory.php');

// Initialize Inventory object
$inventory = new Inventory();

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productName = $_POST['productName'];
    $newQuantity = (int)$_POST['quantity'];

    // Update the product quantity in the inventory
    $inventory->updateProductStock($productName, $newQuantity);

    // Redirect back to the index page after updating
    header('Location: index.php');
    exit;
}

// Fetch products from inventory
$products = $inventory->getProducts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Product Quantity</title>
    <link rel="stylesheet" href="css/update_product.css">
</head>
<body>

    <header>
        <h1>Update Product Quantity</h1>
    </header>

    <nav>
        <a href="index.php">Home</a>
        <a href="update_product.php">Update Product Quantity</a>
        <a href="add_product.php">Add New Product</a>
        <a href="process_order.php">Place Order</a>
        <a href="sales_report.php">View Sales Report</a>
    </nav>

    <div class="container">
        <h2>Update Product Quantity</h2>

        <form action="update_product.php" method="POST">
            <label for="productName">Select Product:</label>
            <select name="productName" id="productName">
                <?php foreach ($products as $product): ?>
                    <option value="<?= htmlspecialchars($product['name']) ?>"><?= htmlspecialchars($product['name']) ?></option>
                <?php endforeach; ?>
            </select>

            <label for="quantity">New Quantity:</label>
            <input type="number" name="quantity" required>

            <input type="submit" value="Update Quantity">
        </form>
    </div>

</body>
</html>
