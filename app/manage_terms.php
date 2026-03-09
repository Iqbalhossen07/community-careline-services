<?php
include('db.php');
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}
$pageTitle = 'Manage Terms of Use';
$terms_data = $mysqli->query("SELECT * FROM terms_of_use WHERE id = 1")->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php') ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
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

            <div class="p-8 mb-32 md:mb-0">
                <div class="flex justify-between items-center mb-6" data-aos="fade-down">
                    <h1 class="text-3xl font-bold font-heading text-gray-800">Terms of Use</h1>
                    <div class="flex gap-3">
                        <a href="terms_view.php" class="h-10 w-10 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shadow-md hover:shadow-lg hover:bg-blue-200 hover:-translate-y-0.5 transition-all duration-300" title="View Page">
                            <i class="fas fa-eye text-sm"></i>
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 md:p-8" data-aos="fade-up">
                    <form action="logics.php" method="POST">
                        <div class="grid grid-cols-1 gap-6 font-body">
                            <div>
                                <label for="textarea-description" class="block text-sm font-semibold text-gray-700 mb-2">Terms Content</label>
                                <textarea id="textarea-description" name="terms_description" rows="15"><?php echo $terms_data['description']; ?></textarea>
                            </div>
                        </div>

                        <div class="mt-8 text-right">
                            <button type="submit" name="update_terms" class="font-nav inline-flex items-center justify-center bg-primary-start text-white px-8 py-3 rounded-lg shadow-md hover:bg-primary-end transition-all duration-300 font-bold uppercase tracking-widest text-sm">
                                <i class="fas fa-check-circle mr-2"></i>
                                <span>Save Terms of Use</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>
    <?php include('bottom.php') ?>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="main.js"></script>
    <script>
        CKEDITOR.replace('textarea-description');
    </script>
</body>

</html>