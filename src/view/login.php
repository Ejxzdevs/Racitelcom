<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/global.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <title>User Login</title>
</head>
<body class="bg-[url('../../src/assets/images/bg/bgraci.jpg')] bg-cover bg-center h-screen bg-gray-800 h-screen flex justify-center items-center">
    <div class="w-full max-w-md backdrop-blur-sm text-white p-8 rounded-lg shadow-lg border border-gray-300">
        <h2 class="text-2xl font-semibold text-center mb-6">User Login</h2>
        <form action="../controller/userController.php" method="post">
            <div class="mb-4 relative">
                <label for="edit_number" class="block text-sm font-medium mb-2">Email</label>
                <div class="flex items-center border border-gray-300 rounded-md">
                    <i class="fas fa-envelope text-gray-500 pl-3"></i>
                    <input type="text" name="email" class="text-sm p-2 w-full border-none focus:outline-none focus:ring-1 focus:ring-blue-300 pl-2" placeholder="Enter Email:" required>
                    <input type="hidden" name="login" required>
                </div>
            </div>
            <div class="mb-4 relative">
                <label for="edit_address" class="block text-sm font-medium mb-2">Password</label>
                <div class="flex items-center border border-gray-300 rounded-md">
                    <i class="fas fa-lock text-gray-500 pl-3"></i>
                    <input type="password"  name="password" class="text-sm p-2 w-full border-none focus:outline-none focus:ring-1 focus:ring-blue-300 pl-2" placeholder="Enter Password:" required>
                </div>
            </div>
            <div class="flex justify-center">
            <button type="submit" class="w-full py-2 bg-white text-gray-800 font-semibold rounded-md hover:bg-blue-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 cursor-pointer transition-all duration-200 ease-in-out">Login</button>
            </div>
        </form>
    </div>
</body>
</html>
