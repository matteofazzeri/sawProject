<?php

    include("./libs/functions.php");

    if(isLogged()){
        header("Location: Home.php");
        exit();
    }

    $username = $pass = $remember = "";
    $username_error = $password_error = "";
    session_start();
    
    //Controlla se il form è stato correttamente inviato
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $pass = $_POST["pass"];
        $remember = $_POST["remember"];
        $username_error = $password_error = "";

        if(empty($username)) {
            $username_error = "Username is required";
        }
        if(empty($pass)){
            $password_error = "Password is required";
        }

       require "./././server/api/connection/connect.inc.php";

        //Controlla che l'utente sia registrato
        if(empty($username_error) && empty($password_error)) {
            $select = "SELECT * FROM users WHERE username = '$username'";
            if(mysqli_num_rows(mysqli_query($con, $select)) == 0) {
                $username_error = "Looks like you're not registered yet.";
            } else {
                $query = "SELECT password FROM users WHERE username = '$username'";
                $result = mysqli_query($con, $query);
                if(!$result) {
                    die("Query error: " . mysqli_error($con));
                }
                $row = mysqli_fetch_assoc($result);
                $pass_db = $row["password"];
                echo password_verify($pass, $pass_db);
                if(password_verify($pass, $pass_db)) {
                    //Il login ha successo
                    $_SESSION["username"] = $username;
                    if($remember == "on") {
                        setcookie("username", $username, time() + (86400 * 30), "/");
                    }
                    header("Location: Home.php");
                    $con->close();
                    exit();
                } else {
                    //Il login fallisce, quindi mostro un messaggio di errore
                    $password_error = "Invalid username or password";
                    $con->close();
                }
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./style/form.css">
        <title>SAW: login</title>
    </head>
    <body>
        <?php
            if(!isset($_COOKIE["username"])) {
                echo '<form action="login.php" method="post">
                <fieldset>
                    <input type="text" name="username" placeholder="Username"><br><span class="error"><?php echo $username_error; ?></span><br>
                    <input type="password" name="password" placeholder="Password"><br><span class="error"><?php echo $password_error; ?></span><br>
                    <input type="checkbox" name="remember" value="1">Remember me<br>
                    <input type="submit" value="Login">
                </fieldset>
            </form>';
            } else {
                header("Location: Home.php");
            }
        ?>
    </body>
</html>