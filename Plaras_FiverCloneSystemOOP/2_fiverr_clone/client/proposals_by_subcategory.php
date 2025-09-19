<?php require_once 'classloader.php'; ?>
<?php 
if (isset($_SESSION['role']) && $_SESSION['role'] != 'client' && $_SESSION['role'] != 'admin') {
  header("Location: ../freelancer/index.php");
}

if (!$userObj->isLoggedIn()) {
  header("Location: login.php");
} 

if (!isset($_GET['id'])) {
    header("Location: index.php");
}

$proposals = $proposalObj->getProposalsBySubcategoryId($_GET['id']);
?>
<!doctype html>
  <html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <title>Proposals by Subcategory</title>
  </head>
  <body class="bg-gray-100">
    <?php include 'includes/navbar.php'; ?>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-purple-700 text-center mb-8">Proposals in <?php echo $proposals[0]['subcategory_name'] ?? 'Subcategory'; ?></h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php foreach ($proposals as $proposal) { ?>
              <div class="bg-white shadow-md rounded-xl overflow-hidden">
                <img src="<?php echo '../images/'.$proposal['image']; ?>" class="w-full h-48 object-cover" alt="">
                <div class="p-6">
                  <h2 class="text-xl font-bold text-purple-700 mb-2"><a href="other_profile_view.php?user_id=<?php echo $proposal['user_id'] ?>"><?php echo $proposal['username']; ?></a></h2>
                  <p class="text-gray-600 text-sm mb-4"><?php echo $proposal['description']; ?></p>
                  <p class="text-gray-800 font-bold mb-2">Category: <?php echo $proposal['category_name']; ?></p>
                  <p class="text-gray-800 font-bold mb-4">Subcategory: <?php echo $proposal['subcategory_name']; ?></p>
                  <p class="text-lg font-bold text-purple-700 mb-4"><?php echo number_format($proposal['min_price']) . " - " . number_format($proposal['max_price']);?> PHP</p>
                </div>
              </div>
            <?php } ?>
        </div>
    </div>
  </body>
</html>