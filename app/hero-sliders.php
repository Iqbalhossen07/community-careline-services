<?php
include('db.php'); // ডেটাবেস কানেকশন
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}
$pageTitle = 'Manage Hero Slider';

// --- ডেটাবেস থেকে সব হিরো ইমেজ নিয়ে আসা ---
$hero_images = [];
$result = $mysqli->query("SELECT * FROM hero_images ORDER BY id DESC");
if ($result) {
    $hero_images = $result->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php') ?>
    <title>Manage Hero Sliders - Admin Dashboard</title>
    <style>
        .slider-card {
            border: 3px solid transparent;
            transition: all 0.3s ease-in-out;
        }

        .slider-card:hover {
            border-color: #44afe4;
            transform: scale(1.03);
        }

        .modal.hidden {
            display: none;
        }

        .preview-image {
            width: 100%;
            height: 6rem;
            object-fit: cover;
            border-radius: 0.375rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        }
    </style>
</head>

<body class="bg-gray-100 font-body"> <div class="flex h-screen">

        <?php include('sidebar.php') ?>

        <main class="flex-1 h-full overflow-y-auto">

            <?php include('top.php') ?>
            <?php
            if (isset($_SESSION['message']) && $_SESSION['message'] != '') {
            ?>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: "<?php echo $_SESSION['message']; ?>",
                            icon: "<?php echo $_SESSION['message_type']; ?>",
                            confirmButtonText: "OK"
                        });
                    });
                </script>
            <?php
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
            }
            ?>
            <div class="p-8 mb-32 md:mb-0">

                <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                    <h1 class="text-3xl font-bold font-heading text-gray-800" data-aos="fade-right">
                        Manage Hero Slider Images
                    </h1>

                    <div class="flex items-center space-x-3" data-aos="fade-left">
                        <button data-modal-toggle="addModal" class="font-nav flex items-center justify-center bg-primary-start text-white px-4 py-2 rounded-lg shadow-md hover:bg-primary-end transition-colors duration-300">
                            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span>Add New Slide(s)</span>
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    <?php if (!empty($hero_images)) : ?>
                        <?php foreach ($hero_images as $index => $image) :
                            $image_path = 'uploads/hero_images/' . htmlspecialchars($image['image']);
                        ?>
                            <div class="slider-card group relative rounded-lg overflow-hidden shadow-md" data-aos="fade-up" data-aos-delay="<?php echo ($index + 1) * 100; ?>">
                                <img src="<?php echo $image_path; ?>" alt="Slider Image" class="w-full h-64 object-cover">

                                <div class="absolute bottom-4 right-4 flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <button data-modal-toggle="editModal"
                                        class="edit-btn h-8 w-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center shadow-md hover:shadow-lg hover:bg-green-200 hover:-translate-y-0.5 transition-all duration-300"
                                        title="Edit"
                                        data-id="<?php echo $image['id']; ?>"
                                        data-old-image="<?php echo htmlspecialchars($image['image']); ?>"
                                        data-image-src="<?php echo $image_path; ?>">
                                         <i class="fas fa-pencil-alt text-sm"></i>
                                    </button>

                                    <button data-modal-toggle="deleteModal"
                                        class="delete-btn h-8 w-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center shadow-md hover:shadow-lg hover:bg-red-200 hover:-translate-y-0.5 transition-all duration-300"
                                        title="Delete"
                                        data-id="<?php echo $image['id']; ?>"
                                        data-image-src="<?php echo $image_path; ?>">
                                         <i class="fas fa-trash-alt text-sm"></i>
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p class="font-body text-gray-500 col-span-full text-center py-10">No hero images found. Please add some slides.</p>
                    <?php endif; ?>
                </div>

            </div>
        </main>
    </div>

    <div id="addModal" class="modal hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-2xl" data-aos="fade-up">
            <form method="POST" action="logics.php" enctype="multipart/form-data">
                <div class="flex justify-between items-center p-5 border-b">
                    <h3 class="text-2xl font-heading font-bold">Add New Slide(s)</h3>
                    <button data-modal-close="addModal" type="button" class="text-gray-500 hover:text-gray-800">&times;</button>
                </div>

                <div class="p-6">
                    <div>
                        <label class="font-body block text-sm font-semibold text-gray-700 mb-2">Upload Images (Single/Multiple)</label>
                        <div id="image-preview-container-add" class="grid grid-cols-3 sm:grid-cols-4 gap-2 mb-4">
                        </div>
                        <label for="file-upload-multiple" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-primary-end border-dashed rounded-md cursor-pointer hover:bg-gray-50">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <span class="font-nav text-sm text-primary-start hover:text-primary-end">Click to upload</span>
                                <p class="font-body text-xs text-gray-500">or drag & drop (PNG, JPG)</p>
                            </div>
                            <input id="file-upload-multiple" name="images[]" type="file" class="sr-only" multiple onchange="previewAddImages(event)">
                        </label>
                    </div>
                </div>

                <div class="p-5 border-t text-right">
                    <button data-modal-close="addModal" type="button" class="font-nav bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 mr-2">Cancel</button>
                    <button type="submit" name="add_hero_images" class="font-nav bg-primary-start text-white px-4 py-2 rounded-lg hover:bg-primary-end">Upload Slides</button>
                </div>
            </form>
        </div>
    </div>

    <div id="editModal" class="modal hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-lg" data-aos="fade-up">
            <form method="POST" action="logics.php" enctype="multipart/form-data">
                <div class="flex justify-between items-center p-5 border-b">
                    <h3 class="text-2xl font-heading font-bold">Edit Slide Image</h3>
                    <button data-modal-close="editModal" type="button" class="text-gray-500 hover:text-gray-800">&times;</button>
                </div>

                <div class="p-6 space-y-4">
                    <input type="hidden" id="edit-id" name="id">
                    <input type="hidden" id="edit-old-image" name="old_image">

                    <div>
                        <label class="font-body block text-sm font-semibold text-gray-700 mb-2">Current Image</label>
                        <img id="edit-current-image-preview" src="" alt="Preview" class="w-full h-96 rounded-lg shadow-md">
                    </div>
                    <div>
                        <label class="font-body block text-sm font-semibold text-gray-700 mb-2">Upload New Image</label>
                        <label for="edit-file-upload" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-primary-end border-dashed rounded-md cursor-pointer hover:bg-gray-50">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <span class="font-nav text-sm text-primary-start hover:text-primary-end">Click to upload replacement</span>
                            </div>
                            <input id="edit-file-upload" name="image" type="file" class="sr-only" onchange="previewEditImage(event)">
                        </label>
                    </div>
                </div>

                <div class="p-5 border-t text-right">
                    <button data-modal-close="editModal" type="button" class="font-nav bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 mr-2">Cancel</button>
                    <button type="submit" name="update_hero_image" class="font-nav bg-primary-start text-white px-4 py-2 rounded-lg hover:bg-primary-end">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <div id="deleteModal" class="modal hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-md" data-aos="fade-up">
            <div class="flex justify-between items-center p-5 border-b">
                <h3 class="text-2xl font-heading font-bold">Confirm Deletion</h3>
                <button data-modal-close="deleteModal" type="button" class="text-gray-500 hover:text-gray-800">&times;</button>
            </div>
            <div class="p-6 text-center font-body">
                <p>Are you sure you want to delete this slide?</p>
                <img id="delete-image-preview" src="" alt="Delete Preview" class="w-3/4 rounded-lg shadow-md my-4 mx-auto">
            </div>
            <div class="p-5 border-t text-right">
                <button data-modal-close="deleteModal" type="button" class="font-nav bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 mr-2">Cancel</button>
                <a id="delete-confirm-link" href="#" class="font-nav bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 inline-block">Delete</a>
            </div>
        </div>
    </div>

    <?php include('bottom.php') ?>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="main.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // --- Edit Modal Logic ---
            const editButtons = document.querySelectorAll('.edit-btn');
            const editIdInput = document.getElementById('edit-id');
            const editOldImageInput = document.getElementById('edit-old-image');
            const editImagePreview = document.getElementById('edit-current-image-preview');
            const editFileInput = document.getElementById('edit-file-upload');

            editButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const id = button.dataset.id;
                    const oldImage = button.dataset.oldImage;
                    const imageSrc = button.dataset.imageSrc;

                    editIdInput.value = id;
                    editOldImageInput.value = oldImage;
                    editImagePreview.src = imageSrc;
                    editFileInput.value = null;
                });
            });

            // --- Delete Modal Logic ---
            const deleteButtons = document.querySelectorAll('.delete-btn');
            const deleteImagePreview = document.getElementById('delete-image-preview');
            const deleteConfirmLink = document.getElementById('delete-confirm-link');

            deleteButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const id = button.dataset.id;
                    const imageSrc = button.dataset.imageSrc;

                    deleteImagePreview.src = imageSrc;
                    deleteConfirmLink.href = `logics.php?hero_image_delete_id=${id}`;
                });
            });
        });

        // --- Multi Image Preview ---
        function previewAddImages(event) {
            const previewContainer = document.getElementById('image-preview-container-add');
            previewContainer.innerHTML = '';

            if (event.target.files) {
                Array.from(event.target.files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'preview-image';
                        previewContainer.appendChild(img);
                    }
                    reader.readAsDataURL(file);
                });
            }
        }

        // --- Single Image Preview ---
        function previewEditImage(event) {
            const previewImage = document.getElementById('edit-current-image-preview');

            if (event.target.files && event.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                }
                reader.readAsDataURL(event.target.files[0]);
            }
        }
    </script>
</body>

</html>