<?php
include('db.php');
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}
$pageTitle = 'Manage Testimonials';

// Fetch Testimonials
$testimonials = [];
$result = $mysqli->query("SELECT * FROM testimonials ORDER BY id DESC");
if ($result) {
    $testimonials = $result->fetch_all(MYSQLI_ASSOC);
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

                <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold font-heading text-gray-800">Client Testimonials</h1>
                        <p class="text-sm text-gray-500 font-body">Manage what your clients are saying about you</p>
                    </div>
                    <a href="add-testimonial.php"
                        class="bg-primary-start text-white px-6 py-2.5 rounded-lg shadow-md hover:bg-primary-end transition-all font-bold uppercase tracking-wider text-xs flex items-center justify-center">
                        <i class="fa-solid fa-plus mr-2"></i> Add Testimonial
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6" id="testimonialGrid">
                    <?php if (!empty($testimonials)) : ?>
                    <?php foreach ($testimonials as $item) : ?>
                    <div
                        class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 flex flex-col hover:shadow-md transition-all duration-300 relative overflow-hidden group">

                        <div
                            class="absolute -top-2 -right-2 text-gray-50 opacity-10 group-hover:opacity-20 transition-opacity">
                            <i class="fa-solid fa-quote-right text-8xl"></i>
                        </div>

                        <div class="relative z-10 flex-grow">
                            <i class="fa-solid fa-quote-left text-primary-start/40 text-2xl mb-4 block"></i>
                            <p class="text-gray-600 text-sm italic leading-relaxed font-body mb-6 line-clamp-3">
                                <?php echo htmlspecialchars($item['t_des']); ?>
                            </p>
                        </div>

                        <div class="mt-auto pt-6 border-t border-gray-50 relative z-10">
                            <div class="flex justify-between items-end">
                                <div>
                                    <h4 class="font-bold text-gray-800 font-heading text-lg">
                                        <?php echo htmlspecialchars($item['t_name']); ?>
                                    </h4>
                                    <p class="text-xs text-primary-start font-bold uppercase tracking-widest">
                                        <?php echo htmlspecialchars($item['t_designation']); ?>
                                    </p>
                                </div>

                                <div class="flex space-x-2">
                                    <a href="view-testimonial.php?id=<?php echo $item['id']; ?>"
                                        class="h-8 w-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center shadow-sm hover:bg-blue-100 transition-all"
                                        title="View">
                                        <i class="fas fa-eye text-[10px]"></i>
                                    </a>
                                    <a href="edit-testimonial.php?id=<?php echo $item['id']; ?>"
                                        class="h-8 w-8 rounded-full bg-green-50 text-green-600 flex items-center justify-center shadow-sm hover:bg-green-100 transition-all"
                                        title="Edit">
                                        <i class="fas fa-pencil-alt text-[10px]"></i>
                                    </a>
                                    <button data-id="<?php echo $item['id']; ?>"
                                        class="delete-btn h-8 w-8 rounded-full bg-red-50 text-red-600 flex items-center justify-center shadow-sm hover:bg-red-100 transition-all"
                                        title="Delete">
                                        <i class="fas fa-trash-alt text-[10px]"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php else : ?>
                    <div
                        class="col-span-full text-center py-20 bg-white rounded-2xl border border-dashed border-gray-200">
                        <i class="fa-solid fa-comments text-6xl text-gray-100 mb-4"></i>
                        <p class="text-gray-400 font-body">No testimonials available yet. Click "Add Testimonial" to get
                            started!</p>
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
        // Delete Logic
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                Swal.fire({
                    title: 'Are you sure?',
                    text: "This feedback will be removed permanently.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#eb380b',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) window.location.href =
                        'logics.php?delete_testimonial_id=' + id;
                });
            });
        });
    });
    </script>
</body>

</html>