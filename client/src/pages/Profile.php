<?php
    include("./libs/functions.php");
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

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./style/form.css">
        <title>SAW: profile</title>
    </head>
    <body>
        <?php
            session_start();
            if(!isset($_SESSION["username"])) {
                header("Location: Login.php");
                exit();
            }
            echo "Welcome " . $_SESSION["username"];
        ?>
        <br>
        <p>Edit your profile</p>
            <form>
                <fieldset>
                    <label for="profile_photo">Choose a profile photo:</label>
                    <input type="file" name="profile_photo"><br> 
                    <input type="text" name="firstname" placeholder="$firstname"><br><span class="error"><?php echo $firstname_error; ?></span><br>
                    <input type="text" name="lastname" placeholder="$lastname"><br><span class="error"><?php echo $lastname_error; ?></span><br>
                    <input type="text" name="username" placeholder="$username"><br><span class="error"><?php echo $username_error; ?></span><br>
                    <input type="submit" value="Change my information">
                </fieldset>
            </form>
        <br>
        <p>Change your password</p>
            <form>
                <fieldset>
                    <input type="password" name="password" placeholder="New password"><br><span class="error"><?php echo $password_error; ?></span><br>
                    <input type="password" name="confirm" placeholder="Confirm new password"><br><span class="error"><?php echo $confirm_password_error; ?></span><br>
                    <input type="submit" value="Change my password">
                </fieldset>
            </form>
        <a href="Logout.php">Logout</a>
    </body>
</html>

<?php
    display('Footer');