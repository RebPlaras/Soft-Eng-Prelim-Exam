<?php require_once 'classloader.php'; ?>
<?php 
if (!$userObj->isLoggedIn()) {
  header("Location: login.php");
}

if (!$userObj->isAdmin()) {
  header("Location: ../freelancer/index.php");
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

    <title>Profile</title>
  </head>
  <body class="bg-gray-100">
    <?php include 'includes/navbar.php'; ?>
    <?php $userInfo = $userObj->getUsers($_SESSION['user_id']); ?>
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow-md rounded-xl p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="md:col-span-1 text-center">
                    <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png" class="rounded-full w-48 h-48 mx-auto mb-4" alt="">
                    <h2 class="text-2xl font-bold text-purple-700"><?php echo $userInfo['username']; ?></h2>
                    <p class="text-gray-600"><?php echo $userInfo['email']; ?></p>
                </div>
                <div class="md:col-span-2">
                    <form action="core/handleForms.php" method="POST" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Contact Number</label>
                            <input type="text" name="contact_number" value="<?php echo $userInfo['contact_number']; ?>" required class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Bio</label>
                            <textarea name="bio_description" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"><?php echo $userInfo['bio_description']; ?></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Display Picture</label>
                            <input type="file" name="display_picture" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                        </div>
                        <button type="submit" name="updateUserBtn" class="w-full bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
  </body>
</html>