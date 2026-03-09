<?php
include('db.php'); // ডেটাবেস কানেকশন

// সেশন চেক
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
</head>

<body class="bg-gray-100 font-body">
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

            <div class="p-8 mb-16 md:mb-0" data-aos="fade-up">

                <form id="bulkDeleteForm" action="logics.php" method="POST">
                    <input type="hidden" name="bulk_delete_action" value="1">

                    <div class="p-8 mb-16 md:mb-0">
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
                                    <div class="border-card bg-white rounded-xl shadow-lg flex flex-col relative overflow-hidden">
                                        <div class="absolute top-4 left-4 z-10">
                                            <input type="checkbox" name="message_ids[]" value="<?php echo $msg['id']; ?>" class="msg-checkbox w-5 h-5 rounded border-gray-300 text-blue-600">
                                        </div>
                                        <div class="p-5 pl-12 border-b border-gray-100 flex justify-between items-start">
                                            <div>
                                                <h3 class="text-xl font-bold text-gray-900"><?php echo htmlspecialchars($msg['name']); ?></h3>
                                                <p class="text-sm text-gray-500 mt-1"><?php echo htmlspecialchars($msg['email']); ?></p>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-gray-500 mb-1">Phone Number</label>
                                                <p class="text-gray-700"><?php echo htmlspecialchars($msg['phone']); ?></p>
                                            </div>
                                            <div>
                                                <label class="block text-xs font-semibold text-gray-500 mb-1">Service</label>
                                                <p class="text-gray-700"><?php echo ($msg['service']); ?></p>
                                            </div>

                                        </div>
                                        <div class="p-5 flex-1 space-y-4 font-body">
                                            <div>
                                                <label class="block text-xs font-bold text-gray-500 mb-1 uppercase tracking-widest">Message</label>
                                                <div class="bg-gray-50 p-3 rounded-lg">
                                                    <p class="text-gray-700 text-sm"><?php echo nl2br(($msg['message'])); ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="col-span-full text-center py-10">No messages found.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </div>

    <div id="deleteModal" class="modal hidden fixed inset-0 z-[60] flex items-center justify-center bg-black/50 p-4 font-body">
        <div class="bg-white rounded-xl shadow-lg w-full max-w-md" data-aos="zoom-in" data-aos-duration="300">
            <div class="flex justify-between items-center p-5 border-b">
                <h3 class="text-xl font-heading font-bold text-gray-800">Confirm Deletion</h3>
                <button data-modal-close="deleteModal" class="text-gray-500 hover:text-gray-800 text-2xl">&times;</button>
            </div>
            <div class="p-6 text-center">
                <div class="w-16 h-16 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-exclamation-triangle text-2xl"></i>
                </div>
                <p id="delete-modal-text" class="text-gray-600"></p>
            </div>
            <div class="p-5 border-t flex justify-end gap-3">
                <button data-modal-close="deleteModal" type="button" class="bg-gray-200 text-gray-800 px-5 py-2 rounded-lg hover:bg-gray-300 transition-colors text-sm font-bold uppercase tracking-wider">Cancel</button>
                <a id="delete-confirm-link" href="#" class="bg-red-600 text-white px-5 py-2 rounded-lg hover:bg-red-700 transition-colors text-sm font-bold uppercase tracking-wider">Delete Now</a>
            </div>
        </div>
    </div>

    <?php include('bottom.php') ?>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="main.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Single Delete Logic ---
            const deleteButtons = document.querySelectorAll('.delete-btn');
            const deleteModal = document.getElementById('deleteModal');
            const deleteModalText = document.getElementById('delete-modal-text');
            const deleteConfirmLink = document.getElementById('delete-confirm-link');
            const closeButtons = document.querySelectorAll('[data-modal-close]');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const msgId = this.dataset.id;
                    const msgName = this.dataset.name;
                    deleteModalText.innerHTML = `Are you sure you want to delete the message from <strong>${msgName}</strong>?`;
                    deleteConfirmLink.href = `logics.php?message_delete_id=${msgId}`;
                    deleteModal.classList.remove('hidden');
                });
            });

            closeButtons.forEach(btn => {
                btn.addEventListener('click', () => deleteModal.classList.add('hidden'));
            });

            // --- Bulk Delete "Select All" Logic ---
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('.msg-checkbox');

            if (selectAll) {
                selectAll.addEventListener('change', function() {
                    checkboxes.forEach(cb => {
                        cb.checked = selectAll.checked;
                    });
                });
            }

            // --- Bulk Delete SweetAlert Confirmation ---
            window.confirmBulkDelete = function(e) {
                const checkedCount = document.querySelectorAll('.msg-checkbox:checked').length;

                if (checkedCount === 0) {
                    e.preventDefault();
                    Swal.fire({
                        title: "No Selection",
                        text: "Please select at least one message to delete.",
                        icon: "warning",
                        confirmButtonColor: "#3B82F6"
                    });
                    return false;
                }

                e.preventDefault();
                Swal.fire({
                    title: `Delete ${checkedCount} Messages?`,
                    text: "You won't be able to revert this action!",
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