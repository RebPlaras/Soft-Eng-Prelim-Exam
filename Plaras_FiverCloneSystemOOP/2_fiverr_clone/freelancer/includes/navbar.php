<?php require_once __DIR__ . '/../classloader.php';
$proposal = new Proposal();
?>
<nav class="bg-purple-700 p-4">
  <div class="container mx-auto flex justify-between items-center">
    <a class="text-white text-xl font-bold" href="index.php">Freelancer Panel</a>
    <div class="hidden md:flex space-x-4">
      <a class="text-white hover:text-purple-200" href="index.php">Home</a>
      <a class="text-white hover:text-purple-200" href="profile.php">Profile</a>
      <a class="text-white hover:text-purple-200" href="your_proposals.php">Your Proposals</a>
      <a class="text-white hover:text-purple-200" href="offers_from_clients.php">Offers From Clients</a>
      <div class="relative">
        <button class="text-white hover:text-purple-200 focus:outline-none">Categories</button>
        <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-10 hidden">
          <?php 
            $categories = $proposal->getCategories();
            foreach($categories as $category) {
          ?>
            <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-100" href="proposals_by_category.php?id=<?php echo $category['category_id']; ?>"><?php echo $category['category_name']; ?></a>
            <?php
              $subcategories = $proposal->getSubcategoriesByCategoryId($category['category_id']);
              foreach($subcategories as $subcategory) {
            ?>
              <a class="block px-4 py-2 text-sm text-gray-700 hover:bg-purple-100 ml-4" href="proposals_by_subcategory.php?id=<?php echo $subcategory['subcategory_id']; ?>"><?php echo $subcategory['subcategory_name']; ?></a>
            <?php } ?>
          <?php } ?>
        </div>
      </div>
      <a class="text-white hover:text-purple-200" href="core/handleForms.php?logoutUserBtn=1">Logout</a>
    </div>
  </div>
</nav>
<script>
  const dropdownButton = document.querySelector('.relative button');
  const dropdownMenu = document.querySelector('.relative .absolute');

  dropdownButton.addEventListener('click', () => {
    dropdownMenu.classList.toggle('hidden');
  });
</script>