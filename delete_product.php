<?php
// Include the Inventory class
include('Inventory.php');  // Make sure the path is correct

// Initialize Inventory object
$inventory = new Inventory();

// Check if product_name is submitted via POST
if (isset($_POST['product_name'])) {
    $productName = $_POST['product_name'];

    // Delete the product using the Inventory class method
    if ($inventory->deleteProductByName($productName)) {
        // Redirect with success message
        header('Location: index.php?status=success');
        exit();
    } else {
        // Redirect with error message
        header('Location: index.php?status=error');
        exit();
    }
} else {
    // If no product_name is provided, redirect with error message
    header('Location: index.php?status=error');
    exit();
}
?>
