<?php
include 'db.php';

$id         = $_POST['id'] ?? null;
$fname      = $_POST['fname'] ?? '';
$lname      = $_POST['lname'] ?? '';
$address    = $_POST['address'] ?? '';
$gender     = $_POST['gender'] ?? '';
$username   = $_POST['username'] ?? '';
$password   = $_POST['password'] ?? '';
$department = $_POST['department'] ?? '';

// ─── form validation ──────────────────────────────────────
$errors = [];

// First Name — required, letters only, no numbers
if (empty($fname))
    $errors['fname'] = 'First name is required.';
elseif (preg_match('/\d/', $fname))
    $errors['fname'] = 'First name must not contain numbers.';
elseif (!preg_match('/^[a-zA-Z\s]+$/', $fname))
    $errors['fname'] = 'First name must contain letters only.';

// Last Name — required, letters only, no numbers
if (empty($lname))
    $errors['lname'] = 'Last name is required.';
elseif (preg_match('/\d/', $lname))
    $errors['lname'] = 'Last name must not contain numbers.';
elseif (!preg_match('/^[a-zA-Z\s]+$/', $lname))
    $errors['lname'] = 'Last name must contain letters only.';

// Address / Email — required
if (empty($address))
    $errors['address'] = 'Email address is required.';

// Gender — required
if (empty($gender))
    $errors['gender'] = 'Gender is required.';
elseif (!in_array($gender, ['male', 'female']))
    $errors['gender'] = 'Invalid gender value.';

// Skills — at least one required
if (empty($_POST['skills']))
    $errors['skills'] = 'Please select at least one skill.';

// Username — required
if (empty($username))
    $errors['username'] = 'Username is required.';
elseif (strlen($username) < 3)
    $errors['username'] = 'Username must be at least 3 characters.';
elseif (!preg_match('/^[a-zA-Z0-9_]+$/', $username))
    $errors['username'] = 'Username can only contain letters, numbers and underscores.';

// Password — required on create, optional on update
if (!$id && empty($password)) {
    $errors['password'] = 'Password is required.';
} elseif (!empty($password)) {
    if (strlen($password) !== 8)
        $errors['password'] = 'Password must be exactly 8 characters.';
    elseif (preg_match('/[A-Z]/', $password))
        $errors['password'] = 'Password must not contain uppercase letters.';
    elseif (!preg_match('/^[a-z0-9_]+$/', $password))
        $errors['password'] = 'Password may only contain lowercase letters, digits and underscore.';
}

// Image validation — type and size
if (!empty($_FILES['img']['name'])) {
    $allowed_types = ['image/jpeg', 'image/png'];
    $max_size      = 2 * 1024 * 1024; // 2 MB
    $file_type     = $_FILES['img']['type'];
    $file_size     = $_FILES['img']['size'];

    if (!in_array($file_type, $allowed_types)) {
        $errors['img'] = 'Only JPG and PNG images are allowed.';
    } elseif ($file_size > $max_size) {
        $errors['img'] = 'Image must be smaller than 2 MB.';
    }
}

// ─── validation failed ────────────────────────────────────
if (count($errors) > 0) {
    session_start();
    $_SESSION['errors']  = $errors;
    $_SESSION['userinfo'] = [
        'fname'      => $fname,
        'lname'      => $lname,
        'address'    => $address,
        'gender'     => $gender,
        'username'   => $username,
        'password'   => $password,
        'department' => $department,
        'skills'     => $_POST['skills'] ?? []
    ];
    header("Location: register.php?id=$id&error=1");
    exit;

// ─── no validation errors ─────────────────────────────────
} else {

    $db = DATA_BASE::getInstance();

    // ── UPDATE ──────────────────────────────────────────────
    if ($id) {

        // fetch old record to get existing image
        $result  = $db->select("users", "id=$id");
        $row     = $result->fetch_assoc();
        $old_img = $row['img'] ?? 'default.png';

        // handle image upload
        if (!empty($_FILES['img']['name'])) {
            $img = basename($_FILES['img']['name']);

            // delete old image only if it is not the default
            if ($old_img && $old_img !== 'default.png' && file_exists("./img/$old_img")) {
                unlink("./img/$old_img");
            }

            move_uploaded_file($_FILES['img']['tmp_name'], "./img/$img");
        } else {
            // keep old image, fall back to default if none stored
            $img = !empty($old_img) ? $old_img : 'default.png';
        }

        // build SET clause — keep old password if none supplied
        $password_set = !empty($password)
            ? "password='$password',"
            : "password='" . $row['password'] . "',";

        $set = "
            fname='$fname',
            lname='$lname',
            address='$address',
            gender='$gender',
            username='$username',
            $password_set
            department='$department',
            img='$img'
        ";

        $db->update('users', $set, "id=$id");
        $user_id = $id;

        // remove old skills before re-inserting
        $db->delete('user_skills', "user_id=$user_id");

    // ── INSERT ──────────────────────────────────────────────
    } else {

        // default image when none uploaded
        $img = 'default.png';

        if (!empty($_FILES['img']['name'])) {
            $img = basename($_FILES['img']['name']);
            move_uploaded_file($_FILES['img']['tmp_name'], "./img/$img");
        }

        $columns = "fname,lname,address,gender,username,password,department,img";
        $values  = "'$fname','$lname','$address','$gender','$username','$password','$department','$img'";
        $user_id = $db->insert('users', $columns, $values);
    }

    // ── INSERT SKILLS ────────────────────────────────────────
    if (!empty($_POST['skills'])) {
        foreach ($_POST['skills'] as $skill) {
            $skill = addslashes($skill);
            $db->insert(
                'user_skills',
                "user_id,skill",
                "$user_id,'$skill'"
            );
        }
    }

    header("Location: users_table.php");
    exit;
}
?>