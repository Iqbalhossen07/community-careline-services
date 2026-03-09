<?php
include('db.php'); // ডেটাবেস কানেকশন

// সেশন চেক এবং বর্তমান অ্যাডমিনের ডেটা আনা
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

$session_email = $_SESSION['email'];
$upload_folder = 'uploads/admin_images/';
$pageTitle = 'Manage My Profile';

// ডেটাবেস থেকে বর্তমান অ্যাডমিনের তথ্য আনা
$stmt = $mysqli->prepare("SELECT * FROM admin_login WHERE email = ?");
$stmt->bind_param("s", $session_email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    session_destroy();
    header('Location: login.php');
    exit();
}

// ভেরিয়েবল সেট করা
$current_name = $user['name'];
$current_email = $user['email'];
$current_image_name = $user['image'];
$current_picture = (!empty($current_image_name)) ? $upload_folder . $current_image_name : 'https://i.pravatar.cc/150?img=3';
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

            <?php if (isset($_SESSION['message']) && $_SESSION['message'] != ''): ?>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: "<?php echo $_SESSION['message']; ?>",
                            icon: "<?php echo $_SESSION['message_type']; ?>",
                            confirmButtonColor: '#44afe4',
                            confirmButtonText: "OK"
                        });
                    });
                </script>
                <?php unset($_SESSION['message']);
                unset($_SESSION['message_type']); ?>
            <?php endif; ?>

            <div class="p-8 mb-32 md:mb-0" data-aos="fade-up">
                <div class="flex justify-between items-center mb-8">
                    <h1 class="text-3xl font-bold font-heading text-gray-800">
                        My Profile <span class="text-primary-start font-normal">(Admin Settings)</span>
                    </h1>
                </div>

                <div class="bg-white rounded-2xl shadow-xl p-6 md:p-10 border border-gray-100">
                    <form action="logics.php" method="POST" enctype="multipart/form-data" class="space-y-8">
                        <input type="hidden" name="old_image" value="<?php echo htmlspecialchars($current_image_name); ?>">

                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">
                            <div class="flex flex-col items-center space-y-4">
                                <h3 class="text-xs font-bold font-heading text-gray-400 uppercase tracking-widest">Current Picture</h3>
                                <div class="relative group">
                                    <img id="image-preview" src="<?php echo $current_picture; ?>" alt="Admin"
                                        class="w-40 h-40 rounded-full object-cover border-4 border-white shadow-2xl transition-transform duration-500 group-hover:scale-105">
                                    <div class="absolute inset-0 rounded-full border-2 border-primary-start/20 animate-pulse"></div>
                                </div>
                            </div>

                            <div class="lg:col-span-2 space-y-4">
                                <label class="block text-sm font-bold text-gray-700 uppercase tracking-widest">Change Profile Picture</label>

                                <div class="relative group">
                                    <input id="file-upload" name="image" type="file" class="hidden" onchange="previewImage(event)">
                                    <label for="file-upload" class="flex flex-col items-center justify-center w-full h-44 border-2 border-dashed border-sky-200 rounded-2xl cursor-pointer bg-sky-50/30 hover:bg-sky-50 hover:border-primary-start transition-all duration-300">
                                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                            <div class="mb-3 p-3 bg-white rounded-full shadow-sm text-primary-start group-hover:scale-110 transition-transform duration-300">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                </svg>
                                            </div>
                                            <p class="mb-1 text-sm text-gray-600 font-nav">
                                                <span class="font-bold text-primary-start">Upload a file</span> or drag and drop
                                            </p>
                                            <p class="text-xs text-gray-400">PNG, JPG up to 2MB</p>
                                            <p id="file-name" class="mt-2 text-xs font-bold text-green-600 hidden"></p>
                                        </div>
                                    </label>
                                </div>
                                <p class="text-[11px] text-gray-400 italic flex items-center">
                                    <i class="fa-solid fa-circle-info mr-1 text-primary-start"></i>
                                    Leave blank to keep the current picture.
                                </p>
                            </div>
                        </div>

                        <hr class="border-gray-50">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label class="block text-sm font-bold text-gray-700 uppercase tracking-widest">Full Name</label>
                                <input type="text" name="full_name" value="<?php echo htmlspecialchars($current_name); ?>"
                                    class="w-full px-5 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary-start/20 focus:border-primary-start outline-none transition-all font-body" required>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-bold text-gray-700 uppercase tracking-widest">Email Address</label>
                                <input type="email" name="email" value="<?php echo htmlspecialchars($current_email); ?>"
                                    class="w-full px-5 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary-start/20 focus:border-primary-start outline-none transition-all font-body" required>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-bold text-gray-700 uppercase tracking-widest">Old Password</label>
                                <input type="password" name="old_password" placeholder="••••••••"
                                    class="w-full px-5 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary-start/20 focus:border-primary-start outline-none transition-all font-body">
                                <p class="text-[10px] text-gray-400 italic">Required only if changing password.</p>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-bold text-gray-700 uppercase tracking-widest">New Password</label>
                                <input type="password" name="new_password" placeholder="New Password"
                                    class="w-full px-5 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary-start/20 focus:border-primary-start outline-none transition-all font-body">
                            </div>

                            <div class="md:col-span-2 space-y-2">
                                <label class="block text-sm font-bold text-gray-700 uppercase tracking-widest">Confirm New Password</label>
                                <input type="password" name="confirm_password" placeholder="Confirm New Password"
                                    class="w-full px-5 py-3 rounded-xl border border-gray-200 focus:ring-2 focus:ring-primary-start/20 focus:border-primary-start outline-none transition-all font-body">
                            </div>
                        </div>

                        <div class="flex justify-end pt-4">
                            <button type="submit" name="update_profile"
                                class="bg-gradient-to-r from-primary-start to-primary-end text-white px-10 py-4 rounded-xl font-heading shadow-lg shadow-primary-start/30 hover:shadow-primary-start/50 hover:-translate-y-1 transition-all duration-300 uppercase tracking-widest text-sm">
                                Update Profile
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

    <script>
        // ইমেজ প্রিভিউ এবং ফাইল নাম দেখানোর ফাংশন
        function previewImage(event) {
            const preview = document.getElementById('image-preview');
            const fileNameDisplay = document.getElementById('file-name');
            const file = event.target.files[0];

            if (file) {
                fileNameDisplay.textContent = "Selected: " + file.name;
                fileNameDisplay.classList.remove('hidden');

                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.add('animate-fade-in');
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>

</html>