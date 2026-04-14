<?php 
include 'db.php';

$id = (int) $_GET['id'];

$sql = "DELETE FROM users WHERE id = $id";

if ($conn->query($sql)) {
    echo "User deleted successfully";
} else {
    echo "Error deleting user";
}
header("Location: users_table.php");
?>