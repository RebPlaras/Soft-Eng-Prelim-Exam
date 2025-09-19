<?php
session_start();
require_once 'classloader.php';

if (!isset($_SESSION['user_id']) || !$admin->isAdmin($_SESSION['user_id'])) {
    header('Location: ../client/login.php');
    exit();
}

$offers = $offer->getOffers();

?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Offers</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-purple-700 text-center mb-8">Manage Offers</h1>
        <div class="text-center mb-8">
            <a href="index.php" class="text-purple-600 hover:underline">Back to Dashboard</a>
        </div>

        <div class="bg-white shadow-md rounded-xl p-8">
            <h2 class="text-2xl font-bold text-purple-700 mb-6">All Offers</h2>
            <table class="w-full text-left">
                <thead>
                    <tr class="border-b-2 border-purple-200">
                        <th class="px-4 py-2">Description</th>
                        <th class="px-4 py-2">Proposal</th>
                        <th class="px-4 py-2">Client</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($offers as $o): ?>
                        <tr class="border-b border-gray-200">
                            <td class="px-4 py-2"><?php echo htmlspecialchars($o['description']); ?></td>
                            <td class="px-4 py-2"><?php echo htmlspecialchars($o['proposal_description']); ?></td>
                            <td class="px-4 py-2"><?php echo htmlspecialchars($o['username']); ?></td>
                            <td class="px-4 py-2">
                                <a href="delete_offer.php?id=<?php echo $o['offer_id']; ?>" class="text-red-500 hover:text-red-700">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>