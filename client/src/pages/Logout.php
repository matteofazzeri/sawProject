<!DOCTYPE html>
<html lang="en">
    <head>
        <title>SAW: Logout</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
    </head>
    <body> 
        <?php
            session_start();
            session_unset();
            session_destroy();
            header("Location: Login.php");
            exit();
        ?>
    </body>
</html>

<?php
    display('Footer');