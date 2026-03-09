<?php
include('db.php');
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: services.php');
    exit();
}
$id = $_GET['id'];

// Fetch Service Data
$stmt = $mysqli->prepare("SELECT * FROM services WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$service = $res->fetch_assoc();
$pageTitle = 'Manage Edit Service';
if (!$service) {
    header('Location: services.php');
    exit();
}

// ছবিগুলো কমা দিয়ে স্ট্রিং আকারে আছে, তাই অ্যারে-তে কনভার্ট করছি
$existing_images_str = $service['image'];
$existing_images_array = !empty($existing_images_str) ? explode(',', $existing_images_str) : [];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php') ?>
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
            <div class="p-8 mb-32 md:mb-0">
                <div class="flex justify-between items-center mb-6" data-aos="fade-down">
                    <h1 class="text-3xl font-bold font-heading text-gray-800">Edit Service</h1>
                    <div class="flex gap-3">
                        <a href="services.php" class="font-nav bg-gray-600 text-white px-4 py-2 rounded shadow flex items-center gap-2 hover:bg-gray-700 transition-colors">
                            <i class="fa-solid fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 md:p-8" data-aos="fade-up">
                    <form action="logics.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $service['id']; ?>">

                        <input type="hidden" name="old_image" id="old_image_input" value="<?php echo htmlspecialchars($existing_images_str); ?>">

                        <div class="bg-gray-50 rounded border border-gray-200 p-6 mb-6">


                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="mb-4">
                                    <label class="font-body block text-sm font-semibold mb-1">Service Name</label>
                                    <input type="text" name="title" class="font-body w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end focus:border-transparent" value="<?php echo htmlspecialchars($service['title']); ?>" required>
                                </div>
                                <div class="mb-4">
                                    <label class="font-body block text-sm font-semibold text-gray-700 mb-1">Category</label>
                                    <select name="category" class="font-body w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end focus:border-transparent bg-white" required>
                                        <option value="" disabled>Select Category</option>

                                        <?php
                                        // ১. ক্যাটাগরি টেবিল থেকে সব ডাটা ফেচ করা
                                        $cat_query = $mysqli->query("SELECT * FROM categories ORDER BY name ASC");

                                        if ($cat_query && $cat_query->num_rows > 0) {
                                            while ($row = $cat_query->fetch_assoc()) {
                                                $cat_name = htmlspecialchars($row['name']);

                                                // ২. চেক করা হচ্ছে এই ক্যাটাগরি কি বর্তমান সার্ভিসের ক্যাটাগরির সাথে মিলে কি না
                                                // যদি মিলে যায় তবে 'selected' ভেরিয়েবলে ডাটা সেট হবে
                                                $selected = ($cat_name == $service['category']) ? 'selected' : '';

                                                echo "<option value='$cat_name' $selected>$cat_name</option>";
                                            }
                                        } else {
                                            echo "<option value='' disabled>No categories found</option>";
                                        }
                                        ?>

                                    </select>
                                </div>
                            </div>
                            <div>
                                <label class="font-body block text-sm font-semibold mb-1">Description</label>
                                <textarea id="textarea-description" name="description" rows="4" class="font-body w-full px-3 py-2 border rounded" required><?php echo htmlspecialchars($service['description']); ?></textarea>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded border border-gray-200 p-6 mb-6">
                            <h3 class="font-heading font-bold text-gray-800 mb-4 border-b pb-2">Manage Images</h3>

                            <?php if (!empty($existing_images_array)): ?>
                                <label class="font-body block text-xs font-semibold text-gray-500 mb-2 uppercase tracking-wide">Existing Images (Click 'X' to remove)</label>
                                <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-6" id="existing-images-container">
                                    <?php foreach ($existing_images_array as $img): ?>
                                        <div class="relative group img-card bg-white p-1 rounded-lg shadow border border-gray-200" id="img-box-<?php echo md5($img); ?>">
                                            <img src="uploads/services_images/<?php echo $img; ?>" class="w-full h-32 object-cover rounded" alt="Service Image">

                                            <button type="button" onclick="removeExistingImage('<?php echo $img; ?>', '<?php echo md5($img); ?>')"
                                                class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-7 h-7 flex items-center justify-center shadow-lg hover:bg-red-600 transition transform hover:scale-110 z-10" title="Remove this image">
                                                <i class="fa-solid fa-times text-xs"></i>
                                            </button>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>

                            <label class="font-body block text-xs font-semibold text-gray-500 mb-2 uppercase tracking-wide">Upload New Images (Add more)</label>
                            <label for="file-upload" class="flex justify-center px-6 pt-5 pb-6 border-2 border-primary-end border-dashed rounded-md cursor-pointer hover:bg-white bg-gray-50 transition-colors">
                                <div class="space-y-1 text-center w-full">

                                    <div id="new-preview-container" class="hidden grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                                    </div>

                                    <div id="upload-placeholder">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600 justify-center font-body">
                                            <span class="relative font-medium text-primary-start hover:text-primary-end">
                                                Select files
                                            </span>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500 font-body">PNG, JPG up to 10MB (Multiple allowed)</p>
                                    </div>

                                    <input id="file-upload" name="images[]" type="file" class="sr-only" multiple onchange="previewNewImages(event)">
                                </div>
                            </label>
                        </div>

                        <div class="mt-6 text-right">
                            <button type="submit" name="update_service" class="font-nav bg-primary-start text-white px-6 py-2 rounded shadow hover:bg-primary-end transition font-bold uppercase tracking-wider">Update Service</button>
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

        // --- Logic 1: Remove Existing Image ---
        function removeExistingImage(filename, elementId) {
            const element = document.getElementById('img-box-' + elementId);
            if (element) {
                element.remove();
            }

            const input = document.getElementById('old_image_input');
            let currentImages = input.value.split(',');

            const index = currentImages.indexOf(filename);
            if (index > -1) {
                currentImages.splice(index, 1);
            }

            input.value = currentImages.join(',');
        }

        // --- Logic 2: Preview New Images ---
        function previewNewImages(event) {
            const container = document.getElementById('new-preview-container');
            const placeholder = document.getElementById('upload-placeholder');
            const files = event.target.files;

            container.innerHTML = '';

            if (files.length > 0) {
                placeholder.classList.add('hidden');
                container.classList.remove('hidden');

                Array.from(files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const imgWrapper = document.createElement('div');
                        imgWrapper.className = 'relative w-full h-24 rounded overflow-hidden shadow border border-green-200';

                        const badge = document.createElement('span');
                        // Added font-body to the dynamic badge
                        badge.className = 'absolute top-0 left-0 bg-green-500 text-white text-[10px] px-2 py-0.5 rounded-br font-bold z-10 font-body';
                        badge.innerText = 'NEW';

                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'w-full h-full object-cover opacity-90';

                        imgWrapper.appendChild(badge);
                        imgWrapper.appendChild(img);
                        container.appendChild(imgWrapper);
                    }
                    reader.readAsDataURL(file);
                });
            } else {
                container.classList.add('hidden');
                placeholder.classList.remove('hidden');
            }
        }
    </script>
</body>

</html>