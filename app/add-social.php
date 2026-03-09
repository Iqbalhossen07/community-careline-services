<?php
include('db.php'); // ডেটাবেস কানেকশন

// সেশন চেক
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

$pageTitle = 'Add Social Link';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php') ?>
    <title>Add Social Link - Admin Dashboard</title>
</head>

<body class="bg-gray-100 font-body">
    <div class="flex h-screen">

        <?php include('sidebar.php') ?>

        <main class="flex-1 h-full overflow-y-auto">

            <?php include('top.php') ?>

            <div class="p-8 mb-32 md:mb-0">

                <div class="flex justify-between items-center mb-6" data-aos="fade-down">
                    <h1 class="text-3xl font-bold font-heading text-gray-800">
                        Add Social Link
                    </h1>
                    <a href="manage-social.php" class="font-nav flex items-center bg-gray-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-gray-700 transition-colors duration-300 font-semibold uppercase tracking-wider text-xs">
                        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                        </svg>
                        <span>Back to Manage</span>
                    </a>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 md:p-8" data-aos="fade-up">
                    <form action="logics.php" method="POST">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 font-body">

                            <div class="md:col-span-5">
                                <label for="platform_name" class="block text-sm font-semibold text-gray-700 mb-2">Select Platform</label>
                                <select id="platform_name" name="platform_name" required
                                    class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end focus:border-transparent font-body bg-white">
                                    <option value="" disabled selected>Choose a platform...</option>
                                    <option value="WhatsApp">WhatsApp</option>
                                    <option value="Facebook">Facebook</option>
                                    <option value="YouTube">YouTube</option>
                                    <option value="TikTok">TikTok</option>
                                    <option value="Instagram">Instagram</option>
                                    <option value="Telegram">Telegram</option>
                                    <option value="Twitter">Twitter</option>
                                    <option value="LinkedIn">LinkedIn</option>
                                </select>
                            </div>

                            <div class="md:col-span-7">
                                <label for="link" class="block text-sm font-semibold text-gray-700 mb-2">Social Profile URL</label>
                                <input type="url" id="link" name="link"
                                    value="<?php echo isset($social['link']) ? htmlspecialchars($social['link']) : ''; ?>"
                                    class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end focus:border-transparent font-body"
                                    placeholder="https://..." required>
                            </div>


                            <div class="md:col-span-12 mt-4">
                                <div class="bg-white border border-blue-100 p-6 rounded-xl shadow-sm relative overflow-hidden">
                                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-blue-50 rounded-full opacity-50"></div>

                                    <div class="flex items-center mb-6 relative z-10">
                                        <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center shadow-lg shadow-blue-200">
                                            <i class="fas fa-info-circle text-white text-sm"></i>
                                        </div>
                                        <h4 class="ml-3 text-sm font-bold text-gray-800 uppercase tracking-wider font-heading">
                                            Correct Link Format <span class="text-blue-600">(Guideine)</span>
                                        </h4>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 relative z-10">

                                        <div class="border-l-4 border-l-[#25D366] flex items-center p-3 bg-gray-50/80 border border-gray-100 rounded-xl shadow-sm transition-all duration-300 hover:shadow-md hover:bg-[#25D366] group cursor-default">
                                            <div class="w-10 h-10 shrink-0 rounded-full bg-[#25D366] text-white flex items-center justify-center shadow-md transform transition-transform duration-300 group-hover:scale-110">
                                                <i class="fab fa-whatsapp text-lg"></i>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-[12px] font-bold text-gray-700 uppercase group-hover:text-white">WhatsApp</p>
                                                <p class="text-[10px] text-gray-500 break-all group-hover:text-white">https://wa.me/44 7XXX XXXXXX</p>
                                                <span class="text-[9px] text-red-400 italic block group-hover:text-white/90">(Do not include '+' or '-')</span>
                                            </div>
                                        </div>

                                        <div class="border-l-4 border-l-[#1877F2] flex items-center p-3 bg-gray-50/80 border border-gray-100 rounded-xl shadow-sm transition-all duration-300 hover:shadow-md hover:bg-[#1877F2] group cursor-default">
                                            <div class="w-10 h-10 shrink-0 rounded-full bg-[#1877F2] text-white flex items-center justify-center shadow-md transform transition-transform duration-300 group-hover:scale-110">
                                                <i class="fab fa-facebook-f text-lg"></i>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-[12px] font-bold text-gray-700 uppercase group-hover:text-white">Facebook</p>
                                                <p class="text-[10px] text-gray-500 break-all group-hover:text-white">https://facebook.com/yourpage</p>
                                            </div>
                                        </div>

                                        <div class="border-l-4 border-l-[#FF0000] flex items-center p-3 bg-gray-50/80 border border-gray-100 rounded-xl shadow-sm transition-all duration-300 hover:shadow-md hover:bg-[#FF0000] group cursor-default">
                                            <div class="w-10 h-10 shrink-0 rounded-full bg-[#FF0000] text-white flex items-center justify-center shadow-md transform transition-transform duration-300 group-hover:scale-110">
                                                <i class="fab fa-youtube text-lg"></i>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-[12px] font-bold text-gray-700 uppercase group-hover:text-white">YouTube</p>
                                                <p class="text-[10px] text-gray-500 break-all group-hover:text-white">youtube.com/@yourchannel</p>
                                            </div>
                                        </div>

                                        <div class="border-l-4 border-l-[#ee2a7b] flex items-center p-3 bg-gray-50/80 border border-gray-100 rounded-xl shadow-sm transition-all duration-300 hover:shadow-md hover:bg-[#ee2a7b] group cursor-default">
                                            <div class="w-10 h-10 shrink-0 rounded-full bg-gradient-to-tr from-[#f9ce34] via-[#ee2a7b] to-[#6228d7] text-white flex items-center justify-center shadow-md transform transition-transform duration-300 group-hover:scale-110">
                                                <i class="fab fa-instagram text-lg"></i>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-[12px] font-bold text-gray-700 uppercase group-hover:text-white">Instagram</p>
                                                <p class="text-[10px] text-gray-500 break-all group-hover:text-white">instagram.com/yourprofile</p>
                                            </div>
                                        </div>

                                        <div class="border-l-4 border-l-[#0088cc] flex items-center p-3 bg-gray-50/80 border border-gray-100 rounded-xl shadow-sm transition-all duration-300 hover:shadow-md hover:bg-[#0088cc] group cursor-default">
                                            <div class="w-10 h-10 shrink-0 rounded-full bg-[#0088cc] text-white flex items-center justify-center shadow-md transform transition-transform duration-300 group-hover:scale-110">
                                                <i class="fab fa-telegram-plane text-lg"></i>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-[12px] font-bold text-gray-700 uppercase group-hover:text-white">Telegram</p>
                                                <p class="text-[10px] text-gray-500 break-all group-hover:text-white">https://t.me/yourusername</p>
                                            </div>
                                        </div>

                                        <div class="border-l-4 border-l-[#000000] flex items-center p-3 bg-gray-50/80 border border-gray-100 rounded-xl shadow-sm transition-all duration-300 hover:shadow-md hover:bg-[#000000] group cursor-default">
                                            <div class="w-10 h-10 shrink-0 rounded-full bg-[#000000] text-white flex items-center justify-center shadow-md transform transition-transform duration-300 group-hover:scale-110">
                                                <i class="fab fa-tiktok text-lg"></i>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-[12px] font-bold text-gray-700 uppercase group-hover:text-white">TikTok</p>
                                                <p class="text-[10px] text-gray-500 break-all group-hover:text-white">tiktok.com/@yourusername</p>
                                            </div>
                                        </div>

                                        <div class="border-l-4 border-l-[#1DA1F2] flex items-center p-3 bg-gray-50/80 border border-gray-100 rounded-xl shadow-sm transition-all duration-300 hover:shadow-md hover:bg-[#1DA1F2] group cursor-default">
                                            <div class="w-10 h-10 shrink-0 rounded-full bg-[#1DA1F2] text-white flex items-center justify-center shadow-md transform transition-transform duration-300 group-hover:scale-110">
                                                <i class="fab fa-twitter text-lg"></i>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-[12px] font-bold text-gray-700 uppercase group-hover:text-white">Twitter</p>
                                                <p class="text-[10px] text-gray-500 break-all group-hover:text-white">twitter.com/yourusername</p>
                                            </div>
                                        </div>

                                        <div class="border-l-4 border-l-[#0077B5] flex items-center p-3 bg-gray-50/80 border border-gray-100 rounded-xl shadow-sm transition-all duration-300 hover:shadow-md hover:bg-[#0077B5] group cursor-default">
                                            <div class="w-10 h-10 shrink-0 rounded-full bg-[#0077B5] text-white flex items-center justify-center shadow-md transform transition-transform duration-300 group-hover:scale-110">
                                                <i class="fab fa-linkedin-in text-lg"></i>
                                            </div>
                                            <div class="ml-4">
                                                <p class="text-[12px] font-bold text-gray-700 uppercase group-hover:text-white">LinkedIn</p>
                                                <p class="text-[10px] text-gray-500 break-all group-hover:text-white">linkedin.com/in/yourname</p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 text-right">
                            <button type="submit" name="add_social" class="font-nav inline-flex items-center justify-center bg-primary-start text-white px-8 py-3 rounded-lg shadow-md hover:bg-primary-end transition-colors duration-300 font-bold uppercase tracking-widest text-sm">
                                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                <span>Save Social Link</span>
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