<?php

include __DIR__ . "/../../connection/inc.php";


// Read raw POST data
$postData = file_get_contents("php://input");

// Decode JSON data
$data = json_decode($postData, true);

if (!isset($data['uuid'])) {
  echo json_encode(['message' => 'Invalid data'], JSON_PRETTY_PRINT);
  http_response_code(400);
  exit;
}

$uuid = htmlspecialchars(strip_tags($data['uuid']));

// get all the items from the cart of the user
$cartItems = getElem("SELECT * FROM shopping_cart as c JOIN spaceships_detail_view as s on c.product_id = s.product_id WHERE c.user_id = :uuid", [
  'uuid' => $uuid,
]);

// check if the user has items in the cart
if (count($cartItems) === 0) {
  echo json_encode(['message' => 'No items in the cart'], JSON_PRETTY_PRINT);
  http_response_code(400);
  exit;
}

// calculate the total amount of the order

$total_amount = 0;

foreach ($cartItems as $item) {
  $price = getElem("SELECT price FROM products WHERE id = :eid", [
    'eid' => $item['product_id'],
  ])[0];
  $total_amount += $price['price'] * $item['quantity'];
}

// create a new order and get the order_id
$order_id = insertValue("INSERT INTO orders (user_id, total_amount) VALUES (:uuid, :total)", [
  'uuid' => $uuid,
  'total' => $total_amount,
], true);

// check if the creation of the order was successful
if ($order_id === false) {
  echo json_encode(['message' => 'Failed to create order'], JSON_PRETTY_PRINT);
  http_response_code(500);
  exit;
}

// add all the items to the order_list
foreach ($cartItems as $item) {

  $insertOrderElem = insertValue("INSERT INTO order_items (order_id, product_id, quantity, subtotal) VALUES (:oid, :pid, :qty, :subt)", [
    'oid' => $order_id,
    'pid' => $item['product_id'],
    'qty' => $item['quantity'],
    'subt' => $item['quantity'] * $item['product_price'],
  ]);

  // check if the insertion of the item was successful

  if ($insertOrderElem === false) {
    echo json_encode(['message' => 'Failed to add item to order'], JSON_PRETTY_PRINT);
    http_response_code(500);
    exit;
  }
}

if (insertValue("DELETE FROM shopping_cart WHERE user_id = :uuid", [
  'uuid' => $uuid,
]) === false) {
  echo json_encode(['message' => 'Failed to clear cart'], JSON_PRETTY_PRINT);
  http_response_code(500);
  exit;
}

echo json_encode(['message' => 'Order created successfully'], JSON_PRETTY_PRINT);
