<?php

include __DIR__ . "/../libs/helper.inc.php";

//Controlla se il form è stato correttamente inviato
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  echo json_encode(getElem("SELECT email, full_name, username FROM users WHERE id = :id", [
    'id' => $_SESSION['uuid']
  ]));
}
