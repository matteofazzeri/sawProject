<?php


display('Head', false, [
  'title' => 'Item Searched',
  'css' => ['generic', 'navbar', 'cart'],
  'js' => ['config', 'Loaders', 'cart', 'Product']
]);

display('Navbar');
display('Error404', true);
display('Footer');
