<?php
// Ensure the Inventory class is included
require_once(__DIR__ . '/Inventory.php');

// Initialize Inventory object
$inventory = new Inventory();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $searchTerm = $_POST['searchTerm'] ?? '';
    $products = $inventory->getProducts();

    // Filter products matching the search term (case insensitive)
    $filteredProducts = array_filter($products, function ($product) use ($searchTerm) {
        return stripos($product['name'], $searchTerm) !== false;
    });
} else {
    $filteredProducts = $inventory->getProducts();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Products</title>
</head>
<body>
    <h1>Search Products</h1>
    <form method="POST" action="">
        <label for="searchTerm">Search for a product:</label>
        <input type="text" name="searchTerm" required>
        <input type="submit" value="Search">
    </form>

    <h2>Product Results</h2>
    <table border="1">
        <tr>
            <th>Product Name</th>
            <th>Price</th>
            <th>Quantity</th>
        </tr>
        <?php if (!empty($filteredProducts)): ?>
            <?php foreach ($filteredProducts as $product): ?>
                <tr>
                    <td><?= htmlspecialchars($product['name']) ?></td>
                    <td><?= htmlspecialchars($product['price']) ?></td>
                    <td><?= htmlspecialchars($product['quantity']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="3">No matching products found.</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>
