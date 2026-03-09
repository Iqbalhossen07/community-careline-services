<?php
include('db.php');
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}
$pageTitle = 'Manage Careers';

// Fetch Careers
$careers = [];
$result = $mysqli->query("SELECT * FROM careers ORDER BY id DESC");
if ($result) {
    $careers = $result->fetch_all(MYSQLI_ASSOC);
}

// ফিল্টারের জন্য ইউনিক ডাটা বের করা
$types_query = $mysqli->query("SELECT DISTINCT c_job_type FROM careers WHERE c_job_type != ''");
$locations_query = $mysqli->query("SELECT DISTINCT c_location FROM careers WHERE c_location != ''");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php') ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <style>
    .hidden-card {
        display: none !important;
    }

    .career-card {
        transition: all 0.3s ease;
    }
    </style>
</head>

<body class="bg-gray-100 font-body text-gray-800">
    <div class="flex h-screen">
        <?php include('sidebar.php') ?>
        <main class="flex-1 h-full overflow-y-auto">
            <?php include('top.php') ?>

            <div class="p-4 md:p-8 mb-32 md:mb-0" data-aos="fade-up">

                <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div>
                        <h1 class="text-3xl font-bold font-heading text-gray-800">Careers</h1>
                        <p class="text-sm text-gray-500 font-body">Manage job openings and opportunities</p>
                    </div>
                    <a href="add-career.php"
                        class="bg-primary-start text-white px-6 py-2.5 rounded-lg shadow-md hover:bg-primary-end transition-all font-bold uppercase tracking-wider text-xs flex items-center justify-center">
                        <i class="fa-solid fa-plus mr-2"></i> Add New Career
                    </a>
                </div>

                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 mb-8">
                    <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                        <div class="flex flex-col sm:flex-row items-center gap-4 w-full lg:w-auto">
                            <div class="relative w-full sm:w-64">
                                <select id="typeFilter"
                                    class="appearance-none w-full bg-gray-50 border border-gray-200 text-gray-700 py-2.5 px-4 pr-10 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-start text-sm cursor-pointer">
                                    <option value="all">All Job Types</option>
                                    <?php while ($t = $types_query->fetch_assoc()): ?>
                                    <option value="<?php echo htmlspecialchars($t['c_job_type']); ?>">
                                        <?php echo htmlspecialchars($t['c_job_type']); ?></option>
                                    <?php endwhile; ?>
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </div>
                            </div>

                            <div class="relative w-full sm:w-64">
                                <select id="locationFilter"
                                    class="appearance-none w-full bg-gray-50 border border-gray-200 text-gray-700 py-2.5 px-4 pr-10 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-start text-sm cursor-pointer">
                                    <option value="all">All Locations</option>
                                    <?php while ($l = $locations_query->fetch_assoc()): ?>
                                    <option value="<?php echo htmlspecialchars($l['c_location']); ?>">
                                        <?php echo htmlspecialchars($l['c_location']); ?></option>
                                    <?php endwhile; ?>
                                </select>
                                <div
                                    class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-gray-400">
                                    <i class="fa-solid fa-chevron-down text-xs"></i>
                                </div>
                            </div>

                            <button id="resetBtn"
                                class="flex items-center gap-2 text-primary-start hover:text-primary-end font-bold text-sm transition-colors px-2">
                                <i class="fa-solid fa-rotate-left"></i> Reset Filters
                            </button>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6" id="careersGrid">
                    <?php if (!empty($careers)) : ?>
                    <?php foreach ($careers as $job) : ?>
                    <div class="career-card bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col hover:shadow-md transition-all duration-300"
                        data-type="<?php echo htmlspecialchars($job['c_job_type']); ?>"
                        data-location="<?php echo htmlspecialchars($job['c_location']); ?>">

                        <div class="flex flex-wrap gap-2 mb-4">
                            <span
                                class="bg-green-50 text-green-600 text-[10px] font-bold px-3 py-1 rounded-full border border-green-100 uppercase tracking-widest">
                                <?php echo htmlspecialchars($job['c_job_type']); ?>
                            </span>
                            <span
                                class="bg-blue-50 text-blue-600 text-[10px] font-bold px-3 py-1 rounded-full border border-blue-100 uppercase tracking-widest">
                                <?php echo htmlspecialchars($job['c_location']); ?>
                            </span>
                        </div>

                        <h3 class="text-xl font-bold text-gray-800 mb-3 font-heading">
                            <?php echo htmlspecialchars($job['c_title']); ?>
                        </h3>

                        <p class="text-gray-500 text-sm mb-6 line-clamp-2 leading-relaxed font-body">
                            <?php echo strip_tags($job['c_description']); ?>
                        </p>

                        <div class="flex items-center justify-end mt-auto pt-5 border-t border-gray-50">
                            <div class="flex space-x-3">
                                <a href="view-career.php?id=<?php echo $job['id']; ?>"
                                    class="h-9 w-9 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shadow-sm hover:shadow-lg hover:bg-blue-200 transition-all"
                                    title="View Details">
                                    <i class="fas fa-eye text-sm"></i>
                                </a>

                                <a href="edit-career.php?id=<?php echo $job['id']; ?>"
                                    class="h-9 w-9 rounded-full bg-green-100 text-green-600 flex items-center justify-center shadow-sm hover:shadow-lg hover:bg-green-200 transition-all"
                                    title="Edit">
                                    <i class="fas fa-pencil-alt text-sm"></i>
                                </a>

                                <button data-id="<?php echo $job['id']; ?>"
                                    class="delete-btn h-9 w-9 rounded-full bg-red-100 text-red-600 flex items-center justify-center shadow-sm hover:shadow-lg hover:bg-red-200 transition-all"
                                    title="Delete">
                                    <i class="fas fa-trash-alt text-sm"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                    <?php else : ?>
                    <div class="col-span-full text-center py-20">
                        <i class="fa-solid fa-folder-open text-6xl text-gray-200 mb-4"></i>
                        <p class="text-gray-400 font-body">No careers available. Start by adding one!</p>
                    </div>
                    <?php endif; ?>
                </div>

                <div id="noResults"
                    class="hidden col-span-full text-center py-20 bg-white rounded-xl border border-dashed">
                    <i class="fa-solid fa-magnifying-glass text-5xl text-gray-200 mb-4"></i>
                    <p class="text-gray-400">No jobs match your selected filters.</p>
                </div>

            </div>
        </main>
    </div>

    <?php include('bottom.php') ?>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="main.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeFilter = document.getElementById('typeFilter');
        const locationFilter = document.getElementById('locationFilter');
        const resetBtn = document.getElementById('resetBtn');
        const cards = document.querySelectorAll('.career-card');
        const noResults = document.getElementById('noResults');

        function filterJobs() {
            const type = typeFilter.value;
            const loc = locationFilter.value;
            let count = 0;

            cards.forEach(card => {
                const cardType = card.getAttribute('data-type');
                const cardLoc = card.getAttribute('data-location');

                const typeMatch = (type === 'all' || cardType === type);
                const locMatch = (loc === 'all' || cardLoc === loc);

                if (typeMatch && locMatch) {
                    card.classList.remove('hidden-card');
                    count++;
                } else {
                    card.classList.add('hidden-card');
                }
            });

            noResults.classList.toggle('hidden', count > 0);
        }

        typeFilter.addEventListener('change', filterJobs);
        locationFilter.addEventListener('change', filterJobs);

        resetBtn.addEventListener('click', function() {
            typeFilter.value = 'all';
            locationFilter.value = 'all';
            filterJobs();
        });

        // Delete Logic
        document.querySelectorAll('.delete-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                Swal.fire({
                    title: 'Are you sure?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#eb380b',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) window.location.href =
                        'logics.php?delete_career_id=' + id;
                });
            });
        });
    });
    </script>
</body>

</html>