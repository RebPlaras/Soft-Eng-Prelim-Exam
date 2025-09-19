<?php require_once 'classloader.php'; ?>
<?php 
if (isset($_SESSION['role']) && $_SESSION['role'] != 'freelancer' && $_SESSION['role'] != 'admin') {
  header("Location: ../client/index.php");
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

    <title>Freelancer Dashboard</title>
  </head>
  <body class="bg-gray-100">
    <?php include 'includes/navbar.php'; ?>
    <div class="container mx-auto px-4 py-8">
      <h1 class="text-3xl font-bold text-purple-700 text-center mb-8">Welcome, <?php echo $_SESSION['username']; ?>!</h1>

      <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
        <div class="md:col-span-5">
          <div class="bg-white shadow-md rounded-xl p-8">
            <h2 class="text-2xl font-bold text-center text-purple-700 mb-6">Add New Proposal</h2>
            <form action="core/handleForms.php" method="POST" enctype="multipart/form-data" class="space-y-4">
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
                <div>
                    <label class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" required class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Category</label>
                    <select id="category" name="category_id" required class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <option value="">Select Category</option>
                        <?php
                        $categories = $proposalObj->getCategories();
                        foreach ($categories as $category) {
                            echo "<option value='{$category['category_id']}'>{$category['category_name']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Subcategory</label>
                    <select id="subcategory" name="subcategory_id" required class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                        <option value="">Select Subcategory</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Minimum Price</label>
                    <input type="number" name="min_price" required class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Maximum Price</label>
                    <input type="number" name="max_price" required class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Image</label>
                    <input type="file" name="image" required class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-purple-500">
                </div>
                <button type="submit" name="insertNewProposalBtn" class="w-full bg-purple-600 text-white py-2 px-4 rounded-lg hover:bg-purple-700 transition">Add Proposal</button>
            </form>
          </div>
        </div>
        <div class="md:col-span-7">
          <div class="grid grid-cols-1 gap-8">
            <?php $getProposals = $proposalObj->getProposals(); ?>
            <?php foreach ($getProposals as $proposal) { ?>
              <div class="bg-white shadow-md rounded-xl overflow-hidden">
                <img src="<?php echo '../images/' . $proposal['image']; ?>" alt="" class="w-full h-48 object-cover">
                <div class="p-6">
                  <h2 class="text-xl font-bold text-purple-700 mb-2"><a href="other_profile_view.php?user_id=<?php echo $proposal['user_id']; ?>"><?php echo $proposal['username']; ?></a></h2>
                  <p class="text-gray-500 text-sm mb-2"><i><?php echo $proposal['proposals_date_added']; ?></i></p>
                  <p class="text-gray-600 text-sm mb-4"><?php echo $proposal['description']; ?></p>
                  <p class="text-gray-800 font-bold mb-2">Category: <?php echo $proposal['category_name']; ?></p>
                  <p class="text-gray-800 font-bold mb-4">Subcategory: <?php echo $proposal['subcategory_name']; ?></p>
                  <p class="text-lg font-bold text-purple-700"><?php echo number_format($proposal['min_price']) . " - " . number_format($proposal['max_price']); ?> PHP</p>
                </div>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script>
        $(document).ready(function(){
            $('#category').on('change', function(){
                var category_id = $(this).val();
                if(category_id){
                    $.ajax({
                        type:'POST',
                        url:'core/ajax.php',
                        data:'category_id='+category_id,
                        success:function(html){
                            $('#subcategory').html(html);
                        }
                    }); 
                }else{
                    $('#subcategory').html('<option value="">Select category first</option>');
                }
            });
        });
    </script>
  </body>
</html>