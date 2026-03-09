<?php
include('db.php'); // ডেটাবেস কানেকশন

// সেশন চেক
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

$pageTitle = 'View Privacy Policy';

// --- Step 1: Fetch Privacy Policy Data ---
$result = $mysqli->query("SELECT * FROM privacy_policy WHERE id = 1");
$policy = $result->fetch_assoc();

// Format date
$date_display = 'Not Updated Yet';
if (isset($policy['updated_at']) && !empty($policy['updated_at'])) {
    $date_display = date('F j, Y', strtotime($policy['updated_at']));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php') ?>
    <title><?php echo $pageTitle; ?> - Admin Dashboard</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <style>
        .prose h1, .prose h2, .prose h3 { font-family: 'Archivo Black', sans-serif; color: #1f2937; }
        .prose p, .prose li { font-family: 'Space Grotesk', sans-serif; color: #4b5563; }
    </style>
</head>

<body class="bg-gray-100 font-body"> 
    <div class="flex h-screen">
        <?php include('sidebar.php') ?>

        <main class="flex-1 h-full overflow-y-auto">
            <?php include('top.php') ?>
            
            <div class="p-8 mb-32 md:mb-0 ">
                <div class="flex justify-between items-center mb-6" data-aos="fade-down">
                    <h1 class="text-3xl font-bold font-heading text-gray-800">
                        Privacy Policy Details
                    </h1>
                    
                    <div class="flex gap-3">
                        <a href="manage_privacy.php" class="font-nav flex items-center bg-gray-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-gray-700 transition-colors duration-300 font-semibold uppercase tracking-wider text-xs">
                            <i class="fas fa-arrow-left mr-2"></i>
                            <span>Back</span>
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 md:p-10 border-t-4 border-primary-start" data-aos="fade-up">
                    <div class="max-w-8xl mx-auto">
                        
                      

                        <div class="font-body text-base leading-relaxed space-y-6 prose max-w-none min-h-[400px]">
                            <?php if(!empty($policy['description'])): ?>
                                <?php echo $policy['description']; ?>
                            <?php else: ?>
                                <p class="text-gray-400 italic">No content available. Please edit to add details.</p>
                            <?php endif; ?>
                        </div>
                        
                        <div class="border-t pt-8 mt-10 text-right">
                            <a href="manage_privacy.php" class="font-nav inline-flex items-center justify-center bg-primary-start text-white px-8 py-3 rounded-lg shadow-md hover:bg-primary-end transition-all duration-300 font-bold uppercase tracking-widest text-sm transform hover:-translate-y-1">
                                <i class="fas fa-edit mr-2 text-xs"></i>
                                <span>Edit Privacy Policy</span>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </main>
    </div>

    <?php include('bottom.php') ?>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="main.js"></script>
    <script>AOS.init();</script>
</body>
</html>