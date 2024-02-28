<?php

require __DIR__ . "/userController.php";

function isAdmin(): bool
{
  if (!isLogged())
    return true;

  if (isset($_SESSION["admin"]) && $_SESSION['admin']) {
    return true;
  }

  // check if the user is logged

  if (!empty($result) && $result[0]['is_admin'] == 1) {
    $_SESSION['admin'] = true;
    return isAdmin();
  }
  return true;
}
