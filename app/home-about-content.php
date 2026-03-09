<?php
include('db.php'); // ডেটাবেস কানেকশন

// সেশন চেক
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}
$pageTitle = 'Manage Home About Content';

// --- ডেটাবেস থেকে বর্তমান কনটেন্ট আনা ---
$current_data = [];
$query = "SELECT * FROM home_about_content WHERE id = 1 LIMIT 1";
$result = $mysqli->query($query);

if ($result && $result->num_rows > 0) {
    $current_data = $result->fetch_assoc();
}

// ভেরিয়েবল সেট করা
$current_title = $current_data['title'] ?? '';
$current_description = $current_data['content'] ?? '';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php') ?>
    <title>Home About Content - Careline</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
</head>

<body class="bg-gray-100 font-body">
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
            <?php unset($_SESSION['message']);
                unset($_SESSION['message_type']);
            } ?>

            <div class="p-8 mb-32 md:mb-0 ">

                <div class="flex justify-between items-center mb-6" data-aos="fade-down">
                    <h1 class="text-3xl font-bold font-heading text-gray-800">
                        Manage Home About Content
                    </h1>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 md:p-8" data-aos="fade-up">

                    <form action="logics.php" method="POST">
                        <div class="grid grid-cols-1 gap-8">

                            <div>
                                <label class="font-body block text-sm font-semibold text-gray-700 mb-1">About Title</label>
                                <textarea name="title" rows="3" class="font-body w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end focus:border-transparent" placeholder="e.g., Our Ethos" required><?php echo htmlspecialchars($current_title); ?></textarea>
                            </div>

                            <div>
                                <label for="textarea-description" class="font-body block text-sm font-semibold text-gray-700 mb-2">Description</label>
                                <textarea id="textarea-description" name="content" rows="10" class="font-body w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end focus:border-transparent"
                                    placeholder="Write the about us content here..."><?php echo htmlspecialchars($current_description); ?></textarea>
                            </div>

                        </div>

                        <div class="mt-8 text-right">
                            <button type="submit" name="update_home_about_content" class="font-nav inline-flex items-center justify-center bg-primary-start text-white px-8 py-3 rounded-lg shadow-md hover:bg-primary-end transition-colors duration-300 font-bold">
                                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                                </svg>
                                <span>Save Changes</span>
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
        // Initialize CKEditor
        CKEDITOR.replace('textarea-description');
    </script>
</body>

</html>