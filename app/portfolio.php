<?php
include('db.php'); // ডেটাবেস কানেকশন

// সেশন চেক
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}
$pageTitle = 'Manage Portfolios';
$upload_folder = 'uploads/portfolio_images/';

// --- ডেটাবেস থেকে সব পোর্টফোলিও আইটেম নিয়ে আসা ---
$portfolios = [];
$result = $mysqli->query("SELECT * FROM portfolios ORDER BY id DESC");
if ($result) {
    $portfolios = $result->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php') ?>
    <title>Manage Portfolios - Admin Dashboard</title>
</head>

<body class="bg-gray-100 font-body"> <div class="flex h-screen">

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

            <div class="p-8 mb-32 md:mb-0" data-aos="fade-up">

                <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                    <h1 class="text-3xl font-bold font-heading text-gray-800">
                        Manage Portfolios
                    </h1>

                    <a href="add-portfolio.php" class="font-nav flex items-center justify-center bg-primary-start text-white px-4 py-2 rounded-lg shadow-md hover:bg-primary-end transition-colors duration-300 w-full md:w-auto font-bold uppercase tracking-wider text-xs">
                        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        <span>Add New Item</span>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                    <?php if (!empty($portfolios)) : ?>
                        <?php foreach ($portfolios as $item) : ?>
                            <?php
                            $image_path = $upload_folder . htmlspecialchars($item['image']);
                            $snippet = strip_tags($item['short_description']);
                            $snippet = (mb_strlen($snippet) > 100) ? mb_substr($snippet, 0, 100) . '...' : $snippet;
                            ?>
                            
                            <div class="border-card bg-white rounded-xl shadow-md border border-gray-100 hover:shadow-xl transition duration-300 flex flex-col overflow-hidden group">

                                <div class="relative h-56 w-full overflow-hidden">
                                    <img src="<?php echo $image_path; ?>" alt="<?php echo htmlspecialchars($item['name']); ?>" 
                                         class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-110">
                                    
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                </div>

                                <div class="p-6 flex flex-col flex-grow">
                                    
                                    <div class="flex items-center gap-2 mb-2">
                                        <?php if(!empty($item['year'])): ?>
                                            <span class="font-body bg-blue-50 text-blue-600 text-[10px] font-bold px-2 py-1 rounded border border-blue-100 uppercase tracking-wider">
                                                <i class="fa-solid fa-clock mr-1"></i> <?php echo htmlspecialchars($item['year']); ?>
                                            </span>
                                        <?php endif; ?>
                                        
                                        <?php if(!empty($item['country'])): ?>
                                            <span class="font-body bg-purple-50 text-purple-600 text-[10px] font-bold px-2 py-1 rounded border border-purple-100 uppercase tracking-wider">
                                                <i class="fa-solid fa-location-dot mr-1"></i><?php echo htmlspecialchars($item['country']); ?>
                                            </span>
                                        <?php endif; ?>
                                        <?php if(!empty($item['typology'])): ?>
                                            <span class="font-body bg-green-50 text-green-600 text-[10px] font-bold px-2 py-1 rounded border border-green-100 uppercase tracking-wider">
                                                <i class="fa-solid fa-tag mr-1"></i><?php echo htmlspecialchars($item['typology']); ?>
                                            </span>
                                        <?php endif; ?>
                                        <?php if(!empty($item['gross_cost'])): ?>
                                            <span class="font-body bg-red-50 text-red-600 text-[10px] font-bold px-2 py-1 rounded border border-red-100 uppercase tracking-wider">
                                               <i class="fa-solid fa-money-bill-1 mr-1"></i><?php echo htmlspecialchars($item['gross_cost']); ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>

                                    <h3 class="text-xl font-bold font-heading text-gray-800 mb-2 line-clamp-1" title="<?php echo htmlspecialchars($item['name']); ?>">
                                        <?php echo htmlspecialchars($item['name']); ?>
                                    </h3>
                                    
                                    <p class="text-gray-600 text-sm mb-4 line-clamp-3 flex-grow leading-relaxed">
                                        <?php echo htmlspecialchars($snippet); ?>
                                    </p>

                                    <div class="flex justify-end space-x-3 mt-auto pt-4 border-t border-gray-100">
                                        <a href="view-portfolio.php?id=<?php echo $item['id']; ?>" 
                                           class="h-9 w-9 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shadow-md hover:shadow-lg hover:bg-blue-200 hover:-translate-y-0.5 transition-all duration-300" 
                                           title="View Details">
                                            <i class="fas fa-eye text-sm"></i>
                                        </a>

                                        <a href="edit-portfolio.php?id=<?php echo $item['id']; ?>" 
                                           class="h-9 w-9 rounded-full bg-green-100 text-green-600 flex items-center justify-center shadow-md hover:shadow-lg hover:bg-green-200 hover:-translate-y-0.5 transition-all duration-300" 
                                           title="Edit">
                                            <i class="fas fa-pencil-alt text-sm"></i>
                                        </a>

                                        <button data-id="<?php echo $item['id']; ?>" 
                                                class="delete-btn h-9 w-9 rounded-full bg-red-100 text-red-600 flex items-center justify-center shadow-md hover:shadow-lg hover:bg-red-200 hover:-translate-y-0.5 transition-all duration-300" 
                                                title="Delete">
                                            <i class="fas fa-trash-alt text-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <div class="col-span-full flex flex-col items-center justify-center py-20 bg-white rounded-xl border-2 border-dashed border-gray-300">
                            <div class="bg-gray-100 p-4 rounded-full mb-4">
                                <i class="fa-regular fa-folder-open text-4xl text-gray-400"></i>
                            </div>
                            <h3 class="font-heading text-lg font-semibold text-gray-700">No Portfolio Items Found</h3>
                            <p class="font-body text-gray-500 mb-6">Get started by adding your first project.</p>
                            <a href="add-portfolio.php" class="font-nav bg-primary-start text-white px-6 py-2 rounded-lg hover:bg-primary-end transition shadow-md font-bold uppercase tracking-wider text-xs">
                                Add Portfolio Item
                            </a>
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
            const deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const portfolioId = this.dataset.id;

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "This will delete the item and all associated images!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#eb380b',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'logics.php?portfolio_delete_id=' + portfolioId;
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>