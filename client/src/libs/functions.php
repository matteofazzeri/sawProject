<?php

/* check if user is logged and has the autologin on */
/* function isLogged(): bool
{
  if (isset($_SESSION["logged"])) {
    if ($_SESSION['logged'])
      return true;
  }

  //! connect to the database and check if the user is registered

  if (!empty($result)) { */
    /* check if the keep_logged flag is 1 (true) */
    /* if ($result[0]['keep_logged'] === 1) { */
      /* check if is expired */
      /* if ($result[0]['expire_date'] > date('Y-m-d H:i:s', time())) {
        $_SESSION['logged'] = true;
        $_SESSION['uuid'] = $result[0]['users_id'];
        return isLogged();
      }
    }
  }
  return false;
} */

// check if the user is an Admin
/* function isAdmin(): bool
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
} */

function display(string $filename, bool $template = false, array $data = []): void
{
  // create variables from the associative array
  foreach ($data as $key => $value)
    $$key = $value;

  $template ?
    require_once __DIR__ . '/../templates/' . $filename . '.php' :
    require_once __DIR__ . '/../components/' . $filename . '.php';
}


function reRoute(string $apiUrl): void
{
  // Initialize cURL session
  $ch = curl_init($apiUrl);

  // Pass through all POST fields
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($_POST));

  // Set options to return the response and include headers
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HEADER, true);

  // File to store cookies (make sure this path is correct and writable)
  $cookieFile = "cookies";
  curl_setopt($ch, CURLOPT_COOKIEFILE, $cookieFile); // Read cookies
  curl_setopt($ch, CURLOPT_COOKIEJAR, $cookieFile); // Write cookies

  // Execute cURL session
  $response = curl_exec($ch);

  // Get HTTP response code
  $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

  // Separate headers and body
  $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
  $header = substr($response, 0, $headerSize);
  $body = substr($response, $headerSize);

  // Close cURL session
  curl_close($ch);

  // Send the response received from the backend to the client
  http_response_code($httpCode);
  echo $body;
}
