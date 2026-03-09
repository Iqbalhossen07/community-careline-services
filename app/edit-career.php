<?php
include('db.php');
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

if (!isset($_GET['id'])) {
    header('Location: careers.php');
    exit();
}

$id = $_GET['id'];
$pageTitle = 'Edit Career';

// Fetch Current Career Data
$stmt = $mysqli->prepare("SELECT * FROM careers WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$career = $result->fetch_assoc();

if (!$career) {
    header('Location: careers.php');
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
                    <h1 class="text-3xl font-bold font-heading text-gray-800">Edit Career Opening</h1>
                    <a href="careers.php"
                        class="font-nav bg-gray-600 text-white px-4 py-2 rounded shadow flex items-center gap-2 hover:bg-gray-700 transition-colors">
                        <i class="fa-solid fa-arrow-left text-sm"></i> Back
                    </a>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 md:p-8" data-aos="fade-up">
                    <form action="logics.php" method="POST">
                        <input type="hidden" name="id" value="<?php echo $career['id']; ?>">

                        <div class="bg-gray-50 rounded-xl border border-gray-200 p-6 mb-6">
                            <h3 class="font-heading font-bold text-gray-700 mb-4 border-b pb-2">Update Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold mb-1 text-gray-700">Job Title</label>
                                    <input type="text" name="c_title"
                                        value="<?php echo htmlspecialchars($career['c_title']); ?>"
                                        class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-primary-end outline-none transition-all"
                                        required>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold mb-1 text-gray-700">Job Type</label>
                                    <select name="c_job_type"
                                        class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-primary-end outline-none bg-white"
                                        required>
                                        <?php
                                        $types = ['Full-Time', 'Part-Time', 'Remote', 'Internship', 'Contract'];
                                        foreach ($types as $type) {
                                            $selected = ($career['c_job_type'] == $type) ? 'selected' : '';
                                            echo "<option value='$type' $selected>$type</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-semibold mb-1 text-gray-700">Location</label>
                                    <input type="text" name="c_location"
                                        value="<?php echo htmlspecialchars($career['c_location']); ?>"
                                        class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-primary-end outline-none transition-all"
                                        required>
                                </div>

                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold mb-1 text-gray-700">Salary Range</label>
                                    <input type="text" name="c_salary"
                                        value="<?php echo htmlspecialchars($career['c_salary']); ?>"
                                        class="w-full px-4 py-2.5 border rounded-lg focus:ring-2 focus:ring-primary-end outline-none transition-all">
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-xl border border-gray-200 p-6 mb-6 space-y-6">
                            <h3 class="font-heading font-bold text-gray-700 mb-2 border-b pb-2">Job Details & Content
                            </h3>

                            <div class="w-full">
                                <label class="block text-sm font-semibold mb-2 text-gray-700">Job Description</label>
                                <textarea id="textarea-description1"
                                    name="c_description"><?php echo $career['c_description']; ?></textarea>
                            </div>

                            <div class="w-full">
                                <label class="block text-sm font-semibold mb-2 text-gray-700">Responsibilities</label>
                                <textarea id="textarea-description2"
                                    name="c_responsibilties"><?php echo $career['c_responsibilties']; ?></textarea>
                            </div>

                            <div class="w-full">
                                <label class="block text-sm font-semibold mb-2 text-gray-700">Requirements</label>
                                <textarea id="textarea-description3"
                                    name="c_requirements"><?php echo $career['c_requirements']; ?></textarea>
                            </div>
                        </div>



                        <div class="text-right">
                            <button type="submit" name="update_career"
                                class="bg-primary-start text-white px-8 py-3 rounded-lg shadow-md hover:bg-primary-end transition-all font-bold uppercase tracking-widest text-sm">
                                <i class="fa-solid fa-arrows-rotate mr-2"></i> Update Job
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
    ClassicEditor.create(document.querySelector("#textarea-description1")).catch(
        (error) => {
            console.error(error);
        }
    );
    ClassicEditor.create(document.querySelector("#textarea-description2")).catch(
        (error) => {
            console.error(error);
        }
    );
    ClassicEditor.create(document.querySelector("#textarea-description3")).catch(
        (error) => {
            console.error(error);
        }
    );
    </script>
</body>

</html>