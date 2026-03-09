<?php
include('db.php'); // ডেটাবেস কানেকশন

// সেশন চেক
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

$pageTitle = 'Manage Social Links';

// --- ডেটাবেস থেকে সব সোশ্যাল লিঙ্ক নিয়ে আসা ---
$social_links = [];
$result = $mysqli->query("SELECT * FROM social_links ORDER BY id DESC");
if ($result) {
    $social_links = $result->fetch_all(MYSQLI_ASSOC);
}

// প্ল্যাটফর্ম অনুযায়ী আইকন এবং কালার সেটিংস (যাতে দেখতে সুন্দর লাগে)
$platform_settings = [
    'WhatsApp'  => ['icon' => 'fa-whatsapp', 'color' => 'bg-green-100 text-green-600', 'border' => 'border-green-200'],
    'Facebook'  => ['icon' => 'fa-facebook-f', 'color' => 'bg-blue-100 text-blue-600', 'border' => 'border-blue-200'],
    'YouTube'   => ['icon' => 'fa-youtube', 'color' => 'bg-red-100 text-red-600', 'border' => 'border-red-200'],
    'TikTok'    => ['icon' => 'fa-tiktok', 'color' => 'bg-gray-100 text-gray-900', 'border' => 'border-gray-300'],
    'Instagram' => ['icon' => 'fa-instagram', 'color' => 'bg-pink-100 text-pink-600', 'border' => 'border-pink-200'],
    'Telegram'  => ['icon' => 'fa-telegram-plane', 'color' => 'bg-sky-100 text-sky-500', 'border' => 'border-sky-200'],
    'Twitter'   => ['icon' => 'fa-twitter', 'color' => 'bg-blue-50 text-blue-400', 'border' => 'border-blue-100'],
    'LinkedIn'  => ['icon' => 'fa-linkedin-in', 'color' => 'bg-indigo-100 text-indigo-700', 'border' => 'border-indigo-200'],
];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php') ?>
</head>

<body class="bg-gray-100 font-body">
    <div class="flex h-screen">

        <?php include('sidebar.php') ?>

        <main class="flex-1 h-full overflow-y-auto">

            <?php include('top.php') ?>

            <?php
            if (isset($_SESSION['message']) && $_SESSION['message'] != '') {
            ?>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: "<?php echo $_SESSION['message']; ?>",
                            icon: "<?php echo $_SESSION['message_type']; ?>",
                            confirmButtonText: "OK",
                            confirmButtonColor: '#44afe4'
                        });
                    });
                </script>
            <?php
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
            }
            ?>

            <div class="p-8 mb-32 md:mb-0" data-aos="fade-up">

                <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                    <h1 class="text-3xl font-bold font-heading text-gray-800">
                        Manage Social Links
                    </h1>

                    <a href="add-social.php" class="font-nav flex items-center justify-center bg-primary-start text-white px-4 py-2 rounded-lg shadow-md hover:bg-primary-end transition-colors duration-300 w-full md:w-auto uppercase tracking-wider text-xs font-bold" data-aos="fade-left">
                        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        <span>Add Social Link</span>
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                    <?php if (!empty($social_links)) : ?>
                        <?php foreach ($social_links as $index => $social) : ?>
                            <?php
                            $platform = $social['platform_name'];
                            $settings = $platform_settings[$platform] ?? ['icon' => 'fa-link', 'color' => 'bg-gray-100 text-gray-600', 'border' => 'border-gray-200'];
                            ?>
                            <div class="border-card bg-white rounded-xl shadow-lg p-6 text-center flex flex-col items-center">
                                
                                <div class="w-32 h-32 rounded-full shadow-inner mb-4 flex items-center justify-center text-5xl border-4 <?php echo $settings['border'] . ' ' . $settings['color']; ?>">
                                    <i class="fa-brands <?php echo $settings['icon']; ?>"></i>
                                </div>

                                <h3 class="text-xl font-bold font-heading text-gray-900"><?php echo htmlspecialchars($platform); ?></h3>
                                
                             

                                <div class="mt-2 w-full">
                                    <p class="text-[10px] text-gray-400 truncate px-2 italic bg-gray-50 rounded py-1">
                                        <?php echo htmlspecialchars($social['link']); ?>
                                    </p>
                                </div>

                                <div class="flex justify-center space-x-3 mt-6 pt-4 border-t border-gray-100 w-full">
                                    <a href="<?php echo $social['link']; ?>" target="_blank" class="h-8 w-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shadow-md hover:shadow-lg hover:bg-blue-200 hover:-translate-y-0.5 transition-all duration-300" title="Visit Link">
                                        <i class="fas fa-external-link-alt text-xs"></i>
                                    </a>
                                    <a href="edit-social.php?id=<?php echo $social['id']; ?>" class="h-8 w-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center shadow-md hover:shadow-lg hover:bg-green-200 hover:-translate-y-0.5 transition-all duration-300" title="Edit">
                                        <i class="fas fa-pencil-alt text-xs"></i>
                                    </a>
                                    <button data-id="<?php echo $social['id']; ?>" class="delete-social-btn h-8 w-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center shadow-md hover:shadow-lg hover:bg-red-200 hover:-translate-y-0.5 transition-all duration-300" title="Delete">
                                        <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p class="text-gray-500 col-span-full text-center py-10 font-body">No social links found. Please add a new link.</p>
                    <?php endif; ?>
                </div>

            </div>
        </main>
    </div>

    <?php include('bottom.php') ?>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="main.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-social-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const socialId = this.dataset.id;

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This link will be removed from your frontend!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#44afe4', // থিম কালার
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'logics.php?social_delete_id=' + socialId;
                        }
                    });
                });
            });
        });
    </script>
</body>

</html>