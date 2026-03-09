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
$pageTitle = 'Career Details';

// Fetch Career Data
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
</head>

<body class="bg-gray-100 font-body">
    <div class="flex h-screen">
        <?php include('sidebar.php') ?>
        <main class="flex-1 h-full overflow-y-auto">
            <?php include('top.php') ?>
            <div class="p-4 md:p-8 mb-32 md:mb-0">

                <div class="flex justify-between items-center mb-8" data-aos="fade-down">
                    <div>
                        <h1 class="text-3xl font-bold font-heading text-gray-800">Job Preview</h1>
                        <p class="text-sm text-gray-500">Detailed view of the career opening</p>
                    </div>
                    <div class="flex gap-3">
                        <a href="careers.php"
                            class="bg-gray-600 text-white px-4 py-2 rounded shadow flex items-center gap-2 hover:bg-gray-700 transition-all text-sm font-bold uppercase tracking-wider">
                            <i class="fa-solid fa-arrow-left"></i> Back
                        </a>
                        <a href="edit-career.php?id=<?php echo $career['id']; ?>"
                            class="bg-primary-start text-white px-4 py-2 rounded shadow flex items-center gap-2 hover:bg-primary-end transition-all text-sm font-bold uppercase tracking-wider">
                            <i class="fa-solid fa-pencil-alt text-xs"></i> Edit Job
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                    <div class="lg:col-span-2 space-y-8" data-aos="fade-right">

                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                            <div class="flex flex-wrap gap-2 mb-4">
                                <span
                                    class="bg-green-100 text-green-600 text-[10px] font-bold px-3 py-1 rounded-full border border-green-200 uppercase tracking-widest"><?php echo htmlspecialchars($career['c_job_type']); ?></span>
                                <span
                                    class="bg-blue-100 text-blue-600 text-[10px] font-bold px-3 py-1 rounded-full border border-blue-200 uppercase tracking-widest"><?php echo htmlspecialchars($career['c_location']); ?></span>
                            </div>
                            <h2 class="text-3xl font-bold text-gray-800 mb-6 font-heading">
                                <?php echo htmlspecialchars($career['c_title']); ?></h2>

                            <div class="prose prose-sm max-w-none text-gray-600 leading-relaxed font-body mb-8">
                                <h4 class="text-lg font-bold text-gray-800 mb-3 border-b pb-2 flex items-center gap-2">
                                    <i class="fa-solid fa-file-lines text-primary-start"></i> Job Description
                                </h4>
                                <div class="ck-content">
                                    <?php echo $career['c_description']; ?>
                                </div>
                            </div>

                            <div class="prose prose-sm max-w-none text-gray-600 leading-relaxed font-body mb-8">
                                <h4 class="text-lg font-bold text-gray-800 mb-3 border-b pb-2 flex items-center gap-2">
                                    <i class="fa-solid fa-clipboard-check text-primary-start"></i> Key Responsibilities
                                </h4>
                                <div class="ck-content">
                                    <?php echo $career['c_responsibilties']; ?>
                                </div>
                            </div>

                            <div class="prose prose-sm max-w-none text-gray-600 leading-relaxed font-body">
                                <h4 class="text-lg font-bold text-gray-800 mb-3 border-b pb-2 flex items-center gap-2">
                                    <i class="fa-solid fa-graduation-cap text-primary-start"></i> Requirements
                                </h4>
                                <div class="ck-content">
                                    <?php echo $career['c_requirements']; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-1 space-y-6" data-aos="fade-left">
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-8">
                            <h3 class="font-heading font-bold text-gray-800 mb-6 flex items-center gap-2 border-b pb-4">
                                <i class="fa-solid fa-circle-info text-blue-500"></i> Job Summary
                            </h3>

                            <ul class="space-y-6">
                                <li class="flex items-start gap-4">
                                    <div
                                        class="h-10 w-10 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400">
                                        <i class="fa-solid fa-location-dot"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Location</p>
                                        <p class="text-sm text-gray-700 font-semibold">
                                            <?php echo htmlspecialchars($career['c_location']); ?></p>
                                    </div>
                                </li>
                                <li class="flex items-start gap-4">
                                    <div
                                        class="h-10 w-10 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400">
                                        <i class="fa-solid fa-briefcase"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Job Type</p>
                                        <p class="text-sm text-gray-700 font-semibold">
                                            <?php echo htmlspecialchars($career['c_job_type']); ?></p>
                                    </div>
                                </li>
                                <li class="flex items-start gap-4">
                                    <div
                                        class="h-10 w-10 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400">
                                        <i class="fa-solid fa-money-bill-wave"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Salary</p>
                                        <p class="text-sm text-gray-700 font-semibold">
                                            <?php echo !empty($career['c_salary']) ? htmlspecialchars($career['c_salary']) : 'Negotiable'; ?>
                                        </p>
                                    </div>
                                </li>
                                <li class="flex items-start gap-4">
                                    <div
                                        class="h-10 w-10 rounded-lg bg-gray-50 flex items-center justify-center text-gray-400">
                                        <i class="fa-solid fa-calendar-day"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 font-bold uppercase tracking-wider">Posted Date
                                        </p>
                                        <p class="text-sm text-gray-700 font-semibold">
                                            <?php echo date('M d, Y', strtotime($career['created_at'])); ?></p>
                                    </div>
                                </li>
                            </ul>

                            <hr class="my-6 border-gray-50">

                            <div class="bg-primary-start/5 p-4 rounded-xl border border-primary-start/10">
                                <p class="text-xs text-primary-start font-body leading-relaxed">
                                    <i class="fa-solid fa-lightbulb mr-1"></i> This job post is currently
                                    <strong>Live</strong> on your website career page.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </main>
    </div>

    <?php include('bottom.php') ?>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="main.js"></script>
</body>

</html>