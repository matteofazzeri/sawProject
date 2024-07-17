<?php

include __DIR__ . "/../connection/inc.php";

$eid = htmlspecialchars(strip_tags($_GET['eid']));
$name = htmlspecialchars(strip_tags($_GET['en']));



$res = getElem(
  "SELECT name FROM products WHERE id LIKE :eid",
  ['eid' => $eid]
);

if (empty($res) or !$res) {
  echo json_encode(['error' => 'Element not found']);
  http_response_code(404);
  exit;
} else if (str_replace('-', ' ', $res[0]['name']) != $name) {
  echo json_encode(['error' => 'Elem name not match the one on db']);
  http_response_code(404);
  exit;
}

echo json_encode(getElem(
  "SELECT sdv.*, COALESCE(sc.quantity, 1) AS quantity
    FROM spaceships_detail_view sdv
    LEFT JOIN shopping_cart sc 
    ON sdv.product_id = sc.product_id AND sc.user_id = :uuid
    WHERE sdv.product_id LIKE :eid",
  [
    'eid' => $eid,
    'uuid' => $_SESSION['uuid'] ?? null,
  ]
));
