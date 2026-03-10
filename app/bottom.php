<footer class="lg:hidden fixed bottom-5 left-0 right-0 z-50 font-nav">
    <div
        class="bg-white/90 backdrop-blur-lg rounded-full shadow-[0_15px_40px_rgba(0,0,0,0.12)] w-[94%] max-w-lg mx-auto p-2 border border-white/60">
        <div class="flex justify-around items-center h-16">

            <?php
            $isActive = ($active_page == 'index.php');
            $circleSize = $isActive ? 'w-13 h-13 border-[3px] scale-110 shadow-lg' : 'w-10 h-10 border-2';
            $bgClass = $isActive ? 'bg-rose-500 shadow-rose-200' : 'bg-rose-50';
            $iconClass = $isActive ? 'text-white text-xl' : 'text-rose-500 text-lg';
            ?>
            <a href="index.php" class="flex flex-col items-center justify-center transition-all duration-300">
                <div
                    class="flex items-center justify-center rounded-full transition-all duration-300 border-white <?php echo $circleSize . ' ' . $bgClass; ?>">
                    <i class="fa-solid fa-house <?php echo $iconClass; ?>"></i>
                </div>
                <span
                    class="text-[9px] mt-1 font-bold <?php echo $isActive ? 'text-rose-600' : 'text-gray-400'; ?>">Dash</span>
            </a>

            <?php
            $portfolio_pages = ['testimonials.php', 'add-testimonial.php', 'edit-testimonial.php', 'view-testimonial.php'];
            $isActive = in_array($active_page, $portfolio_pages);
            $circleSize = $isActive ? 'w-13 h-13 border-[3px] scale-110 shadow-lg' : 'w-10 h-10 border-2';
            $bgClass = $isActive ? 'bg-emerald-500 shadow-emerald-200' : 'bg-emerald-50';
            $iconClass = $isActive ? 'text-white text-xl' : 'text-emerald-500 text-lg';
            ?>
            <a href="testimonials.php" class="flex flex-col items-center justify-center transition-all duration-300">
                <div
                    class="flex items-center justify-center rounded-full transition-all duration-300 border-white <?php echo $circleSize . ' ' . $bgClass; ?>">
                    <i class="fa-solid fa-comment-dots <?php echo $iconClass; ?>"></i>
                </div>
                <span
                    class="text-[9px] mt-1 font-bold <?php echo $isActive ? 'text-emerald-600' : 'text-gray-400'; ?>">Testimonials</span>
            </a>

            <?php
            $blogs_pages = ['blogs.php', 'add-blog.php', 'edit-blog.php'];
            $isActive = in_array($active_page, $blogs_pages);
            $circleSize = $isActive ? 'w-13 h-13 border-[3px] scale-110 shadow-lg' : 'w-10 h-10 border-2';
            $bgClass = $isActive ? 'bg-sky-500 shadow-sky-200' : 'bg-sky-50';
            $iconClass = $isActive ? 'text-white text-xl' : 'text-sky-500 text-lg';
            ?>
            <a href="blogs.php" class="flex flex-col items-center justify-center transition-all duration-300">
                <div
                    class="flex items-center justify-center rounded-full transition-all duration-300 border-white <?php echo $circleSize . ' ' . $bgClass; ?>">
                    <i class="fa-solid fa-newspaper <?php echo $iconClass; ?>"></i>
                </div>
                <span
                    class="text-[9px] mt-1 font-bold <?php echo $isActive ? 'text-sky-600' : 'text-gray-400'; ?>">Blog</span>
            </a>

            <?php
            $isActive = ($active_page == 'contact-messages.php');
            $circleSize = $isActive ? 'w-13 h-13 border-[3px] scale-110 shadow-lg' : 'w-10 h-10 border-2';
            $bgClass = $isActive ? 'bg-indigo-500 shadow-indigo-200' : 'bg-indigo-50';
            $iconClass = $isActive ? 'text-white text-xl' : 'text-indigo-500 text-lg';
            ?>
            <a href="contact-messages.php"
                class="flex flex-col items-center justify-center transition-all duration-300">
                <div
                    class="flex items-center justify-center rounded-full transition-all duration-300 border-white <?php echo $circleSize . ' ' . $bgClass; ?>">
                    <i class="fa-solid fa-envelope <?php echo $iconClass; ?>"></i>
                </div>
                <span
                    class="text-[9px] mt-1 font-bold <?php echo $isActive ? 'text-indigo-600' : 'text-gray-400'; ?>">Message</span>
            </a>

            <button id="mobile-menu-open" class="flex flex-col items-center justify-center transition-all duration-300">
                <div
                    class="w-10 h-10 bg-amber-50 border-2 border-white flex items-center justify-center rounded-full transition-all duration-300 hover:bg-amber-500 hover:text-white">
                    <i class="fa-solid fa-bars text-amber-500 text-lg"></i>
                </div>
                <span class="text-[9px] mt-1 font-bold text-gray-400">Menu</span>
            </button>

        </div>
    </div>
</footer>

<style>
/* কাস্টম শ্যাডো এবং সাইজ */
.w-13 {
    width: 52px;
    height: 52px;
}

.shadow-rose-200 {
    box-shadow: 0 8px 20px rgba(244, 63, 94, 0.3);
}

.shadow-emerald-200 {
    box-shadow: 0 8px 20px rgba(16, 185, 129, 0.3);
}

.shadow-sky-200 {
    box-shadow: 0 8px 20px rgba(14, 165, 233, 0.3);
}

.shadow-indigo-200 {
    box-shadow: 0 8px 20px rgba(99, 102, 241, 0.3);
}
</style>