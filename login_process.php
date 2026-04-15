<?php
session_start();
include 'db.php';

$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

$stmt = $conn->prepare("SELECT * FROM users WHERE address = ?");
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();
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