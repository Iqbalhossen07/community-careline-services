<?php
include('db.php'); // ডেটাবেস কানেকশন

// সেশন চেক (লগইন না থাকলে রিডাইরেক্ট)
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}
$pageTitle = 'Contact Messages';

// --- ডেটাবেস থেকে সব মেসেজ আনা (নতুনগুলো আগে) ---
$messages = [];
$result = $mysqli->query("SELECT * FROM messages ORDER BY id DESC");
if ($result) {
    $messages = $result->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php') ?>
    <title>Contact Messages - Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>

<body class="bg-gray-100 font-body">
    <div class="flex h-screen">

        <?php include('sidebar.php') ?>

        <main class="flex-1 h-full overflow-y-auto">

            <?php include('top.php') ?>

            <?php if (isset($_SESSION['message'])): ?>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: "<?php echo $_SESSION['message']; ?>",
                            icon: "<?php echo $_SESSION['message_type']; ?>",
                            confirmButtonColor: 'hsl(200 75% 58%)',
                            confirmButtonText: "OK"
                        });
                    });
                </script>
                <?php 
                unset($_SESSION['message']); 
                unset($_SESSION['message_type']); 
            endif; ?>

            <div class="p-8 mb-32 md:mb-0" data-aos="fade-up">

                <form id="bulkDeleteForm" action="logics.php" method="POST">
                    <input type="hidden" name="bulk_delete_action" value="1">

                    <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                        <h1 class="text-3xl font-bold font-heading text-gray-800">Contact Form Submissions</h1>

                        <div class="flex items-center gap-4">
                            <div class="flex items-center bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-200">
                                <input type="checkbox" id="selectAll" class="w-4 h-4 text-blue-600 rounded cursor-pointer">
                                <label for="selectAll" class="ml-2 text-sm font-medium text-gray-700 cursor-pointer">Select All</label>
                            </div>
                            <button type="button" onclick="confirmBulkDelete(event)" 
                                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm font-bold shadow-md flex items-center gap-2 transition-all">
                                <i class="fas fa-trash-alt"></i> Delete Selected
                            </button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <?php if (!empty($messages)) : ?>
                            <?php foreach ($messages as $msg) : ?>
                                <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow flex flex-col relative overflow-hidden border border-gray-100">
                                    
                                    <div class="absolute top-4 left-4 z-10">
                                        <input type="checkbox" name="message_ids[]" value="<?php echo $msg['id']; ?>" class="msg-checkbox w-5 h-5 rounded border-gray-300 text-blue-600">
                                    </div>

                                    <div class="p-5 pl-12 border-b border-gray-100 flex justify-between items-start">
                                        <div>
                                            <h3 class="text-lg font-bold text-gray-900 leading-tight"><?php echo htmlspecialchars($msg['name']); ?></h3>
                                            <p class="text-xs text-gray-500 mt-1"><?php echo htmlspecialchars($msg['email']); ?></p>
                                        </div>
                                        
                                        <button type="button" 
                                                class="single-delete-btn h-8 w-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all duration-300"
                                                data-id="<?php echo $msg['id']; ?>"
                                                data-name="<?php echo htmlspecialchars($msg['name']); ?>">
                                            <i class="fas fa-trash-alt text-sm"></i>
                                        </button>
                                    </div>

                                    <div class="p-5 flex-1 space-y-4">
                                        <div>
                                            <label class="block text-[10px] uppercase tracking-wider font-bold text-gray-400 mb-1">Phone</label>
                                            <p class="text-gray-700 text-sm font-medium"><?php echo htmlspecialchars($msg['phone']); ?></p>
                                        </div>
                                        <div>
                                            <label class="block text-[10px] uppercase tracking-wider font-bold text-gray-400 mb-1">Service Interest</label>
                                            <p class="text-gray-700 text-sm"><?php echo htmlspecialchars($msg['service']); ?></p>
                                        </div>
                                        <div>
                                            <label class="block text-[10px] uppercase tracking-wider font-bold text-gray-400 mb-1">Message Body</label>
                                            <div class="text-gray-600 text-sm leading-relaxed max-h-[120px] overflow-y-auto pr-2 bg-gray-50 p-3 rounded-lg border border-gray-100">
                                                <?php echo nl2br(htmlspecialchars($msg['message'])); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="col-span-full text-center py-20 bg-white rounded-2xl shadow-sm border border-dashed border-gray-300">
                                <i class="fas fa-envelope-open text-gray-300 text-5xl mb-4"></i>
                                <p class="text-gray-500 font-medium">No contact messages found in the database.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <?php include('bottom.php') ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="main.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init();

            // --- ১. সিঙ্গেল ডিলিট (Single Delete with SweetAlert2) ---
            const singleDeleteBtns = document.querySelectorAll('.single-delete-btn');
            singleDeleteBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const id = this.dataset.id;
                    const name = this.dataset.name;

                    Swal.fire({
                        title: 'Are you sure?',
                        html: `Do you want to delete the message from <b>${name}</b>?<br><span style="color:red; font-size:12px;">This action cannot be undone!</span>`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#6B7280',
                        confirmButtonText: 'Yes, Delete it!',
                        cancelButtonText: 'No, Keep it'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // কনফার্ম করলে logics.php তে পাঠিয়ে দিচ্ছে
                            window.location.href = `logics.php?message_delete_id=${id}`;
                        }
                    });
                });
            });

            // --- ২. বাল্ক ডিলিট "Select All" Logic ---
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.msg-checkbox');

            if(selectAll) {
                selectAll.addEventListener('change', function() {
                    checkboxes.forEach(cb => {
                        cb.checked = selectAll.checked;
                    });
                });
            }

            // --- ৩. বাল্ক ডিলিট SweetAlert Confirmation ---
            window.confirmBulkDelete = function(e) {
                const checkedBoxes = document.querySelectorAll('.msg-checkbox:checked');
                const checkedCount = checkedBoxes.length;
                
                if (checkedCount === 0) {
                    Swal.fire({
                        title: "No Selection",
                        text: "Please select at least one message to delete.",
                        icon: "info",
                        confirmButtonColor: "hsl(200 75% 58%)"
                    });
                    return false;
                }

                Swal.fire({
                    title: `Delete ${checkedCount} Messages?`,
                    text: "Are you sure you want to remove all selected items? This is permanent.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6B7280',
                    confirmButtonText: 'Yes, Delete All',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('bulkDeleteForm').submit();
                    }
                });
            }
        });
    </script>
</body>
</html>