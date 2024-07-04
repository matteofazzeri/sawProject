<?php

$page = $_GET['page'] ?? 1;
$items_per_page = $_GET['nElem'] ?? 16;
$searchedElem = $_GET['k'] ?? '';

$data = getElem(
  "SELECT sdv.*, COALESCE(sc.quantity, 1) AS quantity
    FROM spaceships_detail_view sdv
    LEFT JOIN shopping_cart sc 
    ON sdv.product_id = sc.product_id AND sc.user_id = :uuid
    WHERE sdv.product_name LIKE :searchElem",
  [
    'searchElem' => "%$searchedElem%",
    'uuid' => $_SESSION['uuid'] ?? 1
  ]
);


/* if (empty($data)) {
  echo json_encode(['message' => 'No items found'], JSON_PRETTY_PRINT);
  http_response_code(204);
  //exit;
} */

$result = array_values($data);



// Paginate result array
$offset = ($page - 1) * $items_per_page;
$result = array_slice($result, $offset, $items_per_page);

if (empty($result))
  http_response_code(204);
else {
  echo json_encode($result, JSON_PRETTY_PRINT);
  http_response_code(200);
}
