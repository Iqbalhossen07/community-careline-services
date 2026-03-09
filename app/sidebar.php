<?php
// PHP LOGIC: Identify the active page for navigation highlighting
$active_page = basename($_SERVER['PHP_SELF']);

// Group child pages to highlight the parent menu item
if ($active_page == 'add-blog.php' || $active_page == 'edit-blog.php' || $active_page == 'view-blog.php') {
    $active_page = 'blogs.php';
}
if ($active_page == 'add-career.php' || $active_page == 'edit-career.php' || $active_page == 'view-career.php') {
    $active_page = 'careers.php';
}
if ($active_page == 'add-service.php' || $active_page == 'edit-service.php' || $active_page == 'view-service.php' || $active_page == 'manage-categories.php') {
    $active_page = 'services.php';
}
if ($active_page == 'add-portfolio.php' || $active_page == 'edit-portfolio.php' || $active_page == 'view-portfolio.php') {
    $active_page = 'portfolio.php';
}
if ($active_page == 'add-event.php' || $active_page == 'edit-event.php' || $active_page == 'view-event.php') {
    $active_page = 'events.php';
}
if ($active_page == 'add-member.php' || $active_page == 'edit-member.php' || $active_page == 'view-member.php') {
    $active_page = 'members.php';
}
if ($active_page == 'add-social.php' || $active_page == 'edit-social.php') {
    $active_page = 'manage-social.php';
}
if ($active_page == 'add-social.php' || $active_page == 'edit-social.php') {
    $active_page = 'manage-social.php';
}
if ($active_page == 'privacy_view.php') {
    $active_page = 'manage_privacy.php';
}
if ($active_page == 'terms_view.php') {
    $active_page = 'manage_terms.php';
}

$is_about_active = ($active_page == 'home-about-content.php' || $active_page == 'about-content.php');
?>

