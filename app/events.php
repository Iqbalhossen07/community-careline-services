<?php
include('db.php'); // Database Connection

// Session Check
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}
$pageTitle = 'Manage Events';
$upload_folder = 'uploads/event_images/'; // Folder for event images

// --- Fetch Events from Database ---
$events = [];
$query = "SELECT * FROM events ORDER BY event_date DESC"; // Show newest events first

$result = $mysqli->query($query);

if ($result) {
    $events = $result->fetch_all(MYSQLI_ASSOC);
}

// Get today's date for status comparison
$today_date = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php') ?>
    <title>Manage Events - Admin Dashboard</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        /* Custom hover effect for event cards */
        .event-card {
            border: 2px solid transparent;
            /* Start with a transparent border */
        }

        .event-card:hover {
            border-color: #eb380b;
            /* Tailwind's primary color */
            transform: scale(1.02);
            transition: all 0.3s ease-in-out;
        }
    </style>
</head>

<body class="bg-gray-100 font-merriweather">
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

            <div class="p-8 mb-32 md:mb-0 " data-aos="fade-up">

                <div class="flex flex-col md:flex-row justify-between items-center mb-6 gap-4">
                    <h1 class="text-3xl font-bold font-lora text-gray-800" data-i18n="admin_manage_events">
                        Manage Events
                    </h1>

                    <div class="flex items-center gap-3 w-full md:w-auto">

                        <button id="lang-toggle" class="flex items-center justify-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-all font-semibold text-sm shadow-sm w-full md:w-auto">
                            <i class="fa-solid fa-globe text-primary-start"></i>
                            <span id="lang-btn-text">বাংলা UI</span>
                        </button>

                        <a href="add-event.php" class="flex items-center justify-center bg-primary-start text-white px-4 py-2 rounded-lg shadow-md hover:bg-primary-end transition-colors duration-300 w-full md:w-auto" data-aos="fade-left">
                            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span data-i18n="admin_btn_add_event">Add New Event</span>
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                    <?php if (!empty($events)) : ?>
                        <?php foreach ($events as $index => $event) : ?>
                            <?php
                            // --- English Data ---
                            $snippet_en = strip_tags($event['details']);
                            $snippet_en = (mb_strlen($snippet_en) > 100) ? mb_substr($snippet_en, 0, 100) . '...' : $snippet_en;
                            $venue_en = htmlspecialchars($event['venue']);

                            // English Name Limit (30 chars)
                            $name_en_raw = $event['event_name'];
                            $name_en = (mb_strlen($name_en_raw) > 50) ? mb_substr($name_en_raw, 0, 50) . '...' : $name_en_raw;
                            $name_en = htmlspecialchars($name_en);

                            // --- Bangla Data (Fallback to English if empty) ---
                            // Bangla Name Limit (30 chars)
                            $name_bn_raw = !empty($event['event_name_bn']) ? $event['event_name_bn'] : $event['event_name'];
                            $name_bn = (mb_strlen($name_bn_raw) > 50) ? mb_substr($name_bn_raw, 0, 50) . '...' : $name_bn_raw;

                            $venue_bn = !empty($event['venue_bn']) ? $event['venue_bn'] : $venue_en;

                            $details_bn_raw = !empty($event['details_bn']) ? $event['details_bn'] : $event['details'];
                            $snippet_bn = strip_tags($details_bn_raw);
                            $snippet_bn = (mb_strlen($snippet_bn) > 100) ? mb_substr($snippet_bn, 0, 100) . '...' : $snippet_bn;

                            $image_path = $upload_folder . htmlspecialchars($event['image']);

                            // Status Logic
                            if ($event['event_date'] >= $today_date) {
                                $status_color = 'blue';
                                $status_text_en = 'Upcoming';
                                $status_text_bn = 'আসন্ন';
                            } else {
                                $status_color = 'gray';
                                $status_text_en = 'Past';
                                $status_text_bn = 'অতীত';
                            }
                            ?>
                            <div class="event-card bg-white rounded-xl shadow-lg p-5 flex flex-col sm:flex-row items-center space-y-4 sm:space-y-0 sm:space-x-6 border border-gray-200">

                                <img src="<?php echo $image_path; ?>" alt="<?php echo $name_en; ?>" class="w-full sm:w-32 h-40 sm:h-24 rounded-lg object-cover">

                                <div class="flex-1 text-center sm:text-left">
                                    <h3 class="text-xl font-bold font-lora text-gray-900 lang-en-content">
                                        <?php echo $name_en; ?>
                                    </h3>
                                    <h3 class="text-xl font-bold font-lora text-gray-900 lang-bn-content hidden">
                                        <?php echo ($name_bn); ?>
                                    </h3>

                                    <p class="text-sm text-gray-500 flex items-center justify-center sm:justify-start my-1">
                                        <svg class="w-4 h-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                                        </svg>
                                        <span class="lang-en-content"><?php echo $venue_en; ?></span>
                                        <span class="lang-bn-content hidden"><?php echo ($venue_bn); ?></span>
                                    </p>

                                    <p class="text-sm text-gray-600 mt-2 lang-en-content">
                                        <?php echo $snippet_en; ?>
                                    </p>
                                    <p class="text-sm text-gray-600 mt-2 lang-bn-content hidden">
                                        <?php echo ($snippet_bn); ?>
                                    </p>
                                </div>

                                <div class="flex flex-col items-center justify-center space-y-3 sm:pl-4">

                                    <span class="text-xs font-semibold bg-<?php echo $status_color; ?>-100 text-<?php echo $status_color; ?>-700 px-3 py-1 rounded-full">
                                        <span class="lang-en-content"><?php echo $status_text_en; ?></span>
                                        <span class="lang-bn-content hidden"><?php echo $status_text_bn; ?></span>
                                        (<?php echo date('M j', strtotime($event['event_date'])); ?>)
                                    </span>

                                    <div class="flex space-x-3">
                                        <a href="view-event.php?id=<?php echo $event['id']; ?>" class="h-8 w-8 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center shadow-md hover:shadow-lg hover:bg-blue-200 hover:-translate-y-0.5 transition-all duration-300" title="View">
                                            <i class="fas fa-eye text-sm"></i>
                                        </a>
                                        <a href="edit-event.php?id=<?php echo $event['id']; ?>" class="h-8 w-8 rounded-full bg-green-100 text-green-600 flex items-center justify-center shadow-md hover:shadow-lg hover:bg-green-200 hover:-translate-y-0.5 transition-all duration-300" title="Edit">
                                            <i class="fas fa-pencil-alt text-sm"></i>
                                        </a>
                                        <button data-id="<?php echo $event['id']; ?>" class="delete-btn h-8 w-8 rounded-full bg-red-100 text-red-600 flex items-center justify-center shadow-md hover:shadow-lg hover:bg-red-200 hover:-translate-y-0.5 transition-all duration-300" title="Delete">
                                            <i class="fas fa-trash-alt text-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-gray-500 col-span-full text-center py-10" data-i18n="admin_no_events">
                            No events found. Please add a new event.
                        </p>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>


    <?php include('bottom.php') ?>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="main.js"></script>

    <script src="admin-lang.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.delete-btn');
            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const eventId = this.dataset.id;

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#eb380b', // primary-start
                        cancelButtonColor: '#6b7280', // gray-500
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirect to delete
                            window.location.href = 'logics.php?event_delete_id=' + eventId;
                        }
                    });
                });
            });
        });
    </script>
</body>

</html>