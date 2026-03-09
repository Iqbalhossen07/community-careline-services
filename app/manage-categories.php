<?php
include('db.php');
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}
$pageTitle = 'Manage Categories';

// ডাটাবেস থেকে সব ক্যাটাগরি ফেচ করা
$result = $mysqli->query("SELECT * FROM categories ORDER BY id DESC");
$categories = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php') ?>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <style>
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>

<body class="bg-gray-100 font-body text-gray-800">
    <div class="flex h-screen">
        <?php include('sidebar.php') ?>

        <main class="flex-1 h-full overflow-y-auto no-scrollbar">
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
            <?php
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
            }
            ?>

            <div class="p-4 md:p-8 mb-32 md:mb-0">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8" data-aos="fade-down">
                    <div>
                        <h1 class="text-3xl font-bold font-heading text-gray-800">Manage Categories</h1>
                        <p class="text-sm text-gray-500 font-body">Organize your services by categories</p>
                    </div>
                    <button onclick="openModal()" class="font-nav bg-primary-start text-white px-6 py-2 rounded shadow hover:bg-primary-end transition font-bold uppercase tracking-wider">
                        <i class="fa-solid fa-plus-circle mr-2 text-sm"></i> Add New Category
                    </button>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">
                    <?php if (!empty($categories)) : ?>
                        <?php 
                        $delay = 0; 
                        foreach ($categories as $cat) : 
                        ?>
                            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex items-center justify-between group hover:shadow-md transition-all" 
                                 data-aos="fade-up" 
                                 data-aos-delay="<?php echo $delay; ?>">
                                
                                <span class="font-semibold text-gray-700"><?php echo htmlspecialchars($cat['name']); ?></span>
                                
                                <button data-id="<?php echo $cat['id']; ?>" class="delete-cat-btn text-red-400 hover:text-red-600 transition-colors p-2" title="Delete Category">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        <?php 
                        $delay += 50; // প্রতিটি কার্ডের জন্য ৫০ মিলিসেকেন্ড ডিলে বাড়বে
                        endforeach; 
                        ?>
                    <?php else : ?>
                        <div class="col-span-full text-center py-16 bg-white rounded-2xl border-2 border-dashed border-gray-200" data-aos="zoom-in">
                            <div class="bg-gray-50 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fa-solid fa-folder-open text-2xl text-gray-300"></i>
                            </div>
                            <h4 class="text-gray-500 font-heading">No Categories Found</h4>
                            <p class="text-gray-400 text-sm font-body">Click "Add New Category" to create your first one.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <div id="categoryModal" class="fixed inset-0 z-[100] hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-black bg-opacity-50" onclick="closeModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form action="logics.php" method="POST">
                    <div class="px-6 py-6 bg-white text-center sm:text-left">
                        <h3 class="text-xl font-bold font-heading text-gray-800 mb-2">Add New Category</h3>
                        <p class="text-sm text-gray-500 mb-6 font-body">Enter the name of the new service category below.</p>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Category Name</label>
                                <input type="text" name="category_name" required placeholder="e.g., Landscape Architecture" 
                                    class="w-full bg-gray-50 border border-gray-200 text-gray-700 py-3 px-4 rounded-lg focus:ring-2 focus:ring-primary outline-none transition-all font-body">
                            </div>
                        </div>
                    </div>
                    <div class="px-6 py-4 bg-gray-50 flex flex-col sm:flex-row-reverse gap-2">
                        <button type="submit" name="add_category" class="font-nav bg-primary-start text-white px-6 py-2 rounded shadow hover:bg-primary-end transition font-bold uppercase tracking-wider">Save Category</button>
                        <button type="button" onclick="closeModal()" class="bg-white text-gray-500 border border-gray-200 px-8 py-2.5 rounded-lg font-bold uppercase text-xs tracking-wider hover:bg-gray-100 transition-all">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php include('bottom.php') ?>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // AOS ইনিশিয়ালাইজেশন
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            offset: 50
        });

        // মডাল কন্ট্রোল ফাংশন
        function openModal() {
            const modal = document.getElementById('categoryModal');
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; // মডাল ওপেন থাকলে পেজ স্ক্রল হবে না
        }

        function closeModal() {
            const modal = document.getElementById('categoryModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        // ক্যাটাগরি ডিলিট লজিক (SweetAlert2 সহ)
        document.querySelectorAll('.delete-cat-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                Swal.fire({
                    title: 'Delete Category?',
                    text: "Warning: This may affect services associated with this category!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#eb380b',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Yes, Delete it!',
                    cancelButtonText: 'Keep it'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'logics.php?delete_category_id=' + id;
                    }
                });
            });
        });
    </script>
</body>
</html>