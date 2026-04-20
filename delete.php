<?php 
include 'db.php';

$id = (int) $_GET['id'];

$db = DATA_BASE::getInstance();

// get user
$result = $db->select("users", "id=$id");
$user = $result->fetch_assoc();

if ($user) {

    // delete image 
    $imgPath = "./img/" . $user['img'];

    if (!empty($user['img']) && file_exists($imgPath)) {
        unlink($imgPath);
    }

    // delete user
    $db->delete("users", "id=$id");
}

header("Location: users_table.php");

?>