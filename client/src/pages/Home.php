<?php
require __DIR__ . '/../libs/help_func.php';


display('Head', false, [
    'title' => 'Home',
    'css' => ['generic', 'navbar', 'homepage', 'productCard'],
    'js' => ['Product', 'config']
]
);
display('Navbar');
display('Homepage', true);
display('Footer');
