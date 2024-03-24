<?php
function display(string $filename, bool $template = false, array $data = []): void
{
  // create variables from the associative array
  foreach ($data as $key => $value)
    $$key = $value;

  $template ?
  require_once __DIR__ . '/../templates/' . $filename . '.php' : 
  require_once __DIR__ . '/../components/' . $filename . '.php';
}
