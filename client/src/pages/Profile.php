<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
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