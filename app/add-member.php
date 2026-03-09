<?php
include('db.php'); // ডেটাবেস কানেকশন

// সেশন চেক
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}
$pageTitle = 'Add New Member';
$upload_folder = 'uploads/member_images/'; // মেম্বার ছবির ফোল্ডার
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php') ?>
    <title>Add New Member - Admin Dashboard</title>
</head>

<body class="bg-gray-100 font-body"> <div class="flex h-screen">

        <?php include('sidebar.php') ?>

        <main class="flex-1 h-full overflow-y-auto">

            <?php include('top.php') ?>

            <div class="p-8 mb-32 md:mb-0">

                <div class="flex justify-between items-center mb-6" data-aos="fade-down">
                    <h1 class="text-3xl font-bold font-heading text-gray-800">
                        Add New Member
                    </h1>
                    <a href="members.php" class="font-nav flex items-center bg-gray-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-gray-700 transition-colors duration-300 font-semibold uppercase tracking-wider text-xs">
                        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                        </svg>
                        <span>Back to Members</span>
                    </a>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 md:p-8" data-aos="fade-up">
                    <form action="logics.php" method="POST" enctype="multipart/form-data">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 font-body">

                            <div>
                                <label for="member_name" class="block text-sm font-semibold text-gray-700 mb-2">Full Name</label>
                                <input type="text" id="member_name" name="name" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end focus:border-transparent font-body"
                                    placeholder="e.g., John Doe" required>
                            </div>

                            <div>
                                <label for="member_designation" class="block text-sm font-semibold text-gray-700 mb-2">Designation</label>
                                <input type="text" id="member_designation" name="designation" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end focus:border-transparent font-body"
                                    placeholder="e.g., Senior Architect, Interior Designer, Project Manager" required>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Profile Picture</label>

                                <label for="file-upload" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-primary-end border-dashed rounded-md cursor-pointer hover:bg-gray-50 transition-colors bg-white">
                                    <div class="space-y-1 text-center">
                                        <img id="image-preview" src="" alt="Image Preview" class="hidden w-32 h-32 mx-auto rounded-full shadow-md mb-4 object-cover" />
                                        <svg id="svg-placeholder" class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600 justify-center">
                                            <span class="font-nav relative font-medium text-primary-start hover:text-primary-end">
                                                Upload a file
                                            </span>
                                            <p class="pl-1">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-400">PNG, JPG up to 10MB</p>
                                    </div>
                                    <input id="file-upload" name="image" type="file" class="sr-only" onchange="previewImage(event)" required>
                                </label>
                            </div>

                        </div>

                        <div class="mt-8 text-right">
                            <button type="submit" name="add_member" class="font-nav inline-flex items-center justify-center bg-primary-start text-white px-8 py-3 rounded-lg shadow-md hover:bg-primary-end transition-colors duration-300 font-bold uppercase tracking-widest text-sm">
                                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                <span>Add Member</span>
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
            } else {
                preview.src = '';
                preview.classList.add('hidden');
                placeholder.classList.remove('hidden'); 
            }
        }
    </script>
</body>
</html>