<?php
include __DIR__ . "/../connection/inc.php";

header("Access-Control-Allow-Origin: *");

$requestURL = explode('/', $_SERVER['REQUEST_URI']);

$URL_lenght = $requestURL[count($requestURL) - 1];

$latest_add = $_GET['x'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  if ($latest_add) {
    echo json_encode(getElem('SELECT * FROM spaceships_detail_view ORDER BY product_updated_at DESC LIMIT 16'), JSON_PRETTY_PRINT);
  } else {
    http_response_code(400); // Bad request (invalid request)
    echo "Invalid request";
  }
} else {
  http_response_code(400);
  echo "Invalid request";
}
