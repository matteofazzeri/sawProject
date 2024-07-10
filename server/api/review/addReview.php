<?php

// Read raw POST data
$postData = file_get_contents("php://input");

// Decode JSON data
$data = json_decode($postData, true);

if (!isset($data['title']) || !isset($data['stars'])) {
  
}
