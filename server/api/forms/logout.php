<?php

session_unset();
session_destroy();

echo json_encode(["message" => "Logout successful"]);
http_response_code(200);
exit;
