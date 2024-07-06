<?php
include("./libs/helper.inc.php");
    if(!isLogged()) {
        header("Location: Login.php");
        exit();
    }

    $username = $_COOKIE["username"];
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($con, $query);
    if(!$result) {
        die("Query error: " . mysqli_error($con));
    }
    $row = mysqli_fetch_assoc($result);
    $userProfile = [
        "firstname" => $row["firstname"],
        "lastname" => $row["lastname"],
        "username" => $row["username"],
        "email" => $row["email"]
    ];

    $new_firstname = $new_lastname = $new_username = $new_password = $new_confirm_password = "";
    $firstname_error = $lastname_error = $username_error = $password_error = $confirm_password_error = "";

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if($_POST["new_firstname"] != $userProfile["firstname"]){
            $new_firstname = test_input($_POST["new_firstname"]);
            } else {
                if(!preg_match("/^[a-zA-Z ]*$/", $new_firstname)){
                    $firstname_error = "Only letters and white space allowed";
                }
            }
        if($_POST["new_lastname"] != $userProfile["lastname"]){
            $new_lastname = test_input($_POST["new_lastname"]);
            } else {
                if(!preg_match("/^[a-zA-Z ]*$/", $new_lastname)){
                    $lastname_error = "Only letters and white space allowed";
                }
            }
        if($_POST["new_username"] != $userProfile["username"]){
            $new_username = test_input($_POST["new_username"]);
            } else {
                if(!preg_match("/^[a-zA-Z0-9]*$/", $new_username)){
                    $username_error = "Invalid username format";
                }
            }
        if($_POST["new_password"] != ""){
            $new_password = test_input($_POST["new_password"]);
        }
        if($_POST["new_confirm_password"] != ""){
            $new_confirm_password = test_input($_POST["new_confirm_password"]);
            if($new_password != $new_confirm_password){
                $confirm_password_error = "Passwords don't match";
            }
        }
    }

    if($firstname_error == "" && $lastname_error == "" && $username_error == "" && $password_error == "" && $confirm_password_error == ""){
        $update = "UPDATE users SET firstname = '$new_firstname', lastname = '$new_lastname', username = '$new_username', password = '$new_password' WHERE username = '$username'";
        if(!mysqli_query($con, $update)){
            echo "Error: " . $update . "<br>" . mysqli_error($con);
            exit();
        }
        header("Location: Profile.php");
        exit();
    }
?>