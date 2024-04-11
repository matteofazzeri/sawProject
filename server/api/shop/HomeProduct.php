<?php
include __DIR__ . "/../connection/inc.php";
include __DIR__ . "/func.php";

$data = getElem("SELECT * FROM spaceships_detail_view");

$page = $_GET['page'] ?? 1;
$item_per_page = $_GET['nElem'] ?? 16;
$latest_added = $_GET['la'] ?? 0;
  

echo x($data, $page, $item_per_page);
