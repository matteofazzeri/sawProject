<?php
function display(string $filename, array $data = []): void
{
  // create variables from the associative array
  /* foreach ($data as $key => $value) {
    $$key = $value;
  } */

  extract($data);

  require_once __DIR__ . '/../components/' . $filename . '.php';
}
