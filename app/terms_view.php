<?php
include('db.php'); 

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

$pageTitle = 'View Terms of Use';

// --- Step 1: Fetch Terms Data ---
$result = $mysqli->query("SELECT * FROM terms_of_use WHERE id = 1");
$terms = $result->fetch_assoc();

// Format date
$date_display = 'Not Updated Yet';
if (isset($terms['updated_at']) && !empty($terms['updated_at'])) {
    $date_display = date('F j, Y', strtotime($terms['updated_at']));
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php') ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
</head>

<body class="bg-gray-100 font-body"> 
    <div class="flex h-screen">
        <?php include('sidebar.php') ?>

        <main class="flex-1 h-full overflow-y-auto">
            <?php include('top.php') ?>
            
            <div class="p-8 mb-32 md:mb-0 ">
                <div class="flex justify-between items-center mb-6" data-aos="fade-down">
                    <h1 class="text-3xl font-bold font-heading text-gray-800">
                        Terms of Use Details
                    </h1>
                    
                    
                    <div class="flex gap-3">
                        <a href="manage_terms.php" class="font-nav flex items-center bg-gray-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-gray-700 transition-colors duration-300 font-semibold uppercase tracking-wider text-xs">
                            <i class="fas fa-arrow-left mr-2"></i>
                            <span>Back</span>
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 md:p-10 border-t-4 border-[#44afe4]" data-aos="fade-up">
                    <div class="max-w-8xl mx-auto">
                        
                        

                        <div class="font-body text-base text-gray-700 leading-relaxed space-y-4 prose max-w-none min-h-[400px]">
                            <?php if(!empty($terms['description'])): ?>
                                <?php echo $terms['description']; ?>
                            <?php else: ?>
                                <p class="text-gray-400 italic">Terms content has not been set yet.</p>
                            <?php endif; ?>
                        </div>
                        
                        <div class="border-t pt-8 mt-10 text-right">
                            <a href="manage_terms.php" class="font-nav inline-flex items-center justify-center bg-[#44afe4] text-white px-8 py-3 rounded-lg shadow-md hover:bg-opacity-90 transition-all duration-300 font-bold uppercase tracking-widest text-sm transform hover:-translate-y-1">
                                <i class="fas fa-pen-nib mr-2 text-xs"></i>
                                <span>Edit Terms of Use</span>
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
 
</body>
</html>