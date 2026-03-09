<?php
include('db.php'); // ডেটাবেস কানেকশন

// সেশন চেক
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}
$pageTitle = 'Manage About Content';
$upload_folder = 'uploads/about_images/'; // ফোল্ডার পাথ

// --- ডেটাবেস থেকে বর্তমান কনটেন্ট আনা ---
$current_data = [];
$query = "SELECT * FROM about_content WHERE id = 1 LIMIT 1";
$result = $mysqli->query($query);

if ($result && $result->num_rows > 0) {
    $current_data = $result->fetch_assoc();
}

// ভেরিয়েবল সেট করা
$current_title = $current_data['title'] ?? ''; 
$current_description = $current_data['content'] ?? '';
$current_images_str = $current_data['image'] ?? ''; 

// কমা দিয়ে আলাদা করা ছবিগুলোকে অ্যারেতে কনভার্ট করা
$current_images = !empty($current_images_str) ? explode(',', $current_images_str) : [];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php') ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <style>
        .file-upload-box:hover {
            border-color: #44afe4; /* Primary Color */
            background-color: #f9fafb;
        }
    </style>
</head>

<body class="bg-gray-100 font-body"> 
    <div class="flex h-screen">

        <?php include('sidebar.php') ?>

        <main class="flex-1 h-full overflow-y-auto">

            <?php include('top.php') ?>
            
            <?php if (isset($_SESSION['message']) && $_SESSION['message'] != '') { ?>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: "<?php echo $_SESSION['message']; ?>",
                            icon: "<?php echo $_SESSION['message_type']; ?>",
                            confirmButtonText: "OK"
                        });
                    });
                </script>
            <?php unset($_SESSION['message']); unset($_SESSION['message_type']); } ?>
            
            <div class="p-8 mb-32 md:mb-0 ">

                <div class="flex justify-between items-center mb-6" data-aos="fade-down">
                    <h1 class="text-3xl font-bold font-heading text-gray-800">
                        Manage About Content
                    </h1>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 md:p-8" data-aos="fade-up">
                    
                    <form action="logics.php" method="POST" enctype="multipart/form-data"> 
                        
                        <input type="hidden" name="old_images" value="<?php echo htmlspecialchars($current_images_str); ?>">

                        <div class="grid grid-cols-1 gap-8">
                            
                            <div>
                                <label for="about_title" class="font-body block text-sm font-semibold text-gray-700 mb-2">About Title</label>
                                <input type="text" id="about_title" name="title" class="font-body w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end focus:border-transparent" 
                                    value="<?php echo htmlspecialchars($current_title); ?>" placeholder="e.g., Our Identity" required>
                            </div>

                            <div>
                                <label for="textarea-description" class="font-body block text-sm font-semibold text-gray-700 mb-2">Description</label>
                                <textarea id="textarea-description" name="description" rows="10" class="font-body w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end focus:border-transparent" 
                                    placeholder="Write the about us content here..."><?php echo htmlspecialchars($current_description); ?></textarea>
                            </div>
                            
                            <div class="bg-gray-50 p-6 rounded-lg border border-gray-200">
                                <label class="block text-sm font-semibold text-gray-700 mb-4">About Images (Multiple)</label>
                                
                                <div class="flex flex-col gap-6">
                                    
                                    <?php if(!empty($current_images)): ?>
                                    <div class="w-full">
                                        <p class="text-xs text-gray-500 mb-2 uppercase tracking-wide font-bold">Current Images</p>
                                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                            <?php foreach($current_images as $img): ?>
                                                <div class="relative group h-32 w-full">
                                                    <img src="<?php echo $upload_folder . $img; ?>" alt="Current Image" class="w-full h-full object-cover rounded-lg shadow-sm border border-gray-200">
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>

                                    <div class="w-full">
                                        <label for="file-upload" class="file-upload-box flex flex-col justify-center items-center h-40 px-6 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer transition-all">
                                            <div class="space-y-2 text-center">
                                                <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-400"></i>
                                                <div class="text-sm text-gray-600">
                                                    <span class="font-medium text-primary-start hover:text-primary-end">Click to upload</span>
                                                    <span>or drag and drop</span>
                                                </div>
                                                <p class="text-xs text-gray-500">Select multiple images (PNG, JPG)</p>
                                            </div>
                                            <input id="file-upload" name="image[]" type="file" class="sr-only" multiple onchange="previewImages(event)">
                                        </label>
                                    </div>
                                    
                                    <div id="new-images-preview" class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-2"></div>

                                </div>
                            </div>

                        </div>

                        <div class="mt-8 text-right">
                            <button type="submit" name="update_about_content" class="font-nav inline-flex items-center justify-center bg-primary-start text-white px-8 py-3 rounded-lg shadow-md hover:bg-primary-end transition-colors duration-300 font-bold">
                                <i class="fa-solid fa-save mr-2"></i>
                                <span>Save Changes</span>
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
        // Initialize CKEditor
        CKEDITOR.replace('textarea-description'); 

        // Multiple Image Preview Script
        function previewImages(event) {
            const previewContainer = document.getElementById('new-images-preview');
            previewContainer.innerHTML = ''; // Clear previous previews
            const files = event.target.files;

            if (files) {
                Array.from(files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const imgDiv = document.createElement('div');
                        imgDiv.className = 'relative h-24 w-full';
                        imgDiv.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover rounded-lg shadow-sm border border-green-200">`;
                        previewContainer.appendChild(imgDiv);
                    }
                    reader.readAsDataURL(file);
                });
            }
        }
    </script>
</body>
</html>