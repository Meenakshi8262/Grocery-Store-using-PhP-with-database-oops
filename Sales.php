<?php
class Sales {
    private $orders = [];

    // Add an order to sales
    public function addOrder($order) {
        if ($order instanceof Order) {
            $this->orders[] = $order;
        } else {
            throw new Exception("Invalid order object.");
        }
    }

    // Calculate total sales amount
    public function calculateTotalSales() {
        $total = 0;
        foreach ($this->orders as $order) {
            $total += $order->calculateOrderTotal();
        }
        return $total;
    }

    // Generate a sales report
    public function generateSalesReport() {
        $report = "Sales Report:\n";
        foreach ($this->orders as $order) {
            $report .= "Customer: " . $order->getCustomerName() . "\n";
            foreach ($order->getProducts() as $product) {
                $report .= "- " . $product['name'] . " (Qty: " . $product['quantity'] . ") - $" . ($product['quantity'] * $product['price']) . "\n";
            }
            $report .= "Order Total: $" . $order->calculateOrderTotal() . "\n\n";
        }
        return $report;
    }
}
?>
