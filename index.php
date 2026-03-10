<?php include('head.php') ?>

<body class="font-body text-gray-600 antialiased bg-white">
    <!-- header section  -->
    <?php include('header.php') ?>


    <!-- hero section  -->
    <section id="home"
        class="relative h-[80vh] md:h-[100vh] min-h-[500px] md:min-h-[650px] overflow-hidden bg-darkText">

        <?php
        // ১. ডাটাবেস থেকে হিরো ইমেজগুলো নিয়ে আসা
        $hero_result = $mysqli->query("SELECT image FROM hero_images ORDER BY id DESC");
        $hero_slides = [];
        if ($hero_result) {
            $hero_slides = $hero_result->fetch_all(MYSQLI_ASSOC);
        }
        ?>

        <div id="hero-slider" class="relative w-full h-full">
            <?php if (!empty($hero_slides)): ?>
            <?php foreach ($hero_slides as $index => $slide): ?>
            <div
                class="slide absolute inset-0 w-full h-full transition-opacity duration-1000 <?php echo $index === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0'; ?>">

                <img src="app/uploads/hero_images/<?php echo htmlspecialchars($slide['image']); ?>" alt="Caregiver"
                    class="absolute inset-0 w-full h-full object-cover">

                <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-transparent"></div>

                <div
                    class="relative z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex flex-col justify-center pt-28 md:pt-32">
                    <div class="max-w-2xl">
                        <span
                            class="inline-flex items-center gap-2 text-white font-bold tracking-widest uppercase text-[10px] md:text-xs px-4 py-2 bg-brand/90 backdrop-blur-sm rounded-full mb-4 md:mb-6 shadow-lg">
                            Trusted UK Care Providers
                        </span>
                        <h1
                            class="font-heading text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold text-white mb-4 md:mb-6 leading-[1.1]">
                            Get the help and <span class="text-brand">home support</span> you need.
                        </h1>

                        <p class="text-base md:text-xl text-gray-200 mb-6 md:mb-8 leading-relaxed max-w-xl">
                            We provide premium, compassionate care in the comfort of your own home. Our dedicated
                            professionals ensure your independence and well-being.
                        </p>

                        <div class="flex flex-wrap gap-3 md:gap-4">
                            <a href="contact.php"
                                class="px-6 py-3 md:px-8 md:py-4 bg-brand text-white text-sm md:text-base font-bold rounded-xl shadow-lg shadow-black/20 hover:shadow-xl hover:shadow-black/30 hover:bg-brandDark hover:-translate-y-1 transition-all duration-300">
                                Book Assessment
                            </a>
                            <a href="services.php"
                                class="px-6 py-3 md:px-8 md:py-4 bg-white/10 backdrop-blur-md border border-white/30 text-white text-sm md:text-base font-bold rounded-xl hover:bg-white hover:text-darkText hover:-translate-y-1 transition-all duration-300">
                                Our Services
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <div class="slide absolute inset-0 w-full h-full opacity-100 z-10 bg-gray-900">
                <div class="relative z-20 flex items-center justify-center h-full text-white">No Hero Images Found</div>
            </div>
            <?php endif; ?>
        </div>

        <div class="absolute bottom-6 md:bottom-10 left-1/2 -translate-x-1/2 z-30 flex gap-3">
            <button class="slide-dot w-3 h-3 rounded-full bg-brand transition-all duration-300 w-8"></button>
            <button
                class="slide-dot w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-all duration-300"></button>
        </div>
    </section>

    <!-- service section  -->
    <section id="services" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            <div class="text-center max-w-3xl mx-auto mb-16">
                <span
                    class="inline-flex items-center gap-2 text-brandDark font-bold tracking-widest uppercase text-xs px-4 py-1.5 bg-brand/10 rounded-full mb-5">
                    What We Offer
                </span>


                <h1 class="font-heading text-2xl  md:text-4xl  font-bold text-darkText mb-4 md:mb-6 tracking-[-0.03em]">
                    Comprehensive
                    <span class="text-brand relative ">Care
                        <svg class="absolute -bottom-1.5 left-0 w-full h-1.5 md:h-2 text-brand/30" viewBox="0 0 100 10"
                            preserveAspectRatio="none">
                            <path d="M0 5 L100 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </span>
                    Solutions
                </h1>
                <p class="text-gray-600 text-lg">Flexible support options designed around your specific requirements and
                    routines.</p>
            </div>

            <?php
            // ১. ডাটাবেস থেকে সার্ভিসগুলো নিয়ে আসা
            $service_result = $mysqli->query("SELECT * FROM services ORDER BY id DESC");
            $all_services = [];
            if ($service_result) {
                $all_services = $service_result->fetch_all(MYSQLI_ASSOC);
            }
            ?>

            <div class="grid md:grid-cols-3 gap-8">
                <?php if (!empty($all_services)): ?>
                <?php foreach ($all_services as $service):
                        // ইমেজ স্ট্রিং থেকে প্রথম ইমেজটি নেওয়া (যদি একাধিক থাকে)
                        $service_images = explode(',', $service['image']);
                        $first_image = trim($service_images[0]);
                    ?>
                <div
                    class="bg-white rounded-md border border-gray-100 shadow-md shadow-black/5 hover:shadow-xl hover:shadow-black/10 transition-all duration-300 group flex flex-col">
                    <div
                        class="relative h-60 rounded-md overflow-hidden border-[6px] border-white shadow-sm ring-1 ring-black/5">
                        <?php if (!empty($first_image)): ?>
                        <img src="app/uploads/services_images/<?php echo htmlspecialchars($first_image); ?>"
                            alt="<?php echo htmlspecialchars($service['title']); ?>"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <?php else: ?>
                        <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-400">
                            <i class="fa-solid fa-image text-4xl"></i>
                        </div>
                        <?php endif; ?>
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-darkText/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                    </div>

                    <div class="flex-1 flex flex-col p-5">
                        <h3
                            class="font-heading text-xl md:text-xl font-bold text-darkText mb-3 uppercase tracking-tight">
                            <?php echo htmlspecialchars($service['title']); ?>
                        </h3>

                        <p class="text-gray-600 mb-6 text-sm md:text-base line-clamp-3 flex-1 font-body">
                            <?php echo strip_tags($service['description']); ?>
                        </p>

                        <a href="service-details.php?id=<?php echo $service['id']; ?>"
                            class="mt-auto self-start inline-flex items-center justify-center px-5 py-2.5 border border-transparent text-sm font-bold rounded-md text-white bg-brand hover:bg-brandDark shadow-md shadow-black/20 hover:shadow-lg hover:shadow-black/30 transition-all duration-300 transform hover:-translate-y-1">
                            Learn more
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <div class="col-span-full text-center py-10">
                    <p class="text-gray-400">No services found.</p>
                </div>
                <?php endif; ?>
            </div>

            <div class="mt-16 text-center">
                <a href="services.php"
                    class="inline-flex items-center justify-center px-8 py-3.5 border border-transparent text-base md:text-lg font-bold rounded-md text-white bg-brand hover:bg-brandDark shadow-xl shadow-black/20 hover:shadow-2xl hover:shadow-black/30 transition-all duration-300 transform hover:-translate-y-1">
                    View All Services
                </a>
            </div>

        </div>
    </section>


    <!-- why choose us section  -->

    <section id="why-us" class="py-20 bg-darkText text-white relative overflow-hidden">
        <div
            class="absolute inset-0 opacity-20 bg-[radial-gradient(circle_at_bottom_left,_var(--tw-gradient-stops))] from-brand via-darkText to-transparent">
        </div>
        <div
            class="absolute top-0 right-0 w-1/2 h-full opacity-5 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-white to-transparent">
        </div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-2 gap-16 items-center">

                <div>
                    <span
                        class="inline-flex items-center gap-2 text-brand font-bold tracking-widest uppercase text-xs mb-4">
                        <span class="w-8 h-[2px] bg-brand block"></span>
                        The Careline Difference
                    </span>

                    <h2 class="font-heading text-2xl md:text-4xl font-bold mb-6 leading-tight">
                        Why families across the UK <span class="text-brand italic">trust</span> Careline.
                    </h2>

                    <p class="text-gray-300 text-lg mb-10 leading-relaxed max-w-lg">
                        We don't just provide care; we build meaningful relationships. Our rigorous standards ensure
                        safety, while our genuine empathy ensures happiness.
                    </p>

                    <div class="space-y-4">
                        <div
                            class="flex items-start gap-5 p-4 rounded-2xl hover:bg-white/5 border border-transparent hover:border-white/10 transition-all duration-300 group cursor-default">
                            <div
                                class="w-14 h-14 rounded-xl bg-brand/20 flex items-center justify-center flex-shrink-0 group-hover:bg-brand transition-colors duration-300">
                                <svg class="w-6 h-6 text-brand group-hover:text-white transition-colors duration-300"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-heading text-xl font-bold mb-2 text-white">Tailored Care Plans</h4>
                                <p class="text-gray-400 leading-relaxed text-sm md:text-base">Services specifically
                                    designed to adapt as your health or lifestyle needs change over time.</p>
                            </div>
                        </div>

                        <div
                            class="flex items-start gap-5 p-4 rounded-2xl hover:bg-white/5 border border-transparent hover:border-white/10 transition-all duration-300 group cursor-default">
                            <div
                                class="w-14 h-14 rounded-xl bg-brand/20 flex items-center justify-center flex-shrink-0 group-hover:bg-brand transition-colors duration-300">
                                <svg class="w-6 h-6 text-brand group-hover:text-white transition-colors duration-300"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-heading text-xl font-bold mb-2 text-white">24/7 On-Call Support</h4>
                                <p class="text-gray-400 leading-relaxed text-sm md:text-base">Our dedicated management
                                    team is always available, day or night, ensuring peace of mind.</p>
                            </div>
                        </div>

                        <div
                            class="flex items-start gap-5 p-4 rounded-2xl hover:bg-white/5 border border-transparent hover:border-white/10 transition-all duration-300 group cursor-default">
                            <div
                                class="w-14 h-14 rounded-xl bg-brand/20 flex items-center justify-center flex-shrink-0 group-hover:bg-brand transition-colors duration-300">
                                <svg class="w-6 h-6 text-brand group-hover:text-white transition-colors duration-300"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg>
                            </div>
                            <div>
                                <h4 class="font-heading text-xl font-bold mb-2 text-white">Compassionate Staff</h4>
                                <p class="text-gray-400 leading-relaxed text-sm md:text-base">Handpicked professionals
                                    chosen not just for their skills, but for their genuine empathy and warmth.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="relative mt-10 lg:mt-0 px-4 sm:px-0 lg:pl-10">
                    <div
                        class="absolute inset-0 bg-transparent border-2 border-brand/30 rounded-3xl transform translate-x-4 translate-y-4 -z-10">
                    </div>

                    <div class="relative rounded-3xl overflow-hidden shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1516841273335-e39b37888115?auto=format&fit=crop&w=800&q=80"
                            alt="Happy senior woman with caregiver"
                            class="w-full h-[400px] md:h-[550px] object-cover transition-transform duration-700 hover:scale-105">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-darkText/80 via-transparent to-transparent opacity-60">
                        </div>
                    </div>

                    <div
                        class="absolute -bottom-8 -left-2 sm:-left-8 bg-white p-5 md:p-6 rounded-2xl shadow-2xl border-4 border-darkText flex items-center gap-4 z-20 transform hover:-translate-y-2 transition-transform duration-300 w-[90%] sm:w-auto">
                        <div class="flex -space-x-4">
                            <img class="w-12 h-12 rounded-full border-2 border-white object-cover"
                                src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=100&q=80"
                                alt="Client">
                            <img class="w-12 h-12 rounded-full border-2 border-white object-cover"
                                src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?auto=format&fit=crop&w=100&q=80"
                                alt="Client">
                            <img class="w-12 h-12 rounded-full border-2 border-white object-cover"
                                src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=100&q=80"
                                alt="Client">
                            <div
                                class="w-12 h-12 rounded-full border-2 border-white bg-brand text-white flex items-center justify-center font-bold text-xs">
                                500+
                            </div>
                        </div>
                        <div>
                            <p class="font-heading font-bold text-lg text-darkText leading-tight">Trusted by Families
                            </p>
                            <p class="text-brand font-bold text-sm flex items-center gap-1">
                                Across the UK <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- about us section  -->
    <section id="about" class="py-20 md:py-32 bg-lightBg overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <?php
            // ১. ডাটাবেস থেকে হোম অ্যাবাউট ডাটা ফেচ করা
            $about_query = "SELECT content, image FROM home_about_content WHERE id = 1 LIMIT 1";
            $about_result = $mysqli->query($about_query);
            $about_data = $about_result->fetch_assoc();

            // ইমেজগুলোকে অ্যারেতে কনভার্ট করা
            $about_images = !empty($about_data['image']) ? explode(',', $about_data['image']) : [];

            // প্রথম এবং দ্বিতীয় ইমেজ আলাদা করা
            $img1 = isset($about_images[0]) ? 'app/uploads/home_about_images/' . trim($about_images[0]) : 'img/default1.jpg';
            $img2 = isset($about_images[1]) ? 'app/uploads/home_about_images/' . trim($about_images[1]) : 'img/default2.jpg';
            ?>

            <div class="grid md:grid-cols-2 gap-12 lg:gap-20 items-center">

                <div class="order-2 md:order-1 relative mt-10 md:mt-0 px-4 sm:px-0">
                    <div
                        class="absolute -top-6 -left-6 w-32 h-32 bg-brand/10 rounded-full border-2 border-brand/20 -z-10">
                    </div>

                    <div class="relative pb-16 pr-10 sm:pr-16">
                        <img src="<?php echo $img1; ?>" alt="Careline Primary About Image"
                            class="w-[85%] sm:w-4/5 rounded-3xl shadow-lg border-4 md:border-8 border-white object-cover h-[250px] sm:h-[350px] md:h-[400px] relative z-10 transition-transform duration-500 hover:scale-[1.02]">

                        <img src="<?php echo $img2; ?>" alt="Careline Secondary About Image"
                            class="absolute bottom-0 right-0 w-[60%] sm:w-[55%] rounded-3xl shadow-2xl border-4 md:border-8 border-lightBg object-cover h-[180px] sm:h-[250px] z-20 transition-transform duration-500 hover:scale-[1.05]">

                        <div
                            class="absolute top-1/2 -left-4 sm:-left-8 -translate-y-1/2 bg-brand text-white p-4 sm:p-6 rounded-2xl shadow-xl z-30 border-4 border-white flex flex-col items-center justify-center transform hover:-translate-y-2 transition-transform duration-300">
                            <span
                                class="font-heading text-4xl sm:text-5xl font-bold text-white block leading-none mb-2 tracking-tighter">
                                Your
                            </span>

                            <span
                                class="font-heading font-bold text-[10px] sm:text-xs uppercase tracking-[0.2em] text-white text-center leading-tight">
                                Best Choice <br>
                                <span class="text-white font-medium">For Home Care</span>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="order-1 md:order-2">
                    <span
                        class="inline-flex items-center gap-2 text-brandDark font-bold tracking-widest uppercase text-xs px-4 py-1.5 bg-brand/10 rounded-full mb-5">
                        Who We Are
                    </span>

                    <h1
                        class="font-heading text-2xl md:text-4xl font-bold text-darkText mb-4 md:mb-6 tracking-[-0.03em]">
                        About Community
                        <span class="text-brand relative "> Careline Services
                            <svg class="absolute -bottom-1.5 left-0 w-full h-1.5 md:h-2 text-brand/30"
                                viewBox="0 0 100 10" preserveAspectRatio="none">
                                <path d="M0 5 L100 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                            </svg>
                        </span>
                        (Bexley) Ltd
                    </h1>

                    <div class="text-lg leading-relaxed text-gray-600 mb-6 font-body prose prose-sm max-w-none">
                        <?php echo $about_data['content']; ?>
                    </div>

                    <a href="about.php"
                        class="inline-flex mt-4 items-center justify-center px-4 py-2.5 md:px-6 md:py-3 border border-transparent text-sm md:text-lg font-bold rounded-md text-white bg-brand hover:bg-brandDark shadow-xl shadow-black/20 hover:shadow-2xl hover:shadow-black/30 transition-all duration-300 transform hover:-translate-y-1">
                        Read More
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- career section  -->
    <section id="careers" class="py-20 bg-white relative overflow-hidden border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            <div class="grid lg:grid-cols-12 gap-12 lg:gap-20 items-center">

                <div class="lg:col-span-5 flex flex-col h-full justify-center">

                    <div class="max-w-xl">
                        <span
                            class="inline-flex items-center gap-2 text-brandDark font-bold tracking-widest uppercase text-xs max-w-2xl px-4 py-1.5 bg-brand/10 rounded-full mb-5">
                            Join Our Family
                        </span>

                    </div>






                    <h1
                        class="font-heading text-2xl  md:text-4xl  font-bold text-darkText mb-4 md:mb-6 tracking-[-0.03em]">
                        Build a rewarding
                        <span class="text-brand relative ">career
                            <svg class="absolute -bottom-1.5 left-0 w-full h-1.5 md:h-2 text-brand/30"
                                viewBox="0 0 100 10" preserveAspectRatio="none">
                                <path d="M0 5 L100 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                            </svg>
                        </span>
                        with us.
                    </h1>

                    <p class="text-gray-600 text-lg mb-8 leading-relaxed">
                        We are always looking for compassionate and dedicated individuals. Enjoy comprehensive training,
                        flexible hours, and the opportunity to make a genuine difference in people's lives every single
                        day.
                    </p>

                    <div
                        class="relative rounded-md overflow-hidden border-[6px] border-white shadow-lg ring-1 ring-black/5 group hidden md:block">
                        <img src="https://images.unsplash.com/photo-1576765608866-5b51046452be?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80"
                            alt="Caregiver team"
                            class="w-full h-64 object-cover transition-transform duration-700 group-hover:scale-105">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-darkText/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-7 flex flex-col gap-5">

                    <a href="career-details.php"
                        class="group block bg-lightBg rounded-md p-6 md:p-8 border border-gray-100 shadow-sm transition-all duration-300 transform hover:-translate-y-1 hover:bg-white hover:border-brand/30 hover:shadow-xl hover:shadow-black/10 relative overflow-hidden">
                        <div
                            class="absolute top-0 left-0 w-1 h-full bg-brand transform -translate-x-full group-hover:translate-x-0 transition-transform duration-300">
                        </div>

                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
                            <div class="flex-1">
                                <div class="flex flex-wrap gap-2 mb-3">
                                    <span
                                        class="bg-white border border-gray-200 text-darkText px-3 py-1 rounded-full text-xs font-bold group-hover:border-brand/30 transition-colors">Full-Time
                                        / Part-Time</span>
                                    <span
                                        class="bg-white border border-gray-200 text-darkText px-3 py-1 rounded-full text-xs font-bold group-hover:border-brand/30 transition-colors">Multiple
                                        Locations</span>
                                </div>
                                <h3
                                    class="font-heading text-xl font-bold text-darkText group-hover:text-brand transition-colors uppercase tracking-tight mb-2">
                                    Care Worker
                                </h3>
                                <p class="text-gray-500 text-sm">Provide frontline compassionate care and daily support
                                    to our clients in their own homes.</p>
                            </div>

                            <div class="shrink-0 mt-4 sm:mt-0">
                                <div
                                    class="inline-flex items-center justify-center px-5 py-2.5 border border-transparent text-sm font-bold rounded-md text-white bg-brand group-hover:bg-brandDark shadow-md shadow-black/20 group-hover:shadow-lg group-hover:shadow-black/30 transition-all duration-300 transform group-hover:-translate-y-0.5">
                                    Apply Now
                                    <svg class="ml-2 w-4 h-4 transform group-hover:translate-x-1 transition-transform"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>

                    <a href="career-details.php"
                        class="group block bg-lightBg rounded-md p-6 md:p-8 border border-gray-100 shadow-sm transition-all duration-300 transform hover:-translate-y-1 hover:bg-white hover:border-brand/30 hover:shadow-xl hover:shadow-black/10 relative overflow-hidden">
                        <div
                            class="absolute top-0 left-0 w-1 h-full bg-brand transform -translate-x-full group-hover:translate-x-0 transition-transform duration-300">
                        </div>

                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
                            <div class="flex-1">
                                <div class="flex flex-wrap gap-2 mb-3">
                                    <span
                                        class="bg-white border border-gray-200 text-darkText px-3 py-1 rounded-full text-xs font-bold group-hover:border-brand/30 transition-colors">Full-Time</span>
                                    <span
                                        class="bg-white border border-gray-200 text-darkText px-3 py-1 rounded-full text-xs font-bold group-hover:border-brand/30 transition-colors">London
                                        Region</span>
                                </div>
                                <h3
                                    class="font-heading text-xl font-bold text-darkText group-hover:text-brand transition-colors uppercase tracking-tight mb-2">
                                    Senior Care Supervisor
                                </h3>
                                <p class="text-gray-500 text-sm">Lead, mentor, and support our team of care workers
                                    while ensuring the highest standards of compliance.</p>
                            </div>
                            <div class="shrink-0 mt-4 sm:mt-0">
                                <div
                                    class="inline-flex items-center justify-center px-5 py-2.5 border border-transparent text-sm font-bold rounded-md text-white bg-brand group-hover:bg-brandDark shadow-md shadow-black/20 group-hover:shadow-lg group-hover:shadow-black/30 transition-all duration-300 transform group-hover:-translate-y-0.5">
                                    Apply Now
                                    <svg class="ml-2 w-4 h-4 transform group-hover:translate-x-1 transition-transform"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>

                    <a href="career-details.php"
                        class="group block bg-lightBg rounded-md p-6 md:p-8 border border-gray-100 shadow-sm transition-all duration-300 transform hover:-translate-y-1 hover:bg-white hover:border-brand/30 hover:shadow-xl hover:shadow-black/10 relative overflow-hidden">
                        <div
                            class="absolute top-0 left-0 w-1 h-full bg-brand transform -translate-x-full group-hover:translate-x-0 transition-transform duration-300">
                        </div>

                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6">
                            <div class="flex-1">
                                <div class="flex flex-wrap gap-2 mb-3">
                                    <span
                                        class="bg-white border border-gray-200 text-darkText px-3 py-1 rounded-full text-xs font-bold group-hover:border-brand/30 transition-colors">Part-Time</span>
                                    <span
                                        class="bg-white border border-gray-200 text-darkText px-3 py-1 rounded-full text-xs font-bold group-hover:border-brand/30 transition-colors">Head
                                        Office</span>
                                </div>
                                <h3
                                    class="font-heading text-xl font-bold text-darkText group-hover:text-brand transition-colors uppercase tracking-tight mb-2">
                                    Office Support
                                </h3>
                                <p class="text-gray-500 text-sm">Manage daily administrative tasks, scheduling, and
                                    coordinate communication between clients and carers.</p>
                            </div>
                            <div class="shrink-0 mt-4 sm:mt-0">
                                <div
                                    class="inline-flex items-center justify-center px-5 py-2.5 border border-transparent text-sm font-bold rounded-md text-white bg-brand group-hover:bg-brandDark shadow-md shadow-black/20 group-hover:shadow-lg group-hover:shadow-black/30 transition-all duration-300 transform group-hover:-translate-y-0.5">
                                    Apply Now
                                    <svg class="ml-2 w-4 h-4 transform group-hover:translate-x-1 transition-transform"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </a>

                    <div class="mt-4">
                        <a href="careers.php"
                            class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-bold rounded-md text-white bg-brand hover:bg-brandDark shadow-md shadow-black/20 hover:shadow-lg hover:shadow-black/30 transition-all duration-300 transform hover:-translate-y-1">
                            All Jobs
                        </a>
                    </div>

                </div>

            </div>
        </div>
    </section>


    <!-- blog section  -->
    <section id="blog" class="py-20 bg-lightBg">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            <div class="text-center max-w-3xl mx-auto mb-8">
                <span
                    class="inline-flex items-center gap-2 text-brandDark font-bold tracking-widest uppercase text-xs max-w-2xl px-4 py-1.5 bg-brand/10 rounded-full mb-2">
                    Our Blog
                </span>




                <h1 class="font-heading text-2xl  md:text-4xl  font-bold text-darkText mb-4 md:mb-6 tracking-[-0.03em]">
                    Latest
                    <span class="text-brand relative ">News
                        <svg class="absolute -bottom-1.5 left-0 w-full h-1.5 md:h-2 text-brand/30" viewBox="0 0 100 10"
                            preserveAspectRatio="none">
                            <path d="M0 5 L100 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </span>
                    & Insights
                </h1>
                <p class="text-gray-600 text-lg">Helpful resources, expert care tips, and updates from the Careline UK
                    team.</p>
            </div>





            <div class="grid md:grid-cols-3 gap-8">

                <article
                    class="bg-white rounded-md border border-gray-100 shadow-md shadow-black/5 hover:shadow-xl hover:shadow-black/10 transition-all duration-300 group flex flex-col overflow-hidden transform hover:-translate-y-1">
                    <div class="relative h-56 w-full overflow-hidden bg-gray-200">
                        <img src="https://images.unsplash.com/photo-1576765608535-5f04d1e3f289?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80"
                            alt="Senior safety at home"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-darkText/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                        <div
                            class="absolute top-4 left-4 bg-white/95 backdrop-blur-sm px-3 py-1.5 rounded-md text-xs font-bold text-darkText uppercase tracking-wider shadow-sm">
                            Health Tips
                        </div>
                    </div>
                    <div class="flex-1 flex flex-col p-6 md:p-8">
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
                            class="font-heading text-xl font-bold text-darkText mb-3 group-hover:text-brand transition-colors line-clamp-2">
                            How to Create a Safe Home Environment for Seniors
                        </h3>
                        <p class="text-gray-600 mb-6 text-sm md:text-base line-clamp-3 flex-1">
                            Simple modifications can make a massive difference in preventing falls and ensuring your
                            loved ones remain safe while living independently.
                        </p>
                        <a href="blog-details.php"
                            class="mt-auto self-start inline-flex items-center justify-center px-5 py-2.5 border border-transparent text-sm font-bold rounded-md text-white bg-brand hover:bg-brandDark shadow-md shadow-black/20 hover:shadow-lg hover:shadow-black/30 transition-all duration-300 transform hover:-translate-y-1 group/btn">
                            Read Article
                            <span
                                class="ml-2 transform group-hover/btn:translate-x-1 transition-transform">&rarr;</span>
                        </a>
                    </div>
                </article>

                <article
                    class="bg-white rounded-md border border-gray-100 shadow-md shadow-black/5 hover:shadow-xl hover:shadow-black/10 transition-all duration-300 group flex flex-col overflow-hidden transform hover:-translate-y-1">
                    <div class="relative h-56 w-full overflow-hidden bg-gray-200">
                        <img src="img/b1.jpg" alt="Mental health and companionship"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-darkText/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                        <div
                            class="absolute top-4 left-4 bg-white/95 backdrop-blur-sm px-3 py-1.5 rounded-md text-xs font-bold text-darkText uppercase tracking-wider shadow-sm">
                            Wellbeing
                        </div>
                    </div>
                    <div class="flex-1 flex flex-col p-6 md:p-8">
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
                            class="font-heading text-xl font-bold text-darkText mb-3 group-hover:text-brand transition-colors line-clamp-2">
                            The Importance of Companionship for Mental Health
                        </h3>
                        <p class="text-gray-600 mb-6 text-sm md:text-base line-clamp-3 flex-1">
                            Loneliness can have severe physical effects. Discover why regular social interaction and
                            professional companionship are vital for the elderly.
                        </p>
                        <a href="blog-details.php"
                            class="mt-auto self-start inline-flex items-center justify-center px-5 py-2.5 border border-transparent text-sm font-bold rounded-md text-white bg-brand hover:bg-brandDark shadow-md shadow-black/20 hover:shadow-lg hover:shadow-black/30 transition-all duration-300 transform hover:-translate-y-1 group/btn">
                            Read Article
                            <span
                                class="ml-2 transform group-hover/btn:translate-x-1 transition-transform">&rarr;</span>
                        </a>
                    </div>
                </article>

                <article
                    class="bg-white rounded-md border border-gray-100 shadow-md shadow-black/5 hover:shadow-xl hover:shadow-black/10 transition-all duration-300 group flex flex-col overflow-hidden transform hover:-translate-y-1">
                    <div class="relative h-56 w-full overflow-hidden bg-gray-200">
                        <img src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80"
                            alt="Caregiver training"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-darkText/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        </div>
                        <div
                            class="absolute top-4 left-4 bg-white/95 backdrop-blur-sm px-3 py-1.5 rounded-md text-xs font-bold text-darkText uppercase tracking-wider shadow-sm">
                            Company News
                        </div>
                    </div>
                    <div class="flex-1 flex flex-col p-6 md:p-8">
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
                            class="font-heading text-xl font-bold text-darkText mb-3 group-hover:text-brand transition-colors line-clamp-2">
                            How We Maintain a CQC "Outstanding" Rating
                        </h3>
                        <p class="text-gray-600 mb-6 text-sm md:text-base line-clamp-3 flex-1">
                            A behind-the-scenes look at our rigorous recruitment process, continuous training programs,
                            and dedication to excellence in caregiving.
                        </p>
                        <a href="blog-details.php"
                            class="mt-auto self-start inline-flex items-center justify-center px-5 py-2.5 border border-transparent text-sm font-bold rounded-md text-white bg-brand hover:bg-brandDark shadow-md shadow-black/20 hover:shadow-lg hover:shadow-black/30 transition-all duration-300 transform hover:-translate-y-1 group/btn">
                            Read Article
                            <span
                                class="ml-2 transform group-hover/btn:translate-x-1 transition-transform">&rarr;</span>
                        </a>
                    </div>
                </article>

            </div>

            <div class="mt-16 text-center">
                <a href="blogs.php"
                    class="inline-flex items-center justify-center px-8 py-3.5 border border-transparent text-base md:text-lg font-bold rounded-md text-white bg-brand hover:bg-brandDark shadow-xl shadow-black/20 hover:shadow-2xl hover:shadow-black/30 transition-all duration-300 transform hover:-translate-y-1">
                    View All Posts
                </a>
            </div>

        </div>
    </section>


    <!-- testimonial section -->
    <section class="py-20 bg-white relative overflow-hidden">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="text-center mb-16">


                <span
                    class="inline-flex items-center gap-2 text-brandDark font-bold tracking-widest uppercase text-xs max-w-2xl px-4 py-1.5 bg-brand/10 rounded-full mb-2">
                    Testimonials
                </span>




                <h1 class="font-heading text-2xl  md:text-4xl  font-bold text-darkText mb-4 md:mb-6 tracking-[-0.03em]">
                    Trusted
                    <span class="text-brand relative ">by UK
                        <svg class="absolute -bottom-1.5 left-0 w-full h-1.5 md:h-2 text-brand/30" viewBox="0 0 100 10"
                            preserveAspectRatio="none">
                            <path d="M0 5 L100 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </span>
                    Families
                </h1>
            </div>
        </div>

        <div class="relative w-full overflow-hidden pb-8">

            <div
                class="absolute top-0 left-0 w-20 md:w-40 h-full bg-gradient-to-r from-white to-transparent z-20 pointer-events-none">
            </div>

            <div
                class="absolute top-0 right-0 w-20 md:w-40 h-full bg-gradient-to-l from-white to-transparent z-20 pointer-events-none">
            </div>

            <div class="animate-marquee gap-6 px-4">

                <div class="flex gap-6">
                    <div
                        class="w-[350px] md:w-[400px] bg-white p-8 rounded-2xl shadow-lg shadow-black/5 border border-gray-100 relative flex flex-col transition-transform hover:-translate-y-1 duration-300 cursor-default flex-shrink-0">
                        <svg class="absolute top-6 right-6 w-10 h-10 text-brand/10" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                        </svg>
                        <div class="flex gap-1 text-brand mb-4 text-sm">★★★★★</div>
                        <p class="text-gray-600 text-base italic mb-8 flex-1">"The carers are incredibly punctual,
                            polite, and treat my mother with such dignity. Careline has taken a huge weight off our
                            family's shoulders."</p>
                        <div class="flex items-center gap-4 mt-auto">
                            <div
                                class="w-12 h-12 rounded-full bg-brand/20 flex items-center justify-center text-brand font-bold text-lg">
                                SJ</div>
                            <div>
                                <h4 class="font-bold text-darkText font-heading leading-tight">Sarah Jenkins</h4>
                                <span class="text-sm text-gray-500">London, UK</span>
                            </div>
                        </div>
                    </div>

                    <div
                        class="w-[350px] md:w-[400px] bg-white p-8 rounded-2xl shadow-lg shadow-black/5 border border-gray-100 relative flex flex-col transition-transform hover:-translate-y-1 duration-300 cursor-default flex-shrink-0">
                        <svg class="absolute top-6 right-6 w-10 h-10 text-brand/10" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                        </svg>
                        <div class="flex gap-1 text-brand mb-4 text-sm">★★★★★</div>
                        <p class="text-gray-600 text-base italic mb-8 flex-1">"Professional from the very first phone
                            call. The bespoke care plan perfectly matched my husband's complex needs. Highly
                            recommended."</p>
                        <div class="flex items-center gap-4 mt-auto">
                            <div
                                class="w-12 h-12 rounded-full bg-brand/20 flex items-center justify-center text-brand font-bold text-lg">
                                DT</div>
                            <div>
                                <h4 class="font-bold text-darkText font-heading leading-tight">David T.</h4>
                                <span class="text-sm text-gray-500">Manchester, UK</span>
                            </div>
                        </div>
                    </div>

                    <div
                        class="w-[350px] md:w-[400px] bg-white p-8 rounded-2xl shadow-lg shadow-black/5 border border-gray-100 relative flex flex-col transition-transform hover:-translate-y-1 duration-300 cursor-default flex-shrink-0">
                        <svg class="absolute top-6 right-6 w-10 h-10 text-brand/10" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                        </svg>
                        <div class="flex gap-1 text-brand mb-4 text-sm">★★★★★</div>
                        <p class="text-gray-600 text-base italic mb-8 flex-1">"Careline provided live-in care for my
                            father, and the peace of mind it gave us was invaluable. The staff truly care about what
                            they do."</p>
                        <div class="flex items-center gap-4 mt-auto">
                            <div
                                class="w-12 h-12 rounded-full bg-brand/20 flex items-center justify-center text-brand font-bold text-lg">
                                EW</div>
                            <div>
                                <h4 class="font-bold text-darkText font-heading leading-tight">Emma W.</h4>
                                <span class="text-sm text-gray-500">Birmingham, UK</span>
                            </div>
                        </div>
                    </div>

                    <div
                        class="w-[350px] md:w-[400px] bg-white p-8 rounded-2xl shadow-lg shadow-black/5 border border-gray-100 relative flex flex-col transition-transform hover:-translate-y-1 duration-300 cursor-default flex-shrink-0">
                        <svg class="absolute top-6 right-6 w-10 h-10 text-brand/10" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                        </svg>
                        <div class="flex gap-1 text-brand mb-4 text-sm">★★★★★</div>
                        <p class="text-gray-600 text-base italic mb-8 flex-1">"Such a compassionate team. They go above
                            and beyond what is expected every single day. We couldn't have asked for better support."
                        </p>
                        <div class="flex items-center gap-4 mt-auto">
                            <div
                                class="w-12 h-12 rounded-full bg-brand/20 flex items-center justify-center text-brand font-bold text-lg">
                                JL</div>
                            <div>
                                <h4 class="font-bold text-darkText font-heading leading-tight">James L.</h4>
                                <span class="text-sm text-gray-500">Bristol, UK</span>
                            </div>
                        </div>
                    </div>

                    <div
                        class="w-[350px] md:w-[400px] bg-white p-8 rounded-2xl shadow-lg shadow-black/5 border border-gray-100 relative flex flex-col transition-transform hover:-translate-y-1 duration-300 cursor-default flex-shrink-0">
                        <svg class="absolute top-6 right-6 w-10 h-10 text-brand/10" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                        </svg>
                        <div class="flex gap-1 text-brand mb-4 text-sm">★★★★★</div>
                        <p class="text-gray-600 text-base italic mb-8 flex-1">"The level of detail in their care plans
                            is outstanding. Truly a premium service that treats clients like family."</p>
                        <div class="flex items-center gap-4 mt-auto">
                            <div
                                class="w-12 h-12 rounded-full bg-brand/20 flex items-center justify-center text-brand font-bold text-lg">
                                OH</div>
                            <div>
                                <h4 class="font-bold text-darkText font-heading leading-tight">Olivia H.</h4>
                                <span class="text-sm text-gray-500">Leeds, UK</span>
                            </div>
                        </div>
                    </div>

                    <div
                        class="w-[350px] md:w-[400px] bg-white p-8 rounded-2xl shadow-lg shadow-black/5 border border-gray-100 relative flex flex-col transition-transform hover:-translate-y-1 duration-300 cursor-default flex-shrink-0">
                        <svg class="absolute top-6 right-6 w-10 h-10 text-brand/10" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                        </svg>
                        <div class="flex gap-1 text-brand mb-4 text-sm">★★★★★</div>
                        <p class="text-gray-600 text-base italic mb-8 flex-1">"Finding reliable care was stressful until
                            we found Careline. The caregivers are brilliant. I couldn't recommend them more highly."</p>
                        <div class="flex items-center gap-4 mt-auto">
                            <div
                                class="w-12 h-12 rounded-full bg-brand/20 flex items-center justify-center text-brand font-bold text-lg">
                                MD</div>
                            <div>
                                <h4 class="font-bold text-darkText font-heading leading-tight">Mark D.</h4>
                                <span class="text-sm text-gray-500">Surrey, UK</span>
                            </div>
                        </div>
                    </div>

                    <div
                        class="w-[350px] md:w-[400px] bg-white p-8 rounded-2xl shadow-lg shadow-black/5 border border-gray-100 relative flex flex-col transition-transform hover:-translate-y-1 duration-300 cursor-default flex-shrink-0">
                        <svg class="absolute top-6 right-6 w-10 h-10 text-brand/10" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                        </svg>
                        <div class="flex gap-1 text-brand mb-4 text-sm">★★★★★</div>
                        <p class="text-gray-600 text-base italic mb-8 flex-1">"Our carer feels like part of the family
                            now. The companionship she provides to my mum is beautiful to witness."</p>
                        <div class="flex items-center gap-4 mt-auto">
                            <div
                                class="w-12 h-12 rounded-full bg-brand/20 flex items-center justify-center text-brand font-bold text-lg">
                                CB</div>
                            <div>
                                <h4 class="font-bold text-darkText font-heading leading-tight">Chloe B.</h4>
                                <span class="text-sm text-gray-500">Kent, UK</span>
                            </div>
                        </div>
                    </div>

                    <div
                        class="w-[350px] md:w-[400px] bg-white p-8 rounded-2xl shadow-lg shadow-black/5 border border-gray-100 relative flex flex-col transition-transform hover:-translate-y-1 duration-300 cursor-default flex-shrink-0">
                        <svg class="absolute top-6 right-6 w-10 h-10 text-brand/10" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                        </svg>
                        <div class="flex gap-1 text-brand mb-4 text-sm">★★★★★</div>
                        <p class="text-gray-600 text-base italic mb-8 flex-1">"Exceptional service from day one. They
                            made sure my uncle was completely comfortable and safe during his recovery at home."</p>
                        <div class="flex items-center gap-4 mt-auto">
                            <div
                                class="w-12 h-12 rounded-full bg-brand/20 flex items-center justify-center text-brand font-bold text-lg">
                                RM</div>
                            <div>
                                <h4 class="font-bold text-darkText font-heading leading-tight">Richard M.</h4>
                                <span class="text-sm text-gray-500">Essex, UK</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex gap-6">
                    <div
                        class="w-[350px] md:w-[400px] bg-white p-8 rounded-2xl shadow-lg shadow-black/5 border border-gray-100 relative flex flex-col transition-transform hover:-translate-y-1 duration-300 cursor-default flex-shrink-0">
                        <svg class="absolute top-6 right-6 w-10 h-10 text-brand/10" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                        </svg>
                        <div class="flex gap-1 text-brand mb-4 text-sm">★★★★★</div>
                        <p class="text-gray-600 text-base italic mb-8 flex-1">"The carers are incredibly punctual,
                            polite, and treat my mother with such dignity. Careline has taken a huge weight off our
                            family's shoulders."</p>
                        <div class="flex items-center gap-4 mt-auto">
                            <div
                                class="w-12 h-12 rounded-full bg-brand/20 flex items-center justify-center text-brand font-bold text-lg">
                                SJ</div>
                            <div>
                                <h4 class="font-bold text-darkText font-heading leading-tight">Sarah Jenkins</h4>
                                <span class="text-sm text-gray-500">London, UK</span>
                            </div>
                        </div>
                    </div>

                    <div
                        class="w-[350px] md:w-[400px] bg-white p-8 rounded-2xl shadow-lg shadow-black/5 border border-gray-100 relative flex flex-col transition-transform hover:-translate-y-1 duration-300 cursor-default flex-shrink-0">
                        <svg class="absolute top-6 right-6 w-10 h-10 text-brand/10" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                        </svg>
                        <div class="flex gap-1 text-brand mb-4 text-sm">★★★★★</div>
                        <p class="text-gray-600 text-base italic mb-8 flex-1">"Professional from the very first phone
                            call. The bespoke care plan perfectly matched my husband's complex needs. Highly
                            recommended."</p>
                        <div class="flex items-center gap-4 mt-auto">
                            <div
                                class="w-12 h-12 rounded-full bg-brand/20 flex items-center justify-center text-brand font-bold text-lg">
                                DT</div>
                            <div>
                                <h4 class="font-bold text-darkText font-heading leading-tight">David T.</h4>
                                <span class="text-sm text-gray-500">Manchester, UK</span>
                            </div>
                        </div>
                    </div>

                    <div
                        class="w-[350px] md:w-[400px] bg-white p-8 rounded-2xl shadow-lg shadow-black/5 border border-gray-100 relative flex flex-col transition-transform hover:-translate-y-1 duration-300 cursor-default flex-shrink-0">
                        <svg class="absolute top-6 right-6 w-10 h-10 text-brand/10" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                        </svg>
                        <div class="flex gap-1 text-brand mb-4 text-sm">★★★★★</div>
                        <p class="text-gray-600 text-base italic mb-8 flex-1">"Careline provided live-in care for my
                            father, and the peace of mind it gave us was invaluable. The staff truly care about what
                            they do."</p>
                        <div class="flex items-center gap-4 mt-auto">
                            <div
                                class="w-12 h-12 rounded-full bg-brand/20 flex items-center justify-center text-brand font-bold text-lg">
                                EW</div>
                            <div>
                                <h4 class="font-bold text-darkText font-heading leading-tight">Emma W.</h4>
                                <span class="text-sm text-gray-500">Birmingham, UK</span>
                            </div>
                        </div>
                    </div>

                    <div
                        class="w-[350px] md:w-[400px] bg-white p-8 rounded-2xl shadow-lg shadow-black/5 border border-gray-100 relative flex flex-col transition-transform hover:-translate-y-1 duration-300 cursor-default flex-shrink-0">
                        <svg class="absolute top-6 right-6 w-10 h-10 text-brand/10" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                        </svg>
                        <div class="flex gap-1 text-brand mb-4 text-sm">★★★★★</div>
                        <p class="text-gray-600 text-base italic mb-8 flex-1">"Such a compassionate team. They go above
                            and beyond what is expected every single day. We couldn't have asked for better support."
                        </p>
                        <div class="flex items-center gap-4 mt-auto">
                            <div
                                class="w-12 h-12 rounded-full bg-brand/20 flex items-center justify-center text-brand font-bold text-lg">
                                JL</div>
                            <div>
                                <h4 class="font-bold text-darkText font-heading leading-tight">James L.</h4>
                                <span class="text-sm text-gray-500">Bristol, UK</span>
                            </div>
                        </div>
                    </div>

                    <div
                        class="w-[350px] md:w-[400px] bg-white p-8 rounded-2xl shadow-lg shadow-black/5 border border-gray-100 relative flex flex-col transition-transform hover:-translate-y-1 duration-300 cursor-default flex-shrink-0">
                        <svg class="absolute top-6 right-6 w-10 h-10 text-brand/10" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                        </svg>
                        <div class="flex gap-1 text-brand mb-4 text-sm">★★★★★</div>
                        <p class="text-gray-600 text-base italic mb-8 flex-1">"The level of detail in their care plans
                            is outstanding. Truly a premium service that treats clients like family."</p>
                        <div class="flex items-center gap-4 mt-auto">
                            <div
                                class="w-12 h-12 rounded-full bg-brand/20 flex items-center justify-center text-brand font-bold text-lg">
                                OH</div>
                            <div>
                                <h4 class="font-bold text-darkText font-heading leading-tight">Olivia H.</h4>
                                <span class="text-sm text-gray-500">Leeds, UK</span>
                            </div>
                        </div>
                    </div>

                    <div
                        class="w-[350px] md:w-[400px] bg-white p-8 rounded-2xl shadow-lg shadow-black/5 border border-gray-100 relative flex flex-col transition-transform hover:-translate-y-1 duration-300 cursor-default flex-shrink-0">
                        <svg class="absolute top-6 right-6 w-10 h-10 text-brand/10" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                        </svg>
                        <div class="flex gap-1 text-brand mb-4 text-sm">★★★★★</div>
                        <p class="text-gray-600 text-base italic mb-8 flex-1">"Finding reliable care was stressful until
                            we found Careline. The caregivers are brilliant. I couldn't recommend them more highly."</p>
                        <div class="flex items-center gap-4 mt-auto">
                            <div
                                class="w-12 h-12 rounded-full bg-brand/20 flex items-center justify-center text-brand font-bold text-lg">
                                MD</div>
                            <div>
                                <h4 class="font-bold text-darkText font-heading leading-tight">Mark D.</h4>
                                <span class="text-sm text-gray-500">Surrey, UK</span>
                            </div>
                        </div>
                    </div>

                    <div
                        class="w-[350px] md:w-[400px] bg-white p-8 rounded-2xl shadow-lg shadow-black/5 border border-gray-100 relative flex flex-col transition-transform hover:-translate-y-1 duration-300 cursor-default flex-shrink-0">
                        <svg class="absolute top-6 right-6 w-10 h-10 text-brand/10" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                        </svg>
                        <div class="flex gap-1 text-brand mb-4 text-sm">★★★★★</div>
                        <p class="text-gray-600 text-base italic mb-8 flex-1">"Our carer feels like part of the family
                            now. The companionship she provides to my mum is beautiful to witness."</p>
                        <div class="flex items-center gap-4 mt-auto">
                            <div
                                class="w-12 h-12 rounded-full bg-brand/20 flex items-center justify-center text-brand font-bold text-lg">
                                CB</div>
                            <div>
                                <h4 class="font-bold text-darkText font-heading leading-tight">Chloe B.</h4>
                                <span class="text-sm text-gray-500">Kent, UK</span>
                            </div>
                        </div>
                    </div>

                    <div
                        class="w-[350px] md:w-[400px] bg-white p-8 rounded-2xl shadow-lg shadow-black/5 border border-gray-100 relative flex flex-col transition-transform hover:-translate-y-1 duration-300 cursor-default flex-shrink-0">
                        <svg class="absolute top-6 right-6 w-10 h-10 text-brand/10" fill="currentColor"
                            viewBox="0 0 24 24">
                            <path
                                d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                        </svg>
                        <div class="flex gap-1 text-brand mb-4 text-sm">★★★★★</div>
                        <p class="text-gray-600 text-base italic mb-8 flex-1">"Exceptional service from day one. They
                            made sure my uncle was completely comfortable and safe during his recovery at home."</p>
                        <div class="flex items-center gap-4 mt-auto">
                            <div
                                class="w-12 h-12 rounded-full bg-brand/20 flex items-center justify-center text-brand font-bold text-lg">
                                RM</div>
                            <div>
                                <h4 class="font-bold text-darkText font-heading leading-tight">Richard M.</h4>
                                <span class="text-sm text-gray-500">Essex, UK</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- contact form section  -->
    <section id="contact" class="py-20 bg-white relative overflow-hidden">
        <div
            class="absolute inset-0 opacity-30 bg-[radial-gradient(circle_at_bottom_right,_var(--tw-gradient-stops))] from-brand/20 via-transparent to-transparent">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

            <div class="grid lg:grid-cols-2 gap-10 lg:gap-16 items-stretch">

                <div
                    class="relative rounded-3xl overflow-hidden shadow-[0_20px_50px_rgba(0,0,0,0.15)] border-8 border-white min-h-[400px] lg:min-h-[550px] group">

                    <video autoplay loop muted playsinline
                        class="absolute inset-0 w-full h-full object-cover transition-transform duration-1000 group-hover:scale-105">
                        <source src="img/form.mp4" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>

                    <div
                        class="absolute inset-0 bg-gradient-to-t from-darkText/90 via-darkText/20 to-transparent z-10 pointer-events-none">
                    </div>

                    <div class="absolute bottom-0 left-0 p-8 md:p-10 w-full z-20 pointer-events-none">
                        <div
                            class="bg-white/20 backdrop-blur-md text-white px-4 py-2 rounded-md inline-flex items-center gap-2 font-bold text-sm uppercase tracking-widest mb-4 border border-white/30">
                            <span class="w-2 h-2 rounded-full bg-brand animate-pulse"></span>
                            Available 24/7
                        </div>
                        <h3 class="font-heading text-3xl md:text-4xl font-bold text-white leading-tight mb-3">
                            Ready to get the <span class="text-brand italic">support</span> you deserve?
                        </h3>
                        <p class="text-gray-300 text-lg">We are here to help your loved ones live comfortably at home.
                        </p>
                    </div>
                </div>

                <div class="bg-lightBg p-6 md:p-8 rounded-3xl shadow-xl border border-gray-100 relative self-center">
                    <div
                        class="absolute -top-6 -right-6 w-20 h-20 bg-brand/10 rounded-full border border-brand/20 -z-10 hidden md:block">
                    </div>

                    <h2 class="font-heading text-2xl md:text-3xl font-bold text-darkText mb-2">Book a Free Assessment
                    </h2>
                    <p class="text-gray-500 mb-5 text-base">Fill out the form below and our UK advisory team will call
                        you back within 24 hours.</p>

                    <form class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-darkText mb-1.5">First Name</label>
                                <input type="text"
                                    class="w-full px-4 py-2.5 rounded-md border border-gray-200 focus:border-brand focus:ring-4 focus:ring-brand/10 outline-none transition-all bg-white text-gray-700 placeholder-gray-400"
                                    placeholder="e.g. John">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-darkText mb-1.5">Last Name</label>
                                <input type="text"
                                    class="w-full px-4 py-2.5 rounded-md border border-gray-200 focus:border-brand focus:ring-4 focus:ring-brand/10 outline-none transition-all bg-white text-gray-700 placeholder-gray-400"
                                    placeholder="e.g. Smith">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-darkText mb-1.5">Phone Number</label>
                                <input type="tel"
                                    class="w-full px-4 py-2.5 rounded-md border border-gray-200 focus:border-brand focus:ring-4 focus:ring-brand/10 outline-none transition-all bg-white text-gray-700 placeholder-gray-400"
                                    placeholder="0800 123 456">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-darkText mb-1.5">Email Address</label>
                                <input type="email"
                                    class="w-full px-4 py-2.5 rounded-md border border-gray-200 focus:border-brand focus:ring-4 focus:ring-brand/10 outline-none transition-all bg-white text-gray-700 placeholder-gray-400"
                                    placeholder="john@example.com">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-darkText mb-1.5">Type of Care Required</label>
                            <div class="relative">
                                <select
                                    class="w-full px-4 py-2.5 rounded-md border border-gray-200 focus:border-brand focus:ring-4 focus:ring-brand/10 outline-none transition-all bg-white text-gray-700 appearance-none cursor-pointer">
                                    <option value="" disabled selected>Select a service...</option>
                                    <option value="personal">Personal Care</option>
                                    <option value="live-in">Live-in Care</option>
                                    <option value="respite">Respite Care</option>
                                    <option value="companionship">Companionship</option>
                                    <option value="other">Not Sure / Other</option>
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-500">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-darkText mb-1.5">How can we help?
                                (Optional)</label>
                            <textarea rows="2"
                                class="w-full px-4 py-2.5 rounded-md border border-gray-200 focus:border-brand focus:ring-4 focus:ring-brand/10 outline-none transition-all bg-white text-gray-700 placeholder-gray-400 resize-none"
                                placeholder="Briefly describe your needs..."></textarea>
                        </div>

                        <div class="pt-1">
                            <button type="submit"
                                class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-bold rounded-md text-white bg-brand hover:bg-brandDark shadow-xl shadow-black/20 hover:shadow-2xl hover:shadow-black/30 transition-all duration-300 transform hover:-translate-y-1">
                                Request Callback
                            </button>
                        </div>

                        <p class="text-[11px] text-center text-gray-400 mt-2">
                            By submitting this form, you agree to our <a href="#"
                                class="text-brand hover:underline">Privacy Policy</a>.
                        </p>
                    </form>
                </div>

            </div>
        </div>
    </section>


    <!-- footer section  -->
    <?php include('footer.php') ?>

    <!-- js section -->
    <script src="main.js"></script>
</body>

</html>