<aside id="sidebar"
    class="w-full lg:w-72 bg-sidebar-bg text-gray-800 flex-shrink-0 shadow-lg fixed lg:relative h-screen overflow-y-auto z-[100] transform -translate-x-full lg:translate-x-0 transition-transform duration-300 no-scrollbar font-nav">

    <button id="sidebar-close"
        class="absolute top-5 right-5 lg:hidden w-10 h-10 bg-rose-50 border-2 border-rose-100 text-rose-500 rounded-full flex items-center justify-center shadow-lg active:scale-90 transition-all duration-200">
        <i class="fa-solid fa-xmark text-xl"></i>
    </button>

    <div class="text-center mb-10 mt-8 lg:mt-0">
        <div class="flex items-center justify-center mb-6">
            <a href="index.php"><img src="../img/logo.png" alt="Logo" class="w-auto h-16 mt-2 "></a>
        </div>
    </div>

    <nav class="space-y-2 p-6 pt-0 h-full overflow-y-auto no-scrollbar">
        <div class="font-heading text-xs text-gray-400 uppercase font-bold mb-2 tracking-widest">CORE</div>
        <ul>
            <li class="mb-2">
                <a href="index.php" class="font-nav flex items-center p-3 rounded-lg transition-colors font-semibold
                    <?php echo ($active_page == 'index.php') ? 'border-l-4 border-primary-end bg-sky-100 text-primary-end' : 'text-gray-700 hover:bg-gray-100'; ?>
                ">
                    <i class="fa-solid fa-house w-5 h-5 mr-3"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="mb-2">
                <a href="../index.php" target="_blank"
                    class="font-nav flex items-center p-3 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors">
                    <i class="fa-solid fa-globe w-5 h-5 mr-3 text-primary-end"></i>
                    <span>View Website</span>
                </a>
            </li>
        </ul>

        <div class="font-heading text-xs text-gray-400 uppercase font-bold mt-6 mb-2 tracking-widest">WEBSITE CONTENT
        </div>
        <ul>
            <li class="mb-2">
                <a href="hero-sliders.php" class="font-nav flex items-center p-3 rounded-lg transition-colors
                    <?php echo ($active_page == 'hero-sliders.php') ? 'border-l-4 border-primary-end bg-sky-100 text-primary-end font-semibold' : 'text-gray-700 hover:bg-gray-100'; ?>
                ">
                    <i class="fa-solid fa-sliders w-5 h-5 mr-3"></i>
                    <span>Hero Sliders</span>
                </a>
            </li>

            <li class="mb-2">
                <button onclick="toggleAboutMenu()"
                    class="font-nav flex items-center justify-between w-full p-3 rounded-lg transition-colors duration-300
              <?php echo $is_about_active ? 'bg-sky-50 text-primary-end font-semibold' : 'text-gray-700 hover:bg-gray-100'; ?>">

                    <div class="flex items-center">
                        <i class="fa-solid fa-address-card w-5 h-5 mr-3"></i>
                        <span>Manage About</span>
                    </div>

                    <i id="aboutChevron"
                        class="fa-solid fa-chevron-down text-xs transition-transform duration-300 <?php echo $is_about_active ? 'rotate-180' : ''; ?>"></i>
                </button>

                <ul id="aboutSubMenu"
                    class="mt-1 space-y-1 overflow-hidden transition-all duration-300 <?php echo $is_about_active ? '' : 'hidden'; ?>">
                    <li>
                        <a href="home-about-content.php" class="font-nav flex items-center pl-11 pr-3 py-2 rounded-lg text-sm transition-colors
               <?php echo ($active_page == 'home-about-content.php')
                    ? 'text-primary-end font-bold bg-sky-100 border-l-4 border-primary-end'
                    : 'text-gray-600 hover:text-primary-end hover:bg-gray-50'; ?>">
                            <i class="fa-solid fa-home w-4 h-4 mr-2 text-xs opacity-70"></i>
                            <span>Home Section</span>
                        </a>
                    </li>

                    <li>
                        <a href="about-content.php" class="font-nav flex items-center pl-11 pr-3 py-2 rounded-lg text-sm transition-colors
               <?php echo ($active_page == 'about-content.php')
                    ? 'text-primary-end font-bold bg-sky-100 border-l-4 border-primary-end'
                    : 'text-gray-600 hover:text-primary-end hover:bg-gray-50'; ?>">
                            <i class="fa-solid fa-file-alt w-4 h-4 mr-2 text-xs opacity-70"></i>
                            <span>About Page</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="mb-2">
                <a href="services.php" class="font-nav flex items-center p-3 rounded-lg transition-colors
                <?php echo ($active_page == 'services.php') ? 'border-l-4 border-primary-end bg-sky-100 text-primary-end font-semibold' : 'text-gray-700 hover:bg-gray-100'; ?>
                ">
                    <i class="fa-solid fa-hand-holding-heart w-5 h-5 mr-3"></i>
                    <span>Services</span>
                </a>
            </li>
            <li class="mb-2">
                <a href="careers.php" class="font-nav flex items-center p-3 rounded-lg transition-colors
                <?php echo ($active_page == 'careers.php') ? 'border-l-4 border-primary-end bg-sky-100 text-primary-end font-semibold' : 'text-gray-700 hover:bg-gray-100'; ?>
                ">
                    <i class="fa-solid fa-hand-holding-heart w-5 h-5 mr-3"></i>
                    <span>Careers</span>
                </a>
            </li>



            <li class="mb-2">
                <a href="blogs.php" class="font-nav flex items-center p-3 rounded-lg transition-colors
                    <?php echo ($active_page == 'blogs.php') ? 'border-l-4 border-primary-end bg-sky-100 text-primary-end font-semibold' : 'text-gray-700 hover:bg-gray-100'; ?>
                ">
                    <i class="fa-solid fa-newspaper w-5 h-5 mr-3"></i>
                    <span>Blogs</span>
                </a>
            </li>



            <li class="mb-2">
                <a href="contact-messages.php" class="font-nav flex items-center p-3 rounded-lg transition-colors
                    <?php echo ($active_page == 'contact-messages.php') ? 'border-l-4 border-primary-end bg-sky-100 text-primary-end font-semibold' : 'text-gray-700 hover:bg-gray-100'; ?>
                ">
                    <i class="fa-solid fa-envelope w-5 h-5 mr-3"></i>
                    <span>Messages</span>
                </a>
            </li>

            <li class="mb-2">
                <a href="manage_privacy.php" class="font-nav flex items-center p-3 rounded-lg transition-colors
        <?php echo ($active_page == 'manage_privacy.php') ? 'border-l-4 border-primary-end bg-sky-100 text-primary-end font-semibold' : 'text-gray-700 hover:bg-gray-100'; ?>
    ">
                    <i class="fa-solid fa-shield-halved w-5 h-5 mr-3"></i>
                    <span>Manage Privacy</span>
                </a>
            </li>

            <li class="mb-2">
                <a href="manage_terms.php" class="font-nav flex items-center p-3 rounded-lg transition-colors
        <?php echo ($active_page == 'manage_terms.php') ? 'border-l-4 border-primary-end bg-sky-100 text-primary-end font-semibold' : 'text-gray-700 hover:bg-gray-100'; ?>
    ">
                    <i class="fa-solid fa-file-contract w-5 h-5 mr-3"></i>
                    <span>Manage Terms</span>
                </a>
            </li>

            <li class="mb-2">
                <a href="manage-footer.php" class="font-nav flex items-center p-3 rounded-lg transition-colors
        <?php echo ($active_page == 'manage-footer.php') ? 'border-l-4 border-primary-end bg-sky-100 text-primary-end font-semibold' : 'text-gray-700 hover:bg-gray-100'; ?>
    ">
                    <i class="fa-solid fa-align-left w-5 h-5 mr-3"></i>
                    <span>Footer Content</span>
                </a>
            </li>
            <li class="mb-2">
                <a href="manage-social.php" class="font-nav flex items-center p-3 rounded-lg transition-colors
        <?php echo ($active_page == 'manage-social.php') ? 'border-l-4 border-primary-end bg-sky-100 text-primary-end font-semibold' : 'text-gray-700 hover:bg-gray-100'; ?>
    ">
                    <i class="fa-solid fa-share-nodes w-5 h-5 mr-3"></i>
                    <span>Social Media</span>
                </a>
            </li>
        </ul>

        <div class="font-heading text-xs text-gray-400 uppercase font-bold mt-6 mb-2 tracking-widest">SETTINGS</div>
        <ul>
            <li class="mb-2">
                <a href="my-profile.php" class="font-nav flex items-center p-3 rounded-lg transition-colors
                    <?php echo ($active_page == 'my-profile.php') ? 'border-l-4 border-primary-end bg-sky-100 text-primary-end font-semibold' : 'text-gray-700 hover:bg-gray-100'; ?>
                ">
                    <i class="fa-solid fa-user w-5 h-5 mr-3"></i>
                    <span>My Profile</span>
                </a>
            </li>
            <li class="mb-2">
                <a href="contact-info.php" class="font-nav flex items-center p-3 rounded-lg transition-colors
                    <?php echo ($active_page == 'contact-info.php') ? 'border-l-4 border-primary-end bg-sky-100 text-primary-end font-semibold' : 'text-gray-700 hover:bg-gray-100'; ?>
                ">
                    <i class="fa-solid fa-phone w-5 h-5 mr-3"></i>
                    <span>Contact Info</span>
                </a>
            </li>
            <li class="mb-2">
                <a href="logout.php"
                    class="font-nav flex items-center p-3 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors">
                    <i class="fa-solid fa-right-from-bracket w-5 h-5 mr-3"></i>
                    <span>Logout</span>
                </a>
            </li>

        </ul>
    </nav>
</aside>

<script>
function toggleAboutMenu() {
    const menu = document.getElementById("aboutSubMenu");
    const chevron = document.getElementById("aboutChevron");

    if (menu.classList.contains("hidden")) {
        menu.classList.remove("hidden");
        chevron.classList.add("rotate-180");
    } else {
        menu.classList.add("hidden");
        chevron.classList.remove("rotate-180");
    }
}
</script>