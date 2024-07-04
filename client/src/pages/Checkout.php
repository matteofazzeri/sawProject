<?php
require __DIR__ . '/../libs/functions.php';
/* 
if (!isLogged()) {
  header('Location: login.php');
  exit;
} */

display('Head', false, [
    'title' => 'Checkout',
    'css' => ['generic', 'navbar', 'cart'],
    'js' => ['config', 'Loaders', 'cart', 'Product']
]);

display('Navbar');
display('Checkout', true);
display('Footer');
