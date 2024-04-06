<?php
require_once 'database.php';

// Assuming you have fetched the data and stored it in the $data variable

foreach ($data['products'] as $product) {
    $name = $conn->real_escape_string($product['name']);
    $description = $conn->real_escape_string($product['description']);
    $price = $product['price'];
    // Extract other relevant fields from the product data

    $sql = "INSERT INTO products (name, description, price) VALUES ('$name', '$description', '$price')";
    $conn->query($sql);
}

$conn->close();
?>