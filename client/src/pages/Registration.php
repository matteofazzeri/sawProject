<?php
require __DIR__ . '/../libs/functions.php';

display('Head', false, [
  'title' => 'SAW: Registration',
  'css' => ['generic', 'navbar', 'forms'],
  'js' => ['config', 'Loaders', 'Product', 'registration']
]);
display('Navbar');
if (!isset($_COOKIE["email"])) : ?>
  <main>
    <div class="form">
      <h1>SAW: Sign up</h1><br>
      <p>Already have an account? <a class="linkform" href="Login.php">Login now!</a></p><br>
      <!-- action="Registration.php" method="post" -->
      <form id="registration" class="registration">
        <fieldset>
          <label for="firstname">First name*</label>
          <input id="firstname" type="text" name="firstname" placeholder="First name">
          <br><span id="err-firstname" class="error">
            Firstname not valid
            <?php //echo $firstname_error; 
            ?></span><br>
          <label for="lastname">Last name*</label>
          <input id="lastname" type="text" name="lastname" placeholder="Last name">
          <br><span id="err-lastname" class="error">
            Lastname not valid
            <?php //echo $lastname_error; 
            ?></span><br>
          <label for="email">Email*</label>
          <input id="email" type="email" name="email" placeholder="Email">
          <br><span id="err-email" class="error">
            Username not valid or available
            <?php //echo $email_error; 
            ?></span><br>
          <label for="username">Username</label>
          <input id="username" type="text" name="username" placeholder="Username">
          <br><span id="err-username" class="error">
            Username not valid or available
            <?php //echo $username_error; 
            ?></span><br>
          <label for="password">Password*</label>
          <input id="password" type="password" name="password" placeholder="Password">
          <br><span id="err-password" class="error">
            Password not valid
            <?php //echo $password_error; 
            ?></span><br>
          <label for="confirm">Confirm password*</label>
          <input id="confirm" type="password" name="confirm" placeholder="Confirm password">
          <br><span id="err-confirm" class="error">
            Confirm password not valid
            <?php //echo $confirm_password_error; 
            ?></span><br>
            <div class="password-info">Password must contain at least 8 characters, including UPPER/lowercase, numbers and special characters.</div><br>
          <p class="required">* = Required fields</p>
          <input type="submit" value="Sign up">
        </fieldset>
      </form>
    </div>
  <?php else :
  header("Location: Home.php");

endif;
  ?>
  </main>

  <?php
  display('Footer');
