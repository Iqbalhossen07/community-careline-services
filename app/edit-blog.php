<?php
include('db.php'); // ডেটাবেস কানেকশন

// সেশন চেক
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}
$pageTitle = 'Edit Blog Post';
$upload_folder = 'uploads/blog_images/';

// --- ধাপ ১: URL থেকে ID নেওয়া ---
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['message'] = "Invalid blog ID.";
    $_SESSION['message_type'] = 'error';
    header('Location: blogs.php');
    exit();
}

$blog_id = $_GET['id'];

// --- ধাপ ২: ID দিয়ে ডেটাবেস থেকে ব্লগটি খুঁজে বের করা ---
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

// ছবির বর্তমান পাথ
$current_image_path = (!empty($blog['image'])) ? $upload_folder . $blog['image'] : '';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php') ?>
    <title>Edit Blog Post - Admin Dashboard</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <style>
        .file-upload-box {
            transition: all 0.3s ease;
            background-color: #f9fafb;
        }
        .file-upload-box:hover {
            background-color: #ffffff;
            border-color: #44afe4; 
        }
    </style>
</head>

<body class="bg-gray-100 font-body"> <div class="flex h-screen">

        <?php include('sidebar.php') ?>

        <main class="flex-1 h-full overflow-y-auto">

            <?php include('top.php') ?>
            
            <div class="p-8 mb-32 md:mb-0 ">

                <div class="flex justify-between items-center mb-6" data-aos="fade-down">
                    <h1 class="text-3xl font-bold font-heading text-gray-800">
                        Edit Blog Post
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
                    <form action="logics.php" method="POST" enctype="multipart/form-data">
                        
                        <input type="hidden" name="id" value="<?php echo $blog['id']; ?>">
                        <input type="hidden" name="old_image" value="<?php echo htmlspecialchars($blog['image']); ?>">

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div class="md:col-span-2 font-body">
                                <label for="blog_title" class="block text-sm font-semibold text-gray-700 mb-2">Post Title</label>
                                <input type="text" id="blog_title" name="name" class="font-body w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end focus:border-transparent" 
                                    value="<?php echo htmlspecialchars($blog['name']); ?>" required>
                            </div>

                            <div class="font-body">
                                <label for="blog_category" class="block text-sm font-semibold text-gray-700 mb-2">Category</label>
                                <input type="text" id="blog_category" name="category" class="font-body w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end focus:border-transparent" 
                                    value="<?php echo htmlspecialchars($blog['category']); ?>" required>
                            </div>

                            <div class="font-body">
                                <label for="blog_author" class="block text-sm font-semibold text-gray-700 mb-2">Author</label>
                                <input type="text" id="blog_author" name="author_name" class="font-body w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end focus:border-transparent" 
                                    value="<?php echo htmlspecialchars($blog['author_name']); ?>" required>
                            </div>

                            <div class="md:col-span-2 font-body">
                                <label for="textarea-description" class="block text-sm font-semibold text-gray-700 mb-2">Blog Content</label>
                                <textarea id="textarea-description" name="description" rows="10" class="font-body w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end focus:border-transparent">
                                    <?php echo htmlspecialchars($blog['description']); ?>
                                </textarea>
                            </div>

                            <div class="md:col-span-2 font-body">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Blog Thumbnail (Change)</label>
                                <label for="file-upload" class="file-upload-box mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed border-primary-end rounded-md cursor-pointer">
                                    <div class="space-y-1 text-center">
                                        
                                        <img id="image-preview" 
                                             src="<?php echo $current_image_path; ?>" 
                                             alt="Current Image Preview" 
                                             class="<?php echo empty($current_image_path) ? 'hidden' : ''; ?> w-64 h-auto mx-auto rounded-lg shadow-md mb-4"/>
                                        
                                        <svg id="svg-placeholder" 
                                             class="<?php echo empty($current_image_path) ? '' : 'hidden'; ?> mx-auto h-12 w-12 text-gray-400" 
                                             stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        
                                        <div class="flex text-sm text-gray-600 justify-center">
                                            <span class="font-nav relative font-medium text-primary-start hover:text-primary-end">
                                                Click to upload a new file
                                            </span>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-400 font-body">PNG, JPG up to 10MB (Leave blank to keep current image)</p>
                                    </div>
                                    <input id="file-upload" name="image" type="file" class="sr-only" onchange="previewImage(event)">
                                </label>
                            </div>
                            
                        </div>

                        <div class="mt-8 text-right">
                            <button type="submit" name="update_blog" class="font-nav inline-flex items-center justify-center bg-primary-start text-white px-6 py-2 rounded-lg shadow-md hover:bg-primary-end transition-colors duration-300 font-bold uppercase tracking-widest text-sm w-full md:w-auto">
                                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                                </svg>
                                <span>Update Post</span>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </main>
    </div>

    <?php include('bottom.php') ?>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="main.js"></script>
    
    <script>
        function previewImage(event) {
            const preview = document.getElementById('image-preview');
            const placeholder = document.getElementById('svg-placeholder');
            const file = event.target.files[0];
            
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden'); 
                    placeholder.classList.add('hidden'); 
                }
                
                reader.readAsDataURL(file);
            }
        }
        
        CKEDITOR.replace('textarea-description'); 
    </script>
</body>
</html>