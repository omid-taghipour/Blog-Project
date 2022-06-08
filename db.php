<?php
$servername = "localhost";
$username = "bloguser";
$password = "blogpass";
$database = "blog_db";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
} catch (Exception $e) {
    echo "Connection failed!";
}
