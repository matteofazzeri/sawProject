<?php
include __DIR__ . "/../connection/inc.php";

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

$requestURL = explode('/', $_SERVER['REQUEST_URI']);

$URL_lenght = $requestURL[count($requestURL) - 1];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require __DIR__ . "/addToCart.php";
} else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  require __DIR__ . "/getCartElem.php";
} else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
  require __DIR__ . "/put.php";
} else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
  require __DIR__ . "/deleteFromCart.php";
} else {
  echo "Invalid request";
}
