<?php include('head.php');

// ১. ইউআরএল থেকে আইডি চেক করা
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: services.php'); // আইডি না থাকলে লিস্ট পেইজে পাঠিয়ে দিবে
    exit();
}

$id = intval($_GET['id']); // সিকিউরিটির জন্য ইনটিজারে কনভার্ট করা

// ২. ডাটাবেস থেকে ওই নির্দিষ্ট সার্ভিসের ডাটা আনা
$stmt = $mysqli->prepare("SELECT * FROM services WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$service = $result->fetch_assoc();

// যদি ডাটা না পাওয়া যায়
if (!$service) {
    header('Location: services.php');
    exit();
}

// ইমেজ পাথ হ্যান্ডেল করা (প্রথম ইমেজটি মেইন ব্যানার হিসেবে দেখাবে)
$images_array = !empty($service['image']) ? explode(',', $service['image']) : [];
$display_image = !empty($images_array) ? trim($images_array[0]) : '';
?>

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
                    <li class="text-brand font-bold uppercase tracking-widest text-[11px] md:text-sm">Services Details
                    </li>
                </ol>
            </nav>
            <h1 class="font-heading text-2xl md:text-4xl font-bold text-white mb-2 tracking-tight">
                <?php echo htmlspecialchars($service['title']); ?>
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
                        <?php if (!empty($display_image)): ?>
                        <img src="app/uploads/services_images/<?php echo htmlspecialchars($display_image); ?>"
                            alt="<?php echo htmlspecialchars($service['title']); ?>"
                            class="w-full h-[400px] object-cover">
                        <?php else: ?>
                        <div class="w-full h-[400px] bg-gray-200 flex items-center justify-center">
                            <i class="fa-solid fa-image text-6xl text-gray-300"></i>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="space-y-8">
                        <div>
                            <h2 class="font-heading text-3xl font-bold text-darkText mb-4">
                                <?php echo htmlspecialchars($service['title']); ?>
                            </h2>

                            <div class="text-lg leading-relaxed text-gray-600 prose prose-brand max-w-none font-body">
                                <?php
                                // এখানে htmlspecialchars ব্যবহার করবেন না কারণ ডেসক্রিপশনে CKEditor এর HTML ট্যাগ আছে
                                echo $service['description'];
                                ?>
                            </div>
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


                                <a href="contact.php"
                                    class="mt-auto self-start inline-flex items-center justify-center px-5 py-2.5 border border-transparent text-sm font-bold rounded-md text-white bg-brand hover:bg-brandDark shadow-md shadow-black/20 hover:shadow-lg hover:shadow-black/30 transition-all duration-300 transform hover:-translate-y-1">
                                    Submit
                                    Request
                                </a>
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