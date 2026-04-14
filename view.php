<!DOCTYPE html>
<html>
<head>
    <title>User Info</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen bg-gradient-to-br from-purple-100 via-pink-50 to-blue-100 flex items-center justify-center p-8">

    <div class="w-full max-w-md">

        <div class="mb-4">
            <a href="users_table.php" class="inline-flex items-center gap-1 text-sm text-purple-600 hover:text-purple-800 font-medium bg-white px-4 py-2 rounded-full shadow-sm hover:shadow transition-all">
                ← Back
            </a>
        </div>

        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl shadow-purple-100 p-8">

            <?php
            include 'db.php';
            $id = $_GET['id'];
            $sql = "SELECT * FROM users WHERE id = $id";
            $result = $conn->query($sql);
            $user = $result->fetch_assoc();
            ?>

            <h2 class="text-xl font-bold text-gray-700 mb-6">User Info</h2>

            <div class="space-y-4">

                <div class="flex items-start gap-3 p-3 rounded-xl bg-gray-50">
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider w-24 pt-0.5">Name</span>
                    <span class="text-gray-700 font-medium"><?=($user['fname'] . " " . $user['lname']) ?></span>
                </div>

                <div class="flex items-start gap-3 p-3 rounded-xl bg-gray-50">
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider w-24 pt-0.5">Address</span>
                    <span class="text-gray-700"><?=($user['address']) ?></span>
                </div>

                <div class="flex items-start gap-3 p-3 rounded-xl bg-gray-50">
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider w-24 pt-0.5">Gender</span>
                    <span class="text-gray-700 capitalize"><?=($user['gender']) ?></span>
                </div>

                <div class="flex items-start gap-3 p-3 rounded-xl bg-gray-50">
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider w-24 pt-0.5">Password</span>
                    <span class="text-gray-700"><?= ($user['password']) ?></span>
                </div>

                <div class="flex items-start gap-3 p-3 rounded-xl bg-gray-50">
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider w-24 pt-0.5">Department</span>
                    <span class="text-gray-700"><?=($user['department']) ?></span>
                </div>

                <div class="flex items-start gap-3 p-3 rounded-xl bg-gray-50">
                    <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider w-24 pt-0.5">Skills</span>
                    <div class="flex flex-wrap gap-1">
                        <?php
                        $user_id = $user['id'];
                        $sqlSkills = "SELECT skill FROM user_skills WHERE user_id = $user_id";
                        $skillsResult = $conn->query($sqlSkills);
                        if ($skillsResult) {
                            while ($row = $skillsResult->fetch_assoc()) {
                                echo "<span class='inline-block bg-purple-100 text-purple-600 text-xs font-medium px-2 py-0.5 rounded-full'>" . htmlspecialchars($row['skill']) . "</span>";
                            }
                        }
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>