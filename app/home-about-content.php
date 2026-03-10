<?php
include('db.php'); // ডেটাবেস কানেকশন

// সেশন চেক
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}
$pageTitle = 'Manage Home About Content';

// --- ডেটাবেস থেকে বর্তমান কনটেন্ট আনা ---
$current_data = [];
$query = "SELECT * FROM home_about_content WHERE id = 1 LIMIT 1";
$result = $mysqli->query($query);

if ($result && $result->num_rows > 0) {
    $current_data = $result->fetch_assoc();
}

// ভেরিয়েবল সেট করা
$current_title = $current_data['title'] ?? '';
$current_description = $current_data['content'] ?? '';
$current_images_str = $current_data['image'] ?? ''; // ইমেজ কলাম

// ছবিগুলো কমা দিয়ে স্ট্রিং আকারে আছে, তাই অ্যারে-তে কনভার্ট করছি
$existing_images_array = !empty($current_images_str) ? explode(',', $current_images_str) : [];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php') ?>
    <title>Home About Content - Careline</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <style>
    /* ইমেজ ডিলিট বাটন হোভার ইফেক্ট */
    .img-card:hover .delete-overlay {
        opacity: 1;
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
            <?php unset($_SESSION['message']);
                unset($_SESSION['message_type']);
            } ?>

            <div class="p-8 mb-32 md:mb-0 ">

                <div class="flex justify-between items-center mb-6" data-aos="fade-down">
                    <h1 class="text-3xl font-bold font-heading text-gray-800">
                        Manage Home About Content
                    </h1>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 md:p-8" data-aos="fade-up">

                    <form action="logics.php" method="POST" enctype="multipart/form-data">

                        <input type="hidden" name="old_images" id="old_images_input"
                            value="<?php echo htmlspecialchars($current_images_str); ?>">

                        <div class="grid grid-cols-1 gap-8">

                            <div>
                                <label class="font-body block text-sm font-semibold text-gray-700 mb-1">About
                                    Title</label>
                                <textarea name="title" rows="3"
                                    class="font-body w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end focus:border-transparent"
                                    placeholder="e.g., Our Ethos"
                                    required><?php echo htmlspecialchars($current_title); ?></textarea>
                            </div>

                            <div>
                                <label for="textarea-description"
                                    class="font-body block text-sm font-semibold text-gray-700 mb-2">Description</label>
                                <textarea id="textarea-description" name="content" rows="10"
                                    class="font-body w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end focus:border-transparent"
                                    placeholder="Write the about us content here..."><?php echo htmlspecialchars($current_description); ?></textarea>
                            </div>

                            <div class="bg-gray-50 rounded-lg border border-gray-200 p-6">
                                <h3 class="font-heading font-bold text-gray-800 mb-5 border-b pb-2">Manage Images</h3>

                                <?php if (!empty($existing_images_array)): ?>
                                <label
                                    class="font-body block text-xs font-semibold text-gray-500 mb-2 uppercase tracking-wide">Existing
                                    Images (Click 'X' to remove)</label>
                                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-6"
                                    id="existing-images-container">
                                    <?php foreach ($existing_images_array as $img): ?>
                                    <div class="relative group img-card bg-white p-1 rounded-lg shadow border border-gray-200"
                                        id="img-box-<?php echo md5($img); ?>">
                                        <img src="uploads/home_about_images/<?php echo $img; ?>"
                                            class="w-full h-32 object-cover rounded" alt="About Image">

                                        <button type="button"
                                            onclick="removeExistingImage('<?php echo $img; ?>', '<?php echo md5($img); ?>')"
                                            class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-7 h-7 flex items-center justify-center shadow-lg hover:bg-red-600 transition transform hover:scale-110 z-10"
                                            title="Remove this image">
                                            <i class="fa-solid fa-times text-xs"></i>
                                        </button>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php endif; ?>

                                <label
                                    class="font-body block text-xs font-semibold text-gray-500 mb-2 uppercase tracking-wide">Upload
                                    New Images (Add more)</label>
                                <label for="file-upload"
                                    class="flex justify-center px-6 pt-5 pb-6 border-2 border-primary-end border-dashed rounded-md cursor-pointer hover:bg-white bg-gray-50 transition-colors">
                                    <div class="space-y-1 text-center w-full">

                                        <div id="new-preview-container"
                                            class="hidden grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                                        </div>

                                        <div id="upload-placeholder">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor"
                                                fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path
                                                    d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600 justify-center font-body">
                                                <span
                                                    class="relative font-medium text-primary-start hover:text-primary-end">
                                                    Select files
                                                </span>
                                                <p class="pl-1">or drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500 font-body">PNG, JPG up to 10MB (Multiple
                                                allowed)</p>
                                        </div>

                                        <input id="file-upload" name="images[]" type="file" class="sr-only" multiple
                                            onchange="previewNewImages(event)">
                                    </div>
                                </label>
                            </div>

                        </div>

                        <div class="mt-8 text-right">
                            <button type="submit" name="update_home_about_content"
                                class="font-nav inline-flex items-center justify-center bg-primary-start text-white px-8 py-3 rounded-lg shadow-md hover:bg-primary-end transition-colors duration-300 font-bold">
                                <i class="fa-solid fa-cloud-arrow-up mr-2"></i>
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

    // --- লজিক ১: বর্তমান ছবি রিমুভ করা ---
    function removeExistingImage(filename, elementId) {
        // ১.১ HTML থেকে কার্ডটি সরিয়ে ফেলা
        const element = document.getElementById('img-box-' + elementId);
        if (element) {
            element.remove();
        }

        // ১.২ হিডেন ইনপুট ফিল্ড আপডেট করা (স্ট্রিং থেকে ফাইলের নাম বাদ দেওয়া)
        const input = document.getElementById('old_images_input');
        let currentImages = input.value.split(',');

        // অ্যারে থেকে নির্দিষ্ট ফাইলের নামটি খুঁজে বের করে বাদ দেওয়া
        const index = currentImages.indexOf(filename);
        if (index > -1) {
            currentImages.splice(index, 1);
        }

        // নতুন স্ট্রিং তৈরি করে ইনপুটে সেট করা
        input.value = currentImages.join(',');
    }

    // --- লজিক ২: নতুন ছবি আপলোড করার সময় প্রিভিউ দেখানো ---
    function previewNewImages(event) {
        const container = document.getElementById('new-preview-container');
        const placeholder = document.getElementById('upload-placeholder');
        const files = event.target.files;

        container.innerHTML = ''; // আগের প্রিভিউ পরিষ্কার করা

        if (files.length > 0) {
            placeholder.classList.add('hidden'); // প্লেসহোল্ডার লুকানো
            container.classList.remove('hidden'); // প্রিভিউ কন্টেইনার দেখানো

            Array.from(files).forEach(file => {
                const reader = new FileReader();

                reader.onload = function(e) {
                    // প্রিভিউ কার্ড তৈরি
                    const imgWrapper = document.createElement('div');
                    imgWrapper.className =
                        'relative w-full h-32 rounded-lg overflow-hidden shadow-sm border border-gray-200';

                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'w-full h-full object-cover';

                    imgWrapper.appendChild(img);
                    container.appendChild(imgWrapper);
                }

                reader.readAsDataURL(file);
            });
        } else {
            // যদি কোনো ফাইল সিলেক্ট না করা হয়
            container.classList.add('hidden');
            placeholder.classList.remove('hidden');
        }
    }
    </script>
</body>

</html>