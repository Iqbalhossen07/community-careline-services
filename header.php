<?php
// বর্তমানে কোন ফাইলে আছি সেটা বের করার লজিক
$current_page = basename($_SERVER['PHP_SELF']);
?>
<div class="fixed w-full top-4 md:top-6 z-50 px-4 md:px-8 flex justify-center pointer-events-none">
    <header
        class="w-full max-w-7xl bg-white/90 backdrop-blur-lg border border-white/60 shadow-[0_15px_40px_-10px_rgba(0,0,0,0.1)] rounded-2xl pointer-events-auto transition-all duration-300">
        <div class="px-5 sm:px-8">
            <div class="flex justify-between items-center h-20 md:h-20">

                <a href="index.php" class="group inline-flex items-center py-2">
                    <div class="w-44 md:w-56 h-auto overflow-hidden">
                        <img src="img/logo.png" alt="Community Careline Services (Bexley) Ltd"
                            class="w-full h-full object-contain filter drop-shadow-sm ">
                    </div>
                </a>

                <nav class="hidden md:flex space-x-8 items-center">
                    <a href="index.php"
                        class="<?php echo ($current_page == 'index.php') ? 'text-brand font-bold' : 'text-gray-800 font-medium hover:text-brand'; ?> transition-all duration-200 py-1">Home</a>

                    <a href="about.php"
                        class="<?php echo ($current_page == 'about.php') ? 'text-brand font-bold' : 'text-gray-800 font-medium hover:text-brand'; ?> transition-all duration-200 py-1">About
                        Us</a>

                    <a href="services.php"
                        class="<?php echo ($current_page == 'services.php' || $current_page == 'service-details.php') ? 'text-brand font-bold' : 'text-gray-800 font-medium hover:text-brand'; ?> transition-all duration-200 py-1">Services</a>

                    <a href="careers.php"
                        class="<?php echo ($current_page == 'careers.php' || $current_page == 'career-details.php') ? 'text-brand font-bold' : 'text-gray-800 font-medium hover:text-brand'; ?> transition-all duration-200 py-1">Careers</a>

                    <a href="blogs.php"
                        class="<?php echo ($current_page == 'blogs.php' || $current_page == 'blog-details.php') ? 'text-brand font-bold' : 'text-gray-800 font-medium hover:text-brand'; ?> transition-all duration-200 py-1">Blogs</a>

                    <a href="contact.php"
                        class="bg-brand text-white px-7 py-3 rounded-xl font-bold hover:bg-brandDark shadow-lg shadow-black/20 hover:shadow-xl hover:shadow-black/30 transition-all duration-300 transform hover:-translate-y-1">
                        Contact Us
                    </a>
                </nav>

                <div class="md:hidden flex items-center">
                    <button id="mobile-menu-btn"
                        class="text-gray-800 hover:text-brand focus:outline-none p-2 bg-gray-50 rounded-lg">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path id="menu-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div id="mobile-menu"
            class="hidden md:hidden bg-white/95 backdrop-blur-md border-t border-gray-100 absolute w-full rounded-b-[2rem] shadow-2xl overflow-hidden left-0 top-full mt-1">
            <div class="px-5 pt-4 pb-6 space-y-2">

                <a href="index.php"
                    class="block px-4 py-3 text-base font-medium <?php echo ($current_page == 'index.php') ? 'text-brand bg-brand/10 font-bold' : 'text-gray-800 hover:text-brand hover:bg-gray-50'; ?> rounded-xl transition-colors">Home</a>

                <a href="about.php"
                    class="block px-4 py-3 text-base font-medium <?php echo ($current_page == 'about.php') ? 'text-brand bg-brand/10 font-bold' : 'text-gray-800 hover:text-brand hover:bg-gray-50'; ?> rounded-xl transition-colors">About
                    Us</a>

                <a href="services.php"
                    class="block px-4 py-3 text-base font-medium <?php echo ($current_page == 'services.php' || $current_page == 'service-details.php') ? 'text-brand bg-brand/10 font-bold' : 'text-gray-800 hover:text-brand hover:bg-gray-50'; ?> rounded-xl transition-colors">Services</a>

                <a href="careers.php"
                    class="block px-4 py-3 text-base font-medium <?php echo ($current_page == 'careers.php' || $current_page == 'career-details.php') ? 'text-brand bg-brand/10 font-bold' : 'text-gray-800 hover:text-brand hover:bg-gray-50'; ?> rounded-xl transition-colors">Careers</a>

                <a href="blogs.php"
                    class="block px-4 py-3 text-base font-medium <?php echo ($current_page == 'blogs.php' || $current_page == 'blog-details.php') ? 'text-brand bg-brand/10 font-bold' : 'text-gray-800 hover:text-brand hover:bg-gray-50'; ?> rounded-xl transition-colors">Blogs</a>

                <a href="contact.php"
                    class="block px-4 py-3 mt-4 text-base font-bold text-white bg-brand text-center rounded-xl shadow-lg shadow-black/20 hover:shadow-xl hover:shadow-black/30 hover:bg-brandDark transition-all duration-300">
                    Contact Us
                </a>

            </div>
        </div>
    </header>
</div>