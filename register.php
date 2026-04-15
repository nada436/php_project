<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<?php 
 include 'auth.php';
?>
<body class="min-h-screen bg-gradient-to-br from-purple-100 via-pink-50 to-blue-100 flex items-center justify-center py-10 px-4">

    <?php
    include 'db.php';

    $user = [
        'fname' => '',
        'lname' => '',
        'address' => '',
        'gender' => '',
        'username' => '',
        'password' => '',
        'img'=>'',
        'department' => 'open source'
    ];
    $skills = [];
    $id = $_GET['id'] ?? null;

    if ($id) {
        $sql = "SELECT * FROM users WHERE id = $id";
        $result = $conn->query($sql);
        $user = $result->fetch_assoc();
        $result = $conn->query("SELECT skill FROM user_skills WHERE user_id=$id");
        while ($row = $result->fetch_assoc()) {
            $skills[] = $row['skill'];
        }
    }

if (isset($_GET['error'])) {
    $errors = $_SESSION['errors'] ?? [];
    $user = $_SESSION['userinfo'];
    unset($_SESSION['errors']);
    $skills=$user['skills'];
}
    ?>

    <div class="w-full max-w-xl">

        <div class="flex justify-end mb-4">
            <a href="users_table.php" class="text-sm text-purple-600 hover:text-purple-800 font-medium bg-white px-4 py-2 rounded-full shadow-sm hover:shadow transition-all">
                View All Users →
            </a>
        </div>

        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl shadow-purple-100 p-8">

            <h2 class="text-2xl font-bold text-gray-700 mb-6"><?= $id ? 'Edit Employee' : 'Register Employee' ?></h2>

            <form action="save.php" method="post"  enctype="multipart/form-data" id="myForm" class="space-y-5" >

                <input  type="hidden" name="id" value="<?= $id ?>" >

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">First Name</label>
                    <input class="w-full px-4 py-2 rounded-xl border border-gray-200 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-300 focus:border-transparent text-sm transition" name="fname" id="fname" value="<?= htmlspecialchars($user['fname']) ?>" placeholder="Enter first name">
                    <p class="text-red-500 text-xs mt-1 hidden" id="fname-error">
                    <?php if (!empty($errors['fname'])): echo $errors['fname']; endif; ?>
                    </p>
                    <?php if (!empty($errors['fname'])): ?>
                    <script>document.addEventListener('DOMContentLoaded',function(){document.getElementById('fname-error').classList.remove('hidden');});</script>
                    <?php endif; ?>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Last Name</label>
                    <input class="w-full px-4 py-2 rounded-xl border border-gray-200 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-300 focus:border-transparent text-sm transition" name="lname" id="lname" value="<?= htmlspecialchars($user['lname']) ?>" placeholder="Enter last name">
                    <p class="text-red-500 text-xs mt-1 hidden" id="lname-error">
                    <?php if (!empty($errors['lname'])): echo $errors['lname']; endif; ?>
                    </p>
                    <?php if (!empty($errors['lname'])): ?>
                    <script>document.addEventListener('DOMContentLoaded',function(){document.getElementById('lname-error').classList.remove('hidden');});</script>
                    <?php endif; ?>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">email Address</label>
                    <input class="w-full px-4 py-2 rounded-xl border border-gray-200 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-300 focus:border-transparent text-sm transition" name="address" id="address" value="<?= htmlspecialchars($user['address']) ?>" placeholder="Enter email address">
                    <p class="text-red-500 text-xs mt-1 hidden" id="address-error">
                    <?php if (!empty($errors['address'])): echo $errors['address']; endif; ?>
                    </p>
                    <?php if (!empty($errors['address'])): ?>
                    <script>document.addEventListener('DOMContentLoaded',function(){document.getElementById('address-error').classList.remove('hidden');});</script>
                    <?php endif; ?>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Gender</label>
                    <div class="flex gap-6">
                        <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                            <input type="radio" name="gender" value="male" <?= $user['gender'] == 'male' ? 'checked' : '' ?> class="accent-purple-500">
                            Male
                        </label>
                        <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                            <input type="radio" name="gender" value="female" id="female" <?= $user['gender'] == 'female' ? 'checked' : '' ?> class="accent-purple-500">
                            Female
                        </label>
                    </div>
                    <p class="text-red-500 text-xs mt-1 hidden" id="gender-error">
                    <?php if (!empty($errors['gender'])): echo $errors['gender']; endif; ?>
                    </p>
                    <?php if (!empty($errors['gender'])): ?>
                    <script>document.addEventListener('DOMContentLoaded',function(){document.getElementById('gender-error').classList.remove('hidden');});</script>
                    <?php endif; ?>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Courses</label>
                    <div class="flex flex-wrap gap-4">
                        <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                            <input type="checkbox" name="skills[]" value="php" <?= in_array("php", $skills) ? "checked" : "" ?> class="accent-purple-500 skill-checkbox">
                            PHP
                        </label>
                        <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                            <input type="checkbox" name="skills[]" value="j2se" <?= in_array("j2se", $skills) ? "checked" : "" ?> class="accent-purple-500 skill-checkbox">
                            J2SE
                        </label>
                        <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                            <input type="checkbox" name="skills[]" value="mysql" <?= in_array("mysql", $skills) ? "checked" : "" ?> class="accent-purple-500 skill-checkbox">
                            MySQL
                        </label>
                        <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                            <input type="checkbox" name="skills[]" value="postgresql" <?= in_array("postgresql", $skills) ? "checked" : "" ?> class="accent-purple-500 skill-checkbox">
                            PostgreSQL
                        </label>
                    </div>
                    <p class="text-red-500 text-xs mt-1 hidden" id="skills-error">
                    <?php if (!empty($errors['skills'])): echo $errors['skills']; endif; ?>
                    </p>
                    <?php if (!empty($errors['skills'])): ?>
                    <script>document.addEventListener('DOMContentLoaded',function(){document.getElementById('skills-error').classList.remove('hidden');});</script>
                    <?php endif; ?>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Username</label>
                    <input class="w-full px-4 py-2 rounded-xl border border-gray-200 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-300 focus:border-transparent text-sm transition" name="username" id="username" value="<?= htmlspecialchars($user['username']) ?>" placeholder="Enter username">
                    <p class="text-red-500 text-xs mt-1 hidden" id="username-error">
                    <?php if (!empty($errors['username'])): echo $errors['username']; endif; ?>
                    </p>
                    <?php if (!empty($errors['username'])): ?>
                    <script>document.addEventListener('DOMContentLoaded',function(){document.getElementById('username-error').classList.remove('hidden');});</script>
                    <?php endif; ?>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Password</label>
                    <input type="password" class="w-full px-4 py-2 rounded-xl border border-gray-200 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-300 focus:border-transparent text-sm transition" name="password" id="password" value="<?= htmlspecialchars($user['password']) ?>" placeholder="Enter password">
                    <p class="text-xs text-gray-400 mt-1">Exactly 8 characters, lowercase letters, digits and underscore only.</p>
                    <p class="text-red-500 text-xs mt-1 hidden" id="password-error">
                    <?php if (!empty($errors['password'])): echo $errors['password']; endif; ?>
                    </p>
                    <?php if (!empty($errors['password'])): ?>
                    <script>document.addEventListener('DOMContentLoaded',function(){document.getElementById('password-error').classList.remove('hidden');});</script>
                    <?php endif; ?>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Department</label>
                    <input class="w-full px-4 py-2 rounded-xl border border-gray-200 bg-gray-100 text-gray-400 text-sm cursor-not-allowed" name="department" value="open source" readonly>
                </div>

                <div>
                <?php if ($id && !empty($user['img'])): ?>
                        <div class="mb-3 flex items-center gap-3">
                            <img src="./img/<?= htmlspecialchars($user['img']) ?>" alt="current image" class="w-16 h-16 rounded-xl object-cover border border-gray-200">
                            <span class="text-xs text-gray-400">Current image — upload a new one to replace it</span>
                        </div>
                    <?php endif; ?>
                     <input type="file" name="img" id="img" accept=".jpg,.jpeg,.png" class="w-full px-4 py-2 rounded-xl border border-gray-200 bg-gray-50 text-sm text-gray-500 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-medium file:bg-purple-100 file:text-purple-600 hover:file:bg-purple-200 transition">
                     <p class="text-xs text-gray-400 mt-1">JPG or PNG only · max 2 MB</p>
                     <p class="text-red-500 text-xs mt-1 hidden" id="img-error">
                     <?php if (!empty($errors['img'])): echo $errors['img']; endif; ?>
                     </p>
                     <?php if (!empty($errors['img'])): ?>
                     <script>document.addEventListener('DOMContentLoaded',function(){document.getElementById('img-error').classList.remove('hidden');});</script>
                     <?php endif; ?>
                </div>


                <div class="bg-purple-50 rounded-xl px-4 py-3 text-sm text-gray-500">
                    code: <span class="font-semibold text-purple-600">sh68sa</span>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Enter Code</label>
                    <input type="text" class="w-full px-4 py-2 rounded-xl border border-gray-200 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-300 focus:border-transparent text-sm transition" placeholder="Enter code here" id="codeInput">
                </div>

                <div class="flex gap-3 pt-2">
                    <?php if ($id) { ?>
                        <button type="submit" class="px-6 py-2 bg-gradient-to-r from-purple-500 to-pink-400 text-white text-sm font-semibold rounded-xl shadow-md hover:opacity-90 transition">Update</button>
                    <?php } else { ?>
                        <button type="submit" class="px-6 py-2 bg-gradient-to-r from-purple-500 to-pink-400 text-white text-sm font-semibold rounded-xl shadow-md hover:opacity-90 transition">Submit</button>
                    <?php } ?>
                    <button type="reset" class="px-6 py-2 bg-gray-100 text-gray-500 text-sm font-semibold rounded-xl hover:bg-gray-200 transition">Reset</button>
                </div>

            </form>
        </div>
    </div>

    <script>
    // ── helpers ──────────────────────────────────────────────────────────────
    function showError(id, msg) {
        const el = document.getElementById(id);
        el.textContent = msg;
        el.classList.remove('hidden');
    }
    function clearError(id) {
        const el = document.getElementById(id);
        el.textContent = '';
        el.classList.add('hidden');
    }

    // ── live feedback  ────────────────────────────────
    document.getElementById('fname').addEventListener('input', function() {
        if (this.value && /\d/.test(this.value))
            showError('fname-error', 'First name must not contain numbers.');
        else clearError('fname-error');
    });
    document.getElementById('lname').addEventListener('input', function() {
        if (this.value && /\d/.test(this.value))
            showError('lname-error', 'Last name must not contain numbers.');
        else clearError('lname-error');
    });
    document.getElementById('password').addEventListener('input', function() {
        validatePassword(this.value, false);
    });

    function validatePassword(val, required) {
        if (!val) {
            if (required) { showError('password-error', 'Password is required.'); return false; }
            clearError('password-error'); return true;
        }
        if (val.length !== 8)                       { showError('password-error', 'Password must be exactly 8 characters.'); return false; }
        if (/[A-Z]/.test(val))                      { showError('password-error', 'Password must not contain uppercase letters.'); return false; }
        if (/[^a-z0-9_]/.test(val))                 { showError('password-error', 'Password may only contain lowercase letters, digits and underscore.'); return false; }
        clearError('password-error'); return true;
    }

    // ── submit validation ────────────────────────────────────────────────────
    document.getElementById("myForm").addEventListener("submit", function(e) {
        let valid = true;

        // code check (existing behaviour)
        let code = document.getElementById("codeInput").value;
        if (code !== "sh68sa") {
            e.preventDefault();
            alert("Invalid code!");
            return;
        }

        // First Name
        const fname = document.getElementById('fname').value.trim();
        if (!fname) {
            showError('fname-error', 'First name is required.'); valid = false;
        } else if (/\d/.test(fname)) {
            showError('fname-error', 'First name must not contain numbers.'); valid = false;
        } else clearError('fname-error');

        // Last Name
        const lname = document.getElementById('lname').value.trim();
        if (!lname) {
            showError('lname-error', 'Last name is required.'); valid = false;
        } else if (/\d/.test(lname)) {
            showError('lname-error', 'Last name must not contain numbers.'); valid = false;
        } else clearError('lname-error');

        // Address / Email
        const address = document.getElementById('address').value.trim();
        if (!address) {
            showError('address-error', 'Email address is required.'); valid = false;
        } else clearError('address-error');

        // Gender
        const genderChecked = document.querySelector('input[name="gender"]:checked');
        if (!genderChecked) {
            showError('gender-error', 'Please select a gender.'); valid = false;
        } else clearError('gender-error');

        // Skills — at least one must be checked
        const skillsChecked = document.querySelectorAll('.skill-checkbox:checked');
        if (skillsChecked.length === 0) {
            showError('skills-error', 'Please select at least one skill.'); valid = false;
        } else clearError('skills-error');

        // Username
        const username = document.getElementById('username').value.trim();
        if (!username) {
            showError('username-error', 'Username is required.'); valid = false;
        } else clearError('username-error');

        // Password
        const password = document.getElementById('password').value;
        const isEdit   = document.querySelector('input[name="id"]').value !== '';
        if (!isEdit || password) {
            if (!validatePassword(password, !isEdit)) valid = false;
        }

        // Image — type & size (client-side)
        const imgInput = document.getElementById('img');
        if (imgInput.files.length > 0) {
            const file = imgInput.files[0];
            const allowed = ['image/jpeg', 'image/png'];
            if (!allowed.includes(file.type)) {
                showError('img-error', 'Only JPG and PNG images are allowed.'); valid = false;
            } else if (file.size > 2 * 1024 * 1024) {
                showError('img-error', 'Image must be smaller than 2 MB.'); valid = false;
            } else clearError('img-error');
        }

        if (!valid) e.preventDefault();
    });
    </script>
</body>
</html>