<?php
include('db.php'); // ডেটাবেস কানেকশন

// সেশন চেক
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}
$pageTitle = 'View Member Details';
$upload_folder = 'uploads/member_images/'; // মেম্বার ছবির ফোল্ডার

// --- ধাপ ১: URL থেকে ID নেওয়া ---
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['message'] = "Invalid member ID.";
    $_SESSION['message_type'] = 'error';
    header('Location: members.php');
    exit();
}

$member_id = $_GET['id'];

// --- ধাপ ২: ID দিয়ে ডেটাবেস থেকে মেম্বারকে খুঁজে বের করা ---
$stmt = $mysqli->prepare("SELECT * FROM members WHERE id = ?");
$stmt->bind_param("i", $member_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    $_SESSION['message'] = "Member not found.";
    $_SESSION['message_type'] = 'error';
    header('Location: members.php');
    exit();
}

$member = $result->fetch_assoc();
$stmt->close();

// --- ধাপ ৩: প্রদর্শনের জন্য ডেটা প্রস্তুত করা ---
$image_path = (!empty($member['image'])) ? $upload_folder . htmlspecialchars($member['image']) : 'https://i.pravatar.cc/150'; 

$is_admin = (strtolower($member['designation']) == 'administrator');
$border_class = $is_admin ? 'border-primary-start/30' : 'border-gray-200';
$role_bg_class = $is_admin ? 'bg-primary-start/10' : 'bg-gray-100';
$role_text_class = $is_admin ? 'text-primary-end' : 'text-gray-700';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php') ?>
    <title>View Member Details - Admin Dashboard</title>
</head>

<body class="bg-gray-100 font-body"> <div class="flex h-screen">

        <?php include('sidebar.php') ?>

        <main class="flex-1 h-full overflow-y-auto">

            <?php include('top.php') ?>
            
            <div class="p-8 mb-32 md:mb-0 ">

                <div class="flex justify-between items-center mb-6" data-aos="fade-down">
                    <h1 class="text-3xl font-bold font-heading text-gray-800">
                        Member Details
                    </h1>
                    <a href="members.php" class="font-nav flex items-center bg-gray-600 text-white px-4 py-2 rounded-lg shadow-md hover:bg-gray-700 transition-colors duration-300 font-semibold uppercase tracking-wider text-xs">
                        <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" />
                        </svg>
                        <span>Back to Members</span>
                    </a>
                </div>

                <div class="bg-white rounded-xl shadow-lg p-6 md:p-10" data-aos="fade-up">
                    
                    <div class="flex flex-col md:flex-row items-center md:items-start md:space-x-12">
                        
                        <div class="md:w-1/4 flex-shrink-0 text-center">
                            <img src="<?php echo $image_path; ?>" alt="<?php echo htmlspecialchars($member['name']); ?>" 
                                 class="w-48 h-48 rounded-full shadow-xl mb-4 border-4 <?php echo $border_class; ?> mx-auto object-cover">
                        </div>

                        <div class="md:w-3/4 space-y-8 mt-8 md:mt-0 font-body">
                            
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Full Name</label>
                                <h2 class="text-4xl font-bold font-heading text-gray-900 leading-tight">
                                    <?php echo htmlspecialchars($member['name']); ?>
                                </h2>
                            </div>

                            <div class="flex items-center gap-8">
                                <div>
                                    <label class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Designation</label>
                                    <span class="text-base font-bold <?php echo $role_bg_class; ?> <?php echo $role_text_class; ?> px-6 py-2 rounded-full uppercase tracking-wider">
                                        <?php echo htmlspecialchars($member['designation']); ?>
                                    </span>
                                </div>
                            </div>

                            <div class="border-t pt-8 text-right">
                                <a href="edit-member.php?id=<?php echo $member['id']; ?>" class="font-nav inline-flex items-center justify-center bg-primary-start text-white px-8 py-3 rounded-lg shadow-lg hover:bg-primary-end transition-all duration-300 font-bold uppercase tracking-widest text-sm">
                                    <svg class="w-5 h-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                    </svg>
                                    <span>Edit Member</span>
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
</body>
</html>