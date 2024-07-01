<?php
require __DIR__ . '/../libs/functions.php';

display('Head', false, [
    'title' => 'Item Searched',
    'css' => ['generic', 'navbar', 'cart'],
    'js' => ['config', 'Loaders', 'cart', 'Product']
]);

display('Navbar');
display('CartList', true);
display('Footer');
