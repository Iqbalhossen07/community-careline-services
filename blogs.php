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

            <div class="mb-12 flex flex-wrap items-center justify-between gap-6">
                <div class="flex flex-wrap gap-3" id="blog-filters">
                    <button data-filter="all"
                        class="filter-btn active px-6 py-2.5 rounded-full text-sm font-bold transition-all border border-brand bg-brand text-white shadow-lg shadow-brand/20">All
                        Posts</button>
                    <button data-filter="health"
                        class="filter-btn px-6 py-2.5 rounded-full text-sm font-bold transition-all border border-gray-200 bg-white text-darkText hover:border-brand/50 shadow-sm">Health
                        Tips</button>
                    <button data-filter="lifestyle"
                        class="filter-btn px-6 py-2.5 rounded-full text-sm font-bold transition-all border border-gray-200 bg-white text-darkText hover:border-brand/50 shadow-sm">Lifestyle</button>
                    <button data-filter="company"
                        class="filter-btn px-6 py-2.5 rounded-full text-sm font-bold transition-all border border-gray-200 bg-white text-darkText hover:border-brand/50 shadow-sm">Company
                        News</button>
                </div>

                <p class="text-sm font-medium text-gray-400 uppercase tracking-widest">Showing <span id="post-count"
                        class="text-brand">6</span> Articles</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10" id="blog-container">

                <article
                    class="blog-card group bg-white rounded-md border border-gray-100 shadow-md shadow-black/5 hover:shadow-xl hover:shadow-black/10 transition-all duration-300 flex flex-col overflow-hidden"
                    data-category="health">
                    <div
                        class="relative h-60 overflow-hidden border-[6px] border-white ring-1 ring-black/5 m-1 rounded-sm">
                        <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?auto=format&fit=crop&w=800&q=80"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <span
                            class="absolute top-4 left-4 bg-brand text-white text-[10px] font-bold px-3 py-1 rounded-sm uppercase tracking-tighter">Health</span>
                    </div>
                    <div class="p-6 flex flex-col flex-1">
                        <div class="flex flex-wrap items-center gap-6 mb-2  ">

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
                                <span class="font-medium text-darkText tracking-tight">Feb 28, 2026</span>
                            </div>
                            <div class="text-gray-500 text-sm flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-lightBg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <span class="font-medium text-darkText">Admin</span>
                            </div>
                        </div>
                        <h3
                            class="font-heading text-xl font-bold text-darkText mb-3 group-hover:text-brand transition-colors line-clamp-2 uppercase tracking-tight">
                            How to Maintain Mental Wellbeing in Old Age</h3>
                        <p class="text-gray-500 text-sm mb-6 line-clamp-3">Mental health is just as important as
                            physical health, especially for seniors living independently...</p>

                        <a href="blog-details.php"
                            class="mt-auto self-start inline-flex items-center justify-center px-5 py-2.5 border border-transparent text-sm font-bold rounded-md text-white bg-brand hover:bg-brandDark shadow-md shadow-black/20 hover:shadow-lg hover:shadow-black/30 transition-all duration-300 transform hover:-translate-y-1 group/btn">
                            Read Article
                            <span
                                class="ml-2 transform group-hover/btn:translate-x-1 transition-transform">&rarr;</span>
                        </a>
                    </div>
                </article>

                <article
                    class="blog-card group bg-white rounded-md border border-gray-100 shadow-md shadow-black/5 hover:shadow-xl hover:shadow-black/10 transition-all duration-300 flex flex-col overflow-hidden"
                    data-category="lifestyle">
                    <div
                        class="relative h-60 overflow-hidden border-[6px] border-white ring-1 ring-black/5 m-1 rounded-sm">
                        <img src="https://images.unsplash.com/photo-1516733725897-1aa73b87c8e8?auto=format&fit=crop&w=800&q=80"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <span
                            class="absolute top-4 left-4 bg-brand text-white text-[10px] font-bold px-3 py-1 rounded-sm uppercase tracking-tighter">Lifestyle</span>
                    </div>
                    <div class="p-6 flex flex-col flex-1">
                        <div class="flex flex-wrap items-center gap-6 mb-2  ">

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
                                <span class="font-medium text-darkText tracking-tight">Feb 28, 2026</span>
                            </div>
                            <div class="text-gray-500 text-sm flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-lightBg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <span class="font-medium text-darkText">Admin</span>
                            </div>
                        </div>
                        <h3
                            class="font-heading text-xl font-bold text-darkText mb-3 group-hover:text-brand transition-colors line-clamp-2 uppercase tracking-tight">
                            Top 5 Nutritious Meals for Home Care</h3>
                        <p class="text-gray-500 text-sm mb-6 line-clamp-3">Eating well is the foundation of health.
                            Discover easy, nutritious recipes for daily care...</p>

                        <a href="blog-details.php"
                            class="mt-auto self-start inline-flex items-center justify-center px-5 py-2.5 border border-transparent text-sm font-bold rounded-md text-white bg-brand hover:bg-brandDark shadow-md shadow-black/20 hover:shadow-lg hover:shadow-black/30 transition-all duration-300 transform hover:-translate-y-1 group/btn">
                            Read Article
                            <span
                                class="ml-2 transform group-hover/btn:translate-x-1 transition-transform">&rarr;</span>
                        </a>
                    </div>
                </article>

                <article
                    class="blog-card group bg-white rounded-md border border-gray-100 shadow-md shadow-black/5 hover:shadow-xl hover:shadow-black/10 transition-all duration-300 flex flex-col overflow-hidden"
                    data-category="company">
                    <div
                        class="relative h-60 overflow-hidden border-[6px] border-white ring-1 ring-black/5 m-1 rounded-sm">
                        <img src="https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?auto=format&fit=crop&w=800&q=80"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <span
                            class="absolute top-4 left-4 bg-brand text-white text-[10px] font-bold px-3 py-1 rounded-sm uppercase tracking-tighter">Company</span>
                    </div>
                    <div class="p-6 flex flex-col flex-1">
                        <div class="flex flex-wrap items-center gap-6 mb-2  ">

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
                                <span class="font-medium text-darkText tracking-tight">Feb 28, 2026</span>
                            </div>
                            <div class="text-gray-500 text-sm flex items-center gap-2">
                                <div class="w-8 h-8 rounded-lg bg-lightBg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <span class="font-medium text-darkText">Admin</span>
                            </div>
                        </div>
                        <h3
                            class="font-heading text-xl font-bold text-darkText mb-3 group-hover:text-brand transition-colors line-clamp-2 uppercase tracking-tight">
                            Careline Awarded Best Home Care Provider 2026</h3>
                        <p class="text-gray-500 text-sm mb-6 line-clamp-3">We are proud to announce our recent award for
                            excellence in compassionate care services...</p>

                        <a href="blog-details.php"
                            class="mt-auto self-start inline-flex items-center justify-center px-5 py-2.5 border border-transparent text-sm font-bold rounded-md text-white bg-brand hover:bg-brandDark shadow-md shadow-black/20 hover:shadow-lg hover:shadow-black/30 transition-all duration-300 transform hover:-translate-y-1 group/btn">
                            Read Article
                            <span
                                class="ml-2 transform group-hover/btn:translate-x-1 transition-transform">&rarr;</span>
                        </a>
                    </div>
                </article>

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