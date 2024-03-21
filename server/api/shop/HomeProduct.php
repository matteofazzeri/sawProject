<?php
include __DIR__ . "/../connection/inc.php";

$data = getElem("SELECT * FROM spaceships_detail_view");

// Group products by product_id
$grouped_data = [];
foreach ($data as $item) {
  $product_id = $item['product_id'];
  if (!isset($grouped_data[$product_id])) {
    $grouped_data[$product_id] = $item;
    $grouped_data[$product_id]['colors'] = [];
    $grouped_data[$product_id]['sizes'] = [];
    $grouped_data[$product_id]['tags'] = [];
  }
  if (!in_array($item['color_name'], $grouped_data[$product_id]['colors'])) {
    $grouped_data[$product_id]['colors'][] = $item['color_name'];
  }
  if (!in_array($item['size_name'], $grouped_data[$product_id]['sizes'])) {
    $grouped_data[$product_id]['sizes'][] = $item['size_name'];
  }
  if (!in_array($item['tag'], $grouped_data[$product_id]['tags'])) {
    $grouped_data[$product_id]['tags'][] = $item['tag'];
  }
}

// Convert associative array back to indexed array
$result = array_values($grouped_data);

// Encode result array to JSON with pretty print
$json_output = json_encode($result, JSON_PRETTY_PRINT);

// Output JSON
echo "<pre>" . $json_output . "</pre>";
