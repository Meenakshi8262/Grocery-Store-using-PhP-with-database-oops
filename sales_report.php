<?php
include('Sales.php');
include('Order.php');

// Start session
session_start();

// Initialize sales object
$sales = new Sales();

// Initialize the report variable
$report = "";  // Add a default value to avoid undefined variable warning

// Check if there are any stored orders
if (isset($_SESSION['orders']) && is_array($_SESSION['orders'])) {
    foreach ($_SESSION['orders'] as $orderData) {
        // Unserialize the order data before adding it
        $order = is_string($orderData) ? unserialize($orderData) : $orderData;
        if ($order instanceof Order) {
            $sales->addOrder($order);
        }
    }
}

// Generate the sales report if orders are available
$totalSales = $sales->calculateTotalSales();
$report = $sales->generateSalesReport();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sales Report</title>
    <link rel="stylesheet" href="css/sales_report.css">  <!-- Link to the external CSS -->
</head>
<body>
    <header><h1>Sales Report</h1></header>
    <nav>
        <a href="index.php">Home</a>
        <a href="update_product.php">Update Product</a>
        <a href="add_product.php">Add Product</a>
        <a href="process_order.php">Place Order</a>
        <a href="sales_report.php">View Sales Report</a>
    </nav>
    <div class="container">
        <h2>Total Sales: $<?php echo number_format($totalSales, 2); ?></h2>
        
        <!-- Textarea for displaying the sales report -->
        <textarea class="report-textarea" readonly><?php echo $report; ?></textarea>

        <!-- Button to refresh the report -->
        <div class="button-container">
            <form action="sales_report.php" method="POST">
                <button type="submit" name="refresh_report">Refresh Report</button>
            </form>
        </div>
    </div>
</body>
</html>
