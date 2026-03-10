<?php include('head.php') ?>

<body class="font-body text-gray-600 antialiased bg-white">
    <!-- header section  -->
    <?php include('header.php') ?>

    <!-- breadcrumb section -->
    <section class="relative h-[350px] flex items-center overflow-hidden bg-darkText">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1499750310107-5fef28a66643?auto=format&fit=crop&w=1500&q=80"
                class="w-full h-full object-cover opacity-30" alt="Careline Blog">
            <div class="absolute inset-0 bg-gradient-to-r from-darkText via-darkText/90 to-transparent"></div>
        </div>

        <div class="max-w-7xl mx-auto px-6 lg:px-12 relative z-10 w-full mt-20">
            <nav class="flex mb-4 text-sm font-medium">
                <ol class="inline-flex items-center space-x-2">
                    <li><a href="index.php" class="text-gray-400 hover:text-brand transition-colors">Home</a></li>
                    <li class="text-gray-600">/</li>
                    <li class="text-brand font-bold uppercase tracking-widest text-[11px] md:text-sm">Blogs & News</li>
                </ol>
            </nav>
            <h1 class="font-heading text-2xl md:text-4xl font-bold text-white mb-2 tracking-tight">Expert Care Insights
            </h1>
            <p class="text-gray-300 text-lg max-w-2xl">Read our latest articles about health, home care, and wellbeing.
            </p>
        </div>
    </section>

    <!-- blog section -->
    <section class="py-20 bg-lightBg">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">

            <?php
            // ১. সব ব্লগ পোস্ট নিয়ে আসা
            $blog_query = "SELECT * FROM blogs ORDER BY id DESC";
            $blog_result = $mysqli->query($blog_query);
            $blogs = $blog_result->fetch_all(MYSQLI_ASSOC);

            // ২. ফিল্টার বাটনের জন্য ইউনিক ক্যাটাগরিগুলো বের করা
            $cat_query = "SELECT DISTINCT category FROM blogs";
            $cat_result = $mysqli->query($cat_query);
            ?>

            <div class="mb-12 flex flex-wrap items-center justify-between gap-6">
                <div class="flex flex-wrap gap-3" id="blog-filters">
                    <button data-filter="all"
                        class="filter-btn active px-6 py-2.5 rounded-full text-sm font-bold transition-all border border-brand bg-brand text-white shadow-lg shadow-brand/20">
                        All Posts
                    </button>

                    <?php while ($cat_row = $cat_result->fetch_assoc()):
                        $cat_name = $cat_row['category'];
                        $cat_slug = strtolower(str_replace(' ', '-', $cat_name)); // ক্যাটাগরি নামকে স্লাগ বানানো (Health Tips -> health-tips)
                    ?>
                    <button data-filter="<?php echo $cat_slug; ?>"
                        class="filter-btn px-6 py-2.5 rounded-full text-sm font-bold transition-all border border-gray-200 bg-white text-darkText hover:border-brand/50 shadow-sm">
                        <?php echo $cat_name; ?>
                    </button>
                    <?php endwhile; ?>
                </div>

                <p class="text-sm font-medium text-gray-400 uppercase tracking-widest">
                    Showing <span id="post-count" class="text-brand"><?php echo count($blogs); ?></span> Articles
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10" id="blog-container">
                <?php if (!empty($blogs)): ?>
                <?php foreach ($blogs as $blog):
                        $b_cat_slug = strtolower(str_replace(' ', '-', $blog['category']));
                        $b_images = explode(',', $blog['image']);
                        $b_main_img = trim($b_images[0]);
                        $b_date = date('M d, Y', strtotime($blog['created_at']));
                    ?>
                <article
                    class="blog-card group bg-white rounded-md border border-gray-100 shadow-md shadow-black/5 hover:shadow-xl hover:shadow-black/10 transition-all duration-300 flex flex-col overflow-hidden"
                    data-category="<?php echo $b_cat_slug; ?>">

                    <div
                        class="relative h-60 overflow-hidden border-[6px] border-white ring-1 ring-black/5 m-1 rounded-sm">
                        <img src="app/uploads/blog_images/<?php echo htmlspecialchars($b_main_img); ?>"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <span
                            class="absolute top-4 left-4 bg-brand text-white text-[10px] font-bold px-3 py-1 rounded-sm uppercase tracking-tighter">
                            <?php echo htmlspecialchars($blog['category']); ?>
                        </span>
                    </div>

                    <div class="p-6 flex flex-col flex-1">
                        <div class="flex flex-wrap items-center gap-6 mb-2">
                            <div class="text-gray-500 text-sm flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-lightBg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" stroke-width="2">
                                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                        <line x1="16" y1="2" x2="16" y2="6"></line>
                                        <line x1="8" y1="2" x2="8" y2="6"></line>
                                        <line x1="3" y1="10" x2="21" y2="10"></line>
                                    </svg>
                                </div>
                                <span class="font-medium text-darkText tracking-tight"><?php echo $b_date; ?></span>
                            </div>
                            <div class="text-gray-500 text-sm flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-lightBg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <span
                                    class="font-medium text-darkText"><?php echo htmlspecialchars($blog['author_name']); ?></span>
                            </div>
                        </div>

                        <h3
                            class="font-heading text-xl font-bold text-darkText mb-3 group-hover:text-brand transition-colors line-clamp-2 uppercase tracking-tight">
                            <?php echo htmlspecialchars($blog['name']); ?>
                        </h3>

                        <p class="text-gray-500 text-sm mb-6 line-clamp-3">
                            <?php echo strip_tags($blog['description']); ?>
                        </p>

                        <a href="blog-details.php?id=<?php echo $blog['id']; ?>"
                            class="mt-auto self-start inline-flex items-center justify-center px-5 py-2.5 border border-transparent text-sm font-bold rounded-md text-white bg-brand hover:bg-brandDark shadow-md shadow-black/20 hover:shadow-lg hover:shadow-black/30 transition-all duration-300 transform hover:-translate-y-1 group/btn">
                            Read Article
                            <span
                                class="ml-2 transform group-hover/btn:translate-x-1 transition-transform">&rarr;</span>
                        </a>
                    </div>
                </article>
                <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- cta section -->
    <?php include('cta.php') ?>

    <!-- footer section -->
    <?php include('footer.php') ?>

    <!-- js section -->
    <script src="main.js"></script>
</body>

</html>