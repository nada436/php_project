<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
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
    ?>

    <div class="w-full max-w-xl">

        <div class="flex justify-end mb-4">
            <a href="users_table.php" class="text-sm text-purple-600 hover:text-purple-800 font-medium bg-white px-4 py-2 rounded-full shadow-sm hover:shadow transition-all">
                View All Users →
            </a>
        </div>

        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl shadow-purple-100 p-8">

            <h2 class="text-2xl font-bold text-gray-700 mb-6"><?= $id ? 'Edit Employee' : 'Register Employee' ?></h2>

            <form action="save.php" method="post" id="myForm" class="space-y-5">

                <input  type="hidden" name="id" value="<?= $id ?>" >

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">First Name</label>
                    <input class="w-full px-4 py-2 rounded-xl border border-gray-200 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-300 focus:border-transparent text-sm transition" name="fname" value="<?= $user['fname'] ?>" placeholder="Enter first name" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Last Name</label>
                    <input class="w-full px-4 py-2 rounded-xl border border-gray-200 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-300 focus:border-transparent text-sm transition" name="lname" value="<?= $user['lname'] ?>" placeholder="Enter last name" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Address</label>
                    <input class="w-full px-4 py-2 rounded-xl border border-gray-200 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-300 focus:border-transparent text-sm transition" name="address" value="<?= $user['address'] ?>" placeholder="Enter address" required>
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
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-2">Courses</label>
                    <div class="flex flex-wrap gap-4">
                        <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                            <input type="checkbox" name="skills[]" value="php" <?= in_array("php", $skills) ? "checked" : "" ?> class="accent-purple-500">
                            PHP
                        </label>
                        <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                            <input type="checkbox" name="skills[]" value="j2se" <?= in_array("j2se", $skills) ? "checked" : "" ?> class="accent-purple-500">
                            J2SE
                        </label>
                        <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                            <input type="checkbox" name="skills[]" value="mysql" <?= in_array("mysql", $skills) ? "checked" : "" ?> class="accent-purple-500">
                            MySQL
                        </label>
                        <label class="flex items-center gap-2 text-sm text-gray-600 cursor-pointer">
                            <input type="checkbox" name="skills[]" value="postgresql" <?= in_array("postgresql", $skills) ? "checked" : "" ?> class="accent-purple-500">
                            PostgreSQL
                        </label>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Username</label>
                    <input class="w-full px-4 py-2 rounded-xl border border-gray-200 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-300 focus:border-transparent text-sm transition" name="username" value="<?= $user['username'] ?>" placeholder="Enter username" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Password</label>
                    <input type="password" class="w-full px-4 py-2 rounded-xl border border-gray-200 bg-gray-50 focus:outline-none focus:ring-2 focus:ring-purple-300 focus:border-transparent text-sm transition" name="password" value="<?= $user['password'] ?>" placeholder="Enter password" required>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Department</label>
                    <input class="w-full px-4 py-2 rounded-xl border border-gray-200 bg-gray-100 text-gray-400 text-sm cursor-not-allowed" name="department" value="open source" readonly>
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
    document.getElementById("myForm").addEventListener("submit", function(e) {
        let code = document.getElementById("codeInput").value;
        if (code !== "sh68sa") {
            e.preventDefault();
            alert("Invalid code!");
        }
    });
    </script>
</body>
</html>