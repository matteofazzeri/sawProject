<?php

/* check if user is logged and has the autologin on */
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

function display(string $filename, bool $template = false, array $data = []): void
{
  // create variables from the associative array
  foreach ($data as $key => $value)
    $$key = $value;

  $template ?
  require_once __DIR__ . '/../templates/' . $filename . '.php' : 
  require_once __DIR__ . '/../components/' . $filename . '.php';
}


function randomString($lenght = 64): string
{
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $charactersLength = strlen($characters);
  $randomString = '';
  for ($i = 0; $i < $lenght; $i++) {
    $randomString .= $characters[rand(0, $charactersLength - 1)];
  }
  return $randomString;
}

function getAllElem($query_code, $data = [])
{
  require __DIR__ . '/../inc/db.inc.php';
  $result = [];
  try {
    $query = $query_code;
    $stmt = $pdo->prepare($query);

    foreach ($data as $key => $value)
      $stmt->bindParam(':' . $key, $value);

    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      array_push($result, $row);
    }

    $pdo = null;
    $stmt = null;

    return $result;
  } catch (PDOException $e) {
    die("Query failed: " . $e->getMessage() . '<br/>' . $query_code);
  }
}

function getElem($query_code, $data = [])
{
  require __DIR__ . '/../inc/db.inc.php';

  try {
    $query = $query_code;
    $stmt = $pdo->prepare($query);

    foreach ($data as $key => $value)
      $stmt->bindParam(':' . $key, $value);

    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $pdo = null;
    $stmt = null;

    return $result;
  } catch (PDOException $e) {
    die("Query failed: " . $e->getMessage() . '<br/>' . $query_code);
  }
}

function insertValue($query_code, $data = [])
{
  require __DIR__ . '/../inc/db.inc.php';

  try {
    $query = $query_code;
    $stmt = $pdo->prepare($query);

    foreach ($data as $key => &$value)
      $stmt->bindParam(':' . $key, $value);
    $stmt->execute();

    $pdo = null;
    $stmt = null;
  } catch (PDOException $e) {
    die("Query failed: " . $e->getMessage() . '<br/>' . $query_code);
  }
}