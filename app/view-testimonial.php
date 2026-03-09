<?php
include('db.php');

if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}
$pageTitle = 'View Testimonial';

// --- Testimonial ডেটা ফেচ করা ---
$testimonial = null;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $stmt = $mysqli->prepare("SELECT * FROM testimonials WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $testimonial = $result->fetch_assoc();
        $stmt->close();
    }

    if (!$testimonial) {
        $_SESSION['message'] = "Testimonial not found.";
        $_SESSION['message_type'] = 'error';
        header('Location: testimonials.php');
        exit();
    }
} else {
    header('Location: testimonials.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php') ?>
    <title><?php echo $pageTitle; ?> - Admin Dashboard</title>
</head>

<body class="bg-gray-100 font-merriweather">
    <div class="flex h-screen">

        <?php include('sidebar.php') ?>

        <main class="flex-1 h-full overflow-y-auto">

            <?php include('top.php') ?>

            <div class="p-8 mb-32 md:mb-0">

                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-3xl font-bold font-lora text-gray-800" data-aos="fade-right">
                        Full Review from: <?php echo htmlspecialchars($testimonial['t_name']); ?>
                    </h1>
                    <a href="testimonials.php" class="flex items-center bg-gray-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-gray-700 transition-colors duration-300">
                        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                        </svg>
                        <span>Back to Testimonials</span>
                    </a>
                </div>

                <div class="bg-white p-8 rounded-xl shadow-lg" data-aos="fade-left">

                    <div class="border-b pb-4 mb-6">
                        <h2 class="text-2xl font-lora font-bold text-gray-900 mb-2">
                            <?php echo htmlspecialchars($testimonial['t_name']); ?>
                        </h2>
                        <div class="flex items-center space-x-2 text-amber-500">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            <span class="font-bold text-slate-700"><?php echo htmlspecialchars($testimonial['t_review']); ?> Rating</span>
                        </div>
                        <p class="text-gray-500 text-sm mt-2">
                            Submitted on: <?php echo date('F j, Y, g:i a', strtotime($testimonial['created_at'])); ?>
                        </p>
                    </div>

                    <div class="prose max-w-none text-gray-700">
                        <h3 class="text-xl font-bold font-lora mb-3">Testimonial:</h3>
                        <p style="white-space: pre-wrap;"><?php echo ($testimonial['t_des']); ?></p>
                    </div>



                    <div class="border-t pt-5 text-right">
                        <a href="edit-testimonial.php?id=<?php echo $testimonial['id']; ?>" class="inline-flex items-center justify-center bg-primary-start text-white px-6 py-2 rounded-lg shadow-md hover:bg-primary-end transition-colors duration-300 font-semibold">
                            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                            </svg>
                            <span> Edit Testimonial</span>
                        </a>
                    </div>

                </div>

            </div>
        </main>
    </div>
    <!-- bottom menu -->
    <?php include('bottom.php') ?>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="main.js"></script>
</body>

</html>