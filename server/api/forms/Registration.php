<?php

include __DIR__ . "/../libs/helper.inc.php";

/* if (isLogged()) {
  header("Location: Home.php");
  exit();
} */

//Controlla se il form è stato correttamente inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Check if all POST elements are set
  if (!isset($_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['pass'], $_POST['confirm'])) {
    http_response_code(400); // Set the response code to 400 Bad Request
    echo json_encode(['error' => 'Missing required parameter']);
    exit;
  }

  if (!checkAll($_POST['firstname'] . " " . $_POST['lastname'], $_POST['email'], $_POST['username'] ?? "", $_POST['pass'], $_POST['confirm'])) {
    echo "Error -> unable to register" . "<br/>";

    http_response_code(400); // Set the response code to 400 Bad Request
    echo json_encode(['error' => 'Missing required parameter: regex not match']);

    die;
  }

  if (insertValue("INSERT INTO users (username, email, password_hash, full_name ) VALUES (:username, :email, :password, :name)", [
    'username' => test_input($_POST['username'] ?? $_POST['email']),
    'email' => test_input($_POST['email']),
    'password' => password_hash($_POST['pass'], PASSWORD_BCRYPT),
    'name' => test_input($_POST['firstname'] . " " . $_POST['lastname'])
  ])) {
    http_response_code(200); // Set the response code to 200 OK
    echo json_encode(['message' => 'Registration successful']);
  } else {
    http_response_code(500); // Set the response code to 500 Internal Server Error
    echo json_encode(['error' => 'Failed to register user']);
  }

  //Appena registrato sei loggato
  $uuid = insertValue("INSERT INTO users (username, email, password_hash, full_name ) VALUES (:username, :email, :password, :name)", [
    'username' => test_input($_POST['username']),
    'email' => test_input($_POST['email']),
    'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
    'name' => test_input($_POST['firstname'] . " " . $_POST['lastname'])
  ], true);

  if (!$uuid) {
    http_response_code(500); // Set the response code to 500 Internal Server Error
    echo json_encode(['error' => 'Failed to register user']);
  } else {
    http_response_code(200); // Set the response code to 200 OK
    echo json_encode(['uuid' => $uuid]);
  }

  exit;
}


//Funzione ausiliaria per la sanitizzazione dell'input
function test_input($data = "")
{
  $data = trim($data); //doppi nomi e cognomi?
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
