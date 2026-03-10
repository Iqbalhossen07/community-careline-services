<?php include('head.php');

// ১. ইউআরএল থেকে আইডি চেক করা
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: careers.php');
    exit();
}

$id = intval($_GET['id']);

// ২. ডাটাবেস থেকে ওই নির্দিষ্ট ক্যারিয়ারের ডাটা আনা
$stmt = $mysqli->prepare("SELECT * FROM careers WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$career = $result->fetch_assoc();

if (!$career) {
    header('Location: careers.php');
    exit();
}

?>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>

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
                    <li class="text-brand font-bold uppercase tracking-widest text-[11px] md:text-sm">Care Details</li>
                </ol>
            </nav>
            <h1 class="font-heading text-2xl md:text-4xl font-bold text-white mb-2 tracking-tight">
                <?php echo $career['c_title']; ?></h1>
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

                        <div class="text-lg leading-relaxed mb-10 text-gray-600 text-justify font-body">
                            <?php echo $career['c_description']; ?>
                        </div>

                        <div
                            class="grid grid-cols-1 md:grid-cols-2 gap-2 p-6 rounded-2xl bg-lightBg border border-gray-100 shadow-inner">
                            <div class="space-y-1">
                                <p class="text-[10px] uppercase font-bold text-gray-400 tracking-[0.2em]">Salary</p>
                                <p class="text-darkText font-bold text-base">
                                    <?php echo !empty($career['c_salary']) ? htmlspecialchars($career['c_salary']) : 'Negotiable'; ?>
                                </p>
                            </div>

                            <div class="space-y-1 ">
                                <p class="text-[10px] uppercase font-bold text-gray-400 tracking-[0.2em]">Job Type</p>
                                <p class="text-darkText font-bold text-base">
                                    <?php echo htmlspecialchars($career['c_job_type']); ?></p>
                            </div>
                            <div class="space-y-1">
                                <p class="text-[10px] uppercase font-bold text-gray-400 tracking-[0.2em]">Location</p>
                                <div class="flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-brand animate-pulse"></span>
                                    <p class="text-darkText font-bold text-base">
                                        <?php echo htmlspecialchars($career['c_location']); ?></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <h3 class="font-heading text-2xl font-bold text-darkText flex items-center gap-4">
                            Key Responsibilities
                            <div class="h-[1px] flex-1 bg-gray-100"></div>
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 responsibilities-dynamic">
                            <?php
                            // CKEditor থেকে আসা ডাটা থেকে <li> ট্যাগগুলো আলাদা করে আপনার কাস্টম ডিজাইনে ঢোকানো হচ্ছে
                            $resp_html = $career['c_responsibilties'];
                            preg_match_all('/<li>(.*?)<\/li>/s', $resp_html, $matches);

                            if (!empty($matches[1])) {
                                foreach ($matches[1] as $task) {
                                    echo '
                <div class="flex items-center gap-4 p-4 rounded-xl border border-gray-50 hover:border-brand/20 hover:bg-brand/[0.02] transition-all group">
                    <div class="w-8 h-8 rounded-lg bg-brand/10 flex items-center justify-center text-brand shrink-0 group-hover:bg-brand group-hover:text-white transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <span class="text-gray-600 font-medium text-sm md:text-base">' . strip_tags($task) . '</span>
                </div>';
                                }
                            } else {
                                // যদি লিস্ট না থাকে সরাসরি টেক্সট দেখাবে
                                echo '<div class="col-span-full text-gray-600">' . $resp_html . '</div>';
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
                            $req_html = $career['c_requirements'];
                            preg_match_all('/<li>(.*?)<\/li>/s', $req_html, $matches_req);

                            if (!empty($matches_req[1])) {
                                foreach ($matches_req[1] as $req) {
                                    echo '
                <div class="flex items-start gap-4 group/item">
                    <div class="mt-1.5 w-2 h-2 rounded-full bg-brand group-hover/item:scale-150 transition-transform"></div>
                    <p class="text-gray-300 font-medium group-hover/item:text-white transition-colors">' . strip_tags($req) . '</p>
                </div>';
                                }
                            } else {
                                echo '<div class="text-gray-300">' . $req_html . '</div>';
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

                                <form action="app/logics.php" method="POST" enctype="multipart/form-data"
                                    class="space-y-6">
                                    <div class="space-y-4">
                                        <div>
                                            <label
                                                class="text-[10px] uppercase font-bold text-brand tracking-widest ml-1 mb-1 block">Full
                                                Name</label>
                                            <input type="text" name="name" placeholder="e.g. Sarah Jenkins" required
                                                class="w-full px-5 py-3.5 rounded-xl border border-gray-200 focus:border-brand focus:ring-4 focus:ring-brand/10 outline-none transition-all bg-lightBg/50 text-darkText font-medium">
                                        </div>

                                        <div>
                                            <label
                                                class="text-[10px] uppercase font-bold text-brand tracking-widest ml-1 mb-1 block">Email
                                                Address</label>
                                            <input type="email" name="email" placeholder="sarah@example.com" required
                                                class="w-full px-5 py-3.5 rounded-xl border border-gray-200 focus:border-brand focus:ring-4 focus:ring-brand/10 outline-none transition-all bg-lightBg/50 text-darkText font-medium">
                                        </div>

                                        <div>
                                            <label
                                                class="text-[10px] uppercase font-bold text-brand tracking-widest ml-1 mb-1 block">Phone
                                                Number</label>
                                            <input type="tel" name="phone" placeholder="+44 7000 000000" required
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

                                    <div class="mb-6">
                                        <div class="g-recaptcha" data-sitekey="6Lfvh4UsAAAAACm42iCtE0w_JvhRQyoEwn0B5aD0"
                                            data-callback="enableSubmitButton"
                                            data-expired-callback="disableSubmitButton">
                                        </div>
                                    </div>





                                    <button type="submit" id="final_submit_contact_btn" disabled name="submit_data"
                                        class="w-full py-3 bg-brand text-white font-bold rounded-xl shadow-[0_15px_30px_-5px_rgba(0,0,0,0.25)] transition-all duration-300 flex items-center justify-center gap-2 opacity-50 cursor-not-allowed">
                                        Send Application
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                                        </svg>
                                    </button>
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



    <script>
    const submitBtn = document.getElementById('final_submit_contact_btn');

    function enableSubmitButton() {
        submitBtn.disabled = false;

        // ১. ডিসাবলড স্টাইল রিমুভ (অস্পষ্টতা এবং কার্সার ঠিক করা)
        submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');

        // ২. আপনার প্রিমিয়াম অ্যানিমেশন এবং হোভার ইফেক্ট যুক্ত করা
        submitBtn.classList.add(
            'hover:shadow-[0_20px_40px_-5px_rgba(0,0,0,0.35)]',
            'hover:-translate-y-1',
            'active:scale-95'
        );
    }

    function disableSubmitButton() {
        submitBtn.disabled = true;

        // ১. ডিসাবলড স্টাইল আবার দেওয়া
        submitBtn.classList.add('opacity-50', 'cursor-not-allowed');

        // ২. হোভার ইফেক্টগুলো সরিয়ে নেওয়া
        submitBtn.classList.remove(
            'hover:shadow-[0_20px_40px_-5px_rgba(0,0,0,0.35)]',
            'hover:-translate-y-1',
            'active:scale-95'
        );
    }
    </script>
    <!-- js section -->
    <script src="main.js"></script>
</body>

</html>