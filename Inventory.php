<?php
class Inventory {
    private $products = [];
    private $filePath = 'inventory.json';

    // Constructor to load products from the JSON file
    public function __construct() {
        if (file_exists($this->filePath) && filesize($this->filePath) > 0) {
            $this->products = json_decode(file_get_contents($this->filePath), true);
        }
        if (!$this->products) {
            // Default products if JSON is empty
            $this->products = [
                ['name' => 'Apple', 'price' => 2, 'quantity' => 100],
                ['name' => 'Banana', 'price' => 1, 'quantity' => 150]
            ];
            $this->saveInventory(); // Save the default products to the file
        }
    }

    // Fetch all products
    public function getProducts() {
        return $this->products;
    }

    // Get product price by name
    public function getProductPrice($productName) {
        foreach ($this->products as $product) {
            if (strcasecmp($product['name'], $productName) == 0) {
                return $product['price'];
            }
        }
        return null; // Return null if the product is not found
    }

    // Get product stock (quantity) by name
    public function getProductStock($productName) {
        foreach ($this->products as $product) {
            if (strcasecmp($product['name'], $productName) == 0) {
                return $product['quantity'];
            }
        }
        return 0; // Return 0 if the product is not found
    }

    // Update product quantity with validation
    public function updateProductStock($productName, $newQuantity) {
        if ($newQuantity < 0) {
            return "Quantity must be a positive number"; // Return error if quantity is invalid
        }

        foreach ($this->products as &$product) {
            if (strcasecmp($product['name'], $productName) == 0) {
                $product['quantity'] = $newQuantity; // Set the new quantity directly
                $this->saveInventory(); // Save the updated inventory
                return "Product quantity updated successfully"; // Success message
            }
        }
        return "Product not found"; // Product not found
    }

    // Add a new product or update if it exists
    public function addProduct($name, $price, $quantity) {
        if ($quantity < 0) {
            return "Quantity must be a positive number"; // Ensure positive quantity
        }

        // Check if the product already exists
        foreach ($this->products as &$product) {
            if (strcasecmp($product['name'], $name) == 0) {
                $product['quantity'] += $quantity; // If product exists, just add quantity
                $this->saveInventory(); // Save the updated inventory
                return "Product quantity updated successfully"; // Success message
            }
        }

        // If product doesn't exist, add a new one
        $this->products[] = ['name' => $name, 'price' => $price, 'quantity' => $quantity];
        $this->saveInventory(); // Save the updated inventory
        return "Product added successfully"; // Success message
    }

    // Delete product by name
    public function deleteProductByName($productName) {
        foreach ($this->products as $index => $product) {
            if (strcasecmp($product['name'], $productName) == 0) {
                unset($this->products[$index]); // Remove the product from the array
                $this->products = array_values($this->products); // Reindex the array
                $this->saveInventory(); // Save the updated inventory
                return "Product deleted successfully"; // Success message
            }
        }
        return "Product not found"; // Product not found
    }

    // Save inventory to file
    private function saveInventory() {
        file_put_contents($this->filePath, json_encode($this->products, JSON_PRETTY_PRINT));
    }
}
?>
