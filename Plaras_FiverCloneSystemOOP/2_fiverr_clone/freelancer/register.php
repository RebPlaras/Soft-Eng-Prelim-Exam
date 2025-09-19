<?php require_once 'classloader.php'; ?>
<?php 
if ($userObj->isLoggedIn()) {
  header("Location: index.php");
} 
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <title>Register</title>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8 flex justify-center items-center min-h-screen">
        <div class="bg-white shadow-md rounded-xl p-8 w-full max-w-md">
            <h1 class="text-3xl font-bold text-purple-700 text-center mb-8">Freelancer Registration</h1>
            <?php  
              if (isset($_SESSION['message']) && isset($_SESSION['status'])) {
                if ($_SESSION['status'] == "200") {
                    echo "<p class='bg-green-100 text-green-700 px-4 py-2 rounded-md mb-4 text-sm'>{$_SESSION['message' ]}</p>";
                } else {
                    echo "<p class='bg-red-100 text-red-700 px-4 py-2 rounded-md mb-4 text-sm'>{$_SESSION['message']}</p>"; 
                }
                unset($_SESSION['message']);
                unset($_SESSION['status']);
              }
            ?>
            <form action="core/handleForms.php" method="POST" class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Username</label>
                    <input type="text" name="username" required class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" required class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" name="password" required class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Contact Number</label>
                    <input type="text" name="contact_number" required class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <button type="submit" name="registerUserBtn" class="w-full bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition">Register</button>
            </form>
            <p class="text-center mt-4">Already have an account? <a href="login.php" class="text-purple-600 hover:underline">Login here</a></p>
        </div>
    </div>
</body>
</html>