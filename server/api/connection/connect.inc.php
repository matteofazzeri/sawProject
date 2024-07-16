<?php
$serverName = "localhost";
$dbName = "S5163676";

$db = "mysql:host=$serverName;dbname=$dbName";
$userName = "S5163676";
$password = "G4l4ct1c.3mp1r3.F0r-S4w";

try {
    $pdo = new PDO($db, $userName, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}