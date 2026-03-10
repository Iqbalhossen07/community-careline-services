<?php include('head.php') ?>

<body class="font-body text-gray-600 antialiased bg-white">
    <?php include('header.php') ?>

    <section class="relative h-[300px] flex items-center overflow-hidden bg-darkText">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1450101499163-c8848c66ca85?auto=format&fit=crop&w=1500&q=80"
                class="w-full h-full object-cover opacity-20" alt="Terms of Use">
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
            <h1 class="font-heading text-2xl md:text-4xl font-bold text-white mb-2 tracking-tight">Terms & Conditions
            </h1>
            <p class="text-gray-300 text-lg max-w-2xl">Please read our terms of use carefully before using our care
                services.</p>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="max-w-5xl mx-auto px-6 lg:px-12">
            <div
                class="bg-white rounded-[2.5rem] p-8 md:p-16 shadow-2xl shadow-black/[0.03] border border-gray-100 relative">

                <div
                    class="absolute -top-10 left-1/2 transform -translate-x-1/2 w-20 h-20 bg-brand rounded-3xl -rotate-6 flex items-center justify-center text-white shadow-xl shadow-brand/30">
                    <svg class="w-10 h-10 rotate-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                </div>

                <?php
                // ১. ডাটাবেস থেকে টার্মস অফ ইউজ নিয়ে আসা
                $terms_query = "SELECT description FROM terms_of_use LIMIT 1";
                $terms_result = $mysqli->query($terms_query);
                $terms_data = $terms_result->fetch_assoc();
                ?>

                <div class="prose prose-lg max-w-none text-gray-600 leading-relaxed font-body pt-6">
                    <?php if (!empty($terms_data['description'])): ?>
                    <?php echo $terms_data['description']; ?>
                    <?php else: ?>
                    <div class="text-center py-10">
                        <p class="text-gray-400 italic">Terms and conditions are currently being updated.</p>
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