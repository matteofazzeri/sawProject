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

function checkAll() :bool
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