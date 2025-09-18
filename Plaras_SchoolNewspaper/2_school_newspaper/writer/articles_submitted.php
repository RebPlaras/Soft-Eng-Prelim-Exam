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
            <h2 class="text-3xl font-bold text-center mb-10 text-gray-800">Your Submitted Articles</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php $articles = $articleObj->getArticlesByUserID($_SESSION['user_id']); ?>
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
                                    <a href="edit_article.php?id=<?php echo $article['article_id']; ?>" class="gradient-bg hover:bg-primary-700 text-white font-medium py-2 px-4 rounded-lg text-sm">Edit</a>
                                <?php } else { ?>
                                    <span class="bg-yellow-100 text-yellow-700 text-xs font-semibold px-2.5 py-1 rounded-full">Pending</span>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
    </main>
    <footer class="gradient-bg text-white py-8">
        <div class="container mx-auto px-4 text-center">
            <p>© 2025 School Newspaper</p>
        </div>
    </footer>
</body>
</html>