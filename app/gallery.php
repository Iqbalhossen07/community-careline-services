<?php
include('db.php'); // Database Connection
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}
$pageTitle = 'Manage Gallery';
$upload_folder = 'uploads/gallery/'; // Image upload folder




// --- Fetch all gallery items (No filter) ---
$gallery_items = [];
$query = "SELECT * FROM gallery ORDER BY id DESC";
$result = $mysqli->query($query);

if ($result) {
    $gallery_items = $result->fetch_all(MYSQLI_ASSOC);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php') ?>
    <title>Manage Gallery - Admin Dashboard</title>
    <style>
        .gallery-card {
            border: 2px solid transparent;
            transition: all 0.3s ease-in-out;
        }

        .gallery-card:hover {
            border-color: #eb380b;
            /* 'primary-start' color */
            transform: scale(1.03);
        }

        .modal.hidden {
            display: none;
        }

        /* Style for upload preview images */
        .preview-image {
            width: 100%;
            height: 6rem;
            /* 96px */
            object-fit: cover;
            border-radius: 0.375rem;
            /* rounded-md */
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            /* shadow */
        }
    </style>
</head>

<body class="bg-gray-100 font-merriweather">
    <div class="flex h-screen">

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

            <div class="p-8 mb-32 md:mb-0 " data-aos="fade-up">


                <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                    <h1 class="text-3xl font-bold font-lora text-gray-800" >
                        Manage Gallery Items
                    </h1>

                    <div class="flex items-center space-x-3" >

                        <button data-modal-toggle="addModal" class="flex items-center justify-center bg-primary-start text-white px-4 py-2 rounded-lg shadow-md hover:bg-primary-end transition-colors duration-300">
                            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span>Add New Image(s)</span>
                        </button>
                    </div>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">

                    <?php if (!empty($gallery_items)) : ?>
                        <?php foreach ($gallery_items as $index => $item) :
                            $image_path = $upload_folder . htmlspecialchars($item['image']);
                        ?>
                            <div class="gallery-card group relative rounded-lg overflow-hidden shadow-md" >
                                <img src="<?php echo $image_path; ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" class="w-full h-48 object-cover">

                                <div class="absolute top-2 right-2 bg-black/60 text-white text-xs px-2 py-1 rounded opacity-0 group-hover:opacity-100 transition-opacity duration-300" title="<?php echo htmlspecialchars($item['title']); ?>">
                                    <?php echo htmlspecialchars($item['title']); ?>
                                </div>

                                <div class="absolute bottom-2 right-2 flex space-x-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <button data-modal-toggle="editModal"
                                        class="edit-btn h-8 w-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center shadow-md hover:shadow-lg hover:bg-green-200 hover:-translate-y-0.5 transition-all duration-300"
                                        title="Edit Title"
                                        data-id="<?php echo $item['id']; ?>"
                                        data-title="<?php echo htmlspecialchars($item['title']); ?>"
                                        data-image-src="<?php echo $image_path; ?>">
                                  <i class="fas fa-pencil-alt text-sm"></i>
                                    </button>
                                    <button data-modal-toggle="deleteModal"
                                        class="delete-btn h-8 w-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center shadow-md hover:shadow-lg hover:bg-red-200 hover:-translate-y-0.5 transition-all duration-300"
                                        title="Delete Image"
                                        data-id="<?php echo $item['id']; ?>"
                                        data-image-src="<?php echo $image_path; ?>">
                                      <i class="fas fa-trash-alt text-sm"></i>
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-gray-500 col-span-full text-center py-10">
                            No gallery items found. Please add some images.
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <div id="addModal" class="modal hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-2xl" data-aos="fade-up">
            <form action="logics.php" method="POST" enctype="multipart/form-data">
                <div class="flex justify-between items-center p-5 border-b">
                    <h3 class="text-2xl font-lora font-bold">Add New Image(s)</h3>
                    <button data-modal-close="addModal" type="button" class="text-gray-500 hover:text-gray-800">&times;</button>
                </div>
                <div class="p-6 space-y-4">

                    <div>
                        <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">Image Title</label>
                        <input type="text" id="title" name="title" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end"
                            placeholder="e.g., Winter Clothing Drive, Food Distribution, etc." required>
                        <p class="text-xs text-gray-500 mt-1">All uploaded images will be grouped under this title.</p>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Upload Images (Single/Multiple)</label>
                        <div id="image-preview-container-add" class="grid grid-cols-3 sm:grid-cols-4 gap-2 mb-4">
                        </div>
                        <label for="file-upload-multiple" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-primary-end border-dashed rounded-md cursor-pointer hover:bg-gray-50">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <span class="text-sm text-primary-start hover:text-primary-end">Click to upload</span>
                                <p class="text-xs text-gray-500">or drag & drop (PNG, JPG)</p>
                            </div>
                            <input id="file-upload-multiple" name="images[]" type="file" class="sr-only" multiple onchange="previewAddImages(event)" required>
                        </label>
                    </div>
                </div>
                <div class="p-5 border-t text-right">
                    <button data-modal-close="addModal" type="button" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 mr-2">Cancel</button>
                    <button type="submit" name="add_gallery_images" class="bg-primary-start text-white px-4 py-2 rounded-lg hover:bg-primary-end">Upload Images</button>
                </div>
            </form>
        </div>
    </div>

    <div id="editModal" class="modal hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-lg" data-aos="fade-up">
            <form action="logics.php" method="POST">
                <div class="flex justify-between items-center p-5 border-b">
                    <h3 class="text-2xl font-lora font-bold">Edit Image Title</h3>
                    <button data-modal-close="editModal" type="button" class="text-gray-500 hover:text-gray-800">&times;</button>
                </div>
                <div class="p-6 space-y-4">
                    <input type="hidden" id="edit-id" name="id">

                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Image Preview</label>
                        <img id="edit-image-preview" src="" alt="Preview" class="w-full h-auto rounded-lg shadow-md">
                    </div>

                    <div>
                        <label for="edit_title" class="block text-sm font-semibold text-gray-700 mb-2">Image Title </label>
                        <input type="text" id="edit_title" name="title" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end" required>
                    </div>
                </div>
                <div class="p-5 border-t text-right">
                    <button data-modal-close="editModal" type="button" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 mr-2">Cancel</button>
                    <button type="submit" name="update_gallery_item" class="bg-primary-start text-white px-4 py-2 rounded-lg hover:bg-primary-end">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <div id="deleteModal" class="modal hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-md" data-aos="fade-up">
            <div class="flex justify-between items-center p-5 border-b">
                <h3 class="text-2xl font-lora font-bold">Confirm Deletion</h3>
                <button data-modal-close="deleteModal" type="button" class="text-gray-500 hover:text-gray-800">&times;</button>
            </div>
            <div class="p-6 text-center">
                <p>Are you sure you want to delete this image? This action cannot be undone.</p>
                <img id="delete-image-preview" src="" alt="Delete Preview" class="w-1/2 rounded-lg shadow-md my-4 mx-auto">
            </div>
            <div class="p-5 border-t text-right">
                <button data-modal-close="deleteModal" type="button" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-300 mr-2">Cancel</N>
                    <a id="delete-confirm-link" href="#" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 inline-block">Delete</a>
            </div>
        </div>
    </div>

     <!-- bottom menu -->
  <?php include('bottom.php') ?>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="main.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // --- Edit Modal Logic ---
            const editButtons = document.querySelectorAll('.edit-btn');
            const editIdInput = document.getElementById('edit-id');
            const editTitleInput = document.getElementById('edit_title');
            const editImagePreview = document.getElementById('edit-image-preview');

            editButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const id = button.dataset.id;
                    const title = button.dataset.title;
                    const imageSrc = button.dataset.imageSrc;

                    // Set values in the edit modal
                    editIdInput.value = id;
                    editTitleInput.value = title;
                    editImagePreview.src = imageSrc;
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

                    // Set values in the delete modal
                    deleteImagePreview.src = imageSrc;
                    deleteConfirmLink.href = `logics.php?gallery_delete_id=${id}`;
                });
            });
        });

        // --- Function for Add Modal multiple image preview ---
        function previewAddImages(event) {
            const previewContainer = document.getElementById('image-preview-container-add');
            previewContainer.innerHTML = ''; // Clear old previews

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
    </script>
</body>

</html>