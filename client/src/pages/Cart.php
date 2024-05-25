<?php
require __DIR__ . '/../libs/functions.php';

display('Head', false, [
    'title' => 'Item Searched',
    'css' => ['generic', 'navbar'],
    'js' => ['config', 'Loaders', 'cart']
]);

display('Navbar');
display('CartList', true);
display('Footer');
