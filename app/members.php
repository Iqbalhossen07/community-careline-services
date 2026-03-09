<?php
include('db.php'); // ডেটাবেস কানেকশন

// সেশন চেক
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}
$pageTitle = 'Manage Members';
$upload_folder = 'uploads/member_images/'; // আপনার দেওয়া ফোল্ডার পাথ

// --- ডেটাবেস থেকে সব মেম্বার নিয়ে আসা ---
$members = [];
$result = $mysqli->query("SELECT * FROM members ORDER BY id DESC");
if ($result) {
    $members = $result->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php') ?>
    <title>Manage Members - Admin Dashboard</title>
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
            
            <div class="p-8 mb-32 md:mb-0 " data-aos="fade-up">

                <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                    <h1 class="text-3xl font-bold font-heading text-gray-800">
                        Manage Members
                    </h1>
                    
                    <a href="add-member.php" class="font-nav flex items-center justify-center bg-primary-start text-white px-4 py-2 rounded-lg shadow-md hover:bg-primary-end transition-colors duration-300 w-full md:w-auto uppercase tracking-wider text-xs font-bold" data-aos="fade-left">
                        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        <span>Add New Member</span>
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                    <?php if (!empty($members)) : ?>
                        <?php foreach ($members as $index => $member) : ?>
                            <?php
                            $image_path = $upload_folder . htmlspecialchars($member['image']);
                            $is_admin = (strtolower($member['designation']) == 'administrator');
                            $border_class = $is_admin ? 'border-primary-start/20' : 'border-gray-200';
                            $text_class = $is_admin ? 'text-primary-start' : 'text-gray-600';
                            ?>
                            <div class="border-card bg-white rounded-xl shadow-lg p-6 text-center flex flex-col items-center">
                                <img src="<?php echo $image_path; ?>" alt="<?php echo htmlspecialchars($member['name']); ?>" class="w-52 h-52 rounded-full shadow-md mb-4 border-4 <?php echo $border_class; ?> object-cover">
                                
                                <h3 class="text-xl font-bold font-heading text-gray-900"><?php echo htmlspecialchars($member['name']); ?></h3>
                                <p class="text-sm font-semibold <?php echo $text_class; ?> uppercase tracking-wide"><?php echo htmlspecialchars($member['designation']); ?></p>
                                
                                <div class="flex justify-center space-x-3 mt-6 pt-4 border-t border-gray-100 w-full">
                                    <a href="view-member.php?id=<?php echo $member['id']; ?>" class="h-8 w-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shadow-md hover:shadow-lg hover:bg-blue-200 hover:-translate-y-0.5 transition-all duration-300" title="View">
                                            <i class="fas fa-eye text-xs"></i>
                                    </a>
                                    <a href="edit-member.php?id=<?php echo $member['id']; ?>" class="h-8 w-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center shadow-md hover:shadow-lg hover:bg-green-200 hover:-translate-y-0.5 transition-all duration-300" title="Edit">
                                            <i class="fas fa-pencil-alt text-xs"></i>
                                    </a>
                                    <button data-id="<?php echo $member['id']; ?>" class="delete-btn h-8 w-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center shadow-md hover:shadow-lg hover:bg-red-200 hover:-translate-y-0.5 transition-all duration-300" title="Delete">
                                            <i class="fas fa-trash-alt text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p class="text-gray-500 col-span-full text-center py-10 font-body">No members found. Please add a new member.</p>
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
                    const memberId = this.dataset.id;
                    
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
                            window.location.href = 'logics.php?member_delete_id=' + memberId;
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>