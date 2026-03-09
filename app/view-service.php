<?php
include('db.php'); // ডেটাবেস কানেকশন

// সেশন চেক
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}
$pageTitle = 'View Service Details';

// --- ধাপ ১: URL থেকে ID নেওয়া ---
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['message'] = "Invalid service ID.";
    $_SESSION['message_type'] = 'error';
    header('Location: services.php');
    exit();
}

$id = $_GET['id'];

// --- ধাপ ২: ডেটাবেস থেকে সার্ভিসটি খুঁজে বের করা ---
$stmt = $mysqli->prepare("SELECT * FROM services WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['message'] = "Service not found.";
    $_SESSION['message_type'] = 'error';
    header('Location: services.php');
    exit();
}

$service = $result->fetch_assoc();
$stmt->close();

// --- ধাপ ৩: ডেটা প্রস্তুত করা ---
$title = ($service['title']);
$category = ($service['category']);
$desc = $service['description'];

// --- Image Logic ---
$images_str = $service['image'];
$images_array = !empty($images_str) ? explode(',', $images_str) : [];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php') ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
</head>

<body class="bg-gray-100 font-body">
    <div class="flex h-screen">

        <?php include('sidebar.php') ?>

        <main class="flex-1 h-full overflow-y-auto">

            <?php include('top.php') ?>

            <div class="p-8 mb-32 md:mb-0">

                <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4" data-aos="fade-down">
                    <h1 class="text-3xl font-bold font-heading text-gray-800">
                        Service Details
                    </h1>

                    <div class="flex gap-3">
                        <a href="services.php" class="font-nav flex items-center bg-gray-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-gray-700 transition-colors duration-300 font-semibold uppercase tracking-wider text-xs">
                            <i class="fa-solid fa-arrow-left mr-2"></i>
                            <span>Back to Services</span>
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-8 md:p-10 max-w-7xl mx-auto" data-aos="fade-up">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

                        <div class="space-y-4">
                            <h3 class="font-body text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Service Images</h3>

                            <?php if (!empty($images_array)) : ?>
                                <div class="w-full h-64 md:h-80 rounded-xl overflow-hidden shadow-md border border-gray-200 group">
                                    <img src="uploads/services_images/<?php echo $images_array[0]; ?>"
                                        alt="Main Service Image"
                                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                </div>

                                <?php if (count($images_array) > 1) : ?>
                                    <div class="grid grid-cols-3 gap-3">
                                        <?php for ($i = 1; $i < count($images_array); $i++) : ?>
                                            <div class="h-24 rounded-lg overflow-hidden shadow-sm border border-gray-200 cursor-pointer opacity-80 hover:opacity-100 transition">
                                                <img src="uploads/services_images/<?php echo $images_array[$i]; ?>"
                                                    alt="Gallery Image"
                                                    class="w-full h-full object-cover">
                                            </div>
                                        <?php endfor; ?>
                                    </div>
                                <?php endif; ?>

                            <?php else : ?>
                                <div class="w-full h-64 bg-gray-100 flex items-center justify-center rounded-xl border-2 border-dashed border-gray-300 font-body">
                                    <p class="text-gray-400 flex flex-col items-center">
                                        <i class="fa-regular fa-image text-4xl mb-2"></i>
                                        No images uploaded
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="flex flex-col">

                            <div class="mb-6">
                                <label class="font-body block text-sm font-bold text-gray-500 mb-1 uppercase tracking-widest">Service Name</label>
                                <h2 class="text-3xl font-bold font-heading text-gray-900 leading-tight">
                                    <?php echo $title; ?>
                                </h2>
                            </div>

                            <div class="mb-4">
                                <?php if (!empty($category)): ?>
                                    <span class="font-body bg-green-50 text-green-600 text-[10px] font-bold px-2 py-1  rounded border border-green-100 uppercase tracking-wider">
                                        <i class="fa-solid fa-tag mr-1"></i><?php echo ($service['category']); ?>
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="mb-8">
                                <label class="font-body block text-sm font-bold text-gray-500 mb-2 uppercase tracking-widest">Description</label>
                                <div class="font-body text-gray-700 leading-relaxed prose max-w-none bg-gray-50 p-6 rounded-lg border border-gray-100 overflow-y-auto max-h-[400px]">
                                    <?php echo $desc; ?>
                                </div>
                            </div>

                            <div class="mt-auto pt-6 border-t border-gray-200">
                                <a href="edit-service.php?id=<?php echo $service['id']; ?>" class="font-nav inline-flex items-center px-6 py-3 bg-primary-start text-white rounded-lg shadow hover:bg-primary-end transition font-bold uppercase tracking-wider text-sm w-full md:w-auto justify-center">
                                    <i class="fa-solid fa-edit mr-2"></i> <span>Edit This Service</span>
                                </a>
                            </div>

                        </div>
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