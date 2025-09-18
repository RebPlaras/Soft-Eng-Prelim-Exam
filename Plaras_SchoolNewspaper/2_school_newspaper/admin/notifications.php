<?php require_once 'classloader.php'; ?>

<?php 
if (!$userObj->isLoggedIn()) {
  header("Location: login.php");
}

if (!$userObj->isAdmin()) {
  header("Location: ../writer/index.php");
}  

$notificationObj->markAllAsRead($_SESSION['user_id']);
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
            <h2 class="text-3xl font-bold text-center mb-8 text-gray-800">Your Notifications</h2>
            <div class="max-w-3xl mx-auto">
                <?php $notifications = $notificationObj->getNotificationsByUserId($_SESSION['user_id']); ?>
                <?php if (empty($notifications)) { ?>
                    <div class="bg-primary-100 border border-primary-400 text-primary-700 px-4 py-3 rounded relative" role="alert">
                        You have no notifications.
                    </div>
                <?php } else { ?>
                    <?php foreach ($notifications as $notification) { ?>
                        <div class="bg-white shadow-lg rounded-xl mb-4 border-l-4 <?php echo $notification['is_read'] ? 'border-gray-300' : 'border-primary-500'; ?>">
                            <div class="p-6">
                                <p class="text-gray-800"><?php echo $notification['message']; ?></p>
                                <small class="text-gray-500"><?php echo date('F j, Y, g:i a', strtotime($notification['created_at'])); ?></small>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
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