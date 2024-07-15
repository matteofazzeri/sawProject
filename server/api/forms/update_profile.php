<?php

include __DIR__ . "/../libs/helper.inc.php";

//Controlla se il form è stato correttamente inviato
if ($_SERVER["REQUEST_METHOD"] == "GET") {
  echo json_encode(getElem("SELECT email, first_name, last_name, username FROM users WHERE id = :id", [
    'id' => $_SESSION["uuid"] ?? null
  ]));
} else if ($_SERVER["REQUEST_METHOD"] == "POST" or $_SERVER["REQUEST_METHOD"] == "PUT") {
  $data = json_decode(file_get_contents("php://input"), true);

  /* if (empty($data)) {
    $data = $_POST;
  } */

  if (!isset($data['email'], $data['firstname'], $data['lastname'])) {
    http_response_code(400); // Set the response code to 400 Bad Request
    echo json_encode(['error' => 'Missing required parameter']);
    exit;
  }

  if (!checkAll($data['firstname'] . " " . $data['lastname'], $data['email'], $data['username'] ?? "temp", "temp", "temp")) {
    http_response_code(400); // Set the response code to 400 Bad Request
    echo json_encode(['error' => 'Missing required parameter: regex not match']);
    exit;
  }

  $res = insertValue("UPDATE users SET email = :email, first_name = :first_name, last_name = :last_name, username = :username WHERE id = :id", [
    'email' => $data['email'],
    'first_name' => $data['firstname'],
    'last_name' => $data['lastname'],
    'username' => $data['username'] ?? null,
    'id' => $_SESSION["uuid"]
  ]);

  if (!$res) {
    http_response_code(500); // Set the response code to 500 Internal Server Error
    echo json_encode(['error' => 'Internal Server Error']);
  } else {
    http_response_code(200); // Set the response code to 200 OK
  }
} else {
  http_response_code(405); // Set the response code to 405 Method Not Allowed
  echo json_encode(['error' => 'Method Not Allowed']);
}
