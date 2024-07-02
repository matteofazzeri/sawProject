<?php

// Read raw POST data
$postData = file_get_contents("php://input");

// Decode JSON data
$data = json_decode($postData, true);

if (!isset($data['uuid']) || !isset($data['prod_id'])) {
  echo json_encode(['message' => 'Invalid data'], JSON_PRETTY_PRINT);
  exit;
} else {
  $data['uuid'] = htmlspecialchars(strip_tags($data['uuid']));
}

// get all the items from the cart

$cartItems = getElem("SELECT * FROM shopping_cart WHERE user_id = :uuid", [
  'uuid' => $data['uuid'] ?? null,
]);


// calculate the total amount of the order

$total_amount = 0;

foreach ($cartItems as $item) {
  $product = getElem("SELECT * FROM products WHERE id = :id", [
    'id' => $item['product_id'],
  ])[0];
  $total_amount += $product['price'] * $item['quantity'];
}




// create a new order and add the items to the order_items

$order_id = insertValue("INSERT INTO orders (user_id, total_amount) VALUES (:uuid, :total)", [
  'uuid' => $data['uuid'] ?? null,
  'total' => $total_amount,
]);

insertValue("DELETE FROM shopping_cart WHERE user_id = :uuid", [
  'uuid' => $data['uuid'] ?? null,
]);
