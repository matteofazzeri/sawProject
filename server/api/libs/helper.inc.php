<?php
include './connection/inc.php';

/* input checker */

function checkPwd($p, $cpass)
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

function nameCheck($data): bool
{
  if (preg_match("/^.\d.$/", $data)) {
    echo "why tf u have a number in your name man!";
  }
  return preg_match("/([a-zA-Z]+[àèéìòù]*\s+)+([a-zA-Z]+[àèéìòù]*\s*)/", $data);
}

function checkEmail($data): bool
{
  return preg_match("/^[a-zA-Z\d\.]+@[a-zA-Z\d]+\.[a-z]{2,3}$/", $data);
}

function checkUsername($data): bool
{
  return preg_match("/^[Ss][0-9]{7}$/", $data);
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

  if (!empty($res))  return true;
  return false;
}

function checkAll($firstname, $lastname, $email, $username, $pwd, $cpwd): bool
{
  return namecheck($firstname) and namecheck($lastname) and checkEmail($email) and checkUsername($username)
    and checkPwd($pwd, $cpwd) and !userExists($email || $username);
}

function isLogged(): bool
{
  if (isset($_SESSION["logged"])) {
    if ($_SESSION['logged'])
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
