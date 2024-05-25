<?php

include __DIR__ . "/../connection/inc.php";

$eid =  $_GET['eid'];

echo json_encode(getElem("SELECT * FROM spaceships_detail_view WHERE product_id = :eid ", [
  'eid' => $eid,
]));
