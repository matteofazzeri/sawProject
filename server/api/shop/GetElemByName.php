<?php

include __DIR__ . "/../connection/inc.php";

$eid =  $_GET['eid'];



echo empty(getElem("SELECT id FROM products WHERE id = :eid", [
  'eid' => $eid,
])) ?  '0' :  '1';
