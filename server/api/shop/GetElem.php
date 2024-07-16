<?php

include __DIR__ . "/../connection/inc.php";

$eid = htmlspecialchars(strip_tags($_GET['eid']));

$elem = getElem(
  "SELECT sdv.*, COALESCE(sc.quantity, 1) AS quantity
    FROM spaceships_detail_view sdv
    LEFT JOIN shopping_cart sc 
    ON sdv.product_id = sc.product_id AND sc.user_id = :uuid
    WHERE sdv.product_id = :eid ",
  [
    'eid' => $eid,
    'uuid' => $_SESSION['uuid'] ?? null,
  ]
);

if (empty($elem)) {
  echo json_encode(['message' => 'No items found'], JSON_PRETTY_PRINT);
  http_response_code(404);
  exit;
} else if ($elem === false) {
  echo json_encode(['message' => 'An error occurred'], JSON_PRETTY_PRINT);
  http_response_code(500);
  exit;
}

echo json_encode($elem, JSON_PRETTY_PRINT);
http_response_code(200);