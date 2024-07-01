<?php

// Read raw POST data
$postData = file_get_contents("php://input");

// Decode JSON data
$data = json_decode($postData, true);

insertValue("DELETE FROM shopping_cart WHERE user_id = :uuid AND product_id = :prod_id", [
  'uuid' => $data['uuid'] ?? null,
  'prod_id' => $data['prod_id'] ?? null,
]);

echo json_encode(['message' => $data['prod_id'] ?? null], JSON_PRETTY_PRINT);
