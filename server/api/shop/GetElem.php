<?php

include __DIR__ . "/../connection/inc.php";

$eid =  $_GET['eid'];

echo json_encode(getElem(
  "SELECT sdv.*, COALESCE(sc.quantity, 1) AS quantity
    FROM spaceships_detail_view sdv
    LEFT JOIN shopping_cart sc 
    ON sdv.product_id = sc.product_id AND sc.user_id = :uuid
    WHERE sdv.product_id LIKE :eid",
  [
    'eid' => $eid,
    'uuid' => $_SESSION['uuid'] ?? null
  ]
));
