<?php
include('db.php'); // ডেটাবেস কানেকশন

// সেশন চেক
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}
$pageTitle = 'Manage Contact Info';

// --- 1. Contact Details (Phone & Email) ---
$contact_query = $mysqli->query("SELECT * FROM contact_details WHERE id = 1 LIMIT 1");
$current_data = ($contact_query && $contact_query->num_rows > 0) ? $contact_query->fetch_assoc() : [];
$current_phone = $current_data['phone'] ?? '+880 170 000 0000';
$current_email = $current_data['email'] ?? 'info@example.com';
$current_location = $current_data['location'] ?? 'England';


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php') ?>
    <title>Manage Contact Info - Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
</head>

<body class="bg-gray-100 font-body"> <div class="flex h-screen">

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
                            confirmButtonText: "OK"
                        });
                    });
                </script>
            <?php
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
            }
            ?>
            
            <div class="p-8 mb-32 md:mb-0 ">

                <div class="flex justify-between items-center mb-6" data-aos="fade-down">
                    <h1 class="text-3xl font-bold font-heading text-gray-800">
                        Manage Contact Information 
                    </h1>
                </div>

                <div class="border-card bg-white rounded-xl shadow-lg p-6 md:p-8 mb-8" data-aos="fade-up">
                    <h2 class="text-xl font-bold font-heading text-gray-800 border-b pb-3 mb-6">General Information</h2>
                    
                    <form action="logics.php" method="POST">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 font-body">
                            <div>
                                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2 uppercase tracking-wider">Phone Number</label>
                                <input type="text" id="phone" name="phone" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end font-body" value="<?php echo htmlspecialchars($current_phone); ?>" required>
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2 uppercase tracking-wider">Email Address</label>
                                <input type="email" id="email" name="email" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end font-body" value="<?php echo htmlspecialchars($current_email); ?>" required>
                            </div>
                            <div>
                                <label for="location" class="block text-sm font-semibold text-gray-700 mb-2 uppercase tracking-wider">Location</label>
                                <input type="text" id="location" name="location" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end font-body" value="<?php echo htmlspecialchars($current_location); ?>" required>
                            </div>
                        </div>
                        
                        <div class="text-right mt-6">
                            <button type="submit" name="update_general_info" class="font-nav bg-primary-start text-white px-6 py-2 rounded-lg shadow-md hover:bg-primary-end transition-all font-bold uppercase tracking-widest text-xs">
                                Save Changes
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