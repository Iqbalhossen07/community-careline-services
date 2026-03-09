<?php
include('db.php'); // ডেটাবেস কানেকশন

// সেশন চেক
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}
$pageTitle = 'Manage Footer Content';

// বর্তমান ফুটার টেক্সট আনা
$query = "SELECT footer_description FROM footer_settings WHERE id = 1 LIMIT 1";
$result = $mysqli->query($query);
$data = ($result && $result->num_rows > 0) ? $result->fetch_assoc() : [];
$current_text = $data['footer_description'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php') ?>
    <title>Manage Footer - Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
</head>

<body class="bg-gray-100 font-body"> 
    <div class="flex h-screen">

        <?php include('sidebar.php') ?>

        <main class="flex-1 h-full overflow-y-auto">

            <?php include('top.php') ?>
            
            <?php if (isset($_SESSION['message'])): ?>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: "<?php echo $_SESSION['message']; ?>",
                            icon: "<?php echo $_SESSION['message_type']; ?>",
                            confirmButtonText: "OK"
                        });
                    });
                </script>
            <?php unset($_SESSION['message']); unset($_SESSION['message_type']); endif; ?>
            
            <div class="md:p-8 mb-32 md:mb-0">
                <div class="flex justify-between items-center mb-6" data-aos="fade-down">
                    <h1 class="text-3xl font-bold font-heading text-gray-800">
                        Manage Footer Information
                    </h1>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 md:p-8" data-aos="fade-up">
                    <h2 class="text-xl font-bold font-heading text-gray-800 border-b pb-3 mb-6">
                        <i class="fa-solid fa-paragraph mr-2 text-primary-end"></i> Footer Description
                    </h2>
                    
                    <form action="logics.php" method="POST">
                        <div class="font-body">
                            <label for="footer_text" class="block text-sm font-semibold text-gray-700 mb-2 uppercase tracking-wider">About Studio Text</label>
                            <textarea id="footer_text" name="footer_description" rows="5" 
                                class="w-full px-4 py-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end font-body leading-relaxed" 
                                placeholder="Write the footer text here..." required><?php echo htmlspecialchars($current_text); ?></textarea>
                            <p class="text-xs text-gray-400 mt-2 italic">This text will appear in the main footer area of the website.</p>
                        </div>
                        
                        <div class="text-right mt-6">
                            <button type="submit" name="update_footer_text" class="font-nav bg-primary-start text-white px-8 py-3 rounded-lg shadow-md hover:bg-primary-end transition-all font-bold uppercase tracking-widest text-xs">
                                <i class="fa-solid fa-save mr-2"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <?php include('bottom.php') ?>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="main.js"></script>
</body>
</html>