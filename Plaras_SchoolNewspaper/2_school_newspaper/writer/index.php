<?php require_once 'classloader.php'; ?>

<?php 
if (!$userObj->isLoggedIn()) {
  header("Location: login.php");
}

if ($userObj->isAdmin()) {
  header("Location: ../admin/index.php");
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
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#faf5ff',
                            100: '#f3e8ff',
                            200: '#e9d5ff',
                            300: '#d8b4fe',
                            400: '#c084fc',
                            500: '#a855f7',
                            600: '#9333ea',
                            700: '#7e22ce',
                            800: '#6b21a8',
                            900: '#581c87',
                        }
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');
        
        body {
            font-family: 'Poppins', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #a855f7 0%, #7e22ce 100%);
        }
    </style>
</head>
<body class="bg-gray-50 flex flex-col min-h-screen">
    <?php include 'includes/navbar.php'; ?>
    <main class="flex-grow">
        <div class="container mx-auto mt-12">
            <div class="bg-white rounded-xl shadow-lg p-8 text-center border border-primary-100">
                <h1 class="text-4xl font-bold">Hello, <span class="text-primary-600"><?php echo $_SESSION['username']; ?></span>!</h1>
                <p class="text-gray-600 mt-2">Ready to share your piece? Submit your article below.</p>
            </div>

            <div class="mt-8">
                <div class="bg-white rounded-xl shadow-lg border border-primary-100">
                    <div class="p-8">
                        <h5 class="text-2xl font-bold text-gray-800 mb-6">Submit a New Article</h5>
                        <form action="core/handleForms.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-4">
                                <input type="text" class="shadow-sm appearance-none border border-gray-300 rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-primary-500" name="title" placeholder="Enter a catchy title">
                            </div>
                            <div class="mb-4">
                                <textarea name="description" class="shadow-sm appearance-none border border-gray-300 rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-primary-500" rows="5" placeholder="Write your article content here..."></textarea>
                            </div>
                            <div class="mb-4">
                                <label for="category" class="block text-gray-700 text-sm font-bold mb-2">Category</label>
                                <select id="category" name="category_id" class="shadow-sm appearance-none border border-gray-300 rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-primary-500" required>
                                    <option value="">Select a category</option>
                                    <?php
                                    $categories = $categoryObj->getCategories();
                                    foreach ($categories as $category) {
                                        echo "<option value='{$category['category_id']}'>{$category['category_name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="articleImage" class="block text-gray-700 text-sm font-bold mb-2">Upload Image (Optional)</label>
                                <input type="file" id="articleImage" name="articleImage" class="shadow-sm appearance-none border border-gray-300 rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-primary-500">
                            </div>
                            <button type="submit" class="gradient-bg hover:bg-primary-700 text-white font-bold py-3 px-4 rounded-lg focus:outline-none focus:shadow-outline w-full" name="insertArticleBtn">Submit Article</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-200 my-12"></div>

            <h2 class="text-3xl font-bold text-center mb-10 text-gray-800">All Active Articles</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php $articles = $articleObj->getActiveArticles(); ?>
                <?php foreach ($articles as $article) { ?>
                <div class="bg-white rounded-xl shadow-md overflow-hidden flex flex-col card-hover border border-primary-100">
                    <?php if (!empty($article['image_path'])) { ?>
                        <div class="h-48 overflow-hidden">
                            <img src="../uploads/<?php echo $article['image_path']; ?>" class="w-full h-full object-cover" alt="Article Image">
                        </div>
                    <?php } ?>
                    <div class="p-6 flex-grow">
                        <span class="bg-primary-100 text-primary-700 text-xs font-semibold px-2.5 py-1 rounded-full mb-2 inline-block"><?php echo $article['category_name']; ?></span>
                        <h3 class="text-xl font-bold text-primary-700 mb-2"><?php echo $article['title']; ?></h3>
                        <p class="text-gray-600 line-clamp-3"><?php echo $article['content']; ?></p>
                    </div>
                    <div class="px-6 py-4 bg-gray-50 mt-auto">
                        <div class="flex items-center justify-between">
                            <div>
                                <strong class="text-primary-600"><?php echo $article['username'] ?></strong>
                                <span class="text-gray-500 text-sm block"><?php echo date('F j, Y', strtotime($article['created_at'])); ?></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <?php if ($article['is_active'] == 1) { ?>
                                    <span class="bg-green-100 text-green-700 text-xs font-semibold px-2.5 py-1 rounded-full">Published</span>
                                <?php } else { ?>
                                    <span class="bg-yellow-100 text-yellow-700 text-xs font-semibold px-2.5 py-1 rounded-full">Pending</span>
                                <?php } ?>
                                <?php if ($article['author_id'] != $_SESSION['user_id'] && $article['is_active'] == 1 && $article['edit_request'] == 0) { ?>
                                    <form action="core/handleForms.php" method="POST">
                                        <input type="hidden" name="action" value="request_edit_from_author">
                                        <input type="hidden" name="article_id" value="<?php echo $article['article_id']; ?>">
                                        <button type="submit" class="gradient-bg hover:bg-primary-700 text-white font-medium py-2 px-4 rounded-lg text-sm">Request Edit</button>
                                    </form>
                                <?php } else if ($article['edit_request'] == 1) { ?>
                                    <span class="bg-blue-100 text-blue-700 text-xs font-semibold px-2.5 py-1 rounded-full">Edit Requested</span>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </main>
    <footer class="gradient-bg text-white py-8 mt-16">
        <div class="container mx-auto px-4 text-center">
            <p>© 2025 School Newspaper</p>
        </div>
    </footer>
</body>
</html>