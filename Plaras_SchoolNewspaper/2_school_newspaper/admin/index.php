<?php require_once 'classloader.php'; ?>

<?php 
if (!$userObj->isLoggedIn()) {
  header("Location: login.php");
}

if (!$userObj->isAdmin()) {
  header("Location: ../writer/index.php");
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
                <h1 class="text-4xl font-bold">Welcome, <span class="text-primary-600"><?php echo $_SESSION['username']; ?></span>!</h1>
                <p class="text-gray-600 mt-2">Here you can manage the school newspaper content.</p>
            </div>

            

            <h2 class="text-3xl font-bold text-center my-12 text-gray-800">All Articles</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php $articles = $articleObj->getArticles(); ?>
                <?php foreach ($articles as $article) { ?>
                <div class="bg-white rounded-xl shadow-md overflow-hidden flex flex-col card-hover border border-primary-100">
                    <?php if ($article['image_path']) { ?>
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
                            <div class="flex gap-2 items-center">
                                <?php if ($article['is_admin'] == 1) { ?>
                                    <span class="bg-primary-100 text-primary-700 text-xs font-semibold px-2.5 py-1 rounded-full">Admin</span>
                                <?php } ?>
                                <?php if ($article['is_active'] == 1) { ?>
                                    <span class="bg-green-100 text-green-700 text-xs font-semibold px-2.5 py-1 rounded-full">Published</span>
                                <?php } else { ?>
                                    <span class="bg-yellow-100 text-yellow-700 text-xs font-semibold px-2.5 py-1 rounded-full">Pending</span>
                                <?php } ?>
                                <button class="btn-primary bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg delete-article text-sm" data-article-id="<?php echo $article['article_id']; ?>">Delete</button>
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
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script>
        $(document).on('click', '.delete-article', function() {
            var articleId = $(this).data('article-id');
            if (confirm('Are you sure you want to delete this article?')) {
                $.ajax({
                    url: 'core/handleForms.php',
                    type: 'POST',
                    data: {
                        action: 'delete_article',
                        article_id: articleId
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 'success') {
                            location.reload();
                        } else {
                            alert('Failed to delete article.');
                        }
                    }
                });
            }
        });
    </script>
</body>
</html>