<?php
include __DIR__ . "/../connection/inc.php";

/* input checker */

/* function checkPwd($p, $cpass)
{ */
//$lowercase = preg_match("/.*[a-zàèéìòù]+.*/", $p);
//$uppercase = preg_match("/.*[A-Z]+.*/", $p);
//$numbers = preg_match("/.*[0-9]+.*/", $p);
//$character = preg_match("/.*[!|£\$%&=?\^\+-\.,:;_|\*].*/", $p);
/* 
  if (strlen($p) < 8) {
    http_response_code(400);
    echo "Password must be at least 8 characters long.";
    exit;
  }
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
            http_response_code(400);
            echo "Passwords do not match.";
            exit;
          }
          return true;
        }
      }
    }
  }
  http_response_code(400);
  echo "Invalid password format.";
  exit;
} */

function checkPwd($p, $cpass)
{
  // Regex pattern to match allowed characters
  $pattern = '/^[0-9A-Za-z!@&%$*#]{8,}$/';

  // Check if password matches pattern
  if (preg_match($pattern, $p)) {
    // Check if passwords match
    if ($p !== $cpass) {
      http_response_code(400);
      echo "Passwords do not match.";
      exit;
    }
    return true;
  } else {
    http_response_code(400);
    echo "Password must be at least 8 characters long and can only contain the following characters: 0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz!@&%$*#";
    exit;
  }
}


function nameCheck($data): bool
{
  if (preg_match("/^(([a-zA-Z]+[àèéìòù]*\s+)+([a-zA-Z]+[àèéìòù]*\s*)|\b\d{4,}\b)$/", $data)) {
    return true;
  } else {
    http_response_code(400);
    echo "Invalid name format.";
    exit;
  }
}

function checkEmail($data): bool
{
  if (preg_match("/^[a-zA-Z\d](?:[a-zA-Z\d]|(?:[a-zA-Z\d]\.[a-zA-Z\d]))*[a-zA-Z\d]@[a-zA-Z\d]+(?:\.[a-zA-Z\d]+)*\.[a-zA-Z]{2,}$/", $data)) {
    return true;
  } else {
    http_response_code(400);
    echo "Invalid email format.";
    exit;
  }
}

function checkUsername($data): bool
{
  if (preg_match("/^[a-zA-Z0-9]*$/", $data) || empty($data) || $data == "") {
    return true;
  } else {
    http_response_code(400);
    echo "Invalid username format.";
    exit;
  }
}

function userExists($email): bool
{
  $res = getElem(
    "SELECT * FROM users WHERE email = :email OR username = :username;",
    [
      'email' => $email,
      'username' => $email
    ]
  );

  if (!empty($res)) {
    http_response_code(400);
    echo "User already exists.";
    exit;
  }
  return false;
}

function checkAll($fullname, $email, $username, $pwd, $cpwd): bool
{
  return namecheck($fullname) and checkEmail($email) and checkUsername($username)
    and checkPwd($pwd, $cpwd) and !userExists($email || $username);
}

function isLogged(): bool
{
  if (isset($_SESSION["uuid"])) {
    return true;
  }

  //! connect to the database and check if the user is registered
  $result = getElem(
    "SELECT keep_logged, expiration_date, user_id FROM sessions WHERE session_token = :token_cookie;",
    ['token_cookie' => $_COOKIE['rmbme'] ?? 'null']
  );

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
  $result = getElem(
    "SELECT is_admin FROM admin WHERE users_id = :id;",
    ['id' => $_SESSION['id'] ?? 'null']
  );

  // check if the user is logged

  if (!empty($result) && $result[0]['is_admin'] == 1) {
    $_SESSION['admin'] = true;
    return isAdmin();
  }
  return true;
}

function id($data): string
{
  $query = "SELECT id FROM users WHERE email = :email OR username = :username;";
  $data = ['email' => $data, 'username' => $data];
  $res = getElem($query, $data);

  if (!empty($res))  return $res[0]['id'];
  return 'Unknown';
}

function dbInfo($id, $toFind): string
{
  $query = "SELECT $toFind FROM users WHERE id = :id;";
  $data = ['id' => $id];
  $res = getElem($query, $data);

  if (!empty($res))  return $res[0][$toFind];
  return 'Unknown';
}
