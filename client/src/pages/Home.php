<?php
require __DIR__ . '/../libs/help_func.php';


display('Head', false, [
    'title' => 'Home',
    'css' => ['generic', 'homepage', 'productCard', 'navbar'],
    'js' => ['Product']
]
);
display('Navbar');
display('Homepage', true);
display('Footer');
