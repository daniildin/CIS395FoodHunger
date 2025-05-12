<?php
$host = 'localhost';
$db = 'food_deficit';
$user = 'root';
$pass = '';

$conn = new mysqli("localhost", "root", "", "foodapp");


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
