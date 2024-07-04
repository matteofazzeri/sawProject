<?php
require __DIR__ . '/../libs/functions.php';


display('Head', false, [
  'title' => 'SAW: Login',
  'css' => ['generic', 'navbar', 'forms'],
  'js' => ['config', 'Loaders', 'cart', 'Product', 'login']
]);
display('Navbar');
if (!isset($_COOKIE["username"])) : ?>
  <main>
    <div class="form">
      <h1>SAW: Login</h1><br>
      <p>New to SAW? <a href="Registration.php">Sign up now!</a></p><br>
      <!-- action="Login.php" method="post" -->
      <form id="login" class="login">
        <fieldset>
          <input id="username" type="text" name="username" placeholder="Username">
          <br><span id="err-username" class="error">
            Username not correct
            <?php //echo $username_error; 
            ?></span><br>
          <input id="password" type="password" name="password" placeholder="Password">
          <br><span id="err-pwd" class="error">
            Password not correct
            <?php //echo $password_error; 
            ?></span><br>
          <input id="remember" type="checkbox" name="remember" value="1">Remember me<br>
          <input type="submit" value="Login">
        </fieldset>
      </form>
    </div>

  <?php else :
  header("Location: Home.php");

endif;
  ?>
  </main>


  </body>

  </html>

  <?php
  display('Footer');
