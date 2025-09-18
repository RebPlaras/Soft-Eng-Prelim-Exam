<?php
session_start();
require_once 'classloader.php';

// Check if user is logged in and is a writer
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'writer') {
    header('Location: login.php');
    exit();
}

$article = new Article();
$sharedArticles = $article->getSharedArticles($_SESSION['user_id']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shared Articles - Writer Panel</title>
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
            <h2 class="text-3xl font-bold text-center mb-8 text-gray-800">Articles Shared With Me</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php if (!empty($sharedArticles)): ?>
                    <?php foreach ($sharedArticles as $article_data): ?>
                        <div class="bg-white rounded-xl shadow-md overflow-hidden flex flex-col card-hover border border-primary-100">
                            <?php if (!empty($article_data['image_path'])) { ?>
                                <div class="h-48 overflow-hidden">
                                    <img src="../uploads/<?php echo $article_data['image_path']; ?>" class="w-full h-full object-cover" alt="Article Image">
                                </div>
                            <?php } ?>
                            <div class="p-6 flex-grow">
                                <h3 class="text-xl font-bold text-primary-700 mb-2"><?php echo htmlspecialchars($article_data['title']); ?></h3>
                                <p class="text-gray-600 line-clamp-3"><?php echo htmlspecialchars($article_data['content']); ?></p>
                            </div>
                            <div class="px-6 py-4 bg-gray-50 mt-auto">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <strong class="text-primary-600"><?php echo htmlspecialchars($article_data['username']); ?></strong>
                                    </div>
                                    <a href="edit_article.php?id=<?php echo $article_data['article_id']; ?>" class="gradient-bg hover:bg-primary-700 text-white font-bold py-2 px-4 rounded-lg">Edit</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="bg-primary-100 border border-primary-400 text-primary-700 px-4 py-3 rounded relative" role="alert">
                        No articles shared with you.
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
    <footer class="gradient-bg text-white py-8">
        <div class="container mx-auto px-4 text-center">
            <p>© <?php echo date('Y'); ?> School Newspaper. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>