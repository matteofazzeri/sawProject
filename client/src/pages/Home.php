<?php
require __DIR__ . '/../libs/functions.php';


display('Head', false, [
    'title' => 'Home',
    'css' => ['generic', 'navbar', 'homepage', 'productCard'],
    'js' => ['Product', 'config']
]
);
display('Navbar');
display('Homepage', true);
display('Footer');

echo '<a href="Registration.php">Register</a>';