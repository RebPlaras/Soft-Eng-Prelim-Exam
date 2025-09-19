<?php require_once 'classloader.php'; ?>

<?php 
if (!$userObj->isLoggedIn()) {
  header("Location: login.php");
}

if ($userObj->isAdmin()) {
  header("Location: ../client/index.php");
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

    <title>Your Proposals</title>
  </head>
  <body class="bg-gray-100">
    <?php include 'includes/navbar.php'; ?>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-purple-700 text-center mb-8">Your Proposals</h1>
        <p class="text-center text-gray-600 mb-8">Double click to edit!</p>
        <div class="text-center">
            <?php  
              if (isset($_SESSION['message']) && isset($_SESSION['status'])) {

                if ($_SESSION['status'] == "200") {
                  echo "<h1 class='text-green-500'>{$_SESSION['message']}</h1>";
                }

                else {
                  echo "<h1 class='text-red-500'>{$_SESSION['message']}</h1>"; 
                }

              }
              unset($_SESSION['message']);
              unset($_SESSION['status']);
            ?>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php $getProposalsByUserID = $proposalObj->getProposalsByUserID($_SESSION['user_id']); ?>
            <?php foreach ($getProposalsByUserID as $proposal) { ?>
            <div class="bg-white shadow-md rounded-xl overflow-hidden proposalCard">
                <img src="<?php echo "../images/".$proposal['image']; ?>" class="w-full h-48 object-cover" alt="">
                <div class="p-6">
                    <h2 class="text-xl font-bold text-purple-700 mb-2"><a href="#"><?php echo $proposal['username']; ?></a></h2>
                    <p class="text-gray-500 text-sm mb-2"><i><?php echo $proposal['proposals_date_added']; ?></i></p>
                    <p class="text-gray-600 text-sm mb-4"><?php echo $proposal['description']; ?></p>
                    <p class="text-gray-800 font-bold mb-2">Category: <?php echo $proposal['category_name']; ?></p>
                    <p class="text-gray-800 font-bold mb-4">Subcategory: <?php echo $proposal['subcategory_name']; ?></p>
                    <p class="text-lg font-bold text-purple-700"><?php echo number_format($proposal['min_price']) . " - " . number_format($proposal['max_price']);?> PHP</p>
                    <form action="core/handleForms.php" method="POST" class="mt-4">
                        <input type="hidden" name="proposal_id" value="<?php echo $proposal['proposal_id']; ?>">
                        <input type="hidden" name="image" value="<?php echo $proposal['image']; ?>">
                        <button type="submit" name="deleteProposalBtn" class="w-full bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition">Delete</button>
                    </form>
                    <form action="core/handleForms.php" method="POST" class="updateProposalForm hidden mt-4 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Minimum Price</label>
                            <input type="number" name="min_price" value="<?php echo $proposal['min_price']; ?>" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Maximum Price</label>
                            <input type="number" name="max_price" value="<?php echo $proposal['max_price']; ?>" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Description</label>
                            <input type="hidden" name="proposal_id" value="<?php echo $proposal['proposal_id']; ?>">
                            <textarea name="description" class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"><?php echo $proposal['description']; ?></textarea>
                        </div>
                        <button type="submit" name="updateProposalBtn" class="w-full bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition">Update Proposal</button>
                    </form>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script>
       $('.proposalCard').on('dblclick', function (event) {
          var updateProposalForm = $(this).find('.updateProposalForm');
          updateProposalForm.toggleClass('hidden');
        });
    </script>
  </body>
</html>