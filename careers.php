<?php include('head.php') ?>

<body class="font-body text-gray-600 antialiased bg-white">
    <!-- header section  -->
    <?php include('header.php') ?>

    <!-- breadcrumb section -->
    <section class="relative h-[350px] flex items-center overflow-hidden bg-darkText">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?auto=format&fit=crop&w=1500&q=80"
                class="w-full h-full object-cover opacity-30" alt="Careers at Careline">
            <div class="absolute inset-0 bg-gradient-to-r from-darkText via-darkText/90 to-transparent"></div>
        </div>

        <div class="max-w-7xl mx-auto px-6 lg:px-12 relative z-10 w-full mt-20">
            <nav class="flex mb-4 text-sm font-medium">
                <ol class="inline-flex items-center space-x-2">
                    <li><a href="index.php" class="text-gray-400 hover:text-brand transition-colors">Home</a></li>
                    <li class="text-gray-600">/</li>
                    <li class="text-brand font-bold uppercase tracking-widest text-[11px] md:text-sm">Careers</li>
                </ol>
            </nav>
            <h1 class="font-heading text-2xl md:text-4xl font-bold text-white mb-2 tracking-tight">Join Our
                Compassionate Team</h1>
            <p class="text-gray-300 text-lg max-w-2xl">Start a rewarding career making a real difference in people's
                lives every day.</p>
        </div>
    </section>


    <!-- job section -->
    <section class="py-20 bg-lightBg">
        <div class="max-w-5xl mx-auto px-6 lg:px-8">

            <div class="mb-12">
                <h2 class="font-heading text-3xl font-bold text-darkText mb-4">Current Openings</h2>
                <div class="w-20 h-1.5 bg-brand rounded-full"></div>
            </div>

            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-center">
                    <div class="relative">
                        <select id="filter-type"
                            class="w-full pl-4 pr-10 py-3 rounded-md border border-gray-200 focus:border-brand focus:ring-4 focus:ring-brand/10 outline-none transition-all bg-white text-gray-700 appearance-none cursor-pointer text-sm font-bold">
                            <option value="all">All Job Types</option>
                            <option value="full-time">Full-Time</option>
                            <option value="part-time">Part-Time</option>
                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>

                    <div class="relative">
                        <select id="filter-location"
                            class="w-full pl-4 pr-10 py-3 rounded-md border border-gray-200 focus:border-brand focus:ring-4 focus:ring-brand/10 outline-none transition-all bg-white text-gray-700 appearance-none cursor-pointer text-sm font-bold">
                            <option value="all">All Locations</option>
                            <option value="london">London</option>
                            <option value="surrey">Surrey</option>
                            <option value="head office">Head Office</option>
                        </select>
                        <div
                            class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </div>

                    <button id="reset-filters"
                        class="text-brand font-bold text-sm hover:text-brandDark transition-colors flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                        Reset Filters
                    </button>
                </div>
            </div>

            <div id="job-container" class="flex flex-col gap-6">

                <div class="job-card group block bg-white rounded-md p-6 md:p-8 border border-gray-100 shadow-md shadow-black/5 transition-all duration-300 transform hover:-translate-y-1 hover:border-brand/30 hover:shadow-xl hover:shadow-black/10 relative overflow-hidden"
                    data-type="full-time part-time" data-location="london">
                    <div
                        class="absolute top-0 left-0 w-1.5 h-full bg-brand transform -translate-x-full group-hover:translate-x-0 transition-transform duration-300">
                    </div>

                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                        <div class="flex-1">
                            <div class="flex flex-wrap gap-2 mb-4">
                                <span
                                    class="bg-brand/5 text-brand px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border border-brand/10">Full-Time
                                    / Part-Time</span>
                                <span
                                    class="bg-gray-100 text-darkText px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border border-gray-200">London,
                                    UK</span>
                            </div>
                            <h3
                                class="font-heading text-xl font-bold text-darkText group-hover:text-brand transition-colors uppercase tracking-tight mb-3">
                                Care Worker</h3>
                            <p class="text-gray-500 text-sm md:text-base max-w-2xl">Support our clients with their daily
                                routines, including personal care, meal preparation, and companionship. No experience
                                required; full training provided.</p>
                        </div>

                        <div class="shrink-0 w-full md:w-auto">
                            <a href="career-details.php"
                                class="w-full md:w-auto inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-bold rounded-md text-white bg-brand hover:bg-brandDark shadow-md shadow-black/20 group-hover:shadow-lg group-hover:shadow-black/30 transition-all duration-300 transform group-hover:-translate-y-0.5">
                                View Details
                                <svg class="ml-2 w-4 h-4 transform group-hover:translate-x-1 transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="job-card group block bg-white rounded-md p-6 md:p-8 border border-gray-100 shadow-md shadow-black/5 transition-all duration-300 transform hover:-translate-y-1 hover:border-brand/30 hover:shadow-xl hover:shadow-black/10 relative overflow-hidden"
                    data-type="full-time" data-location="surrey">
                    <div
                        class="absolute top-0 left-0 w-1.5 h-full bg-brand transform -translate-x-full group-hover:translate-x-0 transition-transform duration-300">
                    </div>

                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                        <div class="flex-1">
                            <div class="flex flex-wrap gap-2 mb-4">
                                <span
                                    class="bg-brand/5 text-brand px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border border-brand/10">Full-Time</span>
                                <span
                                    class="bg-gray-100 text-darkText px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border border-gray-200">Surrey,
                                    UK</span>
                            </div>
                            <h3
                                class="font-heading text-xl font-bold text-darkText group-hover:text-brand transition-colors uppercase tracking-tight mb-3">
                                Senior Care Supervisor</h3>
                            <p class="text-gray-500 text-sm md:text-base max-w-2xl">Oversee care delivery, conduct
                                assessments, and mentor junior staff. Requires NVQ Level 3 in Health and Social Care.
                            </p>
                        </div>

                        <div class="shrink-0 w-full md:w-auto">
                            <a href="career-details.php"
                                class="w-full md:w-auto inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-bold rounded-md text-white bg-brand hover:bg-brandDark shadow-md shadow-black/20 group-hover:shadow-lg group-hover:shadow-black/30 transition-all duration-300 transform group-hover:-translate-y-0.5">
                                View Details
                                <svg class="ml-2 w-4 h-4 transform group-hover:translate-x-1 transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="job-card group block bg-white rounded-md p-6 md:p-8 border border-gray-100 shadow-md shadow-black/5 transition-all duration-300 transform hover:-translate-y-1 hover:border-brand/30 hover:shadow-xl hover:shadow-black/10 relative overflow-hidden"
                    data-type="part-time" data-location="head office">
                    <div
                        class="absolute top-0 left-0 w-1.5 h-full bg-brand transform -translate-x-full group-hover:translate-x-0 transition-transform duration-300">
                    </div>

                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                        <div class="flex-1">
                            <div class="flex flex-wrap gap-2 mb-4">
                                <span
                                    class="bg-brand/5 text-brand px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border border-brand/10">Part-Time</span>
                                <span
                                    class="bg-gray-100 text-darkText px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider border border-gray-200">Head
                                    Office</span>
                            </div>
                            <h3
                                class="font-heading text-xl font-bold text-darkText group-hover:text-brand transition-colors uppercase tracking-tight mb-3">
                                Office Support</h3>
                            <p class="text-gray-500 text-sm md:text-base max-w-2xl">Handle administrative duties, answer
                                phone calls, and assist with staff scheduling and compliance documentation.</p>
                        </div>

                        <div class="shrink-0 w-full md:w-auto">
                            <a href="career-details.php"
                                class="w-full md:w-auto inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-bold rounded-md text-white bg-brand hover:bg-brandDark shadow-md shadow-black/20 group-hover:shadow-lg group-hover:shadow-black/30 transition-all duration-300 transform group-hover:-translate-y-0.5">
                                View Details
                                <svg class="ml-2 w-4 h-4 transform group-hover:translate-x-1 transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <div id="no-results"
                    class="hidden text-center py-16 bg-white rounded-md border border-dashed border-gray-300">
                    <p class="text-gray-500 font-bold">No jobs found matching your selection.</p>
                </div>

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