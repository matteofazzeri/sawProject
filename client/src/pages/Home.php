<?php
require __DIR__ . '/../libs/functions.php';


display(
  'Head',
  false,
  [
    'title' => 'Home',
    'css' => ['generic', 'navbar', 'homepage', 'productCard'],
    'js' => ['Product', 'config', 'Loaders']
  ]
);

display('Navbar');
display('Homepage', true);
display('Footer');
