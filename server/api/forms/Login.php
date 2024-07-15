<?php


include __DIR__ . "/../libs/helper.inc.php";


//Controlla se il form è stato correttamente inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  $email = $_POST["email"];
  $pass = $_POST["pass"];
  $remember = $_POST["remember"] ?? false;

  $user = getElem("SELECT * FROM users WHERE email = :email", [
    'email' => $email,
  ]);

  if (empty($user)) {
    echo json_encode(["message" => "Looks like you're not registered yet."]);
    http_response_code(401);
    exit;
  }

  if (password_verify($pass, $user[0]['password_hash'])) {
    //Il login ha successo
    if (!isset($_SESSION["uuid"])) $_SESSION["uuid"] = id($email);


    //Genero un token di sessione
    $_SESSION["session_token"] = generateSessionToken();

    //Salvo il token di sessione nel database

    $result = insertValue("INSERT INTO sessions (session_token, user_id, expiration_date) VALUES (:token, :user_id, :expiration_date);", [
      'token' => $_SESSION["session_token"],
      'user_id' => $_SESSION["uuid"],
      'expiration_date' => $remember ? date('Y-m-d H:i:s', time() + 86400 * 30) : date('Y-m-d H:i:s', time() + 86400)
    ]);



    if ($remember) {
      setcookie("rmbme", $user[0]['session_token'], time() + (86400 * 30), "/");
    }



    echo json_encode(["message" => "Login successful"]);
    http_response_code(200);
    exit;
  } else {
    //Il login fallisce, quindi mostro un messaggio di errore
    echo json_encode(["message" => "Invalid email or password"]);
    http_response_code(401);
    exit;
  }
}
