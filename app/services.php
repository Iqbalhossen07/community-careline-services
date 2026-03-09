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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php') ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
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
                <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold font-heading text-gray-800">Manage Services</h1>
                        <p class="text-sm text-gray-500 font-body">Architecture and design service management dashboard
                        </p>
                    </div>
                    <div>
                        <a href="add-service.php"
                            class="font-nav bg-primary-start text-white px-6 py-3 rounded-lg shadow-md hover:bg-primary-end transition-all font-bold uppercase tracking-wider text-xs flex items-center justify-center">
                            <i class="fa-solid fa-plus mr-2"></i> Add New Service
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6" id="servicesGrid">
                    <?php if (!empty($services)) : ?>
                    <?php foreach ($services as $service) :
                            $title = htmlspecialchars($service['title']);
                            $desc = mb_strimwidth(strip_tags($service['description']), 0, 100, "...");
                            $images_array = !empty($service['image']) ? explode(',', $service['image']) : [];
                            $display_image = !empty($images_array) ? $images_array[0] : ''; // শুধু প্রথম ইমেজটি নিবে
                        ?>
                    <div
                        class="service-card bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden flex flex-col group">
                        <div class="relative h-52 w-full overflow-hidden bg-gray-200">
                            <?php if (!empty($display_image)): ?>
                            <img src="uploads/services_images/<?php echo $display_image; ?>" alt="<?php echo $title; ?>"
                                class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                            <?php else: ?>
                            <div class="w-full h-full flex items-center justify-center text-gray-300">
                                <i class="fa-regular fa-image text-5xl"></i>
                            </div>
                            <?php endif; ?>
                            <div
                                class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            </div>
                        </div>

                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="font-heading text-xl font-bold text-gray-800 mb-2 line-clamp-1">
                                <?php echo $title; ?></h3>
                            <p class="text-gray-600 text-sm mb-6 font-body leading-relaxed line-clamp-3">
                                <?php echo $desc; ?></p>

                            <div class="flex items-center justify-end mt-auto pt-4 border-t border-gray-50">
                                <div class="flex space-x-3">
                                    <a href="view-service.php?id=<?php echo $service['id']; ?>"
                                        class="h-8 w-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shadow-md hover:shadow-lg hover:bg-blue-200 transition-all"
                                        title="View">
                                        <i class="fas fa-eye text-sm"></i>
                                    </a>
                                    <a href="edit-service.php?id=<?php echo $service['id']; ?>"
                                        class="h-8 w-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center shadow-md hover:shadow-lg hover:bg-green-200 transition-all"
                                        title="Edit">
                                        <i class="fas fa-pencil-alt text-sm"></i>
                                    </a>
                                    <button data-id="<?php echo $service['id']; ?>"
                                        class="delete-btn h-8 w-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center shadow-md hover:shadow-lg hover:bg-red-200 transition-all"
                                        title="Delete">
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
            </div>
        </main>
    </div>

    <?php include('bottom.php') ?>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="main.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // AOS Initialization
        if (typeof AOS !== 'undefined') {
            AOS.init();
        }

        // Delete Logic
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
                    if (result.isConfirmed) window.location.href =
                        'logics.php?delete_service_id=' + id;
                });
            });
        });
    });
    </script>
</body>

</html>