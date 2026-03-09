<?php include('head.php') ?>

<body class="font-body text-gray-600 antialiased bg-white">
    <!-- header section -->
    <?php include('header.php') ?>

    <!-- breadcrumb section -->
    <section class="relative h-[350px] flex items-center overflow-hidden bg-darkText">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?auto=format&fit=crop&w=1500&q=80"
                class="w-full h-full object-cover opacity-30" alt="Job Details">
            <div class="absolute inset-0 bg-gradient-to-r from-darkText via-darkText/90 to-transparent"></div>
        </div>

        <div class="max-w-7xl mx-auto px-6 lg:px-12 relative z-10 w-full mt-20">
            <nav class="flex mb-4 text-sm font-medium">
                <ol class="inline-flex items-center space-x-2">
                    <li><a href="index.php" class="text-gray-400 hover:text-brand transition-colors">Home</a></li>
                    <li class="text-gray-600">/</li>
                    <li><a href="careers.php" class="text-gray-400 hover:text-brand transition-colors">Careers</a></li>
                    <li class="text-gray-600">/</li>
                    <li class="text-brand font-bold uppercase tracking-widest text-[11px] md:text-sm">Care Worker</li>
                </ol>
            </nav>
            <h1 class="font-heading text-2xl md:text-4xl font-bold text-white mb-2 tracking-tight">Care Worker</h1>
            <p class="text-gray-300 text-lg max-w-2xl">Start a rewarding career making a real difference in people's
                lives every day.</p>
        </div>
    </section>


    <!-- job details section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <div class="grid lg:grid-cols-12 gap-12 lg:gap-16">

                <div class="lg:col-span-7 space-y-12">
                    <div
                        class="relative p-8 rounded-3xl bg-white border border-gray-100 shadow-xl shadow-black/[0.02] overflow-hidden group">
                        <div
                            class="absolute top-0 left-0 w-1.5 h-full bg-brand transform -translate-x-full group-hover:translate-x-0 transition-transform duration-500">
                        </div>

                        <h2 class="font-heading text-3xl font-bold text-darkText mb-6 flex items-center gap-3">
                            Role Overview
                            <span class="w-12 h-[2px] bg-brand/30"></span>
                        </h2>

                        <p class="text-lg leading-relaxed mb-10 text-gray-600 text-justify">
                            As a Care Worker at <span class="text-brand font-bold">Careline</span>, you are the heart of
                            our service. You will provide essential support to our clients in their own homes, helping
                            them maintain their independence and dignity. We are looking for individuals who are
                            naturally kind, patient, and dedicated to providing high-quality care.
                        </p>

                        <div
                            class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6 rounded-2xl bg-lightBg border border-gray-100 shadow-inner">
                            <div class="space-y-1">
                                <p class="text-[10px] uppercase font-bold text-gray-400 tracking-[0.2em]">Salary</p>
                                <p class="text-darkText font-bold text-lg">£12.50 - £14.00<span
                                        class="text-xs text-gray-400 font-medium">/hr</span></p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-[10px] uppercase font-bold text-gray-400 tracking-[0.2em]">Location</p>
                                <div class="flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-brand animate-pulse"></span>
                                    <p class="text-darkText font-bold text-lg">London, UK</p>
                                </div>
                            </div>
                            <div class="space-y-1 ">
                                <p class="text-[10px] uppercase font-bold text-gray-400 tracking-[0.2em]">Job Type</p>
                                <p class="text-darkText font-bold text-lg">Permanent</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <h3 class="font-heading text-2xl font-bold text-darkText flex items-center gap-4">
                            Key Responsibilities
                            <div class="h-[1px] flex-1 bg-gray-100"></div>
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <?php
                            $tasks = [
                                "Personal care (bathing, dressing)",
                                "Preparing nutritious meals",
                                "Medication administration",
                                "Emotional support",
                                "Light housekeeping",
                                "Accompanying to appointments"
                            ];
                            foreach ($tasks as $task) {
                                echo '
                <div class="flex items-center gap-4 p-4 rounded-xl border border-gray-50 hover:border-brand/20 hover:bg-brand/[0.02] transition-all group">
                    <div class="w-8 h-8 rounded-lg bg-brand/10 flex items-center justify-center text-brand shrink-0 group-hover:bg-brand group-hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <span class="text-gray-600 font-medium text-sm md:text-base">' . $task . '</span>
                </div>';
                            }
                            ?>
                        </div>
                    </div>

                    <div
                        class="bg-darkText p-8 md:p-10 rounded-[2.5rem] text-white relative overflow-hidden shadow-2xl shadow-black/20">
                        <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-brand/20 rounded-full blur-[80px]"></div>

                        <h3 class="font-heading text-2xl font-bold mb-8 flex items-center gap-3">
                            What We Are Looking For
                            <span class="w-12 h-[2px] bg-brand"></span>
                        </h3>

                        <div class="space-y-5 relative z-10">
                            <?php
                            $requirements = [
                                "A genuine desire to help others and make a difference.",
                                "Excellent communication and listening skills.",
                                "Reliability and a strong work ethic.",
                                "Right to work in the UK."
                            ];
                            foreach ($requirements as $req) {
                                echo '
                <div class="flex items-start gap-4 group/item">
                    <div class="mt-1.5 w-2 h-2 rounded-full bg-brand group-hover/item:scale-150 transition-transform"></div>
                    <p class="text-gray-300 font-medium group-hover/item:text-white transition-colors">' . $req . '</p>
                </div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-5">
                    <div class="sticky top-28 space-y-6">

                        <div
                            class="bg-white rounded-[2.5rem] p-8 md:p-10 shadow-[0_20px_50px_rgba(0,0,0,0.1)] border border-gray-100 relative overflow-hidden group">

                            <div
                                class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-brand/50 via-brand to-brand/50">
                            </div>

                            <div class="relative z-10">
                                <h3 class="font-heading text-3xl font-bold text-darkText mb-2">Apply Now</h3>
                                <p class="text-gray-500 text-sm mb-8">Take the first step towards a rewarding career.
                                    We'll review your CV within 48 hours.</p>

                                <form action="#" method="POST" enctype="multipart/form-data" class="space-y-6">
                                    <div class="space-y-4">
                                        <div>
                                            <label
                                                class="text-[10px] uppercase font-bold text-brand tracking-widest ml-1 mb-1 block">Full
                                                Name</label>
                                            <input type="text" placeholder="e.g. Sarah Jenkins" required
                                                class="w-full px-5 py-3.5 rounded-xl border border-gray-200 focus:border-brand focus:ring-4 focus:ring-brand/10 outline-none transition-all bg-lightBg/50 text-darkText font-medium">
                                        </div>

                                        <div>
                                            <label
                                                class="text-[10px] uppercase font-bold text-brand tracking-widest ml-1 mb-1 block">Email
                                                Address</label>
                                            <input type="email" placeholder="sarah@example.com" required
                                                class="w-full px-5 py-3.5 rounded-xl border border-gray-200 focus:border-brand focus:ring-4 focus:ring-brand/10 outline-none transition-all bg-lightBg/50 text-darkText font-medium">
                                        </div>

                                        <div>
                                            <label
                                                class="text-[10px] uppercase font-bold text-brand tracking-widest ml-1 mb-1 block">Phone
                                                Number</label>
                                            <input type="tel" placeholder="+44 7000 000000" required
                                                class="w-full px-5 py-3.5 rounded-xl border border-gray-200 focus:border-brand focus:ring-4 focus:ring-brand/10 outline-none transition-all bg-lightBg/50 text-darkText font-medium">
                                        </div>
                                    </div>

                                    <div>
                                        <label
                                            class="text-[10px] uppercase font-bold text-gray-400 tracking-widest ml-1 mb-2 block">Attachment
                                            (CV/Resume)</label>
                                        <div class="relative group/upload">
                                            <input type="file" name="cv" required
                                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                            <div
                                                class="w-full px-4 py-8 border-2 border-dashed border-gray-200 rounded-2xl text-center group-hover/upload:border-brand group-hover/upload:bg-brand/[0.02] transition-all bg-lightBg/30">
                                                <svg class="w-6 h-6 text-brand mx-auto mb-2" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                                </svg>
                                                <p class="text-sm font-bold text-darkText">Click to upload <span
                                                        class="text-gray-400 font-normal text-xs uppercase">PDF/DOC</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="pt-2">
                                        <button type="submit"
                                            class="w-full inline-flex items-center justify-center gap-3 px-6 py-4 border border-transparent text-base font-bold rounded-xl text-white bg-brand hover:bg-brandDark shadow-[0_15px_35px_-5px_rgba(0,0,0,0.25)] hover:shadow-[0_20px_40px_-5px_rgba(0,0,0,0.35)] transition-all duration-300 transform hover:-translate-y-1 active:scale-[0.98]">
                                            Send Application
                                            <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                            </svg>
                                        </button>
                                    </div>
                                </form>

                                <div
                                    class="mt-8 pt-6 border-t border-gray-100 flex items-center justify-center gap-6 opacity-60">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-brand" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <span
                                            class="text-[10px] font-bold text-darkText uppercase tracking-widest">Secure
                                            Data</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-brand" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z"></path>
                                            <path fill-rule="evenodd"
                                                d="M4 5a2 2 0 012-2 3 3 0 003 3h2a3 3 0 003-3 2 2 0 012 2v11a2 2 0 01-2 2H6a2 2 0 01-2-2V5zm3 4a1 1 0 000 2h.01a1 1 0 100-2H7zm3 0a1 1 0 000 2h3a1 1 0 100-2h-3zm-3 4a1 1 0 100 2h.01a1 1 0 100-2H7zm3 0a1 1 0 100 2h3a1 1 0 100-2h-3z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-[10px] font-bold text-darkText uppercase tracking-widest">GDPR
                                            Compliant</span>
                                    </div>
                                </div>
                            </div>
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