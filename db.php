<?php
$servername = "localhost";
$username = "pruser";
$password = "prpass";
$database = "prbg";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
} catch (Exception $e) {
    echo "Connection failed!";
}
