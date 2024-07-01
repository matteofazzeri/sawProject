<?php

    include("./libs/functions.php");

    if(isLogged()) {
        header("Location: Home.php");
        exit();
    }

    $firstname = $lastname = $username = $password = $confirm_password = "";
    $firstname_error = $lastname_error = $username_error = $password_error = $confirm_password_error = $already_registered_error = "";

    //Controlla se il form è stato correttamente inviato
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //Validazione firstname
        if (empty($_POST["firstname"])) {
            $firstname_error = "First name is required";
        } else {
            $firstname = test_input($_POST["firstname"]);
            //Check con espressioni regolari
            if (!preg_match("/^[a-zA-Z ]*$/",$firstname)) {
                $firstname_error = "Only letters and white space allowed";
            }
        }

        //Validazione lastname
        if (empty($_POST["lastname"])) {
            $lastname_error = "Last name is required";
        } else {
            $lastname = test_input($_POST["lastname"]);
            //Check con espressioni regolari\
            if (!preg_match("/^[a-zA-Z ]*$/",$lastname)) {
                $lastname_error = "Only letters and white space allowed";
            }
        }

        //Validazione username
        if (empty($_POST["username"])) {
            $username_error = "username is required";
        } else {
            $username = test_input($_POST["username"]);
            //Check con un filtro
            if (!preg_match("/^[a-zA-Z0-9]*$/",$username)) {
                $username_error = "Invalid username format";
            }
        }

        //Validazione password
        if (empty($_POST["password"])) {
            $password_error = "Password is required";
        } else {
            $password = test_input($_POST["password"]);
        }

        //Validazione password di conferma
        if (empty($_POST["confirm_password"])) {
            $confirm_password_error = "Please confirm your password";
        } else {
            $confirm_password = test_input($_POST["confirm_password"]);
            //Controllo del match tra password
            if ($password != $confirm_password) {
                $confirm_password_error = "Passwords do not match";
            }
        }

        require "./././server/api/connection/connect.inc.php";

        if(!checkAll($firstname, $lastname, $username, $password, $confirm_password)) {
            echo "Error -> unable to register" . "<br/>";
            header("Location: Registration.php");
            die();
        }
        
        //Devo controllare se l'utente è già presente tra gli utenti registrati
        if(empty($username_error) && empty($password_error)) {
            $select = "SELECT * FROM users WHERE username = '$username'";
            if(mysqli_num_rows(mysqli_query($con, $select)) > 0) {
                $already_registered_error = "User already registered";
                echo $already_registered_error;
                $con->close();
                exit();
            }
        }

        //Salvare i dati dell'utente sul database
        if (empty($firstname_error) && empty($lastname_error) && empty($username_error) && empty($password_error) && empty($confirm_password_error)) {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $insert = "INSERT INTO users (firstname, lastname, username, password) VALUES ('$firstname', '$lastname', '$username', '$password')";
            if(!mysqli_query($con, $insert)) {
                echo "Error: " . $insert . "<br>" . mysqli_error($con);
                exit();
            }
        }
            //Redirezione
            header("Location: Home.php");
            exit();
        }
    

    //Funzione ausiliaria per la sanitizzazione dell'input
    function test_input($data) {
        $data = trim($data); //doppi nomi e cognomi?
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./src/style/forms.css">
        <title>SAW: sign up</title>
    </head>
    <body>
        <?php
            if(!isset($_COOKIE["username"])) {
                echo '<form action="Registration.php" method="post">
                    <fieldset>
                        <input type="text" name="firstname" placeholder="First name"><br><span class="error"><?php echo $firstname_error; ?></span><br>
                        <input type="text" name="lastname" placeholder="Last name"><br><span class="error"><?php echo $lastname_error; ?></span><br>
                        <input type="text" name="username" placeholder="Username"><br><span class="error"><?php echo $username_error; ?></span><br>
                        <input type="password" name="password" placeholder="Password"><br><span class="error"><?php echo $password_error; ?></span><br>
                        <input type="password" name="confirm" placeholder="Confirm password"><br><span class="error"><?php echo $confirm_password_error; ?></span><br>
                        <input type="submit" value="Sign up">
                    </fieldset>
                </form>';
            } else {
                header("Location: Home.php");
            }
        ?>
    </body>
</html>