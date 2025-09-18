<?php
session_start();
require_once 'classloader.php';

// Check if user is logged in and is a writer
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'writer') {
    header('Location: login.php');
    exit();
}

$article_id = isset($_GET['id']) ? $_GET['id'] : null;
$article_data = null;

if ($article_id) {
    $article_data = $articleObj->getArticles($article_id);
    if (!$article_data) {
        $_SESSION['message'] = "Article not found.";
        $_SESSION['status'] = '400';
        header('Location: all_articles.php');
        exit();
    }
} else {
    $_SESSION['message'] = "No article ID provided.";
    $_SESSION['status'] = '400';
    header('Location: all_articles.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Article - Writer Panel</title>
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
            <h2 class="text-3xl font-bold text-center mb-8 text-gray-800">Edit Article</h2>
            <div class="max-w-3xl mx-auto bg-white p-8 rounded-xl shadow-lg border border-primary-100">
                <?php  
                if (isset($_SESSION['message']) && isset($_SESSION['status'])) {
                    $status_class = ($_SESSION['status'] == "200") ? "bg-green-100 border border-green-400 text-green-700" : "bg-red-100 border border-red-400 text-red-700";
                    echo "<div class='px-4 py-3 rounded relative {$status_class} mb-4' role='alert'>{$_SESSION['message']}</div>";
                    unset($_SESSION['message']);
                    unset($_SESSION['status']);
                }
                ?>
                <form action="core/handleForms.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="article_id" value="<?php echo $article_data['article_id']; ?>">
                    <div class="mb-4">
                        <label for="title" class="block text-gray-700 text-sm font-bold mb-2">Title</label>
                        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($article_data['title']); ?>" class="shadow-sm appearance-none border border-gray-300 rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-primary-500" required>
                    </div>
                    <div class="mb-4">
                        <label for="content" class="block text-gray-700 text-sm font-bold mb-2">Content</label>
                        <textarea id="content" name="content" rows="10" class="shadow-sm appearance-none border border-gray-300 rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-primary-500" required><?php echo htmlspecialchars($article_data['content']); ?></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="category" class="block text-gray-700 text-sm font-bold mb-2">Category</label>
                        <select id="category" name="category_id" class="shadow-sm appearance-none border border-gray-300 rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-primary-500" required>
                            <?php
                            $categories = $categoryObj->getCategories();
                            foreach ($categories as $category) {
                                $selected = ($category['category_id'] == $article_data['category_id']) ? 'selected' : '';
                                echo "<option value='{$category['category_id']}' {$selected}>{$category['category_name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="articleImage" class="block text-gray-700 text-sm font-bold mb-2">Article Image</label>
                        <input type="file" id="articleImage" name="articleImage" class="shadow-sm appearance-none border border-gray-300 rounded w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-primary-500">
                        <?php if (!empty($article_data['image_path'])) { ?>
                            <p class="text-gray-600 text-sm mt-2">Current image: <a href="../../uploads/<?php echo $article_data['image_path']; ?>" target="_blank" class="text-primary-600 hover:underline"><?php echo $article_data['image_path']; ?></a></p>
                        <?php } ?>
                    </div>
                    <input type="hidden" name="current_image_path" value="<?php echo $article_data['image_path']; ?>">
                    <button type="submit" class="gradient-bg hover:bg-primary-700 text-white font-bold py-3 px-4 rounded-lg focus:outline-none focus:shadow-outline w-full" name="editArticleBtn">Update Article</button>
                </form>
            </div>
        </div>
    </main>
    <footer class="gradient-bg text-white py-8 mt-12">
        <div class="container mx-auto px-4 text-center">
            <p>© 2025 School Newspaper</p>
        </div>
    </footer>
</body>
</html>