<?php
include('db.php');
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: testimonials.php');
    exit();
}

$id = $_GET['id'];
$pageTitle = 'Edit Testimonial';

// Fetch Current Testimonial Data
$stmt = $mysqli->prepare("SELECT * FROM testimonials WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$testimonial = $result->fetch_assoc();

if (!$testimonial) {
    header('Location: testimonials.php');
    exit();
}
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
            <div class="p-8 mb-32 md:mb-0">

                <div class="flex justify-between items-center mb-6" data-aos="fade-down">
                    <h1 class="text-3xl font-bold font-heading text-gray-800">Edit Feedback</h1>
                    <a href="testimonials.php"
                        class="font-nav bg-gray-600 text-white px-4 py-2 rounded shadow flex items-center gap-2 hover:bg-gray-700 transition-colors">
                        <i class="fa-solid fa-arrow-left"></i> Back
                    </a>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 md:p-8" data-aos="fade-up">
                    <form action="logics.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $testimonial['id']; ?>">

                        <div class="bg-gray-50 rounded-xl border border-gray-200 p-6 mb-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-semibold mb-2 text-gray-700">Client Name</label>
                                    <input type="text" name="t_name"
                                        value="<?php echo htmlspecialchars($testimonial['t_name']); ?>"
                                        class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-primary-end outline-none transition-all"
                                        required>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold mb-2 text-gray-700">Designation</label>
                                    <input type="text" name="t_designation"
                                        value="<?php echo htmlspecialchars($testimonial['t_designation']); ?>"
                                        class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-primary-end outline-none transition-all"
                                        required>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-xl border border-gray-200 p-6 mb-6">
                            <label class="block text-sm font-semibold mb-2 text-gray-700">Client Speech /
                                Description</label>
                            <textarea id="textarea-description" name="t_des"
                                required><?php echo $testimonial['t_des']; ?></textarea>
                        </div>

                        <div class="text-right">
                            <button type="submit" name="update_testimonial"
                                class="bg-primary-start text-white px-8 py-3 rounded-lg shadow-md hover:bg-primary-end transition-all font-bold uppercase tracking-widest text-sm">
                                <i class="fa-solid fa-arrows-rotate mr-2"></i> Update Testimonial
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