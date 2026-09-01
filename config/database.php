<?php

$host = "localhost";
$port = "6432"; // port online 6432
$dbname = "exim";
$user = "postgres";
$password = "root";

try {
    $conn = new PDO("pgsql:host=$host;port=$port;dbname=$dbname",$user,$password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal : " . $e->getMessage());
}