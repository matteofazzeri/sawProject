<?php

include __DIR__ . "/../../connection/inc.php";


// Read raw POST data
$postData = file_get_contents("php://input");

// Decode JSON data
$data = json_decode($postData, true);

/* if (!isset($data['uuid'])) {
  echo json_encode(['message' => 'Invalid user data'], JSON_PRETTY_PRINT);
  http_response_code(400);
  exit;
} */

$uuid = htmlspecialchars(strip_tags($data['uuid']));

$uuid = 1;

/* if (!isLogged()) {
  echo json_encode(['message' => 'User not logged in'], JSON_PRETTY_PRINT);
  http_response_code(401);
  exit;
} */

// check if the uuid corresponds to the user with the session id

/* if ($_SESSION['uuid'] !== $uuid) {
  echo json_encode(['message' => 'Invalid user data'], JSON_PRETTY_PRINT);
  http_response_code(400);
  exit;
} */

// get all the items from the cart of the user

$cartItems = getElem(
  "SELECT sdv.*, COALESCE(sc.quantity, 1) AS quantity
    FROM spaceships_detail_view sdv
    JOIN shopping_cart sc 
    ON sdv.product_id = sc.product_id AND sc.user_id = :uuid",
  [
    'uuid' => $uuid,
  ]
);

// check if the user has items in the cart
if (count($cartItems) === 0) {
  echo json_encode(['message' => 'No items in the cart'], JSON_PRETTY_PRINT);
  http_response_code(400);
  exit;
}

// update the quantity of the of the product

foreach ($cartItems as $item) {
  $test = getElem("UPDATE products SET quantity = :new_q WHERE id = :eid", [
    'new_q' => $item['product_quantity'] - $item['quantity'],
    'eid' => $item['product_id'],
  ]);

  if ($test === false) {
    json_encode(['message' => 'not enough product']);
    http_response_code(409);
    exit;
  }
}

// calculate the total amount of the order

$total_amount = 0;

foreach ($cartItems as $item) {
  $values = getElem("SELECT price FROM products WHERE id = :eid", [
    'eid' => $item['product_id'],
  ])[0];
  $total_amount += $values['price'] * $item['quantity'];
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
