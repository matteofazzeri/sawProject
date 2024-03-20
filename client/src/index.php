<!doctype html>
<html lang="it">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="public/index.css">
  <link rel="stylesheet" href="src/style/navbar.css">
  <link rel="stylesheet" href="src/style/productCard.css">
  <link rel="stylesheet" href="src/style/homepage.css">
  <title>test</title>
</head>

<body>

  <?php
  //* access the url
  $fullUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

  define("ROOT", str_replace("\\", "/", __DIR__));
  define("BASE_URL", "http://localhost" . str_replace("/src", "", (explode("xampp/htdocs", ROOT)[1])));
  define("ROUTING_URL", strtolower(str_replace(BASE_URL, "", $fullUrl)));

  //* Routing the url  

  /* echo preg_match("#^/admin(/.+)?$#", ROUTING_URL); */
  if (preg_match("#^/admin.*$#", ROUTING_URL))
    require_once __DIR__ . "/pages/PrivateArea.php";
  else if (preg_match("#^/$#", ROUTING_URL))
    require_once __DIR__ . "/pages/Home.php";
  else if (preg_match("#^/search(\?.*)?$#", ROUTING_URL))
    require_once __DIR__ . "/pages/ShowItems.php";
  else if (preg_match("#^/about$#", ROUTING_URL))
    require_once __DIR__ . "/pages/About.php";
  else if (preg_match("#^/contact$#", ROUTING_URL))
    require_once __DIR__ . "/pages/Contact.php";
  else if (preg_match("#^/notfound$#", ROUTING_URL))
    require_once __DIR__ . "/pages/Error404.php";
  else if (preg_match("#^/repo$#", ROUTING_URL))
    header("Location: https://www.google.com");
  //else
  //header("Location:   " . BASE_URL . "/notfound");

  ?>

  <script src="https://cdn.tailwindcss.com"></script>

</body>

</html>