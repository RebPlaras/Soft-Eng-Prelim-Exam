<?php require_once 'classloader.php'; ?>

<?php 
if (!$userObj->isLoggedIn()) {
  header("Location: login.php");
}

if (!$userObj->isAdmin()) {
  header("Location: ../writer/index.php");
}  

$user_id = $_GET['id'];
$user = $userObj->getUsers($user_id);

?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body class="bg-gray-100 font-sans flex flex-col min-h-screen">
    <?php include 'includes/navbar.php'; ?>
    <main class="flex-grow">
        <div class="container mx-auto mt-12">
            <h2 class="text-3xl font-bold text-center mb-8">Edit User</h2>
            <div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow-md">
                <form action="core/handleForms.php" method="POST">
                    <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
                    <div class="mb-4">
                        <label for="username" class="block text-gray-700 text-sm font-bold mb-2">Username</label>
                        <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    </div>
                    <div class="mb-4">
                        <label for="is_admin" class="block text-gray-700 text-sm font-bold mb-2">Role</label>
                        <select id="is_admin" name="is_admin" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                            <option value="0" <?php echo !$user['is_admin'] ? 'selected' : ''; ?>>Writer</option>
                            <option value="1" <?php echo $user['is_admin'] ? 'selected' : ''; ?>>Admin</option>
                        </select>
                    </div>
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full" name="updateUserBtn">Update User</button>
                </form>
            </div>
        </div>
    </main>
    <footer class="gradient-bg text-white py-8">
        <div class="container mx-auto px-4 text-center">
            <p>© <?php echo date('Y'); ?> School Newspaper</p>
        </div>
    </footer>
</body>
</html>