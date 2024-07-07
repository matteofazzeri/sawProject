<?php

//include("./libs/helper.inc.php");

/*
if (isLogged()) {
  header("Location: Home.php");
  exit();
}
  */

$email = $pass = $remember = "";
$email_error = $password_error = "";
session_start();

//Controlla se il form è stato correttamente inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $email = $_POST["email"];
  $pass = $_POST["pass"];
  $remember = $_POST["remember"];
  $email_error = $password_error = "";

  if (empty($email)) {
    $email_error = "Email is required";
  }
  if (empty($pass)) {
    $password_error = "Password is required";
  }

  include __DIR__ . "/../connection/inc.php";

  //Controlla che l'utente sia registrato
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
  }
}