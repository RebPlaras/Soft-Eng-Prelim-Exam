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

    <title>Offers From Clients</title>
  </head>
  <body class="bg-gray-100">
    <?php include 'includes/navbar.php'; ?>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-purple-700 text-center mb-8">Offers From Clients</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php $getProposalsByUserID = $proposalObj->getProposalsByUserID($_SESSION['user_id']); ?>
            <?php foreach ($getProposalsByUserID as $proposal) { ?>
              <div class="bg-white shadow-md rounded-xl overflow-hidden">
                <img src="<?php echo '../images/'.$proposal['image']; ?>" class="w-full h-48 object-cover" alt="">
                <div class="p-6">
                  <h2 class="text-xl font-bold text-purple-700 mb-2"><a href="#"><?php echo $proposal['username']; ?></a></h2>
                  <p class="text-gray-600 text-sm mb-4"><?php echo $proposal['description']; ?></p>
                  <p class="text-lg font-bold text-purple-700 mb-4"><?php echo number_format($proposal['min_price']) . " - " . number_format($proposal['max_price']);?> PHP</p>
                  
                  <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="text-lg font-bold text-purple-700 mb-4">All Offers</h3>
                    <div class="space-y-4 max-h-60 overflow-y-auto">
                        <?php $getOffersByProposalID = $offerObj->getOffersByProposalID($proposal['proposal_id']); ?>
                        <?php foreach ($getOffersByProposalID as $offer) { ?>
                        <div class="border-b pb-4">
                            <h4><?php echo $offer['username']; ?> <span class="text-purple-500">( <?php echo $offer['contact_number']; ?> )</span></h4>
                            <small><i><?php echo $offer['offer_date_added']; ?></i></small>
                            <p><?php echo $offer['description']; ?></p>
                        </div>
                        <?php } ?>
                    </div>
                  </div>
                </div>
              </div>
            <?php } ?>
        </div>
    </div>
  </body>
</html>