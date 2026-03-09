<?php
include('db.php'); // ডেটাবেস কানেকশন

// সেশন চেক
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}
$pageTitle = 'Add New Portfolio Item';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php') ?>
    <title>Add New Portfolio Item - Admin Dashboard</title>
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <style>
        /* কাস্টম ফাইল আপলোড স্টাইল */
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

<body class="bg-gray-100 font-body">
    <div class="flex h-screen">

        <?php include('sidebar.php') ?>

        <main class="flex-1 h-full overflow-y-auto" data-aos="fade-down">

            <?php include('top.php') ?>

            <div class="p-8 mb-32 md:mb-0">

                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-3xl font-bold font-heading text-gray-800">
                        Add New Portfolio Item
                    </h1>
                    <a href="portfolio.php" class="font-nav flex items-center bg-gray-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-gray-700 transition-colors duration-300 font-semibold uppercase tracking-wider text-xs">
                        <i class="fa-solid fa-arrow-left mr-2"></i>
                        <span>Back to Portfolio</span>
                    </a>
                </div>

                <form action="logics.php" method="POST" enctype="multipart/form-data">

                    <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 mb-8">
                        <h2 class="font-heading text-xl font-bold text-gray-800 mb-4 border-b pb-2 flex items-center">
                            <span class="bg-blue-100 text-blue-600 w-8 h-8 rounded-full flex items-center justify-center mr-3 text-sm">01</span>
                            Basic Information
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                            <div class="md:col-span-2 space-y-4 font-body">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Portfolio Name</label>
                                    <input type="text" name="name" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end focus:border-transparent" placeholder="e.g. Modern Architecture" required>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Typology</label>
                                        <input type="text" name="typology" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end focus:border-transparent" placeholder="Type typology">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Year</label>
                                        <input type="text" name="year" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end focus:border-transparent" placeholder="e.g. 2024">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Country</label>
                                        <input type="text" name="country" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end focus:border-transparent" placeholder="e.g. England">
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Project Type</label>
                                        <select name="type" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end focus:border-transparent bg-white" required>
                                            <option value="" disabled selected>Select Type</option>
                                            <option value="Commercial">Commercial</option>
                                            <option value="Residential">Residential</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Gross Cost</label>
                                        <input type="text" name="gross_cost" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end focus:border-transparent" placeholder="Type gross cost">
                                    </div>

                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Short Description</label>
                                    <textarea name="short_description" rows="3" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end focus:border-transparent" placeholder="Brief overview..."></textarea>
                                </div>
                            </div>

                            <div class="mb-4 font-body">
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Main Thumbnail</label>
                                <label for="main-image-upload" class="file-upload-box h-full min-h-[200px] flex flex-col justify-center items-center px-4 py-6 border-2 border-dashed border-primary-end rounded-lg cursor-pointer">
                                    <img id="main-preview" src="" class="hidden w-full h-40 object-cover rounded-lg mb-2 shadow-sm" />
                                    <div id="main-placeholder" class="text-center">
                                        <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-400 mb-2"></i>
                                        <p class="text-sm text-gray-500 font-medium">Click to Upload</p>
                                        <p class="text-xs text-gray-400 font-body">JPG, PNG (Max 10MB)</p>
                                    </div>
                                    <input id="main-image-upload" name="image" type="file" class="sr-only" onchange="previewSingleImage(event, 'main-preview', 'main-placeholder')" required>
                                </label>
                            </div>

                        </div>
                    </div>


                    <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 mb-8">
                        <h2 class="font-heading text-xl font-bold text-gray-800 mb-4 border-b pb-2 flex items-center">
                            <span class="bg-red-100 text-red-600 w-8 h-8 rounded-full flex items-center justify-center mr-3 text-sm">02</span>
                            The Challenge
                        </h2>

                        <div class="grid grid-cols-1 gap-6 font-body">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Challenge Description</label>
                                <textarea name="challenge_des" id="textarea-description2"></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Challenge Images (Single/Multiple)</label>
                                <label for="challenge-upload" class="file-upload-box w-full flex flex-col justify-center items-center px-6 py-8 border-2 border-dashed border-primary-end rounded-lg cursor-pointer">
                                    <div id="challenge-preview-container" class="hidden grid grid-cols-2 md:grid-cols-4 gap-4 w-full mb-4"></div>
                                    <div id="challenge-placeholder" class="text-center">
                                        <i class="fa-regular fa-images text-4xl text-gray-400 mb-2"></i>
                                        <p class="text-sm text-gray-600">Select multiple images for the challenge section</p>
                                    </div>
                                    <input id="challenge-upload" name="challenge_images[]" type="file" class="sr-only" multiple onchange="previewMultipleImages(event, 'challenge-preview-container', 'challenge-placeholder')">
                                </label>
                            </div>
                        </div>
                    </div>


                    <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 mb-8">
                        <h2 class="font-heading text-xl font-bold text-gray-800 mb-4 border-b pb-2 flex items-center">
                            <span class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center mr-3 text-sm">03</span>
                            The Solution
                        </h2>

                        <div class="grid grid-cols-1 gap-6 font-body">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Solution Description</label>
                                <textarea name="solution_des" id="textarea-description1"></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Solution Images (Single/Multiple)</label>
                                <label for="solution-upload" class="file-upload-box w-full flex flex-col justify-center items-center px-6 py-8 border-2 border-dashed border-primary-end rounded-lg cursor-pointer">
                                    <div id="solution-preview-container" class="hidden grid grid-cols-2 md:grid-cols-4 gap-4 w-full mb-4"></div>
                                    <div id="solution-placeholder" class="text-center">
                                        <i class="fa-solid fa-lightbulb text-3xl text-yellow-400 mb-2"></i>
                                        <p class="text-sm text-gray-500">Select multiple images for solution</p>
                                    </div>
                                    <input id="solution-upload" name="solution_images[]" type="file" class="sr-only" multiple onchange="previewMultipleImages(event, 'solution-preview-container', 'solution-placeholder')">
                                </label>
                            </div>
                        </div>
                    </div>


                    <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 mb-8">
                        <h2 class="font-heading text-xl font-bold text-gray-800 mb-4 border-b pb-2 flex items-center">
                            <span class="bg-purple-100 text-purple-600 w-8 h-8 rounded-full flex items-center justify-center mr-3 text-sm">04</span>
                            The Outcome
                        </h2>

                        <div class="grid grid-cols-1 gap-6 font-body">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Outcome Description</label>
                                <textarea name="outcome_des" id="textarea-description"></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Outcome Images (Single/Multiple)</label>
                                <label for="outcome-upload" class="file-upload-box w-full flex flex-col justify-center items-center px-6 py-8 border-2 border-dashed border-primary-end rounded-lg cursor-pointer">
                                    <div id="outcome-preview-container" class="hidden grid grid-cols-2 md:grid-cols-4 gap-4 w-full mb-4"></div>
                                    <div id="outcome-placeholder" class="text-center">
                                        <i class="fa-solid fa-chart-line text-4xl text-gray-400 mb-2"></i>
                                        <p class="text-sm text-gray-600">Select images showing results/outcome</p>
                                    </div>
                                    <input id="outcome-upload" name="outcome_images[]" type="file" class="sr-only" multiple onchange="previewMultipleImages(event, 'outcome-preview-container', 'outcome-placeholder')">
                                </label>
                            </div>
                        </div>
                    </div>


                    <div class="sticky bottom-4 z-10 font-nav">
                        <div class="bg-white/80 backdrop-blur-md border border-gray-200 p-4 rounded-xl shadow-2xl flex justify-between items-center max-w-4xl mx-auto">
                            <span class="font-body text-gray-500 text-sm font-medium">Ready to publish?</span>
                            <button type="submit" name="add_portfolio" class="bg-primary-start text-white px-8 py-3 rounded-lg shadow-lg hover:bg-primary-end hover:-translate-y-1 transition-all duration-300 font-bold flex items-center uppercase tracking-wider text-sm">
                                <i class="fa-solid fa-check-circle mr-2"></i> Save Portfolio Item
                            </button>
                        </div>
                    </div>

                </form>

            </div>
        </main>
    </div>

    <?php include('bottom.php') ?>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="main.js"></script>

    <script>
        // --- CKEditor Initialization ---
        // --- CKEditor ---
        ClassicEditor.create(document.querySelector("#textarea-description1")).catch(
            (error) => {
                console.error(error);
            }
        );
        ClassicEditor.create(document.querySelector("#textarea-description2")).catch(
            (error) => {
                console.error(error);
            }
        );
        ClassicEditor.create(document.querySelector("#textarea-description3")).catch(
            (error) => {
                console.error(error);
            }
        );

        // --- Single Image Preview Function ---
        function previewSingleImage(event, previewId, placeholderId) {
            const preview = document.getElementById(previewId);
            const placeholder = document.getElementById(placeholderId);
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(file);
            } else {
                preview.classList.add('hidden');
                placeholder.classList.remove('hidden');
            }
        }

        // --- Multiple Image Preview Function ---
        function previewMultipleImages(event, containerId, placeholderId) {
            const container = document.getElementById(containerId);
            const placeholder = document.getElementById(placeholderId);
            const files = event.target.files;

            container.innerHTML = '';

            if (files.length > 0) {
                placeholder.classList.add('hidden');
                container.classList.remove('hidden');

                Array.from(files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'relative w-full h-32 rounded-lg overflow-hidden shadow-sm border border-gray-200 group';
                        div.innerHTML = `
                            <img src="${e.target.result}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black bg-opacity-10 opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                        `;
                        container.appendChild(div);
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