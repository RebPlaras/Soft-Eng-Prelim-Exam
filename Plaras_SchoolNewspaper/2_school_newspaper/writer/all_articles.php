<?php
session_start();
require_once 'classloader.php';

// Check if user is logged in and is a writer
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'writer') {
    header('Location: login.php');
    exit();
}

$articles = $articleObj->getArticles();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Articles - Writer Panel</title>
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
            <h2 class="text-3xl font-bold text-center mb-8 text-gray-800">All Articles</h2>
            <?php  
            if (isset($_SESSION['message']) && isset($_SESSION['status'])) {
                $status_class = ($_SESSION['status'] == "200") ? "bg-green-100 border border-green-400 text-green-700" : "bg-red-100 border border-red-400 text-red-700";
                echo "<div class='px-4 py-3 rounded relative {$status_class} mb-4' role='alert'>{$_SESSION['message']}</div>";
                unset($_SESSION['message']);
                unset($_SESSION['status']);
            }
            ?>
            <div class="bg-white shadow-lg rounded-xl overflow-x-auto border border-primary-100">
                <table class="min-w-full bg-white">
                    <thead class="gradient-bg text-white">
                        <tr>
                            <th class="w-1/4 py-3 px-4 uppercase font-semibold text-sm">Title</th>
                            <th class="w-1/4 py-3 px-4 uppercase font-semibold text-sm">Category</th>
                            <th class="w-1/4 py-3 px-4 uppercase font-semibold text-sm">Author</th>
                            <th class="w-1/4 py-3 px-4 uppercase font-semibold text-sm">Status & Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        <?php if (!empty($articles)): ?>
                            <?php foreach ($articles as $article): ?>
                                <tr class="hover:bg-primary-50">
                                    <td class="py-3 px-4"><?php echo htmlspecialchars($article['title']); ?></td>
                                    <td class="py-3 px-4"><span class="bg-primary-100 text-primary-700 text-xs font-semibold px-2.5 py-1 rounded-full"><?php echo $article['category_name']; ?></span></td>
                                    <td class="py-3 px-4"><?php echo htmlspecialchars($article['username']); ?></td>
                                    <td class="py-3 px-4">
                                        <div class="flex items-center justify-between">
                                            <?php echo $article['is_active'] ? '<span class="bg-green-100 text-green-700 text-xs font-semibold px-2.5 py-1 rounded-full">Active</span>' : '<span class="bg-yellow-100 text-yellow-700 text-xs font-semibold px-2.5 py-1 rounded-full">Inactive</span>'; ?>
                                            <?php if ($article['author_id'] !== $_SESSION['user_id']): // Only show request edit if not the author ?>
                                                <form action="core/handleForms.php" method="POST" class="inline-block">
                                                    <input type="hidden" name="article_id" value="<?php echo $article['article_id']; ?>">
                                                    <input type="hidden" name="action" value="request_edit_from_author">
                                                    <button type="submit" class="gradient-bg hover:bg-primary-700 text-white font-bold py-2 px-4 rounded-lg">Request Edit</button>
                                                </form>
                                            <?php else: ?>
                                                <!-- If it's the author's article, show pending requests or other actions -->
                                                <?php if ($article['edit_request'] == 1 && $article['edit_request_status'] == 'pending'): ?>
                                                    <div class="flex items-center gap-4">
                                                        <div>
                                                            <p>Edit requested by: <?php echo htmlspecialchars($article['requester_username']); ?></p>
                                                            <p>Message: <?php echo htmlspecialchars($article['edit_request_message']); ?></p>
                                                        </div>
                                                        <div class="flex gap-2">
                                                            <form action="core/handleForms.php" method="POST" class="inline-block">
                                                                <input type="hidden" name="article_id" value="<?php echo $article['article_id']; ?>">
                                                                <input type="hidden" name="action" value="accept_edit_request">
                                                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-lg">Approve</button>
                                                            </form>
                                                            <form action="core/handleForms.php" method="POST" class="inline-block">
                                                                <input type="hidden" name="article_id" value="<?php echo $article['article_id']; ?>">
                                                                <input type="hidden" name="action" value="reject_edit_request">
                                                                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded-lg">Deny</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                <?php else: ?>
                                                    No pending edit requests.
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center py-4">No articles found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <footer class="gradient-bg text-white py-8">
        <div class="container mx-auto px-4 text-center">
            <p>© <?php echo date('Y'); ?> School Newspaper</p>
        </div>
    </footer>
</body>
</html>