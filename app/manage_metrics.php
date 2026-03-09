<?php
include('db.php'); // ডেটাবেস কানেকশন

// সেশন চেক
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}
$pageTitle = 'Manage Site Metrics';

// --- site_stats টেবিল থেকে ডাটা ফেচ করা ---
$stats_query = $mysqli->query("SELECT * FROM site_stats WHERE id = 1 LIMIT 1");
$current_data = ($stats_query && $stats_query->num_rows > 0) ? $stats_query->fetch_assoc() : [];

$energy = $current_data['energy_reduction'] ?? 0;
$leed = $current_data['leed_projects'] ?? 0;
$net_zero = $current_data['net_zero_buildings'] ?? 0;
$carbon = $current_data['carbon_committed'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php') ?>
    <title>Manage Site Metrics - Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
</head>

<body class="bg-gray-100 font-body">
    <div class="flex h-screen">

        <?php include('sidebar.php') ?>

        <main class="flex-1 h-full overflow-y-auto">

            <?php include('top.php') ?>
            
            <?php
            // সেশন মেসেজ (SweetAlert)
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
            
            <div class="p-8 mb-32 md:mb-0 ">

                <div class="flex justify-between items-center mb-6" data-aos="fade-down">
                    <h1 class="text-3xl font-bold font-heading text-gray-800">
                        Manage Site Metrics
                    </h1>
                </div>

                <div class="border-card bg-white rounded-xl shadow-lg p-6 md:p-8 mb-8" data-aos="fade-up">
                    <h2 class="text-xl font-bold font-heading text-gray-800 border-b pb-3 mb-6 flex items-center">
                        <i class="fa-solid fa-chart-line mr-2 text-primary-start"></i> Statistics Information
                    </h2>
                    
                    <form action="logics.php" method="POST">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 font-body">
                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-2 uppercase tracking-wider">Avg. Energy Reduction (%)</label>
                                <div class="relative">
                                    <input type="number" name="energy_reduction" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end font-body" value="<?php echo htmlspecialchars($energy); ?>" >
                                    <span class="absolute right-3 top-2 text-gray-400">%</span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-2 uppercase tracking-wider">LEED Certified Projects</label>
                                <input type="number" name="leed_projects" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end font-body" value="<?php echo htmlspecialchars($leed); ?>" >
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-2 uppercase tracking-wider">Net Zero Buildings</label>
                                <input type="number" name="net_zero_buildings" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end font-body" value="<?php echo htmlspecialchars($net_zero); ?>" >
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-500 mb-2 uppercase tracking-wider">Carbon Committed (%)</label>
                                <div class="relative">
                                    <input type="number" name="carbon_committed" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end font-body" value="<?php echo htmlspecialchars($carbon); ?>" >
                                    <span class="absolute right-3 top-2 text-gray-400">%</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-right mt-8 border-t pt-6">
                            <button type="submit" name="update_site_metrics" class="font-nav bg-primary-start text-white px-8 py-3 rounded-lg shadow-md hover:bg-primary-end transition-all font-bold uppercase tracking-widest text-xs">
                                <i class="fa-solid fa-save mr-2"></i> Update Statistics
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
</body>
</html>