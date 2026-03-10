<?php include('head.php') ?>

<body class="font-body text-gray-600 antialiased bg-white">
    <?php include('header.php') ?>

    <section class="relative h-[300px] flex items-center overflow-hidden bg-darkText">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&w=1500&q=80"
                class="w-full h-full object-cover opacity-20" alt="Privacy Policy">
            <div class="absolute inset-0 bg-gradient-to-r from-darkText via-darkText/80 to-transparent"></div>
        </div>

        <div class="max-w-7xl mx-auto px-6 lg:px-12 relative z-10 w-full mt-20">
            <nav class="flex mb-4 text-sm font-medium">
                <ol class="inline-flex items-center space-x-2">
                    <li><a href="index.php" class="text-gray-400 hover:text-brand transition-colors">Home</a></li>
                    <li class="text-gray-600">/</li>
                    <li class="text-brand font-bold uppercase tracking-widest text-[11px] md:text-sm">Legal</li>
                </ol>
            </nav>
            <h1 class="font-heading text-2xl md:text-4xl font-bold text-white mb-2 tracking-tight">Privacy Policy</h1>
            <p class="text-gray-300 text-lg max-w-2xl">How we protect and manage your personal data at Community
                Careline.</p>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="max-w-5xl mx-auto px-6 lg:px-12">
            <div
                class="bg-white rounded-[2.5rem] p-8 md:p-16 shadow-2xl shadow-black/[0.03] border border-gray-100 relative">
                <div
                    class="absolute -top-10 left-1/2 transform -translate-x-1/2 w-20 h-20 bg-brand rounded-3xl rotate-12 flex items-center justify-center text-white shadow-xl shadow-brand/30">
                    <svg class="w-10 h-10 -rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                        </path>
                    </svg>
                </div>

                <?php
                // ১. ডাটাবেস থেকে প্রাইভেসী পলিসি নিয়ে আসা
                $pp_query = "SELECT description FROM privacy_policy LIMIT 1";
                $pp_result = $mysqli->query($pp_query);
                $pp_data = $pp_result->fetch_assoc();
                ?>

                <div class="prose prose-lg max-w-none text-gray-600 leading-relaxed font-body pt-6">
                    <?php if (!empty($pp_data['description'])): ?>
                    <?php echo $pp_data['description']; ?>
                    <?php else: ?>
                    <div class="text-center py-10">
                        <p class="text-gray-400 italic">Privacy policy content is being updated. Please check back soon.
                        </p>
                    </div>
                    <?php endif; ?>
                </div>


            </div>
        </div>
    </section>

    <?php include('footer.php') ?>

    <script src="main.js"></script>
</body>

</html>