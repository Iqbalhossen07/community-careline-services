<?php include('head.php');
// ১. ইউআরএল থেকে আইডি চেক করা
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: blogs.php'); // আইডি না থাকলে মেইন ব্লগ পেইজে পাঠিয়ে দিবে
    exit();
}

$id = intval($_GET['id']);

// ২. ডাটাবেস থেকে ওই নির্দিষ্ট ব্লগের ডাটা আনা
$stmt = $mysqli->prepare("SELECT * FROM blogs WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$blog = $result->fetch_assoc();

// যদি ডাটা না পাওয়া যায়
if (!$blog) {
    header('Location: blogs.php');
    exit();
}

// ইমেজ পাথ হ্যান্ডেল করা
$blog_images = !empty($blog['image']) ? explode(',', $blog['image']) : [];
$display_image = !empty($blog_images) ? trim($blog_images[0]) : '';
$formatted_date = date('M d, Y', strtotime($blog['created_at']));
?>

<body class="font-body text-gray-600 antialiased bg-white">
    <!-- header section  -->
    <?php include('header.php') ?>

    <!-- breadcrumb section -->
    <section class="relative h-[350px] flex items-center overflow-hidden bg-darkText">
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?auto=format&fit=crop&w=1500&q=80"
                class="w-full h-full object-cover opacity-20" alt="Blog Details">
            <div class="absolute inset-0 bg-gradient-to-r from-darkText via-darkText/80 to-transparent"></div>
        </div>

        <div class="max-w-7xl mx-auto px-6 lg:px-12 relative z-10 w-full mt-20">
            <nav class="flex mb-4 text-sm font-medium">
                <ol class="inline-flex items-center space-x-2">
                    <li><a href="index.php" class="text-gray-400 hover:text-brand transition-colors">Home</a></li>
                    <li class="text-gray-600">/</li>
                    <li><a href="blogs.php" class="text-gray-400 hover:text-brand transition-colors">Blogs</a></li>
                    <li class="text-gray-600">/</li>
                    <li class="text-brand font-bold uppercase tracking-widest text-[11px] md:text-sm">Blog Details
                    </li>
                </ol>
            </nav>
            <h1
                class="font-heading text-2xl md:text-4xl font-bold text-white mb-2 tracking-tight max-w-4xl leading-tight">
                <?php echo htmlspecialchars($blog['name']); ?>
            </h1>
            <p class="text-gray-300 text-lg max-w-2xl">Read our latest articles about health, home care, and wellbeing.
            </p>
        </div>
    </section>

    <!-- blog details section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6 lg:px-12">
            <div class="grid lg:grid-cols-12 gap-12 lg:gap-16">

                <div class="lg:col-span-8">
                    <div
                        class="relative rounded-[2.5rem] overflow-hidden mb-12 shadow-[0_20px_50px_rgba(0,0,0,0.15)] border-8 border-white ring-1 ring-black/5">
                        <?php if (!empty($display_image)): ?>
                        <img src="app/uploads/blog_images/<?php echo htmlspecialchars($display_image); ?>"
                            alt="<?php echo htmlspecialchars($blog['name']); ?>" class="w-full h-[450px] object-cover">
                        <?php else: ?>
                        <div class="w-full h-[450px] bg-gray-200 flex items-center justify-center">
                            <i class="fa-solid fa-newspaper text-6xl text-gray-300"></i>
                        </div>
                        <?php endif; ?>

                        <span
                            class="absolute top-6 left-6 bg-brand text-white text-xs font-bold px-4 py-2 rounded-full shadow-lg uppercase">
                            <?php echo htmlspecialchars($blog['category']); ?>
                        </span>
                    </div>

                    <div class="flex flex-wrap items-center gap-6 mb-8 pb-8 border-b border-gray-100">
                        <div class="text-gray-500 text-sm flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-lightBg flex items-center justify-center">
                                <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="2">
                                    <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                    <line x1="16" y1="2" x2="16" y2="6"></line>
                                    <line x1="8" y1="2" x2="8" y2="6"></line>
                                    <line x1="3" y1="10" x2="21" y2="10"></line>
                                </svg>
                            </div>
                            <span class="font-medium text-darkText tracking-tight"><?php echo $formatted_date; ?></span>
                        </div>

                        <div class="text-gray-500 text-sm flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-lightBg flex items-center justify-center">
                                <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <span
                                class="font-medium text-darkText"><?php echo htmlspecialchars($blog['author_name']); ?></span>
                        </div>
                    </div>

                    <div class="prose prose-lg max-w-none text-gray-600 leading-relaxed font-body">
                        <h1 class="text-3xl md:text-4xl font-bold text-darkText mb-6 font-heading">
                            <?php echo htmlspecialchars($blog['name']); ?>
                        </h1>

                        <div class="blog-content-area space-y-6">
                            <?php echo $blog['description']; ?>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-4 space-y-12">
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


                    <?php
                    // ১. বর্তমান ব্লগের আইডি বাদে সবশেষ ৩টি ব্লগ ফেচ করা
                    // $id ভেরিয়েবলটি আপনার ডিটেইল পেইজে আগে থেকেই ডিফাইন করা আছে
                    $recent_query = "SELECT id, name, image, created_at FROM blogs WHERE id != $id ORDER BY id DESC LIMIT 3";
                    $recent_result = $mysqli->query($recent_query);
                    ?>

                    <div class="bg-white p-8 rounded-3xl border border-gray-100 shadow-xl shadow-black/5">
                        <h4 class="font-heading text-xl font-bold text-darkText mb-6">Recent Posts</h4>
                        <div class="space-y-6">

                            <?php if ($recent_result && $recent_result->num_rows > 0): ?>
                            <?php while ($recent = $recent_result->fetch_assoc()):
                                    // ইমেজ হ্যান্ডেলিং
                                    $r_images = explode(',', $recent['image']);
                                    $r_main_img = trim($r_images[0]);
                                    $r_date = date('M d, Y', strtotime($recent['created_at']));
                                ?>
                            <a href="blog-details.php?id=<?php echo $recent['id']; ?>" class="group flex gap-4">
                                <div class="w-20 h-20 rounded-xl overflow-hidden shrink-0 bg-gray-100">
                                    <?php if (!empty($r_main_img)): ?>
                                    <img src="app/uploads/blog_images/<?php echo htmlspecialchars($r_main_img); ?>"
                                        alt="<?php echo htmlspecialchars($recent['name']); ?>"
                                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                    <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center text-gray-300">
                                        <i class="fa-solid fa-image"></i>
                                    </div>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <h5
                                        class="text-sm font-bold text-darkText group-hover:text-brand transition-colors line-clamp-2 leading-snug">
                                        <?php echo htmlspecialchars($recent['name']); ?>
                                    </h5>
                                    <p class="text-xs text-gray-400 mt-1"><?php echo $r_date; ?></p>
                                </div>
                            </a>
                            <?php endwhile; ?>
                            <?php else: ?>
                            <p class="text-xs text-gray-400">No other posts available.</p>
                            <?php endif; ?>

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