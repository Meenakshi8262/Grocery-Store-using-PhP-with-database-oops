<?php
// Include necessary class files
include('Sales.php');
include('Order.php');
include('Inventory.php');

// Start the session
session_start();

// Initialize objects
$sales = new Sales();
$inventory = new Inventory();

// Initialize session orders if not set
if (!isset($_SESSION['orders'])) {
    $_SESSION['orders'] = [];
}

$totalAmount = 0;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['place_order'])) {
        // Get order details from form
        $customerName = $_POST['customer_name'];
        $product = $_POST['product'];
        $quantity = $_POST['quantity'];
        $paymentMethod = $_POST['payment_method'];
        $isGiftWrapped = isset($_POST['gift_wrap']) ? true : false;

        // Retrieve product price and stock
        $productPrice = $inventory->getProductPrice($product);
        $stockAvailable = $inventory->getProductStock($product);

        if ($quantity > $stockAvailable) {
            echo "Not enough stock. Available stock: $stockAvailable.";
            exit;
        }

        // Gift wrap price
        $giftWrapPrice = 2.00;

        // Calculate total amount
        $amount = $productPrice * $quantity;
        if ($isGiftWrapped) {
            $amount += $giftWrapPrice;
        }

        // Create a new order
        $order = new Order($customerName);
        $order->addProduct($product, $quantity, $productPrice);

        if ($isGiftWrapped) {
            $order->addProduct("Gift Wrap", 1, $giftWrapPrice);
        }

        // Update inventory
        $inventory->updateProductStock($product, $stockAvailable - $quantity);

        // Store serialized order in session
        $_SESSION['orders'][] = serialize($order);

        $totalAmount = $amount;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Place Order</title>
    <link rel="stylesheet" href="css/process_order.css">
</head>
<body>
    <header><h1>Place an Order</h1></header>
    <nav>
        <a href="index.php">Home</a>
        <a href="update_product.php">Update Product</a>
        <a href="add_product.php">Add Product</a>
        <a href="process_order.php">Place Order</a>
        <a href="sales_report.php">View Sales Report</a>
    </nav>
    <div class="container">
        <h2>Place an Order</h2>
        <form action="process_order.php" method="POST">
            <label for="customer_name">Customer Name:</label>
            <input type="text" name="customer_name" required>

            <h3>Select Product:</h3>
            <?php
                // Dynamically populate products from inventory
                $products = $inventory->getProducts();
                foreach ($products as $product) {
                    echo '<input type="radio" name="product" value="' . htmlspecialchars($product['name']) . '" required> ' . htmlspecialchars($product['name']) . '<br>';
                }
            ?>

            <label for="quantity">Quantity:</label>
            <input type="number" name="quantity" required min="1">

            <h3>Payment Method:</h3>
            <input type="radio" name="payment_method" value="debit" required> Debit Card
            <input type="radio" name="payment_method" value="credit" required> Credit Card

            <label for="gift_wrap">Gift Wrap:</label>
            <input type="checkbox" name="gift_wrap">

            <button type="submit" name="place_order">Place Order</button>
        </form>

        <?php if ($totalAmount > 0): ?>
            <h3>Total Amount: $<?php echo number_format($totalAmount, 2); ?></h3>
        <?php endif; ?>
    </div>
</body>
</html>
