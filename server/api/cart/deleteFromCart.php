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
  $data['prod_id'] = htmlspecialchars(strip_tags($data['prod_id']));
}

if (isset($data['deleteAll']) && $data['deleteAll'] === true) {
  insertValue("DELETE FROM shopping_cart WHERE user_id = :uuid", [
    'uuid' => $data['uuid'] ?? null,
  ]);
  echo json_encode(['message' => 'All items deleted'], JSON_PRETTY_PRINT);
  exit;
} else {
  insertValue("DELETE FROM shopping_cart WHERE user_id = :uuid AND product_id = :prod_id", [
    'uuid' => $data['uuid'] ?? null,
    'prod_id' => $data['prod_id'] ?? null,
  ]);
  echo json_encode(['message' => $data['prod_id'] ?? null], JSON_PRETTY_PRINT);
  exit;
}
