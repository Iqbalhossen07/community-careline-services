<?php include('head.php') ?>

<body class="font-body text-gray-600 antialiased bg-white overflow-x-hidden">
    <?php include('header.php') ?>

    <section class="relative h-[300px] flex items-center overflow-hidden bg-darkText">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1516733725897-1aa73b87c8e8?auto=format&fit=crop&w=1500&q=80"
                class="w-full h-full object-cover opacity-20" alt="Success Message">
            <div class="absolute inset-0 bg-gradient-to-r from-darkText via-darkText/80 to-transparent"></div>
        </div>

        <div class="max-w-7xl mx-auto px-6 lg:px-12 relative z-10 w-full mt-10">
            <h1 class="font-heading text-3xl md:text-4xl font-bold text-white mb-2 tracking-tight">Submission Successful
            </h1>
            <p class="text-gray-300 text-lg">Thank you for reaching out to Community Careline Services.</p>
        </div>
    </section>

    <section class="py-20 bg-lightBg/50 relative">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <div
                class="bg-white p-10 md:p-16 rounded-[3rem] shadow-2xl shadow-black/5 border border-gray-100 relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-2 bg-brand"></div>

                <div class="mb-8 flex justify-center">
                    <div
                        class="w-24 h-24 bg-brand/10 rounded-full flex items-center justify-center text-brand animate-bounce">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                </div>

                <h2 class="font-heading text-3xl md:text-4xl font-bold text-darkText mb-6">Message Sent Successfully!
                </h2>

                <p class="text-gray-500 text-lg leading-relaxed mb-10 max-w-2xl mx-auto">
                    We have received your request for an assessment. Our dedicated team will review your information and
                    get back to you within <span class="text-brand font-bold">24-48 hours</span>.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="index.php"
                        class="w-full sm:w-auto px-8 py-4 bg-brand text-white font-bold rounded-2xl shadow-[0_15px_30px_-5px_rgba(0,0,0,0.25)] hover:shadow-[0_20px_40px_-5px_rgba(0,0,0,0.35)] transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Back to Home
                    </a>

                    <a href="services.php"
                        class="w-full sm:w-auto px-8 py-4 bg-white text-darkText border border-gray-200 font-bold rounded-2xl hover:bg-gray-50 transition-all duration-300 flex items-center justify-center gap-2">
                        Explore Services
                    </a>
                </div>
            </div>

            <div class="mt-12 text-gray-400 text-sm">
                <p>If this is an emergency, please call us directly at <a href="tel:01634853187"
                        class="text-brand font-bold">01634 853 187</a></p>
            </div>
        </div>
    </section>

    <?php include('footer.php') ?>

    <script src="main.js"></script>
</body>

</html>