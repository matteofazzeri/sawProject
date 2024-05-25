<?php
require __DIR__ . '/../libs/functions.php';

display('Head', false, [
    'title' => 'Item Searched',
    'css' => ['generic', 'navbar', 'productPage'],
    'js' => ['Product', 'config', 'Loaders', 'cart']
]);

display('Navbar');
display('ElementInfo', true);
display('Footer');
