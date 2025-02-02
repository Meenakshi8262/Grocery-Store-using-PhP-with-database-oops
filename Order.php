<?php
class Order {
    private $customerName;
    private $products = [];

    public function __construct($customerName) {
        $this->customerName = $customerName;
    }

    public function addProduct($productName, $quantity, $price) {
        $this->products[] = ['name' => $productName, 'quantity' => $quantity, 'price' => $price];
    }

    public function getCustomerName() {
        return $this->customerName;
    }

    public function getProducts() {
        return $this->products;
    }

    public function calculateOrderTotal() {
        $total = 0;
        foreach ($this->products as $product) {
            $total += $product['quantity'] * $product['price'];
        }
        return $total;
    }
}
?>
