<?php

$page = $_GET['page'] ?? 1;
$items_per_page = $_GET['nElem'] ?? 16;
$latest_added = $_GET['la'] ?? 0;
$searchedElem = $_GET['k'] ?? '';

if ($searchedElem) {
  $data = getElem(
    "SELECT * FROM spaceships_detail_view WHERE product_name LIKE :searchElem",
    [
      'searchElem' => "$searchedElem%",
    ]
  );
} else {
  echo json_encode([], JSON_PRETTY_PRINT);
}

$result = array_values($data);

// Paginate result array
$offset = ($page - 1) * $items_per_page;
$result = array_slice($result, $offset, $items_per_page);

echo json_encode($result, JSON_PRETTY_PRINT);
