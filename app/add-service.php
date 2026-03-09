<?php
include('db.php');
$pageTitle = 'Manage Add Service';
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}
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
                    <h1 class="text-3xl font-bold font-heading text-gray-800">Add New Service</h1>
                    <div class="flex gap-3">
                        <a href="services.php"
                            class="font-nav bg-gray-600 text-white px-4 py-2 rounded shadow flex items-center gap-2 hover:bg-gray-700 transition-colors">
                            <i class="fa-solid fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 md:p-8" data-aos="fade-up">
                    <form action="logics.php" method="POST" enctype="multipart/form-data">

                        <div class="bg-gray-50 rounded border border-gray-200 p-6 mb-6">
                            <div class="grid grid-cols-1 gap-4">
                                <div class="mb-4">
                                    <label class="font-body block text-sm font-semibold mb-1">Service Name</label>
                                    <input type="text" name="title"
                                        class="font-body w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end focus:border-transparent"
                                        required placeholder="Type service name">
                                </div>
                            </div>
                            <div>
                                <label class="font-body block text-sm font-semibold mb-1">Description</label>
                                <textarea id="textarea-description" placeholder="Type description" name="description"
                                    rows="4" class="font-body w-full px-3 py-2 border rounded"></textarea>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded border border-gray-200 p-6 mb-6">
                            <label class="font-body block text-sm font-semibold text-gray-700 mb-2">Service
                                Image</label>
                            <label for="file-upload"
                                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-primary-end border-dashed rounded-md cursor-pointer hover:bg-gray-100 transition-colors bg-white">
                                <div class="space-y-1 text-center w-full">

                                    <div id="preview-container" class="hidden flex justify-center mb-4">
                                    </div>

                                    <div id="placeholder-container">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none"
                                            viewBox="0 0 48 48" aria-hidden="true">
                                            <path
                                                d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02"
                                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600 justify-center font-body">
                                            <span
                                                class="relative font-medium text-primary-start hover:text-primary-end">
                                                Upload a file
                                            </span>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500 font-body">PNG, JPG up to 10MB</p>
                                    </div>

                                    <input id="file-upload" name="image" type="file" class="sr-only" accept="image/*"
                                        onchange="previewImage(event)">
                                </div>
                            </label>
                        </div>
                        <div class="mt-6 text-right">
                            <button type="submit" name="add_service"
                                class="font-nav bg-primary-start text-white px-6 py-2 rounded shadow hover:bg-primary-end transition font-bold uppercase tracking-wider">Save
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

    // Single Image Preview Logic
    function previewImage(event) {
        const container = document.getElementById('preview-container');
        const placeholder = document.getElementById('placeholder-container');
        const file = event.target.files[0];

        container.innerHTML = '';

        if (file) {
            placeholder.classList.add('hidden');
            container.classList.remove('hidden');

            const reader = new FileReader();
            reader.onload = function(e) {
                const imgWrapper = document.createElement('div');
                imgWrapper.className =
                    'relative w-48 h-48 rounded-lg overflow-hidden shadow-sm border border-gray-200';

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