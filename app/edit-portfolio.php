<?php
include('db.php'); // ডেটাবেস কানেকশন

// সেশন চেক
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

$pageTitle = 'Edit Portfolio Item';

// --- ধাপ ১: URL থেকে ID এবং ডেটা আনা ---
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: portfolios.php');
    exit();
}

$id = $_GET['id'];
$stmt = $mysqli->prepare("SELECT * FROM portfolios WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$item = $result->fetch_assoc();

if (!$item) {
    header('Location: portfolios.php');
    exit();
}

// --- ইমেজ স্ট্রিং থেকে অ্যারে কনভার্সন ---
$challenge_imgs = !empty($item['challenge_image']) ? explode(',', $item['challenge_image']) : [];
$solution_imgs  = !empty($item['solution_image']) ? explode(',', $item['solution_image']) : [];
$outcome_imgs   = !empty($item['outcome_image']) ? explode(',', $item['outcome_image']) : [];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php') ?>
    <title>Edit Portfolio - Admin Dashboard</title>
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <style>
        .file-upload-box {
            transition: all 0.3s ease;
            background-color: #f9fafb;
        }
        .file-upload-box:hover {
            background-color: #ffffff;
            border-color: #44afe4; 
        }
        .img-card:hover .delete-overlay { opacity: 1; }
    </style>
</head>

<body class="bg-gray-100 font-body"> <div class="flex h-screen">

        <?php include('sidebar.php') ?>

        <main class="flex-1 h-full overflow-y-auto" data-aos="fade-down">

            <?php include('top.php') ?>

            <div class="p-8 mb-32 md:mb-0">

                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-3xl font-bold font-heading text-gray-800">
                        Edit Portfolio Item
                    </h1>
                    <a href="portfolio.php" class="font-nav flex items-center bg-gray-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-gray-700 transition-colors duration-300 font-semibold uppercase tracking-wider text-xs">
                        <i class="fa-solid fa-arrow-left mr-2"></i>
                        <span>Back to Portfolio</span>
                    </a>
                </div>

                <form action="logics.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                    
                    <input type="hidden" name="old_main_image" value="<?php echo htmlspecialchars($item['image']); ?>">
                    <input type="hidden" name="old_challenge_images" id="old_challenge_input" value="<?php echo htmlspecialchars($item['challenge_image']); ?>">
                    <input type="hidden" name="old_solution_images" id="old_solution_input" value="<?php echo htmlspecialchars($item['solution_image']); ?>">
                    <input type="hidden" name="old_outcome_images" id="old_outcome_input" value="<?php echo htmlspecialchars($item['outcome_image']); ?>">

                    <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 mb-8" >
                        <h2 class="font-heading text-xl font-bold text-gray-800 mb-4 border-b pb-2 flex items-center">
                            <span class="bg-blue-100 text-blue-600 w-8 h-8 rounded-full flex items-center justify-center mr-3 text-sm">01</span>
                            Basic Information
                        </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 font-body">
                            
                            <div class="md:col-span-2 space-y-4">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Portfolio Name</label>
                                    <input type="text" name="name" value="<?php echo htmlspecialchars($item['name']); ?>" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-primary-end focus:border-transparent" required>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                       <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Typology</label>
                                        <input type="text" name="typology" value="<?php echo htmlspecialchars($item['typology']); ?>" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Year</label>
                                        <input type="text" name="year" value="<?php echo htmlspecialchars($item['year']); ?>" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-primary-end focus:border-transparent">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Country</label>
                                        <input type="text" name="country" value="<?php echo htmlspecialchars($item['country']); ?>" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-primary-end focus:border-transparent">
                                    </div>
                                </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Project Type</label>
                                        <select name="type" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end focus:border-transparent bg-white" required>
                                            <option value="<?php echo ($item['type']); ?>"><?php echo ($item['type']); ?></option>
                                            <option value="Commercial">Commercial</option>
                                            <option value="Residential">Residential</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-semibold text-gray-700 mb-1">Gross Cost</label>
                                        <input type="text" name="gross_cost" value="<?php echo ($item['gross_cost']); ?>" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end focus:border-transparent" placeholder="Type gross cost">
                                    </div>

                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-1">Short Description</label>
                                    <textarea name="short_description" rows="3" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring-2 focus:ring-primary-end focus:border-transparent"><?php echo htmlspecialchars($item['short_description']); ?></textarea>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Main Thumbnail</label>
                                <label for="main-image-upload" class="file-upload-box h-full min-h-[200px] flex flex-col justify-center items-center px-4 py-6 border-2 border-dashed border-primary-end rounded-lg cursor-pointer">
                                    <img id="main-preview" src="uploads/portfolio_images/<?php echo $item['image']; ?>" class="w-full h-40 object-cover rounded-lg mb-2 shadow-sm" />
                                    <div class="text-center mt-2 font-body">
                                        <p class="text-sm text-primary-start font-medium">Click to Change</p>
                                    </div>
                                    <input id="main-image-upload" name="image" type="file" class="sr-only" onchange="previewSingleImage(event, 'main-preview')">
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 mb-8" >
                        <h2 class="font-heading text-xl font-bold text-gray-800 mb-4 border-b pb-2 flex items-center">
                            <span class="bg-red-100 text-red-600 w-8 h-8 rounded-full flex items-center justify-center mr-3 text-sm">02</span>
                            The Challenge
                        </h2>

                        <div class="grid grid-cols-1 gap-6 font-body">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Challenge Description</label>
                                <textarea name="challenge_des" id="textarea-description3"><?php echo $item['challenge_des']; ?></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2 uppercase tracking-widest text-xs">Manage Challenge Images</label>
                                
                                <?php if(!empty($challenge_imgs)): ?>
                                    <div class="grid grid-cols-2 md:grid-cols-6 gap-4 mb-4">
                                        <?php foreach($challenge_imgs as $img): $uId = 'chal_'.md5($img); ?>
                                            <div id="<?php echo $uId; ?>" class="relative group img-card bg-gray-50 border rounded-lg p-1">
                                                <img src="uploads/portfolio_images/<?php echo $img; ?>" class="w-full h-24 object-cover rounded">
                                                <button type="button" onclick="removeImage('<?php echo $img; ?>', '<?php echo $uId; ?>', 'old_challenge_input')" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center shadow-lg hover:bg-red-600 transition">
                                                    <i class="fa-solid fa-times text-xs"></i>
                                                </button>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <label for="challenge-upload" class="file-upload-box w-full flex flex-col justify-center items-center px-6 py-6 border-2 border-dashed border-primary-end rounded-lg cursor-pointer">
                                    <div id="chal-new-preview" class="hidden grid grid-cols-4 gap-4 w-full mb-2"></div>
                                    <div id="chal-placeholder" class="text-center font-body">
                                        <i class="fa-regular fa-images text-3xl text-gray-400 mb-1"></i>
                                        <p class="text-sm text-gray-600">Add New Images (Multiple)</p>
                                    </div>
                                    <input id="challenge-upload" name="challenge_images[]" type="file" class="sr-only" multiple onchange="previewNewImages(event, 'chal-new-preview', 'chal-placeholder')">
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 mb-8" >
                        <h2 class="font-heading text-xl font-bold text-gray-800 mb-4 border-b pb-2 flex items-center">
                            <span class="bg-green-100 text-green-600 w-8 h-8 rounded-full flex items-center justify-center mr-3 text-sm">03</span>
                            The Solution
                        </h2>

                        <div class="grid grid-cols-1 gap-6 font-body">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Solution Description</label>
                                <textarea name="solution_des" id="textarea-description2"><?php echo $item['solution_des']; ?></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2 uppercase tracking-widest text-xs">Manage Solution Images</label>
                                
                                <?php if(!empty($solution_imgs)): ?>
                                    <div class="grid grid-cols-2 md:grid-cols-6 gap-4 mb-4">
                                        <?php foreach($solution_imgs as $img): $uId = 'sol_'.md5($img); ?>
                                            <div id="<?php echo $uId; ?>" class="relative group img-card bg-gray-50 border rounded-lg p-1">
                                                <img src="uploads/portfolio_images/<?php echo $img; ?>" class="w-full h-24 object-cover rounded">
                                                <button type="button" onclick="removeImage('<?php echo $img; ?>', '<?php echo $uId; ?>', 'old_solution_input')" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center shadow-lg hover:bg-red-600 transition">
                                                    <i class="fa-solid fa-times text-xs"></i>
                                                </button>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <label for="solution-upload" class="file-upload-box w-full flex flex-col justify-center items-center px-6 py-6 border-2 border-dashed border-primary-end rounded-lg cursor-pointer">
                                    <div id="sol-new-preview" class="hidden grid grid-cols-4 gap-4 w-full mb-2"></div>
                                    <div id="sol-placeholder" class="text-center font-body">
                                        <i class="fa-solid fa-lightbulb text-3xl text-yellow-400 mb-1"></i>
                                        <p class="text-sm text-gray-600">Add New Images (Multiple)</p>
                                    </div>
                                    <input id="solution-upload" name="solution_images[]" type="file" class="sr-only" multiple onchange="previewNewImages(event, 'sol-new-preview', 'sol-placeholder')">
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-lg p-6 md:p-8 mb-8" >
                        <h2 class="font-heading text-xl font-bold text-gray-800 mb-4 border-b pb-2 flex items-center">
                            <span class="bg-purple-100 text-purple-600 w-8 h-8 rounded-full flex items-center justify-center mr-3 text-sm">04</span>
                            The Outcome
                        </h2>

                        <div class="grid grid-cols-1 gap-6 font-body">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1">Outcome Description</label>
                                <textarea name="outcome_des" id="textarea-description1"><?php echo $item['outcome_des']; ?></textarea>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2 uppercase tracking-widest text-xs">Manage Outcome Images</label>
                                
                                <?php if(!empty($outcome_imgs)): ?>
                                    <div class="grid grid-cols-2 md:grid-cols-6 gap-4 mb-4">
                                        <?php foreach($outcome_imgs as $img): $uId = 'out_'.md5($img); ?>
                                            <div id="<?php echo $uId; ?>" class="relative group img-card bg-gray-50 border rounded-lg p-1">
                                                <img src="uploads/portfolio_images/<?php echo $img; ?>" class="w-full h-24 object-cover rounded">
                                                <button type="button" onclick="removeImage('<?php echo $img; ?>', '<?php echo $uId; ?>', 'old_outcome_input')" class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center shadow-lg hover:bg-red-600 transition">
                                                    <i class="fa-solid fa-times text-xs"></i>
                                                </button>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>

                                <label for="outcome-upload" class="file-upload-box w-full flex flex-col justify-center items-center px-6 py-6 border-2 border-dashed border-primary-end rounded-lg cursor-pointer">
                                    <div id="out-new-preview" class="hidden grid grid-cols-4 gap-4 w-full mb-2"></div>
                                    <div id="out-placeholder" class="text-center font-body">
                                        <i class="fa-solid fa-chart-line text-3xl text-gray-400 mb-1"></i>
                                        <p class="text-sm text-gray-600">Add New Images (Multiple)</p>
                                    </div>
                                    <input id="outcome-upload" name="outcome_images[]" type="file" class="sr-only" multiple onchange="previewNewImages(event, 'out-new-preview', 'out-placeholder')">
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="sticky bottom-4 z-10 font-nav">
                        <div class="bg-white/80 backdrop-blur-md border border-gray-200 p-4 rounded-xl shadow-2xl flex justify-between items-center max-w-4xl mx-auto">
                            <span class="font-body text-gray-500 text-sm font-medium">Ready to update?</span>
                            <button type="submit" name="update_portfolio" class="bg-primary-start text-white px-8 py-3 rounded-lg shadow-lg hover:bg-primary-end hover:-translate-y-1 transition-all duration-300 font-bold flex items-center uppercase tracking-widest text-sm">
                                <i class="fa-solid fa-sync mr-2"></i> Update Portfolio Item
                            </button>
                        </div>
                    </div>

                </form>

            </div>
        </main>
    </div>

    <?php include('bottom.php') ?>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="main.js"></script>

    <script>
        // --- CKEditor ---
        // --- CKEditor ---
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

        function previewSingleImage(event, previewId) {
            const preview = document.getElementById(previewId);
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        }

        function removeImage(filename, uniqueId, inputId) {
            const element = document.getElementById(uniqueId);
            if (element) element.remove();

            const input = document.getElementById(inputId);
            let files = input.value.split(',');
            const index = files.indexOf(filename);
            if (index > -1) {
                files.splice(index, 1);
            }
            input.value = files.join(',');
        }

        function previewNewImages(event, containerId, placeholderId) {
            const container = document.getElementById(containerId);
            const placeholder = document.getElementById(placeholderId);
            const files = event.target.files;

            container.innerHTML = ''; 

            if (files.length > 0) {
                placeholder.classList.add('hidden');
                container.classList.remove('hidden');

                Array.from(files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const div = document.createElement('div');
                        div.className = 'relative w-full h-20 rounded-lg overflow-hidden border border-green-300';
                        div.innerHTML = `
                            <span class="absolute top-0 right-0 bg-green-500 text-white text-[10px] px-1 font-body">NEW</span>
                            <img src="${e.target.result}" class="w-full h-full object-cover">
                        `;
                        container.appendChild(div);
                    }
                    reader.readAsDataURL(file);
                });
            } else {
                container.classList.add('hidden');
                placeholder.classList.remove('hidden');
            }
        }
    </script>
</body>
</html>