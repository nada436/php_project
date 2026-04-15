<?php
include 'db.php';

$id = $_POST['id'] ?? null;
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$address = $_POST['address'];
$gender = $_POST['gender'];
$username = $_POST['username'];
$password = $_POST['password'];
$department = $_POST['department'];

// ─── form validation ──────────────────────────────────────
$errors = [];
 
if (empty($fname))
    $errors['fname'] = 'First name is required.';
elseif (!preg_match('/^[a-zA-Z\s]+$/', $fname))
    $errors['fname'] = 'First name must contain letters only.';
 
if (empty($lname))
    $errors['lname'] = 'Last name is required.';
elseif (!preg_match('/^[a-zA-Z\s]+$/', $lname))
    $errors['lname'] = 'Last name must contain letters only.';
 
if (empty($address))
    $errors['address'] = 'Address is required.';
 
if (empty($gender))
    $errors['gender'] = 'Gender is required.';
elseif (!in_array($gender, ['male', 'female']))
    $errors['gender'] = 'Invalid gender value.';
 
if (empty($username))
    $errors['username'] = 'Username is required.';
elseif (strlen($username) < 3)
    $errors['username'] = 'Username must be at least 3 characters.';
elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username))
    $errors['username'] = 'Username can only contain letters, numbers and underscores.';
 
if (empty($password) && !$id)
    $errors['password'] = 'Password is required.';
elseif (!empty($password) && strlen($password) < 6)
    $errors['password'] = 'Password must be at least 6 characters.';
 

if (count($errors) > 0) {
session_start();
$_SESSION['errors'] = $errors;
$_SESSION['userinfo'] = [
    'fname' => $fname,
    'lname' => $lname,
    'address' => $address,
    'gender' => $gender,
    'username' => $username,
    'password' => $password,
    'department' => $department,
    'skills' => $_POST['skills'] ?? []
];
header("Location: register.php?id=$id&error=1");
}
else{
    if ($id) {

    // get old img
    $result = $conn->query("SELECT img FROM users WHERE id=$id");
    $row = $result->fetch_assoc();
    $old_img = $row['img'];

    // check if a new image was uploaded
    if (!empty($_FILES['img']['name'])) {
        $img = $_FILES['img']['name'];

        // delete old img only if it exists
        if ($old_img && file_exists("./img/$old_img")) {
            unlink("./img/$old_img");
        }

        // save new img
        move_uploaded_file($_FILES['img']['tmp_name'], "./img/$img");
    } else {
        // no new image uploaded — keep the old one
        $img = $old_img;
    }

    // UPDATE user
    $sql = "UPDATE users SET 
        fname='$fname',
        lname='$lname',
        address='$address',
        gender='$gender',
        username='$username',
        password='$password',
        department='$department',
        img='$img'
        WHERE id=$id";

    $conn->query($sql);

    $user_id = $id;

    // delete old skills
    $conn->query("DELETE FROM user_skills WHERE user_id=$id");

} else {

    // new upload for create
    $img = $_FILES['img']['name'] ?? '';

    if ($img) {
        move_uploaded_file($_FILES['img']['tmp_name'], "./img/$img");
    }

    // CREATE user
    $sql = "INSERT INTO users (fname, lname, address, gender, username, password, department, img)
        VALUES ('$fname','$lname','$address','$gender','$username','$password','$department','$img')";

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

header("Location: users_table.php");}
?>







