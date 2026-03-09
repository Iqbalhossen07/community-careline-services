<?php
// আগের PHP লজিক ঠিক থাকবে
$email = $_SESSION['email'];
$admin_result = $mysqli->query("SELECT * FROM admin_login WHERE email='$email' ");
if (!empty($admin_result)) {
    $row = $admin_result->fetch_array();
    $admin_photo = $row['image'];
    $admin_name = $row['name'];
    $id = $row['id'];
}
?>

<header class="flex justify-between items-center p-6 bg-white shadow-md font-body sticky top-0 z-40">
    <div class="flex items-center">
        <h1 class="text-2xl font-bold font-heading text-gray-800 hidden lg:block">Welcome To Careline Admin Panel</h1>

        <div class="lg:hidden">
            <a href="index.php"><img src="../img/logo.png" alt="Logo" class="w-auto h-12"></a>
        </div>
    </div>

    <div class="relative flex items-center space-x-4">
        <div class="hidden md:block text-right">
            <p class="text-sm font-bold text-gray-800 leading-none"><?php echo $admin_name; ?></p>
        </div>

        <button id="admin-dropdown-trigger" class="relative group focus:outline-none">
            <img
                src="uploads/admin_images/<?php echo $admin_photo ?>"
                alt="Admin Profile"
                class="w-10 h-10 rounded-full border-2 border-primary-end shadow-sm group-hover:shadow-md transition-all duration-300">
            <span class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"></span>
        </button>

        <div id="admin-dropdown-menu" class="hidden absolute right-0 top-14 w-56 bg-white rounded-2xl shadow-[0_10px_40px_rgba(0,0,0,0.12)] border border-gray-100 py-3 animate-fade-in z-50">
            <div class="px-4 py-2 border-b border-gray-50 mb-2">
                <p class="text-xs text-gray-400 font-semibold uppercase tracking-tighter">Account Settings</p>
            </div>

            <a href="my-profile.php" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-sky-50 hover:text-primary-end transition-colors">
                <i class="fa-solid fa-user-circle w-5 mr-3 opacity-70"></i>
                My Profile
            </a>

            <a href="contact-info.php" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-sky-50 hover:text-primary-end transition-colors">
                <i class="fa-solid fa-gear w-5 mr-3 opacity-70"></i>
                Settings
            </a>

            <div class="my-2 border-t border-gray-50"></div>

            <a href="logout.php" class="flex items-center px-4 py-2 text-sm text-rose-500 hover:bg-rose-50 transition-colors font-bold">
                <i class="fa-solid fa-right-from-bracket w-5 mr-3"></i>
                Logout Account
            </a>
        </div>
    </div>
</header>