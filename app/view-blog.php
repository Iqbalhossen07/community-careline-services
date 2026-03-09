<?php
include('db.php'); // ডেটাবেস কানেকশন

// সেশন চেক
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}
$pageTitle = 'View Blog Post';
$upload_folder = 'uploads/blog_images/';

// --- Step 1: Get ID from URL ---
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['message'] = "Invalid blog ID.";
    $_SESSION['message_type'] = 'error';
    header('Location: blogs.php');
    exit();
}

$blog_id = $_GET['id'];

// --- Step 2: Fetch the blog post ---
$stmt = $mysqli->prepare("SELECT * FROM blogs WHERE id = ?");
$stmt->bind_param("i", $blog_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['message'] = "Blog post not found.";
    $_SESSION['message_type'] = 'error';
    header('Location: blogs.php');
    exit();
}

$blog = $result->fetch_assoc();
$stmt->close();

// Prepare image path
$image_path = (!empty($blog['image'])) ? $upload_folder . htmlspecialchars($blog['image']) : 'path/to/default-image.jpg';

// Format date
$date_display = 'N/A';
if (isset($blog['created_at']) && !empty($blog['created_at'])) {
    $date_display = date('F j, Y', strtotime($blog['created_at']));
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php') ?>
    <title>View Blog Post - Admin Dashboard</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <style>
        /* এডিটর থেকে আসা টেক্সটের জন্য কাস্টম ফন্ট অ্যাপ্লাই */
        .prose h1, .prose h2, .prose h3 { font-family: 'Archivo Black', sans-serif; }
        .prose p, .prose li { font-family: 'Space Grotesk', sans-serif; }
    </style>
</head>

<body class="bg-gray-100 font-body"> <div class="flex h-screen">

        <?php include('sidebar.php') ?>

        <main class="flex-1 h-full overflow-y-auto">

            <?php include('top.php') ?>
            
            <div class="p-8 mb-32 md:mb-0 ">

                <div class="flex justify-between items-center mb-6" data-aos="fade-down">
                    <h1 class="text-3xl font-bold font-heading text-gray-800">
                        Blog Post Details
                    </h1>
                    
                    <div class="flex gap-3">
                        <a href="blogs.php" class="font-nav flex items-center bg-gray-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-gray-700 transition-colors duration-300 font-semibold uppercase tracking-wider text-xs">
                            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                            </svg>
                            <span>Back to Blogs</span>
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 md:p-8" data-aos="fade-up">
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        
                        <div class="md:col-span-1">
                            <img src="<?php echo $image_path; ?>" alt="<?php echo htmlspecialchars($blog['name']); ?>" class="w-full h-auto rounded-lg shadow-md object-cover">
                        </div>

                        <div class="md:col-span-2 space-y-5">
                            
                            <div>
                                <label class="font-body block text-sm font-bold text-gray-400 uppercase tracking-widest mb-1">Category</label>
                                <p class="text-lg font-bold text-primary-start font-nav uppercase tracking-widest">
                                    <?php echo htmlspecialchars($blog['category']); ?>
                                </p>
                            </div>

                            <div>
                                <label class="font-body block text-sm font-bold text-gray-400 uppercase tracking-widest mb-1">Title</label>
                                <h2 class="text-3xl font-bold font-heading text-gray-900 leading-tight"><?php echo htmlspecialchars($blog['name']); ?></h2>
                            </div>

                            <div class="flex items-center gap-10 font-body">
                                <div>
                                    <label class="block text-sm font-bold text-gray-400 uppercase tracking-widest mb-1">Author</label>
                                    <p class="text-base text-gray-800 font-semibold"><?php echo htmlspecialchars($blog['author_name']); ?></p>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-400 uppercase tracking-widest mb-1">Date</label>
                                    <p class="text-base text-gray-800 font-semibold"><?php echo $date_display; ?></p>
                                </div>
                            </div>

                            <div>
                                <label class="font-body block text-sm font-bold text-gray-400 uppercase tracking-widest mb-2">Content</label>
                                <div class="font-body text-base text-gray-700 leading-relaxed space-y-4 prose max-w-none bg-gray-50 p-6 rounded-lg border border-gray-100">
                                    <?php echo $blog['description']; ?>
                                </div>
                            </div>
                            
                            <div class="border-t pt-5 text-right">
                                <a href="edit-blog.php?id=<?php echo $blog['id']; ?>" class="font-nav inline-flex items-center justify-center bg-primary-start text-white px-6 py-2 rounded-lg shadow-md hover:bg-primary-end transition-colors duration-300 font-bold uppercase tracking-widest text-sm">
                                    <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                    </svg>
                                    <span>Edit Post</span>
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