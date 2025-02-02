<?php
// Include Inventory class
include('Inventory.php');

// Initialize Inventory object
$inventory = new Inventory();

// Fetch products from inventory
$products = $inventory->getProducts();

// Handle search functionality
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Filter products based on search term
if ($searchTerm) {
    $products = array_filter($products, function($product) use ($searchTerm) {
        return stripos($product['name'], $searchTerm) !== false;
    });
}

// Display status message (success/error) based on query parameter
$statusMessage = '';
if (isset($_GET['status'])) {
    if ($_GET['status'] == 'success') {
        $statusMessage = "Product deleted successfully.";
    } elseif ($_GET['status'] == 'error') {
        $statusMessage = "Error deleting the product.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory</title>
    <link rel="stylesheet" href="./css/Style.css">
</head>
<body>
    <!-- Header Section -->
    <header>
        <h1>Grocery Store Management</h1>
    </header>

    <!-- Navigation Bar -->
    <nav>
        <a href="index.php">Home</a>
        <a href="update_product.php">Update Product Quantity</a>
        <a href="add_product.php">Add New Product</a>
        <a href="process_order.php">Place Order</a>
        <a href="sales_report.php">View Sales Report</a>
  

    <!-- Status Message -->
    <?php if ($statusMessage): ?>
        <div class="status-message"><?= htmlspecialchars($statusMessage) ?></div>
    <?php endif; ?>

    <!-- Search Bar -->
    <div class="search-bar">
        <form method="GET" action="">
            <input type="text" name="search" placeholder="Search product by name" value="<?= htmlspecialchars($searchTerm) ?>">
        </form>
    </div>
    </nav>
    <!-- Inventory Section -->
    <h2>Current Inventory</h2>

    <!-- Display products -->
    <div class="container">
        <?php if (!empty($products) && is_array($products)): ?>
            <?php foreach ($products as $product): ?>
                <div class="product-box" onmouseover="this.style.backgroundColor='yellow'" onmouseout="this.style.backgroundColor='lightblue'">
                    <h3><?= htmlspecialchars($product['name']) ?></h3>
                    <p class="price"><?= '$' . number_format($product['price'], 2) ?></p>
                    <p class="quantity">Quantity: <?= htmlspecialchars($product['quantity']) ?></p>
                    <form method="POST" action="delete_product.php">
                        <input type="hidden" name="product_name" value="<?= htmlspecialchars($product['name']) ?>">
                        <button type="submit" class="delete-btn">Delete Product</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No products available.</p>
        <?php endif; ?>
    </div>
</body>
</html>
