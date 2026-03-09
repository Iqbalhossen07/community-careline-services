<?php
include('db.php'); // Database Connection

// Session Check
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}
$pageTitle = 'View Event Details';
$upload_folder = 'uploads/event_images/';

// --- Step 1: Get ID from URL ---
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['message'] = "Invalid event ID.";
    $_SESSION['message_type'] = 'error';
    header('Location: events.php');
    exit();
}

$event_id = $_GET['id'];

// --- Step 2: Fetch the event ---
$stmt = $mysqli->prepare("SELECT * FROM events WHERE id = ?");
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['message'] = "Event not found.";
    $_SESSION['message_type'] = 'error';
    header('Location: events.php');
    exit();
}

$event = $result->fetch_assoc();
$stmt->close();

// --- Step 3: Prepare Data ---
$image_path = (!empty($event['image'])) ? $upload_folder . htmlspecialchars($event['image']) : 'path/to/default-image.jpg';
$date_display = date('F j, Y', strtotime($event['event_date']));

// Status Logic
$today_date = date('Y-m-d');
if ($event['event_date'] >= $today_date) {
    $status_text_en = 'Upcoming';
    $status_text_bn = 'আসন্ন';
    $status_color = 'blue';
} else {
    $status_text_en = 'Past';
    $status_text_bn = 'অতীত';
    $status_color = 'gray';
}

// Bangla Data (Fallback)
$name_bn = !empty($event['event_name_bn']) ? $event['event_name_bn'] : $event['event_name'];
$venue_bn = !empty($event['venue_bn']) ? $event['venue_bn'] : $event['venue'];
$details_bn = !empty($event['details_bn']) ? $event['details_bn'] : $event['details'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php') ?>
    <title>View Event Details - Admin Dashboard</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-gray-100 font-merriweather">
    <div class="flex h-screen">

        <?php include('sidebar.php') ?>

        <main class="flex-1 h-full overflow-y-auto">

            <?php include('top.php') ?>

            <div class="p-8 mb-32 md:mb-0 ">

                <div class="flex justify-between items-center mb-6" data-aos="fade-down">
                    <h1 class="text-3xl font-bold font-lora text-gray-800" data-i18n="admin_view_event_title">
                        Event Details
                    </h1>
                    
                    <div class="flex gap-3">
                        <button id="lang-toggle" class="flex items-center gap-2 bg-white px-4 py-2 rounded-lg shadow-md border border-gray-200 text-gray-700 hover:bg-gray-50 transition">
                            <i class="fa-solid fa-globe text-primary-start"></i>
                            <span id="lang-btn-text" class="font-bold text-sm">বাংলা UI</span>
                        </button>

                        <a href="events.php" class="flex items-center bg-gray-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-gray-700 transition-colors duration-300">
                            <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                            </svg>
                            <span data-i18n="admin_back_events">Back to Events</span>
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 md:p-8" data-aos="fade-up">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                        <div class="md:col-span-1">
                            <img src="<?php echo $image_path; ?>" alt="<?php echo htmlspecialchars($event['event_name']); ?>" class="w-full h-auto rounded-lg shadow-md object-cover">
                        </div>

                        <div class="md:col-span-2 space-y-5">

                            <div>
                                <h2 class="text-3xl font-bold font-lora text-gray-900 lang-en-content">
                                    <?php echo htmlspecialchars($event['event_name']); ?>
                                </h2>
                                <h2 class="text-3xl font-bold font-lora text-gray-900 lang-bn-content hidden">
                                    <?php echo htmlspecialchars($name_bn); ?>
                                </h2>
                            </div>

                            <div class="flex flex-wrap items-center gap-6">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-500 mb-1" data-i18n="lbl_event_date">Date</label>
                                    <p class="text-lg text-gray-800 flex items-center">
                                        <i class="fa-solid fa-calendar-days w-5 h-5 mr-2 text-gray-600"></i>
                                        <?php echo $date_display; ?>
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-500 mb-1" data-i18n="lbl_status">Status</label>
                                    <span class="text-sm font-semibold bg-<?php echo $status_color; ?>-100 text-<?php echo $status_color; ?>-700 px-4 py-1.5 rounded-full">
                                        <span class="lang-en-content"><?php echo $status_text_en; ?></span>
                                        <span class="lang-bn-content hidden"><?php echo $status_text_bn; ?></span>
                                    </span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-semibold text-gray-500 mb-1" data-i18n="lbl_venue">Location / Venue</label>
                                <p class="text-lg text-gray-800 flex items-center">
                                    <i class="fa-solid fa-location-dot w-5 h-5 mr-2 text-gray-600"></i>
                                    <span class="lang-en-content"><?php echo htmlspecialchars($event['venue']); ?></span>
                                    <span class="lang-bn-content hidden"><?php echo htmlspecialchars($venue_bn); ?></span>
                                </p>
                            </div>

                            <?php if (!empty($event['ticket_link'])) : ?>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-500 mb-1" data-i18n="lbl_ticket_link">Ticket Link</label>
                                    <a href="<?php echo htmlspecialchars($event['ticket_link']); ?>" target="_blank" class="text-lg text-primary-start hover:text-primary-end hover:underline font-semibold flex items-center">
                                        <span data-i18n="lbl_get_tickets">Get Tickets Here</span>
                                        <i class="fa-solid fa-arrow-up-right-from-square w-4 h-4 ml-1.5"></i>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <div>
                                <label class="block text-sm font-semibold text-gray-500 mb-1" data-i18n="lbl_event_details">Description</label>
                                <div class="text-base text-gray-700 leading-relaxed prose max-w-none lang-en-content">
                                    <?php echo $event['details']; ?>
                                </div>
                                <div class="text-base text-gray-700 leading-relaxed prose max-w-none lang-bn-content hidden">
                                    <?php echo $details_bn; ?>
                                </div>
                            </div>

                            <div class="border-t pt-5 text-right">
                                <a href="edit-event.php?id=<?php echo $event['id']; ?>" class="inline-flex items-center justify-center bg-primary-start text-white px-6 py-2 rounded-lg shadow-md hover:bg-primary-end transition-colors duration-300 font-semibold">
                                    <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                    </svg>
                                    <span data-i18n="btn_edit_event">Edit Event</span>
                                </a>
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
    
    <script src="admin-lang.js"></script>
</body>

</html>