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
            <h2 class="text-3xl font-bold text-center mb-8 text-gray-800">Manage Users</h2>
            <div class="bg-white shadow-lg rounded-xl overflow-x-auto border border-primary-100">
                <table class="min-w-full bg-white">
                    <thead class="gradient-bg text-white">
                        <tr>
                            <th class="w-1/4 py-3 px-4 uppercase font-semibold text-sm">Username</th>
                            <th class="w-1/4 py-3 px-4 uppercase font-semibold text-sm">Email</th>
                            <th class="w-1/4 py-3 px-4 uppercase font-semibold text-sm">Role</th>
                            <th class="w-1/4 py-3 px-4 uppercase font-semibold text-sm">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        <?php $users = $userObj->getUsers(); ?>
                        <?php foreach ($users as $user) { ?>
                            <tr class="hover:bg-primary-50">
                                <td class="py-3 px-4"><?php echo $user['username']; ?></td>
                                <td class="py-3 px-4"><?php echo $user['email']; ?></td>
                                <td class="py-3 px-4"><?php echo $user['is_admin'] ? '<span class="bg-primary-500 text-white text-xs font-semibold px-2.5 py-1 rounded-full">Admin</span>' : '<span class="bg-gray-200 text-gray-800 text-xs font-semibold px-2.5 py-1 rounded-full">Writer</span>'; ?></td>
                                <td class="py-3 px-4">
                                    <a href="edit_user.php?id=<?php echo $user['user_id']; ?>" class="gradient-bg hover:bg-primary-700 text-white font-medium py-2 px-4 rounded-lg text-sm">Edit</a>
                                    <button class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg delete-user text-sm" data-user-id="<?php echo $user['user_id']; ?>">Delete</button>
                                </td>
                            </tr>
                        <?php } ?>
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
    <script src="https://code.jquery.com/jquery-3.7.0.js"></script>
    <script>
        $(document).on('click', '.delete-user', function() {
            var userId = $(this).data('user-id');
            if (confirm('Are you sure you want to delete this user?')) {
                $.ajax({
                    url: 'core/handleForms.php',
                    type: 'POST',
                    data: {
                        action: 'delete_user',
                        user_id: userId
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 'success') {
                            location.reload();
                        } else {
                            alert('Failed to delete user.');
                        }
                    },
                    error: function() {
                        alert('An error occurred while deleting the user.');
                    }
                });
            }
        });
    </script>
</body>
</html>