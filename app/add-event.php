<?php
include('db.php'); // ডেটাবেস কানেকশন

// সেশন চেক
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}
$pageTitle = 'Add New Event';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php') ?>
    <title>Add New Event - Admin Dashboard</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
</head>

<body class="bg-gray-100 font-merriweather">
    <div class="flex h-screen">

        <?php include('sidebar.php') ?>

        <main class="flex-1 h-full overflow-y-auto">

            <?php include('top.php') ?>

            <div class="p-8 mb-32 md:mb-0 ">

                <div class="flex justify-between items-center mb-6" data-aos="fade-down">
                    <h1 class="text-3xl font-bold font-lora text-gray-800" data-i18n="admin_add_event_title">
                        Add New Event
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
                    <form action="logics.php" method="POST" enctype="multipart/form-data">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                            <div>
                                <label for="event_name" class="block text-sm font-semibold text-gray-700 mb-2" data-i18n="lbl_event_name">Event Name (English)</label>
                                <input type="text" id="event_name" name="event_name" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end focus:border-transparent"
                                    placeholder="e.g., Winter Clothing Drive 2025" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-red-700 mb-2">ইভেন্টের নাম (বাংলা)</label>
                                <input type="text" name="event_name_bn" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end focus:border-transparent font-hind"
                                    placeholder="যেমন: শীতবস্ত্র বিতরণ ২০২৫" required>
                            </div>

                            <div>
                                <label for="event_date" class="block text-sm font-semibold text-gray-700 mb-2" data-i18n="lbl_event_date">Event Date (Common)</label>
                                <input type="date" id="event_date" name="event_date" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end focus:border-transparent" 
                                    value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            <div>
                                <label for="ticket_link" class="block text-sm font-semibold text-gray-700 mb-2" data-i18n="lbl_ticket_link">Ticket Link (Common)</label>
                                <input type="text" id="ticket_link" name="ticket_link" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end focus:border-transparent" 
                                    placeholder="https://www.example.com/tickets">
                            </div>

                            <div>
                                <label for="event_location" class="block text-sm font-semibold text-gray-700 mb-2" data-i18n="lbl_venue">Location / Venue (English)</label>
                                <input type="text" id="event_location" name="venue" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end focus:border-transparent"
                                    placeholder="Type your location name" required>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-red-700 mb-2">স্থান / ভেন্যু (বাংলা)</label>
                                <input type="text" name="venue_bn" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end focus:border-transparent font-hind"
                                    placeholder="আপনার জায়গার নাম লিখুন " required>
                            </div>

                            <div class="md:col-span-1">
                                <label for="textarea-description" class="block text-sm font-semibold text-gray-700 mb-2" data-i18n="lbl_event_details">Event Details (English)</label>
                                <textarea id="textarea-description" name="details" rows="5" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end focus:border-transparent"
                                    placeholder="Write the full details about the event here..."></textarea>
                            </div>
                            <div class="md:col-span-1">
                                <label class="block text-sm font-semibold text-red-700 mb-2">ইভেন্টের বিস্তারিত (বাংলা)</label>
                                <textarea id="textarea-description-bn" name="details_bn" rows="5" class="w-full px-4 py-2 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end focus:border-transparent"
                                    placeholder="ইভেন্টের বিস্তারিত এখানে লিখুন..."></textarea>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-semibold text-gray-700 mb-2" data-i18n="lbl_event_thumbnail">Event Thumbnail</label>
                                <label for="file-upload" class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-primary-end border-dashed rounded-md cursor-pointer hover:bg-gray-50 transition-colors">
                                    <div class="space-y-1 text-center">
                                        <img id="image-preview" src="" alt="Image Preview" class="hidden w-64 h-auto mx-auto rounded-lg shadow-md mb-4" />
                                        <svg id="svg-placeholder" class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600 justify-center">
                                            <span class="relative font-medium text-primary-start hover:text-primary-end" data-i18n="txt_upload_file">
                                                Upload a file
                                            </span>
                                            <p class="pl-1" data-i18n="txt_drag_drop">or drag and drop</p>
                                        </div>
                                        <p class="text-xs text-gray-500">PNG, JPG up to 10MB</p>
                                    </div>
                                    <input id="file-upload" name="image" type="file" class="sr-only" required onchange="previewImage(event)">
                                </label>
                            </div>

                        </div>

                        <div class="mt-8 text-right">
                            <button type="submit" name="add_event" class="inline-flex items-center justify-center bg-primary-start text-white px-6 py-2 rounded-lg shadow-md hover:bg-primary-end transition-colors duration-300 font-semibold">
                                <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                <span data-i18n="btn_add_event">Add Event</span>
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
    
    <script src="admin-lang.js"></script>

    <script>
        // Image Preview
        function previewImage(event) {
            const preview = document.getElementById('image-preview');
            const placeholder = document.getElementById('svg-placeholder');
            const file = event.target.files[0];

            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.classList.add('hidden');
                placeholder.classList.remove('hidden');
            }
        }
        
        // CKEditor Initialization (Both Eng & Bn)
        CKEDITOR.replace('textarea-description'); 
        // Initialize CKEditor
        ClassicEditor.create(document.querySelector("#textarea-description-bn")).catch(
            (error) => {
                console.error(error);
            }
        );
    </script>
</body>
</html>