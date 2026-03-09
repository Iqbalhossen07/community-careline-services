<?php include('head.php') ?>

<body class="font-body text-gray-600 antialiased bg-white">
    <!-- header section -->
    <?php include('header.php') ?>

    <!-- breadcrumb section -->
    <section class="relative h-[350px] flex items-center overflow-hidden bg-darkText">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1576765608535-5f04d1e3f289?auto=format&fit=crop&w=1500&q=80"
                class="w-full h-full object-cover opacity-30" alt="Respite Care">
            <div class="absolute inset-0 bg-gradient-to-r from-darkText via-darkText/80 to-transparent"></div>
        </div>

        <div class="max-w-7xl mx-auto px-6 lg:px-12 relative z-10 w-full mt-20">
            <nav class="flex mb-4 text-sm font-medium">
                <ol class="inline-flex items-center space-x-2">
                    <li><a href="index.php" class="text-gray-400 hover:text-brand transition-colors">Home</a></li>
                    <li class="text-gray-600">/</li>
                    <li><a href="services.php" class="text-gray-400 hover:text-brand transition-colors">Services</a>
                    </li>
                    <li class="text-gray-600">/</li>
                    <li class="text-brand font-bold uppercase tracking-widest text-[11px] md:text-sm">Respite Care</li>
                </ol>
            </nav>
            <h1 class="font-heading text-2xl md:text-4xl font-bold text-white mb-2 tracking-tight">Respite Care Services
            </h1>
            <p class="text-gray-300 text-lg max-w-2xl">Premium, compassionate care tailored to your everyday life,
                ensuring independence at home.</p>
        </div>
    </section>

    <!-- service details section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <div class="grid lg:grid-cols-12 gap-12">

                <div class="lg:col-span-8">
                    <div
                        class="relative rounded-3xl overflow-hidden mb-12 shadow-[0_20px_50px_rgba(0,0,0,0.15)] border-8 border-white ring-1 ring-black/5">
                        <img src="img/s1.jpg" alt="Respite Caregiving" class="w-full h-[400px] object-cover">
                    </div>

                    <div class="space-y-8">
                        <div>
                            <h2 class="font-heading text-3xl font-bold text-darkText mb-4">A temporary break, a lifelong
                                peace of mind.</h2>
                            <p class="text-lg leading-relaxed text-gray-600">
                                Caring for a loved one is a rewarding but physically and emotionally demanding
                                responsibility. At Careline, our <strong>Respite Care Services</strong> are designed to
                                provide family caregivers with the essential break they need, while ensuring their loved
                                ones receive the highest quality professional care in a familiar environment.
                            </p>
                        </div>

                        <div class="grid md:grid-cols-2 gap-6 py-6">
                            <div
                                class="bg-lightBg p-6 rounded-2xl border border-gray-100 group hover:border-brand/30 transition-all">
                                <div
                                    class="w-12 h-12 bg-brand/10 rounded-xl flex items-center justify-center text-brand mb-4">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h4 class="font-bold text-darkText mb-2">Short-term Support</h4>
                                <p class="text-sm">From a few hours a week to several weeks of live-in support.</p>
                            </div>
                            <div
                                class="bg-lightBg p-6 rounded-2xl border border-gray-100 group hover:border-brand/30 transition-all">
                                <div
                                    class="w-12 h-12 bg-brand/10 rounded-xl flex items-center justify-center text-brand mb-4">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                        </path>
                                    </svg>
                                </div>
                                <h4 class="font-bold text-darkText mb-2">Safe Recruitment</h4>
                                <p class="text-sm">Every carer is fully vetted, DBS checked, and professionally trained.
                                </p>
                            </div>
                        </div>

                        <div class="prose prose-lg max-w-none text-gray-600">
                            <h3 class="font-heading text-2xl font-bold text-darkText">What is included in Respite Care?
                            </h3>
                            <p>Our respite care is completely flexible. Whether you need cover for a family holiday, a
                                medical appointment, or simply some time to rest, we tailor our approach to suit your
                                routine.</p>
                            <ul class="space-y-4 my-6">
                                <li class="flex items-start gap-3">
                                    <span
                                        class="w-6 h-6 bg-brand/20 text-brand rounded-full flex items-center justify-center shrink-0 mt-1 text-xs">✔</span>
                                    <span><strong>Personal Care:</strong> Assistance with bathing, dressing, and
                                        grooming.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span
                                        class="w-6 h-6 bg-brand/20 text-brand rounded-full flex items-center justify-center shrink-0 mt-1 text-xs">✔</span>
                                    <span><strong>Medication Management:</strong> Timely administration and monitoring
                                        of health needs.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span
                                        class="w-6 h-6 bg-brand/20 text-brand rounded-full flex items-center justify-center shrink-0 mt-1 text-xs">✔</span>
                                    <span><strong>Companionship:</strong> Social interaction and mental wellbeing
                                        support.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <span
                                        class="w-6 h-6 bg-brand/20 text-brand rounded-full flex items-center justify-center shrink-0 mt-1 text-xs">✔</span>
                                    <span><strong>Household Support:</strong> Light cleaning, meal preparation, and
                                        shopping.</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-4">
                    <div class="sticky top-28 space-y-8">
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

                        <div
                            class="bg-darkText p-8 rounded-3xl text-white relative overflow-hidden shadow-2xl shadow-black/20 group">
                            <div
                                class="absolute top-0 right-0 w-24 h-24 bg-brand/10 rounded-full blur-3xl -mr-10 -mt-10 transition-all group-hover:bg-brand/20">
                            </div>

                            <h4 class="font-heading text-2xl font-bold mb-6 flex items-center gap-3">
                                Why Choose Us?
                                <span class="w-10 h-[2px] bg-brand"></span>
                            </h4>

                            <ul class="space-y-5">
                                <li class="flex items-start gap-3">
                                    <div
                                        class="flex-shrink-0 w-5 h-5 rounded-full bg-brand/20 flex items-center justify-center mt-1">
                                        <svg class="w-3 h-3 text-brand" fill="currentColor" viewBox="0 0 20 20">
                                            <path
                                                d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-brand font-bold text-sm tracking-wide">5-STAR RATING</p>
                                        <p class="text-gray-400 text-xs italic">"Outstanding Service" according to
                                            families.</p>
                                    </div>
                                </li>

                                <li class="flex items-start gap-3">
                                    <div
                                        class="flex-shrink-0 w-5 h-5 rounded-full bg-brand/20 flex items-center justify-center mt-1">
                                        <svg class="w-3 h-3 text-brand" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-white font-bold text-sm">CQC REGISTERED</p>
                                        <p class="text-gray-400 text-xs">Fully regulated services in the UK.</p>
                                    </div>
                                </li>

                                <li class="flex items-start gap-3">
                                    <div
                                        class="flex-shrink-0 w-5 h-5 rounded-full bg-brand/20 flex items-center justify-center mt-1">
                                        <svg class="w-3 h-3 text-brand" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" stroke-width="3">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7">
                                            </path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-white font-bold text-sm">24/7 OVERSIGHT</p>
                                        <p class="text-gray-400 text-xs">Professional monitoring day and night.</p>
                                    </div>
                                </li>
                            </ul>

                            <div class="mt-8 pt-6 border-t border-white/5">
                                <p class="text-[10px] text-gray-500 uppercase tracking-widest font-bold">Trusted by
                                    families across UK</p>
                            </div>
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