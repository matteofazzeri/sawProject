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
    $_SESSION["uuid"] = id($email);
    if ($remember) {
      setcookie("email", $email, time() + (86400 * 30), "/");
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
