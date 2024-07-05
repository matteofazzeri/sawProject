<?php
require __DIR__ . '/../libs/functions.php';

display('Head', false, [
    'title' => 'SAW: Profile',
    'css' => ['generic', 'navbar', 'forms'],
    'js' => ['config', 'Loaders', 'profile']
]);
display('Navbar');
    session_start();
    if(!isset($_SESSION["username"])) {
        header("Location: Login.php");
        exit();
    }
    echo '<h1>Welcome <?php echo "$_SESSION["username"]"</h1><br>';
?>
    <main>
    <div class="form">
    <p>Edit your profile</p>
        <!-- action="Profile.php" method="post" -->
        <form id="edit" class="edit">
            <fieldset>
                <label for="profile_photo">Choose a profile photo:</label>
                <input id="photo" type="file" name="profile_photo">
                <br><span id="err-photo" class="error">
                    Photo not available
                    <?php //echo $photo_error; ?></span><br>
                <label for="firstname">First name</label>
                <input id="firstname" type="text" name="firstname" placeholder="$firstname">
                <br><span id="err-firstname" class="error">
                    First name must contain only letters
                    <?php //echo $firstname_error; ?></span><br>
                <label for="lastname">Last name</label>
                <input id="lastname" type="text" name="lastname" placeholder="$lastname">
                <br><span id="err-lastname" class="error">
                    Last name must contain only letters
                    <?php //echo $lastname_error; ?></span><br>
                <label for="username">Username</label>
                <input id="username" type="text" name="username" placeholder="$username">
                <br><span id="err-username" class="error">
                    Username not available
                    <?php //echo $username_error; ?></span><br>
                <input type="submit" value="Change my information">
            </fieldset>
        </form>
    <br>
    <p>Change your password</p>
        <form id="edit-pwd" class="edit-pwd">
            <fieldset>
                <label for="password">Password</label>
                <input id="password" type="password" name="password" placeholder="New password">
                <br><span id="err-password" class="error">
                    Passwords must match    
                <?php //echo $password_error; ?></span><br>
                <label for="confirm">Confirm password</label>
                <input iD="confirm" type="password" name="confirm" placeholder="Confirm new password">
                <br><span id="err-confirm" class="error">
                    Passwords must match    
                <?php echo $confirm_password_error; ?></span><br>
                <input type="submit" value="Change my password">
            </fieldset>
        </form>
    <a href="Logout.php">Logout</a>
    </div>
</main>
</body>
</html>

<?php
    display('Footer');