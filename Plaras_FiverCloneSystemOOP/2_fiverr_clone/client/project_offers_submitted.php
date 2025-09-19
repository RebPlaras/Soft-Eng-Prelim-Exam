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

    <title>Project Offers Submitted</title>
  </head>
  <body class="bg-gray-100">
    <?php include 'includes/navbar.php'; ?>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-purple-700 text-center mb-8">Project Offers Submitted</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php
            // Assuming you have a method to get offers submitted by the current user
            // $offers = $offerObj->getOffersByUserId($_SESSION['user_id']);
            // foreach($offers as $offer) { ... }
            ?>
            <div class="bg-white shadow-md rounded-xl p-8">
                <h2 class="text-xl font-bold text-purple-700 mb-4">Offer for Proposal Title</h2>
                <p class="text-gray-600">Offer description...</p>
            </div>
        </div>
    </div>
  </body>
</html>