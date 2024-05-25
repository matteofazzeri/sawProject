<?php
require __DIR__ . '/../libs/functions.php';

display('Head', false, [
    'title' => 'Item Searched',
    'css' => ['generic', 'productCard', 'searchPage', 'navbar'],
    'js' => ['Product', 'pagination', 'config', 'Loaders', 'cart']
]);
display('Navbar');
display('SearchPage', true);
display('Footer');
