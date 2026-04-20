<?php
session_start();
require 'db.php';

$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');


$db = DATA_BASE::getInstance();
$result = $db->select("users","address='$email'");
$user = $result->fetch_assoc();

if ($user && $user['password'] === $password) {

    $_SESSION['user_id'] = $user['id'];
    $_SESSION['name'] = $user['fname'] . ' ' . $user['lname'];
    $_SESSION['email'] = $user['address'];

    header("Location: users_table.php");
    exit;

} else {
    header("Location: login.php?error=1");
    exit;
}
?>