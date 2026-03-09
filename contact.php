<?php include('head.php') ?>

<body class="font-body text-gray-600 antialiased bg-white">
    <!-- header section  -->
    <?php include('header.php') ?>

    <!-- breadcrumb section -->
    <section class="relative h-[350px] flex items-center overflow-hidden bg-darkText">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1534536281715-e28d76689b4d?auto=format&fit=crop&w=1500&q=80"
                class="w-full h-full object-cover opacity-30" alt="Contact Careline">
            <div class="absolute inset-0 bg-gradient-to-r from-darkText via-darkText/80 to-transparent"></div>
        </div>

        <div class="max-w-7xl mx-auto px-6 lg:px-12 relative z-10 w-full mt-20">
            <nav class="flex mb-4 text-sm font-medium">
                <ol class="inline-flex items-center space-x-2">
                    <li><a href="index.php" class="text-gray-400 hover:text-brand transition-colors">Home</a></li>
                    <li class="text-gray-600">/</li>
                    <li class="text-brand font-bold uppercase tracking-widest text-[11px] md:text-sm">Contact Us</li>
                </ol>
            </nav>
            <h1 class="font-heading text-2xl md:text-4xl font-bold text-white mb-2 tracking-tight">Get In Touch</h1>
            <p class="text-gray-300 text-lg max-w-2xl">We are here to help you and your family. Reach out to us anytime.
            </p>
        </div>
    </section>

    <!-- phone, email location section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div
                    class="p-8 rounded-3xl bg-lightBg border border-gray-100 flex flex-col items-center text-center group hover:bg-white hover:shadow-2xl hover:shadow-black/5 transition-all duration-500">
                    <div
                        class="w-14 h-14 bg-brand rounded-2xl flex items-center justify-center text-white mb-6 shadow-lg shadow-brand/20 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="font-heading text-xl font-bold text-darkText mb-2">Call Us</h3>
                    <a href="tel:01634853187" class="text-brand font-bold text-lg hover:underline">01634 853 187</a>
                </div>

                <div
                    class="p-8 rounded-3xl bg-lightBg border border-gray-100 flex flex-col items-center text-center group hover:bg-white hover:shadow-2xl hover:shadow-black/5 transition-all duration-500">
                    <div
                        class="w-14 h-14 bg-brand rounded-2xl flex items-center justify-center text-white mb-6 shadow-lg shadow-brand/20 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="font-heading text-xl font-bold text-darkText mb-2">Email Us</h3>
                    <a href="mailto:info@communitycareline.uk"
                        class="text-brand font-bold text-lg hover:underline">info@communitycareline.uk</a>
                </div>

                <div
                    class="p-8 rounded-3xl bg-lightBg border border-gray-100 flex flex-col items-center text-center group hover:bg-white hover:shadow-2xl hover:shadow-black/5 transition-all duration-500">
                    <div
                        class="w-14 h-14 bg-brand rounded-2xl flex items-center justify-center text-white mb-6 shadow-lg shadow-brand/20 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <h3 class="font-heading text-xl font-bold text-darkText mb-2">Our Office</h3>
                    <p class="text-darkText font-medium text-sm leading-relaxed">
                        First floor office, 74 High street,<br>
                        Rainham, Kent, ME8 7JH
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- form and map section -->
    <section class="py-20 bg-lightBg">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <div class="grid lg:grid-cols-2 gap-12 items-start">

                <div
                    class="bg-white p-8 md:p-12 rounded-[2.5rem] shadow-2xl shadow-black/5 border border-gray-100 relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-2 bg-brand"></div>
                    <h2 class="font-heading text-3xl font-bold text-darkText mb-4">Book an Assessment</h2>
                    <p class="text-gray-500 mb-8">Tell us about your needs and we'll get back to you shortly.</p>

                    <form action="#" class="space-y-5">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <input type="text" placeholder="Your Name"
                                class="w-full px-5 py-3.5 rounded-xl border border-gray-200 outline-none focus:border-brand transition-all bg-lightBg/30">
                            <input type="tel" placeholder="Phone Number"
                                class="w-full px-5 py-3.5 rounded-xl border border-gray-200 outline-none focus:border-brand transition-all bg-lightBg/30">
                        </div>
                        <input type="email" placeholder="Email Address"
                            class="w-full px-5 py-3.5 rounded-xl border border-gray-200 outline-none focus:border-brand transition-all bg-lightBg/30">
                        <textarea rows="4" placeholder="How can we help you?"
                            class="w-full px-5 py-3.5 rounded-xl border border-gray-200 outline-none focus:border-brand transition-all bg-lightBg/30"></textarea>

                        <button type="submit"
                            class="w-full py-2 md:py-3 bg-brand text-white font-bold rounded-xl shadow-[0_15px_30px_-5px_rgba(0,0,0,0.25)] hover:shadow-[0_20px_40px_-5px_rgba(0,0,0,0.35)] transition-all duration-300 transform hover:-translate-y-1 flex items-center justify-center gap-2">
                            Send Message
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                            </svg>
                        </button>
                    </form>
                </div>

                <div
                    class="relative h-[550px] lg:h-full min-h-[450px] rounded-[2.5rem] overflow-hidden shadow-2xl shadow-black/10 border-8 border-white bg-gray-100">

                    <iframe class="absolute inset-0 w-full h-full border-0"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2493.123456789012!2d0.6063234!3d51.3615175!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47d8cd95c3b9b9b9%3A0x1234567890abcdef!2s74%20High%20St%2C%20Rainham%2C%20Gillingham%20ME8%207JH%2C%20UK!5e0!3m2!1sen!2suk!4v1700000000000!5m2!1sen!2suk"
                        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>

                    <div class="absolute bottom-6 left-6 pointer-events-none">
                        <div
                            class="bg-white/95 backdrop-blur-md p-3 rounded-2xl shadow-xl border border-white/50 flex items-center gap-3">
                            <div
                                class="w-10 h-10 bg-brand rounded-xl flex items-center justify-center shadow-lg shadow-brand/20">
                                <img src="https://cdn-icons-png.flaticon.com/512/3448/3448651.png" class="w-6 h-6"
                                    alt="Pegman Icon">
                            </div>
                            <div>
                                <p
                                    class="text-[10px] uppercase tracking-widest font-bold text-gray-400 leading-none mb-1">
                                    Live View</p>
                                <p class="text-sm font-bold text-darkText leading-none">Click "View on Google Maps" for
                                    Street View</p>
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