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

    <title>View Profile</title>
  </head>
  <body class="bg-gray-100">
    <?php include 'includes/navbar.php'; ?>
    <?php $userInfo = $userObj->getUsers($_GET['user_id']); ?>
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white shadow-md rounded-xl p-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="md:col-span-1">
                    <img src="https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png" class="rounded-full w-48 h-48 mx-auto" alt="">
                </div>
                <div class="md:col-span-2">
                    <h2 class="text-3xl font-bold text-purple-700 mb-4"><?php echo $userInfo['username']; ?></h2>
                    <p class="text-gray-600 mb-4"><?php echo $userInfo['email']; ?></p>
                    <p class="text-gray-600 mb-4">Contact: <?php echo $userInfo['contact_number']; ?></p>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="text-lg font-bold text-purple-700 mb-2">Bio</h3>
                        <p class="text-gray-700"><?php echo $userInfo['bio_description'];?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </body>
</html>