<?php
include __DIR__ . "/../connection/inc.php";

header("Access-Control-Allow-Origin: *");

$requestURL = explode('/', $_SERVER['REQUEST_URI']);

$URL_lenght = $requestURL[count($requestURL) - 1];

$latest_add = $_GET['l'] ?? 0;
$wishlist = $_GET['w'] ?? 0;
$most_sold = $_GET['ms'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  if ($latest_add and !$wishlist and !$most_sold) {
    echo json_encode(getElem('SELECT * FROM spaceships_detail_view ORDER BY product_updated_at DESC LIMIT 16'), JSON_PRETTY_PRINT);
  } else if ($wishlist and !$latest_add and !$most_sold) {
    echo "Wishlist";
  } else if ($most_sold and !$latest_add and !$wishlist) {
    echo "Most sold products";
  } else {
    http_response_code(400); // Bad request (invalid request)
    echo "Invalid request";
  }
} else {
  http_response_code(400); 
  echo "Invalid request";
}
