<?php
require __DIR__ . '/../libs/help_func.php';

display('Head', false, [
    'title' => 'Item Searched',
    'css' => ['generic', 'productCard', 'searchPage', 'navbar'],
    'js' => ['Product']
]);
display('Navbar');
display('SearchPage', true);
display('Footer');
