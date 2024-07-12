<?php


display('Head', false, [
    'title' => 'Item Searched',
    'css' => ['generic', 'navbar', 'productPage', 'review'],
    'js' => ['Product', 'config', 'Loaders', 'cart', 'review']
]);

display('Navbar');
display('ElementInfo', true);
display('Footer');
