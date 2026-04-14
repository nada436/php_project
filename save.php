<?php
include 'db.php';

$id = $_POST['id'] ?? null;
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$address = $_POST['address'];
$gender = $_POST['gender'];
$username = $_POST['username'];
$password = $_POST['password'];
$department=$_POST['department'];
if ($id) {

    // UPDATE user
    $sql = "UPDATE users SET 
        fname='$fname',
        lname='$lname',
        address='$address',
        gender='$gender',
        username='$username',
        password='$password',
        department='$department'
        WHERE id=$id";

    $conn->query($sql);

    $user_id = $id;

    // delete old skills
    $conn->query("DELETE FROM user_skills WHERE user_id=$id");

} else {

    // CREATE user
    $sql = "INSERT INTO users (fname, lname, address, gender, username, password,department)
            VALUES ('$fname','$lname','$address','$gender','$username','$password','$department)";

    $conn->query($sql);

    $user_id = $conn->insert_id;
}

// insert new skills
if (!empty($_POST['skills'])) {
    foreach ($_POST['skills'] as $skill) {
        $conn->query("INSERT INTO user_skills (user_id, skill)
                      VALUES ($user_id, '$skill')");
    }
}

header("Location: users_table.php");
?>