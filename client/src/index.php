<?php

// Get the full URL
$fullUrl = "http://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";


// Define constants
define("ROOT", str_replace("\\", "/", __DIR__));
define("BASE_URL", "http://" . $_SERVER['HTTP_HOST'] . "/" . explode("/", $_SERVER['REQUEST_URI'])[1]);
define("ROUTING_URL", strtolower(str_replace(BASE_URL, "", $fullUrl)));


// Function to safely require pages
function requirePage($pagePath)
{
  $filePath = __DIR__ . $pagePath;

  if (file_exists($filePath)) {
    require_once $filePath;
  } else {
    header("HTTP/1.0 404 Not Found");
    require_once __DIR__ . "/pages/Error404.php";
  }
}

// Routing the URL
switch (true) {
  case preg_match("#^/admin.*$#", ROUTING_URL):
    requirePage("/pages/PrivateArea.php");
    break;
  case preg_match("#^/$#", ROUTING_URL):
    requirePage("/pages/Home.php");
    break;
  case preg_match("#^/search(\?.*)?$#", ROUTING_URL):
    requirePage("/pages/ShowItems.php");
    break;
  case preg_match("#^/cart(\?.*)?$#", ROUTING_URL):
    requirePage("/pages/Cart.php");
    break;
  case preg_match("#^/checkout(\?.*)?$#", ROUTING_URL):
    requirePage("/pages/Checkout.php");
    break;
  case preg_match("#^/about$#", ROUTING_URL):
    requirePage("/pages/About.php");
    break;
  case preg_match("#^/contact$#", ROUTING_URL):
    requirePage("/pages/Contact.php");
    break;
  case preg_match("#^/notfound$#", ROUTING_URL):
    requirePage("/pages/Error404.php");
    break;
  case preg_match("#^/login#", ROUTING_URL):
    requirePage("/pages/Login.php");
    break;
  case preg_match("#^/logout#", ROUTING_URL):
    requirePage("/pages/Logout.php");
    break;
  case preg_match("#^/registration#", ROUTING_URL):
    requirePage("/pages/Registration.php");
    break;
  case preg_match("#^/profile#", ROUTING_URL):
    requirePage("/pages/Profile.php");
    break;
  case preg_match("#^/private#", ROUTING_URL):
    requirePage("/pages/PrivateArea.php");
    break;
  case preg_match("#^/about#", ROUTING_URL):
    requirePage("/pages/About.php");
    break;
  case preg_match("#^/repo$#", ROUTING_URL):
    header("Location: https://github.com/matteofazzeri/sawProject");
    break;
  default:
    if (count(explode('/', ROUTING_URL)) > 2) {
      $parts = explode('/', ROUTING_URL);
      $entityId = $parts[1];
      $productName = $parts[2];
      $productName = strstr($productName, '?', true) ?: $productName;
      $uuid = $_SESSION['uuid'] ?? 1;

      $apiUrl = "http://localhost/sawProject/server/api/e?eid=" . $entityId . "&uuid=" . $uuid;
      $response = file_get_contents($apiUrl);

      

      if ($response !== false) {
        $productData = json_decode($response, true);
        if (
          isset($productData[0]['product_name']) &&
          str_replace("-", " ", strtolower($productData[0]['product_name'])) === str_replace("-", " ", strtolower($productName))
        ) {
          requirePage("/pages/ElementPage.php");
        } else {
          header("Location: " . BASE_URL . "/notfound");
        }
      } else {
        header("HTTP/1.0 404 Not Found");
        requirePage("/pages/Error404.php");
      }
    } else {
      header("Location: " . BASE_URL . "/notfound");
    }
    break;
}
