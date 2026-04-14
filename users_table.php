<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-purple-100 via-pink-50 to-blue-100 p-8">

    <div class="max-w-7xl mx-auto">

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-700">Employees</h1>
            <a href="register.php" class="px-5 py-2 bg-gradient-to-r from-purple-500 to-pink-400 text-white text-sm font-semibold rounded-xl shadow-md hover:opacity-90 transition">
                + Create New User
            </a>
        </div>

        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl shadow-purple-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="px-5 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">ID</th>
                            <th class="px-5 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">First Name</th>
                            <th class="px-5 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Last Name</th>
                            <th class="px-5 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Address</th>
                            <th class="px-5 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Gender</th>
                            <th class="px-5 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Username</th>
                            <th class="px-5 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Password</th>
                            <th class="px-5 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Department</th>
                            <th class="px-5 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider">Skills</th>
                            <th class="px-5 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider"></th>
                            <th class="px-5 py-4 text-xs font-semibold text-gray-400 uppercase tracking-wider"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        <?php
                        include 'db.php';

                        $sql = "SELECT * FROM users";
                        $result = $conn->query($sql);
                        $users = $result->fetch_all(MYSQLI_ASSOC);

                        foreach ($users as $user) {
                            echo "<tr class='hover:bg-purple-50/50 transition-colors'>";

                            foreach ($user as $value) {
                                echo "<td class='px-5 py-4 text-gray-600'>" . (!empty($value) ? htmlspecialchars($value) : "<span class='text-gray-300'>--</span>") . "</td>";
                            }

                            $user_id = $user['id'];
                            $sqlSkills = "SELECT skill FROM user_skills WHERE user_id = $user_id";
                            $skillsResult = $conn->query($sqlSkills);
                            $skillsText = "";
                            if ($skillsResult) {
                                while ($row = $skillsResult->fetch_assoc()) {
                                    $skillsText .= $row['skill'] . ", ";
                                }
                            }
                            $skillsText = rtrim($skillsText, ", ");

                            echo "<td class='px-5 py-4'>";
                            if ($skillsText) {
                                foreach (explode(", ", $skillsText) as $skill) {
                                    echo "<span class='inline-block bg-purple-100 text-purple-600 text-xs font-medium px-2 py-0.5 rounded-full mr-1'>" . htmlspecialchars($skill) . "</span>";
                                }
                            }
                            echo "</td>";

                            echo "<td class='px-3 py-4'><a href='view.php?id=$user_id' class='text-blue-400 hover:text-blue-600 text-xs font-medium transition'>View</a></td>";
                            echo "<td class='px-3 py-4'><a href='register.php?id=$user_id' class='text-purple-400 hover:text-purple-600 text-xs font-medium transition'>Edit</a></td>";
                            echo "<td class='px-3 py-4'><a href='delete.php?id=$user_id' class='text-red-400 hover:text-red-600 text-xs font-medium transition'>Delete</a></td>";

                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</body>
</html>