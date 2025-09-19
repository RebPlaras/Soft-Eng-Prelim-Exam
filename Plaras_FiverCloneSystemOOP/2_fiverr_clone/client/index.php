<?php require_once 'classloader.php'; ?>
<?php 
if (isset($_SESSION['role']) && $_SESSION['role'] != 'client' && $_SESSION['role'] != 'admin') {
  header("Location: ../freelancer/index.php");
}

if (!$userObj->isLoggedIn()) {
  header("Location: login.php");
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

    <title>Client Dashboard</title>
  </head>
  <body class="bg-gray-100">
    <?php include 'includes/navbar.php'; ?>
    <div class="container mx-auto px-4 py-8">
      <h1 class="text-3xl font-bold text-purple-700 text-center mb-8">Welcome, <?php echo $_SESSION['username']; ?>!</h1>

        <?php  
          if (isset($_SESSION['message']) && isset($_SESSION['status'])) {
            if ($_SESSION['status'] == "200") {
                echo "<p class='bg-green-100 text-green-700 px-4 py-2 rounded-md mb-4 text-sm'>{$_SESSION['message']}</p>";
            } else {
                echo "<p class='bg-red-100 text-red-700 px-4 py-2 rounded-md mb-4 text-sm'>{$_SESSION['message']}</p>"; 
            }
            unset($_SESSION['message']);
            unset($_SESSION['status']);
          }
        ?>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <?php $getProposals = $proposalObj->getProposals(); ?>
        <?php foreach ($getProposals as $proposal) { ?>
          <div class="bg-white shadow-md rounded-xl overflow-hidden">
            <img src="<?php echo '../images/'.$proposal['image']; ?>" class="w-full h-48 object-cover" alt="">
            <div class="p-6">
              <h2 class="text-xl font-bold text-purple-700 mb-2"><a href="other_profile_view.php?user_id=<?php echo $proposal['user_id'] ?>"><?php echo $proposal['username']; ?></a></h2>
              <p class="text-gray-600 text-sm mb-4"><?php echo $proposal['description']; ?></p>
              <p class="text-gray-800 font-bold mb-2">Category: <?php echo $proposal['category_name']; ?></p>
              <p class="text-gray-800 font-bold mb-4">Subcategory: <?php echo $proposal['subcategory_name']; ?></p>
              <p class="text-lg font-bold text-purple-700 mb-4"><?php echo number_format($proposal['min_price']) . " - " . number_format($proposal['max_price']);?> PHP</p>

              <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-lg font-bold text-purple-700 mb-4">Offers</h3>
                <div class="space-y-4 max-h-60 overflow-y-auto">
                  <?php $getOffersByProposalID = $offerObj->getOffersByProposalID($proposal['proposal_id']); ?>
                  <?php foreach ($getOffersByProposalID as $offer) { ?>
                    <div class="border-b pb-4">
                      <p class="font-bold"><?php echo $offer['username']; ?> <span class="text-gray-500">(<?php echo $offer['contact_number']; ?>)</span></p>
                      <p class="text-sm text-gray-500"><?php echo $offer['offer_date_added']; ?></p>
                      <p class="text-gray-700"><?php echo $offer['description']; ?></p>
                      <?php if ($offer['user_id'] == $_SESSION['user_id']) { ?>
                        <div class="flex space-x-2 mt-2">
                          <form action="core/handleForms.php" method="POST">
                            <input type="hidden" name="offer_id" value="<?php echo $offer['offer_id']; ?>">
                            <button type="submit" name="deleteOfferBtn" class="text-red-500 hover:text-red-700">Delete</button>
                          </form>
                        </div>
                      <?php } ?>
                    </div>
                  <?php } ?>
                </div>
                <form action="core/handleForms.php" method="POST" class="mt-4">
                  <textarea name="description" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500" placeholder="Write an offer..."></textarea>
                  <input type="hidden" name="proposal_id" value="<?php echo $proposal['proposal_id']; ?>">
                  <button type="submit" name="insertOfferBtn" class="w-full mt-2 bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition">Submit Offer</button>
                </form>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
  </body>
</html>