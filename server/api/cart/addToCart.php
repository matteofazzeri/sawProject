<?php

// Read raw POST data
$postData = file_get_contents("php://input");

// Decode JSON data
$data = json_decode($postData, true);

if ($data !== null) {
  // Access the data
  $eid = htmlspecialchars(strip_tags($data['elem_id'])) ?? null;
  $uuid = id(htmlspecialchars(strip_tags($data['uuid']))) ?? null;
  $n_elem = $data['n_elem'] ?? 0;
} else {
  echo "Error decoding JSON data";
}

// Check if data is missing

if ($uuid === null) {
  echo "Error: user not logged in";
  http_response_code(401);
  exit;
}

if ($eid === null || $n_elem === 0) {
  echo "Error: missing data";
  http_response_code(400);
  exit;
}

$alr_in = getElem("SELECT quantity FROM shopping_cart WHERE user_id = :uuid AND product_id = :eid", [
  'uuid' => $uuid,
  'eid' => $eid,
]);

if ($alr_in === false) {
  echo json_encode(["Error" => "database error"]);
  http_response_code(500);
  exit;
}

if (empty($alr_in)) {
  if (!insertValue("INSERT INTO shopping_cart (user_id, product_id, quantity) VALUES (:uuid, :eid, :quantity)", [
    'uuid' => $uuid,
    'eid' => $eid,
    'quantity' => $n_elem,
  ])) {
    echo json_encode(["Error" => "database error"]);
    http_response_code(500);
    exit;
  }
  http_response_code(201);
} else {
  if (!insertValue("UPDATE shopping_cart SET quantity = :new_quantity WHERE user_id = :uuid AND product_id = :eid", [
    'uuid' => $uuid,
    'eid' => $eid,
    'new_quantity' => $n_elem,
  ])) {
    echo json_encode(["Error" => "database error"]);
    http_response_code(500);
    exit;
  }
  http_response_code(204);
}
