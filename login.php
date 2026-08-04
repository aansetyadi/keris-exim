<?php

session_start();

require "config/database.php";

// hanya boleh POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: index.php");
    exit;
}

$username = trim($_POST['username']);
$password = trim($_POST['password']);

$sql = "SELECT username FROM app_user WHERE username = :username AND password = :password";

$stmt = $conn->prepare($sql);
$stmt->bindValue(":username", $username);
$stmt->bindValue(":password", $password);
$stmt->execute();

$user=$stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    $_SESSION["username"] = $user["username"];
    header("Location: dashboard.php");
    exit;
} else {
    header("Location: index.php?error=Username atau Password salah");
    exit;
}