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

// বর্তমানে শুধু একটি ইমেজ হ্যান্ডেল করা হচ্ছে
$existing_image = $service['image'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php') ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
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
                        <a href="services.php"
                            class="font-nav bg-gray-600 text-white px-4 py-2 rounded shadow flex items-center gap-2 hover:bg-gray-700 transition-colors">
                            <i class="fa-solid fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 md:p-8" data-aos="fade-up">
                    <form action="logics.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php echo $service['id']; ?>">
                        <input type="hidden" name="old_image" value="<?php echo htmlspecialchars($existing_image); ?>">

                        <div class="bg-gray-50 rounded border border-gray-200 p-6 mb-6">
                            <div class="grid grid-cols-1 gap-4">
                                <div class="mb-4">
                                    <label class="font-body block text-sm font-semibold mb-1">Service Name</label>
                                    <input type="text" name="title"
                                        class="font-body w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end focus:border-transparent"
                                        value="<?php echo htmlspecialchars($service['title']); ?>" required>
                                </div>
                            </div>
                            <div>
                                <label class="font-body block text-sm font-semibold mb-1">Description</label>
                                <textarea id="textarea-description" name="description" rows="4"
                                    class="font-body w-full px-3 py-2 border rounded"
                                    required><?php echo htmlspecialchars($service['description']); ?></textarea>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded border border-gray-200 p-6 mb-6">
                            <h3 class="font-heading font-bold text-gray-800 mb-4 border-b pb-2">Manage Image</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <label
                                        class="font-body block text-xs font-semibold text-gray-500 mb-2 uppercase tracking-wide">Current
                                        Image</label>
                                    <div
                                        class="relative w-48 h-48 bg-white p-2 rounded-lg shadow border border-gray-200">
                                        <?php if (!empty($existing_image)): ?>
                                        <img src="uploads/services_images/<?php echo $existing_image; ?>"
                                            class="w-full h-full object-cover rounded" alt="Service Image">
                                        <?php else: ?>
                                        <div class="w-full h-full flex items-center justify-center text-gray-300">
                                            <i class="fa-regular fa-image text-4xl"></i>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div>
                                    <label
                                        class="font-body block text-xs font-semibold text-gray-500 mb-2 uppercase tracking-wide">Change
                                        Image (Optional)</label>
                                    <label for="file-upload"
                                        class="flex justify-center px-6 pt-5 pb-6 border-2 border-primary-end border-dashed rounded-md cursor-pointer hover:bg-white bg-gray-50 transition-colors h-48">
                                        <div
                                            class="space-y-1 text-center w-full flex flex-col justify-center items-center">
                                            <div id="new-preview-container" class="hidden mb-2">
                                            </div>
                                            <div id="upload-placeholder">
                                                <svg class="mx-auto h-10 w-10 text-gray-400" stroke="currentColor"
                                                    fill="none" viewBox="0 0 48 48">
                                                    <path
                                                        d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                        stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                                <p class="text-sm text-gray-600 font-body mt-2">Click to replace image
                                                </p>
                                            </div>
                                            <input id="file-upload" name="image" type="file" class="sr-only"
                                                accept="image/*" onchange="previewNewImage(event)">
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-6 text-right">
                            <button type="submit" name="update_service"
                                class="font-nav bg-primary-start text-white px-6 py-2 rounded shadow hover:bg-primary-end transition font-bold uppercase tracking-wider">Update
                                Service</button>
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

    // --- Logic: Preview New Image ---
    function previewNewImage(event) {
        const container = document.getElementById('new-preview-container');
        const placeholder = document.getElementById('upload-placeholder');
        const file = event.target.files[0];

        container.innerHTML = '';

        if (file) {
            placeholder.classList.add('hidden');
            container.classList.remove('hidden');

            const reader = new FileReader();
            reader.onload = function(e) {
                const imgWrapper = document.createElement('div');
                imgWrapper.className =
                'relative w-32 h-32 rounded overflow-hidden shadow border-2 border-green-400';

                const img = document.createElement('img');
                img.src = e.target.result;
                img.className = 'w-full h-full object-cover';

                imgWrapper.appendChild(img);
                container.appendChild(imgWrapper);
            }
            reader.readAsDataURL(file);
        } else {
            container.classList.add('hidden');
            placeholder.classList.remove('hidden');
        }
    }
    </script>
</body>

</html>