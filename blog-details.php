<?php include('head.php') ?>

<body class="font-body text-gray-600 antialiased bg-white">
    <!-- header section  -->
    <?php include('header.php') ?>

    <!-- breadcrumb section -->
    <section class="relative h-[350px] flex items-center overflow-hidden bg-darkText">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?auto=format&fit=crop&w=1500&q=80"
                class="w-full h-full object-cover opacity-20" alt="Blog Details">
            <div class="absolute inset-0 bg-gradient-to-r from-darkText via-darkText/80 to-transparent"></div>
        </div>

        <div class="max-w-7xl mx-auto px-6 lg:px-12 relative z-10 w-full mt-20">
            <nav class="flex mb-4 text-sm font-medium">
                <ol class="inline-flex items-center space-x-2">
                    <li><a href="index.php" class="text-gray-400 hover:text-brand transition-colors">Home</a></li>
                    <li class="text-gray-600">/</li>
                    <li><a href="blogs.php" class="text-gray-400 hover:text-brand transition-colors">Blogs</a></li>
                    <li class="text-gray-600">/</li>
                    <li class="text-brand font-bold uppercase tracking-widest text-[11px] md:text-sm">Mental Wellbeing
                    </li>
                </ol>
            </nav>
            <h1
                class="font-heading text-2xl md:text-4xl font-bold text-white mb-2 tracking-tight max-w-4xl leading-tight">
                How to Maintain Mental Wellbeing in Old Age
            </h1>
            <p class="text-gray-300 text-lg max-w-2xl">Read our latest articles about health, home care, and wellbeing.
            </p>
        </div>
    </section>

    <!-- blog details section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <div class="grid lg:grid-cols-12 gap-12 lg:gap-16">

                <div class="lg:col-span-8">
                    <div
                        class="relative rounded-[2.5rem] overflow-hidden mb-12 shadow-[0_20px_50px_rgba(0,0,0,0.15)] border-8 border-white ring-1 ring-black/5">
                        <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?auto=format&fit=crop&w=1200&q=80"
                            alt="Mental Wellbeing" class="w-full h-[450px] object-cover">
                        <span
                            class="absolute top-6 left-6 bg-brand text-white text-xs font-bold px-4 py-2 rounded-full shadow-lg">HEALTH
                            TIPS</span>
                    </div>

                    <div class="flex flex-wrap items-center gap-6 mb-8 pb-8 border-b border-gray-100">

                        <div class="text-gray-500 text-sm flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-lightBg flex items-center justify-center">
                                <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="2">
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
                                <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <span class="font-medium text-darkText">Admin</span>
                        </div>
                    </div>

                    <div class="prose prose-lg max-w-none text-gray-600 leading-relaxed space-y-6">
                        <p class="text-xl font-medium text-darkText italic border-l-4 border-brand pl-6">"Mental health
                            is just as important as physical health, especially for seniors living independently. A
                            healthy mind lead to a happier life."</p>

                        <p>Maintaining mental wellbeing in later years is crucial for a high quality of life. As we age,
                            life transitions such as retirement, health changes, or losing loved ones can impact our
                            mental state. However, aging also brings wisdom and the opportunity for new experiences.</p>

                        <h3 class="text-2xl font-bold text-darkText mt-10">1. Stay Socially Active</h3>
                        <p>Isolation is one of the biggest risks to senior mental health. Regularly engaging with
                            friends, family, or community groups can reduce feelings of loneliness and boost mood.</p>

                        <h3 class="text-2xl font-bold text-darkText mt-10">2. Keep Your Mind Engaged</h3>
                        <p>Just like a muscle, the brain needs exercise. Reading, puzzles, learning a new hobby, or even
                            using technology to stay connected helps keep neural pathways active.</p>

                        <div class="bg-lightBg p-8 rounded-3xl border border-gray-100 my-10">
                            <h4 class="font-bold text-darkText mb-4">Did You Know?</h4>
                            <p class="text-sm italic">According to health research, regular social interaction can
                                reduce the risk of cognitive decline by over 20% in seniors.</p>
                        </div>

                        <p>At <span class="text-brand font-bold uppercase">Careline</span>, we don't just provide
                            physical care; our companions are trained to offer mental and emotional support to ensure
                            our clients feel valued and heard every single day.</p>
                    </div>


                </div>

                <div class="lg:col-span-4 space-y-12">
                    <div class="bg-lightBg p-8 rounded-3xl border border-gray-100 shadow-xl shadow-black/5">
                        <h4 class="font-heading text-xl font-bold text-darkText mb-4">Request a Callback</h4>
                        <p class="text-sm mb-6 text-gray-500">Need immediate help? Fill out your phone number and we
                            will call you.</p>
                        <form class="space-y-4">
                            <input type="text" placeholder="Your Name"
                                class="w-full px-4 py-3 rounded-md border border-gray-200 focus:border-brand focus:ring-4 focus:ring-brand/10 outline-none transition-all">
                            <input type="tel" placeholder="Phone Number"
                                class="w-full px-4 py-3 rounded-md border border-gray-200 focus:border-brand focus:ring-4 focus:ring-brand/10 outline-none transition-all">
                            <button
                                class="w-full py-3 bg-brand text-white font-bold rounded-md shadow-lg shadow-black/20 hover:bg-brandDark hover:-translate-y-1 transition-all">Submit
                                Request</button>
                        </form>
                    </div>


                    <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-xl shadow-black/5">
                        <h4 class="font-heading text-xl font-bold text-darkText mb-6">Recent Posts</h4>
                        <div class="space-y-6">
                            <a href="#" class="group flex gap-4">
                                <div class="w-20 h-20 rounded-xl overflow-hidden shrink-0">
                                    <img src="https://images.unsplash.com/photo-1516733725897-1aa73b87c8e8?auto=format&fit=crop&w=150&q=80"
                                        class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h5
                                        class="text-sm font-bold text-darkText group-hover:text-brand transition-colors line-clamp-2">
                                        Top 5 Nutritious Meals for Home Care</h5>
                                    <p class="text-xs text-gray-400 mt-1">Feb 25, 2026</p>
                                </div>
                            </a>
                            <a href="#" class="group flex gap-4">
                                <div class="w-20 h-20 rounded-xl overflow-hidden shrink-0">
                                    <img src="https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?auto=format&fit=crop&w=150&q=80"
                                        class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h5
                                        class="text-sm font-bold text-darkText group-hover:text-brand transition-colors line-clamp-2">
                                        Careline Awarded Best Provider 2026</h5>
                                    <p class="text-xs text-gray-400 mt-1">Feb 20, 2026</p>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="bg-brand p-10 rounded-[2.5rem] text-white relative overflow-hidden group">
                        <div
                            class="absolute -bottom-10 -left-10 w-40 h-40 bg-white/10 rounded-full blur-3xl transition-all group-hover:scale-110">
                        </div>

                        <div class="relative z-10 text-center">
                            <div
                                class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-6">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z">
                                    </path>
                                </svg>
                            </div>
                            <h4 class="font-heading text-2xl font-bold mb-3">Need Expert Advice?</h4>
                            <p class="text-white/80 text-sm mb-8 leading-relaxed">Book a free 15-minute consultation
                                with our care specialists today.</p>

                            <a href="contact.php"
                                class="block w-full py-4 bg-white text-brand font-bold rounded-xl shadow-[0_15px_30px_-5px_rgba(0,0,0,0.2)] hover:shadow-[0_20px_40px_-5px_rgba(0,0,0,0.3)] hover:-translate-y-1 transition-all duration-300 text-center">
                                Free Consultation
                            </a>
                        </div>
                    </div>
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