<?php
include('db.php'); // ডেটাবেস কানেকশন
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
};

// টেবিল থেকে মোট রো গণনা করার ফাংশন
function getCount($mysqli, $table)
{
    $result = $mysqli->query("SELECT COUNT(*) FROM {$table}");
    if ($result) {
        return $result->fetch_row()[0];
    }
    return 0;
}

// সব টেবিলের মোট গণনা
$hero_images_count    = getCount($mysqli, 'hero_images');
$services_count      = getCount($mysqli, 'services');
$portfolio_count     = getCount($mysqli, 'portfolios');
$blogs_count         = getCount($mysqli, 'blogs');
$members_count       = getCount($mysqli, 'members');
$messages_count      = getCount($mysqli, 'messages');

// --- ডেটাবেস থেকে মেসেজ আনা ---
$messages = [];
$result = $mysqli->query("SELECT * FROM messages ORDER BY id DESC LIMIT 3");
if ($result) {
    $messages = $result->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php') ?>
</head>

<body class="bg-gray-100 font-body">
    <div class="flex h-screen">

        <?php include('sidebar.php') ?>

        <main class="flex-1 h-full overflow-y-auto">

            <?php include('top.php') ?>

            <div class="p-8 mb-32 md:mb-0">

                <?php
                date_default_timezone_set('Europe/London');
                $initial_date = date('l, F j, Y');
                $initial_time = date('h:i:s A');
                ?>

                <div class="bg-gradient-to-r from-primary-start to-primary-end text-white p-8 rounded-xl shadow-xl mb-8 transition-all duration-300 ease-in-out hover:shadow-2xl hover:-translate-y-1" data-aos="fade-down" data-aos-duration="1000">
                    <div class="flex flex-col md:flex-row justify-between items-center md:items-center gap-6">

                        <div class="text-center md:text-left">
                            <h2 class="text-3xl font-heading mb-3"> Welcome Back, Admin! </h2>
                            <p class="font-body text-sm md:text-base opacity-90 leading-relaxed max-w-2xl">
                                "Every great structure starts with a solid foundation." <br>
                                Your vision is the blueprint of our success. Let's craft something timeless today.
                            </p>
                        </div>

                        <div class="w-full md:w-auto flex flex-col items-center md:items-end gap-1 bg-white/10 px-5 py-4 rounded-lg backdrop-blur-sm border border-white/20 shadow-inner min-w-[160px]">
                            <div class="flex items-center text-sm font-semibold text-sky-100 font-body">
                                <i class="fa-regular fa-clock mr-2"></i>
                                <span>London, UK</span>
                            </div>

                            <div id="liveDate" class="text-xs opacity-90 font-body text-center md:text-right">
                                <?php echo $initial_date; ?>
                            </div>

                            <div id="liveTime" class="text-2xl font-heading tracking-wider tabular-nums text-center md:text-right">
                                <?php echo $initial_time; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 mb-8">

                    <div class="bg-white border-l-4 p-4 rounded-xl shadow-md flex items-center space-x-4 border border-red-200 transition-all duration-300 ease-in-out hover:scale-[1.05] hover:bg-red-50" data-aos="fade-up" data-aos-delay="100">
                        <div class="w-12 h-12 flex items-center justify-center bg-red-50 rounded-full shadow-lg shadow-red-300/50">
                            <i class="fa-solid fa-images text-red-500 text-xl"></i>
                        </div>
                        <div>
                            <p class="font-body text-sm text-gray-500 uppercase tracking-wider">Hero Images</p>
                            <p class="text-2xl font-heading text-gray-900"><?php echo $hero_images_count; ?></p>
                        </div>
                    </div>

                    <div class="bg-white border-l-4 p-4 rounded-xl shadow-md flex items-center space-x-4 border border-blue-200 transition-all duration-300 ease-in-out hover:scale-[1.05] hover:bg-blue-50" data-aos="fade-up" data-aos-delay="200">
                        <div class="w-12 h-12 flex items-center justify-center bg-blue-50 rounded-full shadow-lg shadow-blue-300/50">
                            <i class="fa-solid fa-layer-group text-blue-500 text-xl"></i>
                        </div>
                        <div>
                            <p class="font-body text-sm text-gray-500 uppercase tracking-wider">Services</p>
                            <p class="text-2xl font-heading text-gray-900"><?php echo $services_count; ?></p>
                        </div>
                    </div>

                    <div class="bg-white border-l-4 p-4 rounded-xl shadow-md flex items-center space-x-4 border border-green-200 transition-all duration-300 ease-in-out hover:scale-[1.05] hover:bg-green-50" data-aos="fade-up" data-aos-delay="300">
                        <div class="w-12 h-12 flex items-center justify-center bg-green-50 rounded-full shadow-lg shadow-green-300/50">
                            <i class="fa-solid fa-building text-green-500 text-xl"></i>
                        </div>
                        <div>
                            <p class="font-body text-sm text-gray-500 uppercase tracking-wider">Portfolios</p>
                            <p class="text-2xl font-heading text-gray-900"><?php echo $portfolio_count; ?></p>
                        </div>
                    </div>

                    <div class="bg-white border-l-4 p-4 rounded-xl shadow-md flex items-center space-x-4 border border-indigo-200 transition-all duration-300 ease-in-out hover:scale-[1.05] hover:bg-indigo-50" data-aos="fade-up" data-aos-delay="400">
                        <div class="w-12 h-12 flex items-center justify-center bg-indigo-50 rounded-full shadow-lg shadow-indigo-300/50">
                            <i class="fa-solid fa-newspaper text-indigo-500 text-xl"></i>
                        </div>
                        <div>
                            <p class="font-body text-sm text-gray-500 uppercase tracking-wider">Blogs</p>
                            <p class="text-2xl font-heading text-gray-900"><?php echo $blogs_count; ?></p>
                        </div>
                    </div>

                    <div class="bg-white border-l-4 p-4 rounded-xl shadow-md flex items-center space-x-4 border border-yellow-200 transition-all duration-300 ease-in-out hover:scale-[1.05] hover:bg-yellow-50" data-aos="fade-up" data-aos-delay="500">
                        <div class="w-12 h-12 flex items-center justify-center bg-yellow-50 rounded-full shadow-lg shadow-yellow-300/50">
                            <i class="fa-solid fa-users text-yellow-500 text-xl"></i>
                        </div>
                        <div>
                            <p class="font-body text-sm text-gray-500 uppercase tracking-wider">Members</p>
                            <p class="text-2xl font-heading text-gray-900"><?php echo $members_count; ?></p>
                        </div>
                    </div>

                    <div class="bg-white border-l-4 p-4 rounded-xl shadow-md flex items-center space-x-4 border border-sky-200 transition-all duration-300 ease-in-out hover:scale-[1.05] hover:bg-sky-50" data-aos="fade-up" data-aos-delay="600">
                        <div class="w-12 h-12 flex items-center justify-center bg-sky-50 rounded-full shadow-lg shadow-sky-300/50">
                            <i class="fa-solid fa-envelope text-sky-500 text-xl"></i>
                        </div>
                        <div>
                            <p class="font-body text-sm text-gray-500 uppercase tracking-wider">Messages</p>
                            <p class="text-2xl font-heading text-gray-900"><?php echo $messages_count; ?></p>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 mb-8 mt-8">
                    <a href="hero-sliders.php" class="font-nav w-full text-center py-4 px-3 text-xs font-semibold rounded-lg text-white transition-all duration-300 hover:-translate-y-0.5 bg-red-500 shadow-lg shadow-red-500/40 hover:shadow-xl">
                        Manage Hero Sliders
                    </a>
                    <a href="services.php" class="font-nav w-full text-center py-4 px-3 text-xs font-semibold rounded-lg text-white transition-all duration-300 hover:-translate-y-0.5 bg-blue-500 shadow-lg shadow-blue-500/40 hover:shadow-xl">
                        Manage Services
                    </a>
                    <a href="portfolio.php" class="font-nav w-full text-center py-4 px-3 text-xs font-semibold rounded-lg text-white transition-all duration-300 hover:-translate-y-0.5 bg-green-500 shadow-lg shadow-green-500/40 hover:shadow-xl">
                        Manage Portfolios
                    </a>
                    <a href="blogs.php" class="font-nav w-full text-center py-4 px-3 text-xs font-semibold rounded-lg text-white transition-all duration-300 hover:-translate-y-0.5 bg-indigo-500 shadow-lg shadow-indigo-500/40 hover:shadow-xl">
                        Manage Blogs
                    </a>
                    <a href="members.php" class="font-nav w-full text-center py-4 px-3 text-xs font-semibold rounded-lg text-white transition-all duration-300 hover:-translate-y-0.5 bg-yellow-500 shadow-lg shadow-yellow-500/4C hover:shadow-xl">
                        Manage Members
                    </a>
                    <a href="contact-messages.php" class="font-nav w-full text-center py-4 px-3 text-xs font-semibold rounded-lg text-white transition-all duration-300 hover:-translate-y-0.5 bg-sky-500 shadow-lg shadow-sky-500/40 hover:shadow-xl">
                        View Messages
                    </a>
                </div>

                <div>
                    <div class="flex justify-between items-center mb-6" data-aos="fade-down">
                        <h1 class="text-2xl font-heading text-gray-800">
                            Recent Contact Form Submissions
                        </h1>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php if (!empty($messages)) : ?>
                            <?php foreach ($messages as $index => $msg) : ?>
                                <div class="border-card bg-white rounded-xl shadow-lg flex flex-col" data-aos="fade-up" data-aos-delay="<?php echo ($index % 3 + 1) * 100; ?>">
                                    <div class="p-5 border-b border-gray-100 flex justify-between items-start">
                                        <div>
                                            <h3 class="text-xl font-heading text-gray-900"><?php echo htmlspecialchars($msg['name']); ?></h3>
                                            <p class="font-body text-sm text-gray-500 mt-1"><?php echo htmlspecialchars($msg['email']); ?></p>
                                        </div>
                                    </div>

                                    <div class="p-5 flex-1 space-y-4">
                                        <div>
                                            <label class="font-body block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Phone Number</label>
                                            <p class="font-body text-gray-700 font-bold"><?php echo htmlspecialchars($msg['phone']); ?></p>
                                        </div>
                                        <div>
                                            <label class="font-body block text-xs font-semibold text-gray-500 mb-1 uppercase tracking-wider">Message</label>
                                            <div class="font-body message-content text-gray-700 text-sm leading-relaxed max-h-[150px] overflow-y-auto pr-2">
                                                <p>
                                                    <?php echo nl2br(htmlspecialchars($msg['message'])); ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="col-span-full text-center font-body text-gray-500">No messages found.</p>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <?php include('bottom.php') ?>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="main.js"></script>
</body>

</html>