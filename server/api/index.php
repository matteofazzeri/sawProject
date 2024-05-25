<?php
// process-data.php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");


$requestURL = $_SERVER['REQUEST_URI'];

$base_url = "/sawProject/server/api/";

$requestURL = str_replace($base_url, "", $requestURL);

if (strpos($requestURL, "forms")) {
  // TODO: send request to form.php file 
} else if ($requestURL[0] == "s") {
  require __DIR__ . "/shop/Shop.php";
} else if ($requestURL[0] == "h") {
  require __DIR__ . "/home/home.php";
} else if (strpos($requestURL, "users")) {
  // TODO: all the request for users data
} else if ($requestURL[0] == "e") {
  require __DIR__ . "/shop/GetElem.php";
} else if ($requestURL[0] == "c") {
  require __DIR__ . "/cart/Cart.php";
}
else {

  echo "wtf are u doing here?!";
  echo $requestURL;
}
