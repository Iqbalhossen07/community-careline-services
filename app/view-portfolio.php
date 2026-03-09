<?php
include('db.php'); // ডেটাবেস কানেকশন

// সেশন চেক
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}
$pageTitle = 'View Portfolio Details';
$upload_folder = 'uploads/portfolio_images/';

// --- ধাপ ১: URL থেকে ID নেওয়া ---
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: portfolios.php');
    exit();
}

$id = $_GET['id'];

// --- ধাপ ২: ডেটাবেস থেকে ডেটা আনা ---
$stmt = $mysqli->prepare("SELECT * FROM portfolios WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$item = $result->fetch_assoc();

if (!$item) {
    header('Location: portfolios.php');
    exit();
}
$stmt->close();

// --- ধাপ ৩: ইমেজ প্রসেসিং ---
$main_image = (!empty($item['image'])) ? $upload_folder . $item['image'] : '';
$challenge_imgs = !empty($item['challenge_image']) ? explode(',', $item['challenge_image']) : [];
$solution_imgs  = !empty($item['solution_image']) ? explode(',', $item['solution_image']) : [];
$outcome_imgs   = !empty($item['outcome_image']) ? explode(',', $item['outcome_image']) : [];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php') ?>
    <title>View Project - Admin Dashboard</title>
    <style>
        .prose h1 { font-size: 1.5rem; font-weight: bold; margin-bottom: 0.5rem; font-family: 'Archivo Black', sans-serif; }
        .prose h2 { font-size: 1.25rem; font-weight: bold; margin-bottom: 0.5rem; font-family: 'Archivo Black', sans-serif; }
        .prose p { margin-bottom: 1rem; line-height: 1.7; font-family: 'Space Grotesk', sans-serif; }
        .gallery-img:hover { transform: scale(1.02); }
    </style>
</head>

<body class="bg-gray-100 font-body"> <div class="flex h-screen">

        <?php include('sidebar.php') ?>

        <main class="flex-1 h-full overflow-y-auto" data-aos="fade-down">

            <?php include('top.php') ?>
            
            <div class="p-8 mb-32 md:mb-0">

                <div class="flex justify-between items-center mb-8">
                    <div>
                        <p class="font-body text-sm text-gray-500 font-bold uppercase tracking-widest mb-1">Project Details</p>
                        <h1 class="text-3xl font-bold font-heading text-gray-800">
                            <?php echo htmlspecialchars($item['name']); ?>
                        </h1>
                    </div>
                    
                    <div class="flex gap-3">
                        <a href="edit-portfolio.php?id=<?php echo $item['id']; ?>" class="font-nav flex items-center bg-primary-start text-white px-4 py-2 rounded-lg shadow-md hover:bg-primary-end transition-colors duration-300 font-bold uppercase tracking-wider text-xs">
                            <i class="fa-solid fa-pencil-alt mr-2"></i> Edit
                        </a>
                        <a href="portfolio.php" class="font-nav flex items-center bg-gray-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-gray-700 transition-colors duration-300 font-bold uppercase tracking-wider text-xs">
                            <i class="fa-solid fa-arrow-left mr-2"></i> Back
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-8">
                    <div class="flex flex-col lg:flex-row">
                        <div class="lg:w-2/3 h-64 lg:h-96 bg-gray-200 relative group cursor-pointer" onclick="openModal('<?php echo $main_image; ?>')">
                            <?php if($main_image): ?>
                                <img src="<?php echo $main_image; ?>" class="w-full h-full object-cover transition duration-500 group-hover:opacity-90">
                                <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                                    <span class="font-nav bg-black/50 text-white px-4 py-2 rounded-full text-xs uppercase tracking-widest backdrop-blur-sm"><i class="fa-solid fa-expand mr-2"></i>View Fullscreen</span>
                                </div>
                            <?php else: ?>
                                <div class="font-body flex items-center justify-center h-full text-gray-400">No Image Available</div>
                            <?php endif; ?>
                        </div>

                        <div class="lg:w-1/3 p-8 border-l border-gray-100 flex flex-col justify-center bg-gray-50/50 font-body">
                            <div class="space-y-6">
                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Project Name</label>
                                    <h2 class="text-2xl font-bold text-gray-800 font-heading"><?php echo htmlspecialchars($item['name']); ?></h2>
                                </div>
                                
                                <div class="flex gap-6">
                                    <div>
                                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Typology</label>
                                        <p class="text-lg font-bold text-green-600"><?php echo htmlspecialchars($item['typology']); ?></p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Year</label>
                                        <p class="text-lg font-bold text-blue-600"><?php echo htmlspecialchars($item['year']); ?></p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Location</label>
                                        <p class="text-lg font-bold text-purple-600"><?php echo htmlspecialchars($item['country']); ?></p>
                                    </div>
                                  
                                </div>

                                <div class="flex gap-6">
                                      <div>
                                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Project Type</label>
                                        <p class="text-lg font-bold text-sky-600"><?php echo htmlspecialchars($item['type']); ?></p>
                                    </div>
                                    <div>
                                        <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Gross Cost</label>
                                        <p class="text-lg font-bold text-red-600"><?php echo htmlspecialchars($item['gross_cost']); ?></p>
                                    </div>

                                </div>

                                <div>
                                    <label class="text-xs font-bold text-gray-400 uppercase tracking-widest">Overview</label>
                                    <p class="text-gray-600 text-sm leading-relaxed mt-1">
                                        <?php echo nl2br(htmlspecialchars($item['short_description'])); ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <?php if(!empty($item['challenge_des']) || !empty($challenge_imgs)): ?>
                <div class="bg-white rounded-xl shadow-lg p-8 mb-8 border-t-4 border-red-400">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="font-body bg-red-100 text-red-600 font-bold w-10 h-10 rounded-full flex items-center justify-center">01</span>
                        <h2 class="text-2xl font-bold text-gray-800 font-heading">The Challenge</h2>
                    </div>
                    
                    <div class="font-body prose max-w-none text-gray-700 mb-8 leading-relaxed">
                        <?php echo $item['challenge_des']; ?>
                    </div>

                    <?php if(!empty($challenge_imgs)): ?>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <?php foreach($challenge_imgs as $img): ?>
                                <div class="h-40 rounded-lg overflow-hidden cursor-pointer shadow-sm" onclick="openModal('<?php echo $upload_folder.$img; ?>')">
                                    <img src="<?php echo $upload_folder.$img; ?>" class="w-full h-full object-cover gallery-img transition duration-300">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>


                <?php if(!empty($item['solution_des']) || !empty($solution_imgs)): ?>
                <div class="bg-white rounded-xl shadow-lg p-8 mb-8 border-t-4 border-green-400">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="font-body bg-green-100 text-green-600 font-bold w-10 h-10 rounded-full flex items-center justify-center">02</span>
                        <h2 class="text-2xl font-bold text-gray-800 font-heading">The Solution</h2>
                    </div>
                    
                    <div class="font-body prose max-w-none text-gray-700 mb-8 leading-relaxed">
                        <?php echo $item['solution_des']; ?>
                    </div>

                    <?php if(!empty($solution_imgs)): ?>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <?php foreach($solution_imgs as $img): ?>
                                <div class="h-40 rounded-lg overflow-hidden cursor-pointer shadow-sm" onclick="openModal('<?php echo $upload_folder.$img; ?>')">
                                    <img src="<?php echo $upload_folder.$img; ?>" class="w-full h-full object-cover gallery-img transition duration-300">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>


                <?php if(!empty($item['outcome_des']) || !empty($outcome_imgs)): ?>
                <div class="bg-white rounded-xl shadow-lg p-8 mb-8 border-t-4 border-purple-400">
                    <div class="flex items-center gap-3 mb-6">
                        <span class="font-body bg-purple-100 text-purple-600 font-bold w-10 h-10 rounded-full flex items-center justify-center">03</span>
                        <h2 class="text-2xl font-bold text-gray-800 font-heading">The Outcome</h2>
                    </div>
                    
                    <div class="font-body prose max-w-none text-gray-700 mb-8 leading-relaxed">
                        <?php echo $item['outcome_des']; ?>
                    </div>

                    <?php if(!empty($outcome_imgs)): ?>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <?php foreach($outcome_imgs as $img): ?>
                                <div class="h-40 rounded-lg overflow-hidden cursor-pointer shadow-sm" onclick="openModal('<?php echo $upload_folder.$img; ?>')">
                                    <img src="<?php echo $upload_folder.$img; ?>" class="w-full h-full object-cover gallery-img transition duration-300">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

            </div>
        </main>
    </div>

    <div id="imageModal" class="fixed inset-0 z-50 hidden bg-black/90 backdrop-blur-sm flex items-center justify-center p-4">
        <button onclick="closeModal()" class="absolute top-5 right-5 text-white text-4xl hover:text-red-500 transition">&times;</button>
        <img id="modalImage" src="" class="max-w-full max-h-[90vh] rounded-lg shadow-2xl">
    </div>

    <?php include('bottom.php') ?>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="main.js"></script>

    <script>
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');

        function openModal(imageSrc) {
            modalImg.src = imageSrc;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden'; 
        }

        function closeModal() {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        modal.addEventListener('click', function(e) {
            if (e.target === modal) closeModal();
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === "Escape") closeModal();
        });
    </script>
</body>
</html>