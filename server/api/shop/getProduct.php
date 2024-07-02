<?php

$page = $_GET['page'] ?? 1;
$items_per_page = $_GET['nElem'] ?? 16;
$latest_added = $_GET['la'] ?? 0;
$searchedElem = $_GET['k'] ?? '';

if ($searchedElem) {
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
} else {
  echo json_encode([], JSON_PRETTY_PRINT);
}

$result = array_values($data);


if (empty($result))
  echo json_encode($result, JSON_PRETTY_PRINT);

// Paginate result array
$offset = ($page - 1) * $items_per_page;
$result = array_slice($result, $offset, $items_per_page);

if (empty($result))
  echo json_encode(['page' => '0']);
else
  echo json_encode($result, JSON_PRETTY_PRINT);
