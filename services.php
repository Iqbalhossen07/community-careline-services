<?php include('head.php') ?>

<body class="font-body text-gray-600 antialiased bg-white">
    <!-- header section -->
    <?php include('header.php') ?>

    <!-- breadcrumb section -->
    <section class="relative h-[350px] flex items-center overflow-hidden bg-darkText">
        <div class="absolute inset-0 z-0">
            <img src="img/s1.jpg" class="w-full h-full object-cover opacity-40" alt="Services Background">
            <div class="absolute inset-0 bg-gradient-to-r from-darkText via-darkText/80 to-transparent"></div>
        </div>

        <div class="max-w-7xl mx-auto px-6 lg:px-12 relative z-10 w-full mt-20">
            <nav class="flex mb-4" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-3 text-sm font-medium">
                    <li class="inline-flex items-center">
                        <a href="index.php"
                            class="text-gray-300 hover:text-brand transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                </path>
                            </svg>
                            Home
                        </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="w-6 h-6 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="ml-1 md:ml-2 text-brand font-bold uppercase tracking-widest">Our
                                Services</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="font-heading text-2xl md:text-4xl font-bold text-white mb-2">Our Specialist Services</h1>
            <p class="text-gray-300 text-lg max-w-2xl">Premium, compassionate care tailored to your everyday life,
                ensuring independence at home.</p>
        </div>
    </section>


    <!-- services section -->
    <section class="py-20 bg-lightBg">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-4">

                <div
                    class="bg-white rounded-md border border-gray-100 shadow-md shadow-black/5 hover:shadow-xl hover:shadow-black/10 transition-all duration-300 group flex flex-col">
                    <div
                        class="relative h-64 rounded-md overflow-hidden border-[6px] border-white shadow-sm ring-1 ring-black/5 ">
                        <img src="img/s1.jpg" alt="Respite Care"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-darkText/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                    </div>
                    <div class="flex-1 flex flex-col p-6">
                        <h3 class="font-heading text-xl font-bold text-darkText mb-3 uppercase tracking-tight">Respite
                            Care Services</h3>
                        <p class="text-gray-600 mb-8 text-sm md:text-base leading-relaxed line-clamp-2">
                            Temporary, high-quality care to provide family caregivers a much-needed break, ensuring your
                            loved ones remain safe and comfortable.
                        </p>
                        <a href="service-details.php"
                            class="mt-auto self-start inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-bold rounded-md text-white bg-brand hover:bg-brandDark shadow-md shadow-black/20 hover:shadow-lg hover:shadow-black/30 transition-all duration-300 transform hover:-translate-y-1">
                            Learn more
                        </a>
                    </div>
                </div>

                <div
                    class="bg-white rounded-md border border-gray-100 shadow-md shadow-black/5 hover:shadow-xl hover:shadow-black/10 transition-all duration-300 group flex flex-col">
                    <div
                        class="relative h-64 rounded-md overflow-hidden border-[6px] border-white shadow-sm ring-1 ring-black/5 ">
                        <img src="img/s2.jpg" alt="Home Care"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-darkText/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                    </div>
                    <div class="flex-1 flex flex-col p-6">
                        <h3 class="font-heading text-xl font-bold text-darkText mb-3 uppercase tracking-tight">Home
                            Care Services</h3>
                        <p class="text-gray-600 mb-8 text-sm md:text-base leading-relaxed line-clamp-2">
                            Compassionate daily assistance tailored to your specific needs, enabling you to live happily
                            and independently in your own home.
                        </p>
                        <a href="service-details.php"
                            class="mt-auto self-start inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-bold rounded-md text-white bg-brand hover:bg-brandDark shadow-md shadow-black/20 hover:shadow-lg hover:shadow-black/30 transition-all duration-300 transform hover:-translate-y-1">
                            Learn more
                        </a>
                    </div>
                </div>

                <div
                    class="bg-white rounded-md border border-gray-100 shadow-md shadow-black/5 hover:shadow-xl hover:shadow-black/10 transition-all duration-300 group flex flex-col">
                    <div
                        class="relative h-64 rounded-md overflow-hidden border-[6px] border-white shadow-sm ring-1 ring-black/5 ">
                        <img src="img/s3.jpg" alt="Dementia Care"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-darkText/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                    </div>
                    <div class="flex-1 flex flex-col p-6">
                        <h3 class="font-heading text-xl font-bold text-darkText mb-3 uppercase tracking-tight">Dementia
                            Care</h3>
                        <p class="text-gray-600 mb-8 text-sm md:text-base leading-relaxed line-clamp-2">
                            Specialized support for those living with memory loss, focusing on safety, dignity, and
                            familiar routines.
                        </p>
                        <a href="service-details.php"
                            class="mt-auto self-start inline-flex items-center justify-center px-6 py-3 border border-transparent text-sm font-bold rounded-md text-white bg-brand hover:bg-brandDark shadow-md shadow-black/20 hover:shadow-lg hover:shadow-black/30 transition-all duration-300 transform hover:-translate-y-1">
                            Learn more
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- cta section  -->
    <section class="py-16 bg-white px-6">
        <div
            class="max-w-5xl mx-auto bg-brand p-8 md:p-12 rounded-[2rem] shadow-2xl shadow-brand/20 relative overflow-hidden">

            <div class="absolute -top-10 -right-10 w-40 h-40 bg-white/10 rounded-full blur-3xl"></div>

            <div class="max-w-2xl mx-auto text-center relative z-10">
                <h2 class="font-heading text-2xl md:text-3xl font-bold text-white mb-4">
                    Can't find what you're looking for?
                </h2>
                <p class="text-white/80 text-base md:text-lg mb-8">
                    Our team can craft a bespoke care plan just for you. Get in touch today.
                </p>

                <div class="flex flex-row justify-center gap-3 md:gap-4">
                    <a href="tel:0800123456"
                        class="flex-1 sm:flex-none bg-white text-darkText px-4 sm:px-8 py-3 rounded-md font-bold text-xs sm:text-base hover:bg-gray-50 transition-all shadow-[0_10px_25px_-5px_rgba(0,0,0,0.2)] hover:shadow-[0_15px_30px_-5px_rgba(0,0,0,0.3)] transform hover:-translate-y-1 duration-300 flex items-center justify-center gap-2">
                        <svg class="w-3 h-3 sm:w-4 sm:h-4 text-brand" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 005.454 5.454l.774-1.548a1 1 0 011.06-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z">
                            </path>
                        </svg>
                        <span class="whitespace-nowrap">0800 123 456</span>
                    </a>

                    <a href="contact.php"
                        class="flex-1 sm:flex-none border-2 border-white text-white px-4 sm:px-8 py-3 rounded-md font-bold text-xs sm:text-base hover:bg-white hover:text-brand transition-all shadow-[0_10px_25px_-5px_rgba(0,0,0,0.1)] hover:shadow-[0_15px_30px_-5px_rgba(0,0,0,0.2)] transform hover:-translate-y-1 duration-300 flex items-center justify-center">
                        <span class="whitespace-nowrap">Book Assessment</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- footer section -->
    <?php include('footer.php') ?>

    <!-- js section -->
    <script src="main.js"></script>
</body>

</html>