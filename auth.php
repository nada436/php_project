<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
else{
echo "<p>welcome back " . $_SESSION['name'] . "</p>";
}