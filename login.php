<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gradient-to-br from-purple-100 via-pink-50 to-blue-100 flex items-center justify-center px-4">

    <?php $error = $_GET['error'] ?? null; ?>

    <div class="w-full max-w-md">

        <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl shadow-purple-100 p-10">

            <div class="mb-8 text-center">
                <h1 class="text-2xl font-bold text-gray-700">Welcome Back</h1>
                <p class="text-sm text-gray-400 mt-1">Sign in to your account</p>
            </div>

            <?php if ($error): ?>
                <div class="mb-5 flex items-center gap-2 bg-red-50 border border-red-200 text-red-500 text-sm rounded-xl px-4 py-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01M12 4a8 8 0 100 16A8 8 0 0012 4z"/>
                    </svg>
                    Invalid name or password. Please try again.
                </div>
            <?php endif; ?>

            <form action="login_process.php" method="post" class="space-y-5">

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Email</label>
                    <input
                        type="email"
                        name="email"
                        placeholder="Enter your email"
                        class="w-full px-4 py-2.5 rounded-xl border <?= $error ? 'border-red-300 bg-red-50 focus:ring-red-300' : 'border-gray-200 bg-gray-50 focus:ring-purple-300' ?> focus:outline-none focus:ring-2 focus:border-transparent text-sm transition"
                    >
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Password</label>
                    <input
                        type="password"
                        name="password"
                        placeholder="Enter your password"
                        class="w-full px-4 py-2.5 rounded-xl border <?= $error ? 'border-red-300 bg-red-50 focus:ring-red-300' : 'border-gray-200 bg-gray-50 focus:ring-purple-300' ?> focus:outline-none focus:ring-2 focus:border-transparent text-sm transition"
                    >
                </div>

                <div class="pt-2">
                    <button
                        type="submit"
                        class="w-full py-2.5 bg-gradient-to-r from-purple-500 to-pink-400 text-white text-sm font-semibold rounded-xl shadow-md hover:opacity-90 active:scale-95 transition"
                    >
                        Login
                    </button>
                </div>

            </form>

        </div>

    </div>

</body>
</html>