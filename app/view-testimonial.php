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
$pageTitle = 'View Testimonial';

// Fetch Testimonial Data
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
</head>

<body class="bg-gray-100 font-body">
    <div class="flex h-screen">
        <?php include('sidebar.php') ?>
        <main class="flex-1 h-full overflow-y-auto">
            <?php include('top.php') ?>
            <div class="p-8 mb-32 md:mb-0">

                <div class="flex justify-between items-center mb-8" data-aos="fade-down">
                    <div>
                        <h1 class="text-3xl font-bold font-heading text-gray-800">Testimonial Details</h1>
                        <p class="text-sm text-gray-500">Preview of client feedback</p>
                    </div>
                    <div class="flex gap-3">
                        <a href="testimonials.php"
                            class="bg-gray-600 text-white px-4 py-2 rounded shadow flex items-center gap-2 hover:bg-gray-700 transition-all text-sm font-bold uppercase tracking-wider">
                            <i class="fa-solid fa-arrow-left"></i> Back
                        </a>
                        <a href="edit-testimonial.php?id=<?php echo $testimonial['id']; ?>"
                            class="bg-primary-start text-white px-4 py-2 rounded shadow flex items-center gap-2 hover:bg-primary-end transition-all text-sm font-bold uppercase tracking-wider">
                            <i class="fa-solid fa-pencil-alt text-xs"></i> Edit
                        </a>
                    </div>
                </div>

                <div class="max-w-4xl mx-auto" data-aos="zoom-in">
                    <div
                        class="bg-white rounded-3xl shadow-xl border border-gray-100 p-10 md:p-16 relative overflow-hidden">

                        <div class="absolute top-10 right-10 opacity-[0.03] pointer-events-none">
                            <i class="fa-solid fa-quote-right text-[200px] text-gray-900"></i>
                        </div>

                        <div class="relative z-10">
                            <div class="mb-8">
                                <i class="fa-solid fa-quote-left text-5xl text-primary-start/20"></i>
                            </div>

                            <div class="text-gray-700 text-xl md:text-2xl italic leading-relaxed font-body mb-10">
                                <?php echo $testimonial['t_des']; ?>
                            </div>

                            <div class="flex items-center gap-4 border-t border-gray-100 pt-8">
                                <div
                                    class="h-14 w-14 rounded-full bg-primary-start/10 flex items-center justify-center text-primary-start">
                                    <i class="fa-solid fa-user text-2xl"></i>
                                </div>
                                <div>
                                    <h4 class="text-xl font-bold text-gray-800 font-heading">
                                        <?php echo htmlspecialchars($testimonial['t_name']); ?>
                                    </h4>
                                    <p class="text-sm text-primary-start font-bold uppercase tracking-widest">
                                        <?php echo htmlspecialchars($testimonial['t_designation']); ?>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div
                            class="mt-12 flex justify-between items-center text-xs text-gray-400 font-body uppercase tracking-tighter border-t border-gray-50 pt-6">
                            <span>ID: #TEST-0<?php echo $testimonial['id']; ?></span>
                            <span>Posted On: <?php echo date('d M, Y', strtotime($testimonial['created_at'])); ?></span>
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