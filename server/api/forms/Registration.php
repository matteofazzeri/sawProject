<?php

include("./libs/helper.inc.php");

/* if (isLogged()) {
  header("Location: Home.php");
  exit();
} */



//Controlla se il form è stato correttamente inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Read raw POST data
  $postData = file_get_contents("php://input");
  // Decode JSON data
  $bodyMessage = json_decode($postData, true);


  /* //Validazione firstname
  if (empty($bodyMessage["firstname"])) {
    // $firstname_error = "First name is required";

    http_response_code(400); // Set the response code to 400 Bad Request
    echo json_encode(['error' => 'Missing required parameter: required_parameter']);
    exit;
  } else {
    $firstname = test_input($bodyMessage["firstname"]);
    //Check con espressioni regolari
    if (!preg_match("/^[a-zA-Z ]*$/", $firstname)) {
      $firstname_error = "Only letters and white space allowed";
    }
  }

  //Validazione lastname
  if (empty($bodyMessage["lastname"])) {
    // $lastname_error = "Last name is required";

    http_response_code(400); // Set the response code to 400 Bad Request
    echo json_encode(['error' => 'Missing required parameter: required_parameter']);
    exit;
  } else {
    $lastname = test_input($bodyMessage["lastname"]);
    //Check con espressioni regolari\
    if (!preg_match("/^[a-zA-Z ]*$/", $lastname)) {
      $lastname_error = "Only letters and white space allowed";
    }
  }

  //Validazione email
  if (empty($bodyMessage["email"])) {
    // $email_error = "Email is required";

    http_response_code(400); // Set the response code to 400 Bad Request
    echo json_encode(['error' => 'Missing required parameter: required_parameter']);
    exit;
  } else {
    $email = test_input($bodyMessage["email"]);
    //Check con un filtro
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $email_error = "Invalid email format";
    }
  }

  $username = test_input($bodyMessage["username"]);
  //Check con un filtro
  if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
    $username_error = "Invalid username format";
  }
  //}

  //Validazione password
  if (empty($bodyMessage["password"])) {
    // $password_error = "Password is required";

    http_response_code(400); // Set the response code to 400 Bad Request
    echo json_encode(['error' => 'Missing required parameter: required_parameter']);
    exit;
  } else {
    $password = test_input($bodyMessage["password"]);
  }

  //Validazione password di conferma
  if (empty($bodyMessage["confirm"])) {
    // $confirm_error = "Please confirm your password";

    http_response_code(400); // Set the response code to 400 Bad Request
    echo json_encode(['error' => 'Missing required parameter: required_parameter']);
    exit;
  } else {
    $confirm = test_input($bodyMessage["confirm"]);
    //Controllo del match tra password
    if ($password != $confirm) {
      $confirm_error = "Passwords do not match";
    }
  } */

  if (!checkAll($bodyMessage['firstname'] . " " . $bodyMessage['lastname'], $bodyMessage['email'], $bodyMessage['username'], $bodyMessage['password'], $bodyMessage['confirm'])) {
    echo "Error -> unable to register" . "<br/>";

    http_response_code(400); // Set the response code to 400 Bad Request
    echo json_encode(['error' => 'Missing required parameter: regex not match']);

    die;
  }

  //Devo controllare se l'utente è già presente tra gli utenti registrati

  // ! lo fa già la checkAll
  /* if (empty($username_error) && empty($password_error)) {
    $select = "SELECT * FROM users WHERE username = '$username'";
    if (mysqli_num_rows(mysqli_query($con, $select)) > 0) {
      $already_registered_error = "User already registered";
      echo $already_registered_error;
      $con->close();
      exit;
    }
  } */

  //Salvare i dati dell'utente sul database
  /* if (empty($firstname_error) && empty($lastname_error) && empty($email_error) && empty($username_error) && empty($password_error) && empty($confirm_error)) {
    $password = password_hash($password, PASSWORD_DEFAULT);
    $insert = "INSERT INTO users (firstname, lastname, email, username, password) VALUES ('$firstname', '$lastname', '$email', '$username', '$password')";


    if (!mysqli_query($con, $insert)) {
      http_response_code(403);
      echo json_encode(['error' => 'Missing required parameter: regex not match']);

      echo "Error: " . $insert . "<br>" . mysqli_error($con);
      exit();
    }
  } */

  if (insertValue("INSERT INTO users (username, email, password_hash, full_name ) VALUES (:username, :email, :password, :name)", [
    'username' => test_input($bodyMessage['username']),
    'email' => test_input($bodyMessage['email']),
    'password' => password_hash($bodyMessage['password'], PASSWORD_BCRYPT),
    'name' => test_input($bodyMessage['firstname'] . " " . $bodyMessage['lastname'])
  ])) {
    http_response_code(200); // Set the response code to 200 OK
    echo json_encode(['message' => 'Registration successful']);
  } else {
    http_response_code(500); // Set the response code to 500 Internal Server Error
    echo json_encode(['error' => 'Failed to register user']);
  }

  /*
  ! IN CASE VOLESSIMO FARE CHE UNA VOLTA REGISTRATO SEI ANCHE LOGGATO:
  $uuid = insertValue("INSERT INTO users (username, email, password_hash, full_name ) VALUES (:username, :email, :password, :name)", [
    'username' => test_input($bodyMessage['username']),
    'email' => test_input($bodyMessage['email']),
    'password' => password_hash($bodyMessage['password'], PASSWORD_BCRYPT),
    'name' => test_input($bodyMessage['firstname'] . " " . $bodyMessage['lastname'])
  ], true);

  if (!$uuid) {
    http_response_code(500); // Set the response code to 500 Internal Server Error
    echo json_encode(['error' => 'Failed to register user']);
  } else {
    http_response_code(200); // Set the response code to 200 OK
    echo json_encode(['uuid' => $uuid]);
  }
  */

  exit();
}


//Funzione ausiliaria per la sanitizzazione dell'input
function test_input($data)
{
  $data = trim($data); //doppi nomi e cognomi?
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
