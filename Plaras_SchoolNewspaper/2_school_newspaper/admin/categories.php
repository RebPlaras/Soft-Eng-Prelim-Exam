<?php require_once 'classloader.php';

if(isset($_POST['add_category'])){
    $category_name = $_POST['category_name'];
    $categoryObj->createCategory($category_name);
    header('Location: categories.php');
}

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
<body class="bg-gray-50">
    <?php require_once 'includes/navbar.php'; ?>

    <div class="container mx-auto mt-12 p-4">
        <div class="bg-white rounded-xl shadow-lg p-8 border border-primary-100">
            <h1 class="text-3xl font-bold text-center mb-8 text-gray-800">Manage Categories</h1>

            <div class="bg-white p-6 rounded-lg shadow-md mb-8">
                <h2 class="text-xl font-semibold mb-4">Add New Category</h2>
                <form method="POST">
                    <div class="flex items-center">
                        <input type="text" name="category_name" class="w-full px-4 py-2 border rounded-l-md focus:outline-none focus:ring-2 focus:ring-primary-500" placeholder="Category Name" required>
                        <button type="submit" name="add_category" class="gradient-bg text-white px-6 py-2 rounded-r-md hover:bg-primary-700">Add</button>
                    </div>
                </form>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4">All Categories</h2>
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-primary-600 text-white">
                            <th class="text-left py-3 px-4">Category Name</th>
                            <th class="text-left py-3 px-4">Created At</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $categories = $categoryObj->getCategories();
                        foreach($categories as $category) { ?>
                            <tr class="border-b border-gray-200 hover:bg-primary-50">
                                <td class="py-3 px-4"><?php echo $category['category_name']; ?></td>
                                <td class="py-3 px-4"><?php echo date('F j, Y', strtotime($category['created_at'])); ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>