<?php
include('db.php'); // ডেটাবেস কানেকশন

// সেশন চেক
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}
$pageTitle = 'Manage Blogs';
$upload_folder = 'uploads/blog_images/'; // ছবি দেখানোর জন্য ফোল্ডার পাথ

// --- ডেটাবেস থেকে সব ব্লগ নিয়ে আসা ---
$blogs = [];
$result = $mysqli->query("SELECT * FROM blogs ORDER BY id DESC");
if ($result) {
    $blogs = $result->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php') ?>
    <title>Manage Blogs - Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
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

            <div class="p-8 mb-32 md:mb-0" data-aos="fade-up">

                <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                    <h1 class="text-3xl font-bold font-heading text-gray-800">
                        Manage Blogs
                    </h1>

                    <div class="flex items-center gap-3 w-full md:w-auto">
                        <a href="add-blog.php" class="font-nav flex items-center justify-center bg-primary-start text-white px-4 py-2 rounded-lg shadow-md hover:bg-primary-end transition-colors duration-300 w-full md:w-auto font-bold uppercase tracking-wider text-xs">
                            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span>Add New Post</span>
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                    <?php if (!empty($blogs)) : ?>
                        <?php foreach ($blogs as $index => $blog) : ?>
                            <?php
                            // Text Snippet Logic
                            $desc = strip_tags($blog['description']);
                            $snippet = (mb_strlen($desc) > 80) ? mb_substr($desc, 0, 80) . '...' : $desc;
                            
                            $image_path = $upload_folder . htmlspecialchars($blog['image']);
                            $date_display = isset($blog['created_at']) ? date('M d, Y', strtotime($blog['created_at'])) : 'N/A';
                            ?>

                            <div class="border-card bg-white rounded-xl shadow-lg overflow-hidden flex flex-col">
                                <img src="<?php echo $image_path; ?>" alt="<?php echo htmlspecialchars($blog['name']); ?>" class="w-full h-48 object-cover">

                                <div class="p-6 flex flex-col flex-1">
                                    <div class="flex-1">
                                        <p class="text-xs font-bold text-primary-start font-nav uppercase tracking-widest">
                                            <?php echo htmlspecialchars($blog['category']); ?>
                                        </p>
                                        
                                        <h3 class="text-lg font-bold font-heading text-gray-900 mt-2 line-clamp-2 leading-tight">
                                            <?php echo htmlspecialchars($blog['name']); ?>
                                        </h3>
                                        
                                        <p class="text-gray-600 text-sm mt-3 leading-relaxed">
                                            <?php echo ($snippet); ?>
                                        </p>

                                        <div class="flex items-center justify-between text-[10px] text-gray-500 mt-4 font-body uppercase tracking-wider">
                                            <span class="font-bold">
                                                <span>By</span> 
                                                <span class="text-gray-700"><?php echo htmlspecialchars($blog['author_name']); ?></span>
                                            </span>
                                            <span><?php echo $date_display; ?></span>
                                        </div>
                                    </div>

                                    <div class="flex justify-end space-x-3 mt-6 pt-4 border-t border-gray-100">
                                        <a href="view-blog.php?id=<?php echo $blog['id']; ?>" class="h-8 w-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shadow-md hover:shadow-lg hover:bg-blue-200 hover:-translate-y-0.5 transition-all duration-300" title="View">
                                            <i class="fas fa-eye text-xs"></i>
                                        </a>
                                        <a href="edit-blog.php?id=<?php echo $blog['id']; ?>" class="h-8 w-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center shadow-md hover:shadow-lg hover:bg-green-200 hover:-translate-y-0.5 transition-all duration-300" title="Edit">
                                            <i class="fas fa-pencil-alt text-xs"></i>
                                        </a>
                                        <button data-id="<?php echo $blog['id']; ?>" class="delete-btn h-8 w-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center shadow-md hover:shadow-lg hover:bg-red-200 hover:-translate-y-0.5 transition-all duration-300" title="Delete">
                                            <i class="fas fa-trash-alt text-xs"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    <?php else : ?>
                        <p class="text-gray-500 col-span-full text-center py-10 font-body">No blog posts found. Please add a new post.</p>
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
            const deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const blogId = this.dataset.id;

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#eb380b', 
                        cancelButtonColor: '#6b7280', 
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'logics.php?blog_delete_id=' + blogId;
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>