<?php
include('db.php');
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}
$pageTitle = 'Manage Services';

// Fetch Services
$services = [];
$result = $mysqli->query("SELECT * FROM services ORDER BY id DESC");
if ($result) {
    $services = $result->fetch_all(MYSQLI_ASSOC);
}

// ইউনিক ক্যাটেগরিগুলো বের করা (ফিল্টার ড্রপডাউনের জন্য)
$categories_query = $mysqli->query("SELECT DISTINCT category FROM services WHERE category IS NOT NULL AND category != ''");
$unique_categories = [];
while ($row = $categories_query->fetch_assoc()) {
    $unique_categories[] = $row['category'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php') ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <style>
        .hidden-card {
            display: none !important;
        }

        .service-card {
            transition: all 0.3s ease;
        }
    </style>
</head>

<body class="bg-gray-100 font-body text-gray-800">
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
            <?php
                unset($_SESSION['message']);
                unset($_SESSION['message_type']);
            }
            ?>


            <div class="p-4 md:p-8 mb-32 md:mb-0" data-aos="fade-up">

                <div class="mb-8">
                    <h1 class="text-3xl font-bold font-heading text-gray-800">Manage Services</h1>
                    <p class="text-sm text-gray-500 font-body">Architecture and design service management dashboard</p>
                </div>

                <div class="bg-white p-4 rounded-xl shadow-md border border-gray-100 mb-8">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">

                        <div class="flex flex-col sm:flex-row items-center gap-3 w-full lg:w-auto">
                            <div class="relative w-full sm:w-64">
                                <select id="categorySelect" class="appearance-none w-full bg-gray-50 border border-gray-200 text-gray-700 py-2.5 px-4 pr-10 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-start font-body text-sm cursor-pointer transition-all">
                                    <option value="all">Select Category</option>
                                    <?php foreach ($unique_categories as $cat): ?>
                                        <option value="<?php echo htmlspecialchars($cat); ?>"><?php echo htmlspecialchars($cat); ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                                    <i class="fa-solid fa-filter text-xs"></i>
                                </div>
                            </div>

                            <div class="flex gap-2 w-full sm:w-auto">
                                <button id="applyFilterBtn" class="font-nav flex-1 sm:flex-none bg-primary-start text-white px-5 py-2.5 rounded-lg shadow hover:bg-primary-end transition-all font-bold uppercase tracking-wider text-xs flex items-center justify-center">
                                    <i class="fa-solid fa-magnifying-glass mr-2"></i> Filter
                                </button>
                                <button id="clearFilterBtn" class="font-nav flex-1 sm:flex-none bg-gray-100 text-gray-600 px-5 py-2.5 rounded-lg shadow-sm hover:bg-gray-200 transition-all font-bold uppercase tracking-wider text-xs flex items-center justify-center">
                                    <i class="fa-solid fa-rotate-left mr-2"></i> Clear
                                </button>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-2 w-full lg:w-auto">
                            <a href="manage-categories.php" class="font-nav bg-blue-600 text-white px-6 py-2.5 rounded-lg shadow-md hover:bg-blue-700 transition-all font-bold uppercase tracking-wider text-xs flex items-center justify-center">
                                <i class="fa-solid fa-list mr-2 text-sm"></i> Manage Categories
                            </a>
                            <a href="add-service.php" class="font-nav bg-primary-start text-white px-6 py-2 rounded shadow hover:bg-primary-end transition font-bold uppercase tracking-wider"></i> Add New Service
                            </a>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 " id="servicesGrid">
                    <?php if (!empty($services)) : ?>
                        <?php foreach ($services as $service) :
                            $title = htmlspecialchars($service['title']);
                            $category = htmlspecialchars($service['category']);
                            $desc = mb_strimwidth(strip_tags($service['description']), 0, 100, "...");
                            $images_array = !empty($service['image']) ? explode(',', $service['image']) : [];
                        ?>
                            <div class="service-card bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden flex flex-col group" data-category="<?php echo $category; ?>">
                                <div class="relative h-52 w-full overflow-hidden bg-gray-200 image-slider-container">
                                    <?php if (!empty($images_array)): ?>
                                        <?php foreach ($images_array as $index => $img): ?>
                                            <img src="uploads/services_images/<?php echo $img; ?>"
                                                alt="<?php echo $title; ?>"
                                                class="absolute inset-0 w-full h-full object-cover slide-image <?php echo ($index === 0) ? 'opacity-100' : 'opacity-0'; ?>">
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="w-full h-full flex items-center justify-center text-gray-300 absolute inset-0">
                                            <i class="fa-regular fa-image text-5xl"></i>
                                        </div>
                                    <?php endif; ?>
                                    <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                </div>

                                <div class="p-6 flex flex-col flex-grow">
                                    <h3 class="font-heading text-xl font-bold text-gray-800 mb-2 line-clamp-1"><?php echo $title; ?></h3>
                                    <p class="text-gray-600 text-sm mb-6 font-body leading-relaxed line-clamp-3"><?php echo $desc; ?></p>

                                    <div class="flex items-center justify-between mt-auto pt-4 border-t border-gray-50">
                                        <div>
                                            <?php if (!empty($category)): ?>
                                                <span class="font-body bg-green-50 text-green-600 text-[10px] font-bold px-2 py-1 rounded border border-green-100 uppercase tracking-wider">
                                                    <i class="fa-solid fa-tag mr-1"></i><?php echo ($service['category']); ?>
                                                </span>
                                            <?php endif; ?>
                                        </div>

                                        <div class="flex space-x-3">
                                            <a href="view-service.php?id=<?php echo $service['id']; ?>" class="h-8 w-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shadow-md hover:shadow-lg hover:bg-blue-200 hover:-translate-y-0.5 transition-all duration-300" title="View">
                                                <i class="fas fa-eye text-sm"></i>
                                            </a>
                                            <a href="edit-service.php?id=<?php echo $service['id']; ?>" class="h-8 w-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center shadow-md hover:shadow-lg hover:bg-green-200 hover:-translate-y-0.5 transition-all duration-300" title="Edit">
                                                <i class="fas fa-pencil-alt text-sm"></i>
                                            </a>
                                            <button data-id="<?php echo $service['id']; ?>" class="delete-btn h-8 w-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center shadow-md hover:shadow-lg hover:bg-red-200 hover:-translate-y-0.5 transition-all duration-300" title="Delete">
                                                <i class="fas fa-trash-alt text-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <div class="col-span-full text-center py-20">
                            <i class="fa-solid fa-folder-open text-6xl text-gray-200 mb-4"></i>
                            <p class="text-gray-400 font-body">No services available. Start by adding one!</p>
                        </div>
                    <?php endif; ?>
                </div>

                <div id="noResults" class="hidden flex flex-col items-center justify-center py-24 bg-white rounded-2xl shadow-inner border border-dashed border-gray-200">
                    <div class="bg-gray-50 p-6 rounded-full mb-4">
                        <i class="fa-solid fa-magnifying-glass text-4xl text-gray-300"></i>
                    </div>
                    <h4 class="font-heading text-xl text-gray-700">No Services Found</h4>
                    <p class="text-gray-400 font-body mt-1">Try selecting a different category or reset the filter.</p>
                </div>

            </div>
        </main>
    </div>
    <?php include('bottom.php') ?>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="main.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const categorySelect = document.getElementById('categorySelect');
            const applyBtn = document.getElementById('applyFilterBtn');
            const clearBtn = document.getElementById('clearFilterBtn');
            const serviceCards = document.querySelectorAll('.service-card');
            const noResults = document.getElementById('noResults');

            // --- FILTER LOGIC (Manual Trigger) ---
            function performFilter() {
                const selected = categorySelect.value;
                let found = 0;

                serviceCards.forEach(card => {
                    const cardCat = card.getAttribute('data-category');
                    if (selected === 'all' || cardCat === selected) {
                        card.classList.remove('hidden-card');
                        found++;
                    } else {
                        card.classList.add('hidden-card');
                    }
                });

                noResults.classList.toggle('hidden', found > 0);
            }

            // Click Apply Filter
            applyBtn.addEventListener('click', performFilter);

            // Click Clear Filter
            clearBtn.addEventListener('click', function() {
                categorySelect.value = 'all';
                performFilter();
            });

            // --- Delete Logic ---
            document.querySelectorAll('.delete-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#eb380b',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) window.location.href = 'logics.php?delete_service_id=' + id;
                    });
                });
            });

            // --- PREMIUM SLIDESHOW LOGIC ---
            const sliders = document.querySelectorAll('.image-slider-container');
            sliders.forEach((slider) => {
                const images = slider.querySelectorAll('img');
                if (images.length > 1) {
                    let currentIndex = 0;
                    setInterval(() => {
                        images[currentIndex].classList.replace('opacity-100', 'opacity-0');
                        currentIndex = (currentIndex + 1) % images.length;
                        images[currentIndex].classList.replace('opacity-0', 'opacity-100');
                    }, 4000);
                }
            });
        });
    </script>
</body>

</html>