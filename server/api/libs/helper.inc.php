<?php

function checkEmail($email)
{
  $regex_email = "/^[a-zA-Z\d\.]+@[a-zA-Z\d]+\.[a-z]{2,3}$/";

  if (!preg_match($regex_email, $email)) {
    echo "Invalid email address";
    return false;
  }

  return true;
}

function checkRegistrationPassword($p, $cpass)
{
  $lowercase = preg_match("/.*[a-zàèéìòù]+.*/", $p);
  $uppercase = preg_match("/.*[A-Z]+.*/", $p);
  $numbers = preg_match("/.*[0-9]+.*/", $p);
  $character = preg_match("/.*[!|£\$%&=?\^\+-\.,:;_|\*].*/", $p);

  if (strlen($p) < 8) return false;
  if ($lowercase || $uppercase || $numbers || $character) {
    if (
      ($lowercase && $uppercase) || ($lowercase && $numbers) || ($lowercase && $character) ||
      ($uppercase && $numbers) || ($uppercase && $character) || ($numbers) || ($character)
    ) {
      if (
        ($lowercase && $uppercase && $numbers) || ($lowercase && $uppercase && $character) ||
        ($lowercase && $numbers && $character) || ($uppercase && $numbers && $character)
      ) {
        if ($lowercase && $uppercase && $numbers && $character) {
          // se pass e cpass non sono uguali, impossible registrarsi nel sito
          if ($p != $cpass) {
            return false;
          }
          return true;
        }
      }
    }
  }
  return false;
}

function checkLoginPassword($password)
{
  $fp = fopen("libs/users.txt", "r");
  while ($line = fgets($fp)) {
    $data = explode("\t", $line);
    if (password_verify($password, trim($data[count($data) - 1])))
      return true;
  }
  return false;
}

function checkAll(): bool
{
  $args = func_get_args();
  foreach ($args as $arg) {
    if (empty($arg)) {
      echo "Error -> unable to register" . "<br/>";
      return false;
    }
  }
  return true;
}

function isLogged(): bool
{
  if (isset($_SESSION["logged"])) {
    if ($_SESSION['logged'])
      return true;
  }

  //! connect to the database and check if the user is registered

  if (!empty($result)) {
    /* check if the keep_logged flag is 1 (true) */
    if ($result[0]['keep_logged'] === 1) {
      /* check if is expired */
      if ($result[0]['expire_date'] > date('Y-m-d H:i:s', time())) {
        $_SESSION['logged'] = true;
        $_SESSION['uuid'] = $result[0]['users_id'];
        return isLogged();
      }
    }
  }
  return false;
}

// check if the user is an Admin
function isAdmin(): bool
{
  if (isLogged() && isset($_SESSION["admin"]) && $_SESSION['admin']) {
    return true;
  }

  //! connect to the database and check if the user is registered

  // check if the user is logged

  if (!empty($result) && $result[0]['is_admin'] == 1) {
    $_SESSION['admin'] = true;
    return isAdmin();
  }
  return true;
}
