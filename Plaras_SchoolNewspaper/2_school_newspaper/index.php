<?php require_once 'writer/classloader.php'; ?>
<!doctype html>
<html lang="en">
<head>
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
        
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        .btn-primary {
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px -1px rgba(168, 85, 247, 0.4);
        }
        
        .fade-in {
            animation: fadeIn 0.6s ease-in;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .gradient-bg {
            background: linear-gradient(135deg, #a855f7 0%, #7e22ce 100%);
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="gradient-bg p-4 text-white shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <a class="text-2xl font-bold flex items-center" href="#">
                <i class="fas fa-book-open mr-2"></i>
                <span class="bg-clip-text">School Newspaper</span>
            </a>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="relative bg-cover bg-center text-white py-24 px-10 text-center" 
     style="background-image: url('https://images6.alphacoders.com/705/705836.jpg'); background-position: center; background-size: cover;">
        <div class="relative z-10 max-w-3xl mx-auto fade-in">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Welcome to Our School Newspaper!</h1>
            <p class="text-lg md:text-xl">Your source for the latest news, events, and stories from our school community.</p>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container mx-auto mt-12 px-4">
        <!-- Login Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
            <div class="bg-white rounded-xl shadow-lg p-8 text-center card-hover border border-purple-100">
                <div class="w-16 h-16 gradient-bg rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-pencil-alt text-2xl text-white"></i>
                </div>
                <h5 class="text-2xl font-bold text-gray-800 mb-3">For Writers</h5>
                <p class="text-gray-600 mb-6">Share your stories and ideas with the school. Click here to submit your articles.</p>
                <a href="writer/login.php" class="btn-primary gradient-bg hover:bg-primary-700 text-white font-medium py-3 px-6 rounded-lg inline-block shadow-md">Writer Login</a>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg p-8 text-center card-hover border border-purple-100">
                <div class="w-16 h-16 gradient-bg rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-user-shield text-2xl text-white"></i>
                </div>
                <h5 class="text-2xl font-bold text-gray-800 mb-3">For Admins</h5>
                <p class="text-gray-600 mb-6">Manage articles, users, and the newspaper content. Click here to access the admin panel.</p>
                <a href="admin/login.php" class="btn-primary gradient-bg hover:bg-primary-700 text-white font-medium py-3 px-6 rounded-lg inline-block shadow-md">Admin Login</a>
            </div>
        </div>

        <div class="border-t border-gray-200 my-12"></div>

        <!-- Latest Articles -->
        <h2 class="text-3xl font-bold text-center mb-4 text-gray-800">Latest Articles</h2>
        <p class="text-center text-gray-600 mb-10 max-w-2xl mx-auto">Stay up to date with the latest news and stories from our school community</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-16">
            <?php $articles = $articleObj->getActiveArticles(); ?>
            <?php foreach ($articles as $article) { ?>
            <div class="bg-white rounded-xl shadow-md overflow-hidden flex flex-col card-hover">
                <?php if ($article['image_path']) { ?>
                    <div class="h-48 overflow-hidden">
                        <img src="uploads/<?php echo $article['image_path']; ?>" class="w-full h-full object-cover" alt="Article Image">
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
                        <?php if ($article['is_admin'] == 1) { ?>
                            <span class="bg-primary-100 text-primary-700 text-xs font-semibold px-2.5 py-1 rounded-full">Admin</span>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="gradient-bg text-white py-8 mt-12">
        <div class="container mx-auto px-4 text-center">
            <p>© <?php echo date('Y'); ?> School Newspaper</p>
        </div>
    </footer>
</body>
</html>