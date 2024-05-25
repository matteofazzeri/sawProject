<?php

include __DIR__ . "/../connection/inc.php";

$uuid = $_GET['uuid'];

$data = getElem("SELECT * FROM shopping_cart WHERE user_id = :uuid", [
  'uuid' => $uuid,
]);

