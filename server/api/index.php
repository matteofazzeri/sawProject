<?php
// process-data.php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");


$requestURL = $_SERVER['REQUEST_URI'];

if (strpos($requestURL, "forms")) {
  // TODO: send request to form.php file 
} else if (strpos($requestURL, "s")) {
  require __DIR__ . "/shop/Shop.php";
} else if (strpos($requestURL, "home")) {
  require __DIR__ . "";
} else if (strpos($requestURL, "users")) {
  // TODO: all the request for users data
} else {
  echo "wtf are u doing here?!";
  echo $requestURL;
}
