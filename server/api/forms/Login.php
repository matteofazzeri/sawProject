<?php


include __DIR__ . "/../libs/helper.inc.php";

/*
if (isLogged()) {
  header("Location: Home.php");
  exit();
}
  */

/* $email = $pass = $remember = "";
$email_error = $password_error = "";
session_start(); */

//Controlla se il form è stato correttamente inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Read raw POST data
  $postData = file_get_contents("php://input");
  // Decode JSON data
  $bodyMessage = json_decode($postData, true);

  $email = $bodyMessage["email"];
  $pass = $bodyMessage["password"];
  $remember = $bodyMessage["remember"];

  /* //Controlla che l'utente sia registrato
  if (empty($email_error) && empty($password_error)) {
    $select = "SELECT * FROM users WHERE email = '$email'";
    if (mysqli_num_rows(mysqli_query($con, $select)) == 0) {
      $email_error = "Looks like you're not registered yet.";
    } else {
      $query = "SELECT password FROM users WHERE email = '$email'";
      $result = mysqli_query($con, $query);
      if (!$result) {
        die("Query error: " . mysqli_error($con));
      }
      $row = mysqli_fetch_assoc($result);
      $pass_db = $row["password"];
      echo password_verify($pass, $pass_db);
      if (password_verify($pass, $pass_db)) {
        //Il login ha successo
        $_SESSION["email"] = $email;
        if ($remember == "on") {
          setcookie("email", $email, time() + (86400 * 30), "/");
        }
        header("Location: Home.php");
        $con->close();
        exit();
      } else {
        //Il login fallisce, quindi mostro un messaggio di errore
        $password_error = "Invalid email or password";
        $con->close();
      }
    }
  } */

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
    session_start();
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
