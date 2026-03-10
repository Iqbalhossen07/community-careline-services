<?php include('head.php') ?>

<body class="font-body text-gray-600 antialiased bg-white">
    <?php include('header.php') ?>
    <section class="relative h-[300px] flex items-center overflow-hidden bg-darkText">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1516733725897-1aa73b87c8e8?auto=format&fit=crop&w=1500&q=80"
                class="w-full h-full object-cover opacity-20" alt="Success Message">
            <div class="absolute inset-0 bg-gradient-to-r from-darkText via-darkText/80 to-transparent"></div>
        </div>

        <div class="max-w-7xl mx-auto px-6 lg:px-12 relative z-10 w-full mt-20">
            <h1 class="font-heading text-2xl md:text-4xl font-bold text-white mb-2 tracking-tight">Submission Successful
            </h1>
            <p class="text-gray-300 text-lg">Thank you for reaching out to Community Careline Services.</p>
        </div>
    </section>

    <section class="py-24 flex items-center justify-center min-h-[70vh]">
        <div class="max-w-2xl mx-auto px-6 text-center">
            <div
                class="w-24 h-24 bg-brand/10 text-brand rounded-full flex items-center justify-center mx-auto mb-8 animate-bounce">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>

            <h1 class="font-heading text-4xl font-bold text-darkText mb-4">Application Submitted!</h1>
            <p class="text-lg text-gray-500 mb-10 leading-relaxed">
                Thank you for your interest in joining <strong>Community Careline Services</strong>. Your CV has been
                successfully uploaded and sent to our HR department.
            </p>

            <div class="p-6 bg-lightBg rounded-2xl mb-10 border border-dashed border-gray-300">
                <p class="text-sm font-bold text-gray-400 uppercase tracking-widest mb-1">What Happens Next?</p>
                <p class="text-darkText font-medium">Our team will review your CV. If your qualifications match our
                    needs, we will contact you for an interview within the next few days.</p>
            </div>

            <a href="index.php"
                class="inline-flex items-center gap-2 px-8 py-4 bg-brand text-white font-bold rounded-xl shadow-lg hover:shadow-brand/30 transition-all hover:-translate-y-1">
                Back to Homepage
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M13 7l5 5m0 0l-5 5m5-5H6" stroke-width="2" />
                </svg>
            </a>
        </div>
    </section>

    <?php include('footer.php') ?>
</body>

</html>