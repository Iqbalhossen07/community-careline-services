<?php
include('db.php');

// PHPMailer দিয়ে ইমেইল পাঠানো
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


// PHPMailer ফাইলগুলো require করা
require '../PHPMailer/Exception.php';
require '../PHPMailer/PHPMailer.php';
require '../PHPMailer/SMTP.php';


//  ------------------ admin login logics start ----------------- 


// Admin Login Logic (Hashed & Secure)
if (isset($_POST['admin_login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // --- ধাপ ১: সেশনের পুরনো এরর এবং ইনপুট মুছে ফেলা ---
    unset($_SESSION['errors']);
    unset($_SESSION['old_input']);

    // --- ধাপ ২: Prepared Statement দিয়ে ইউজার খোঁজা (নিরাপদ পদ্ধতি) ---
    $stmt = $mysqli->prepare("SELECT * FROM `admin_login` WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // ইমেইল পাওয়া গেছে
        $login_row = $result->fetch_assoc();
        $db_hashed_pass = $login_row['password']; // ডাটাবেস থেকে হাশ করা পাসওয়ার্ড

        // --- ধাপ ৩: হাশ করা পাসওয়ার্ড ভেরিফাই করা ---
        if (password_verify($password, $db_hashed_pass)) {
            // পাসওয়ার্ড সঠিক
            $_SESSION['email'] = $login_row['email'];
            $_SESSION['name'] = $login_row['name'];
            $_SESSION['id'] = $login_row['id'];
            $_SESSION['image'] = $login_row['image'];

            $_SESSION['email'] = $email;
            $_SESSION['id'] = $user_id;

            header('Location: index.php'); // ড্যাশবোর্ডে পাঠানো
            exit();
        } else {
            // পাসওয়ার্ড ভুল
            $_SESSION['errors']['password'] = "Invalid Password!"; // নির্দিষ্ট পাসওয়ার্ড ফিল্ডের জন্য এরর
            $_SESSION['old_input']['email'] = $email; // ইমেইলটি মনে রাখা
            header('Location: login.php');
            exit();
        }
    } else {
        // ইমেইল পাওয়া যায়নি
        $_SESSION['errors']['email'] = "Email not found!"; // নির্দিষ্ট ইমেইল ফিল্ডের জন্য এরর
        $_SESSION['old_input']['email'] = $email; // ইমেইলটি মনে রাখা
        header('Location: login.php');
        exit();
    }
}

//  ------------------ admin login logics end ----------------- 




//  -------------------- hero images logics start -------------------------



// Add Hero Images Logic (Multiple Upload Enabled)
if (isset($_POST['add_hero_images'])) {

    // --- Database Insert Prepared Statement (লুপের বাইরে) ---
    $query = "INSERT INTO hero_images (image) VALUES (?)";
    $stmt = $mysqli->prepare($query);

    if (!$stmt) {
        $_SESSION['message'] = "Error: Database query could not be prepared.";
        $_SESSION['message_type'] = 'error';
        header("location:hero-sliders.php"); // hero_images.php পেজে রিডাইরেক্ট
        exit();
    }

    // --- Multiple Image Upload Logic (Loop) ---
    $total_files = count($_FILES['images']['name']);
    $files_uploaded_count = 0;

    for ($i = 0; $i < $total_files; $i++) {

        $image_name = $_FILES['images']['name'][$i];

        if (!empty($image_name)) {
            $tmpName    = $_FILES['images']['tmp_name'][$i];

            // ১. ইউনিক নাম তৈরি
            $image_ext = pathinfo($image_name, PATHINFO_EXTENSION);
            $unique_image_name = time() . '_hero_' . rand(1000, 9999) . '_' . $i . '.' . $image_ext;

            // ২. 'uploads/hero_images/' ফোল্ডার
            $folder = 'uploads/hero_images/' . $unique_image_name;

            // ৩. ডেটাবেসে বাইন্ড এবং এক্সিকিউট
            $stmt->bind_param("s", $unique_image_name);

            if ($stmt->execute()) {
                move_uploaded_file($tmpName, $folder);
                $files_uploaded_count++;
            }
        }
    } // লুপ শেষ

    $stmt->close();

    // --- Final Message ---
    if ($files_uploaded_count > 0) {
        $_SESSION['message'] = "$files_uploaded_count hero image(s) have been added successfully!";
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = "No valid images were uploaded.";
        $_SESSION['message_type'] = 'error';
    }

    header("location:hero-sliders.php");
    exit();
}

// Update Hero Image Logic (Replace Image File)
if (isset($_POST['update_hero_image'])) {
    $hero_image_update_id = $_POST['id'];        // Hidden field: ছবির ID
    $old_image            = $_POST['old_image']; // Hidden field: পুরনো ছবির নাম

    // --- New Image Handling Logic ---
    $new_image = $_FILES['image']['name']; // Edit মোডাল থেকে একটি নতুন ছবি (name="image")

    if ($new_image != "") {
        // 1. যদি নতুন ছবি আপলোড করা হয়
        $image_ext = pathinfo($new_image, PATHINFO_EXTENSION);
        $update_filename = time() . '_hero_' . rand(1000, 9999) . '.' . $image_ext;
        $folder = 'uploads/hero_images/' . $update_filename;
        $tmpName = $_FILES['image']['tmp_name'];

        // নতুন ছবিটি আপলোড করা
        if (move_uploaded_file($tmpName, $folder)) {

            // --- Database Update ---
            $query = "UPDATE `hero_images` SET `image`=? WHERE `id`=?";
            $stmt = $mysqli->prepare($query);

            if ($stmt) {
                $stmt->bind_param("si", $update_filename, $hero_image_update_id);

                if ($stmt->execute()) {
                    // সফলভাবে আপডেট হলে, পুরনো ছবিটি ডিলিট করা
                    $old_image_path = 'uploads/hero_images/' . $old_image;
                    if (file_exists($old_image_path) && !empty($old_image)) {
                        unlink($old_image_path);
                    }
                    $_SESSION['message'] = "Hero image has been updated successfully!";
                    $_SESSION['message_type'] = 'success';
                } else {
                    $_SESSION['message'] = "Failed to update the database record.";
                    $_SESSION['message_type'] = 'error';
                }
                $stmt->close();
            } else {
                $_SESSION['message'] = "Error: Database query could not be prepared.";
                $_SESSION['message_type'] = 'error';
            }
        } else {
            $_SESSION['message'] = "Failed to upload the new image.";
            $_SESSION['message_type'] = 'error';
        }
    } else {
        // যদি নতুন কোনো ছবি সিলেক্ট না করা হয়
        $_SESSION['message'] = "No new image was selected to update.";
        $_SESSION['message_type'] = 'info';
    }

    header('location:hero-sliders.php');
    exit();
}

// Delete Hero Image Logic
if (isset($_GET['hero_image_delete_id'])) {
    $id = $_GET['hero_image_delete_id'];

    // --- ধাপ ১: ছবির নামটি খুঁজে বের করা ---
    $select_query = "SELECT image FROM hero_images WHERE id = ?";
    $stmt_select = $mysqli->prepare($select_query);

    $image_filename = "";

    if ($stmt_select) {
        $stmt_select->bind_param("i", $id);
        $stmt_select->execute();
        $stmt_select->bind_result($image_filename);
        $stmt_select->fetch();
        $stmt_select->close();
    }

    // --- ধাপ ২: ডেটাবেস থেকে রো'টি ডিলিট করা ---
    $delete_query = "DELETE FROM hero_images WHERE id = ?";
    $stmt_delete = $mysqli->prepare($delete_query);

    if ($stmt_delete) {
        $stmt_delete->bind_param("i", $id);

        if ($stmt_delete->execute()) {
            // --- ধাপ ৩: সার্ভার থেকে ছবিটি ডিলিট করা ---
            $image_path = 'uploads/hero_images/' . $image_filename;

            if (file_exists($image_path) && !empty($image_filename)) {
                unlink($image_path); // ছবিটি ডিলিট করা
            }

            $_SESSION['message'] = "Hero image has been deleted successfully!";
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = "Could not delete the hero image.";
            $_SESSION['message_type'] = 'error';
        }
        $stmt_delete->close();
    } else {
        $_SESSION['message'] = "Error: Database query could not be prepared.";
        $_SESSION['message_type'] = 'error';
    }

    header("location:hero-sliders.php");
    exit();
}


//  -------------------- hero images logics end -------------------------




// -------------------- Gallery Logics Start -------------------------
$upload_folder = 'uploads/gallery/'; // Image upload folder

// Add Gallery Images Logic (Multiple Upload Enabled)
if (isset($_POST['add_gallery_images'])) {

    // Title acts as the category
    $title = $_POST['title'];

    // --- Validation ---
    if (empty($title)) {
        $_SESSION['message'] = "Image Title (Category) field is required.";
        $_SESSION['message_type'] = 'error';
        header("location:gallery.php");
        exit();
    }

    // --- Database Insert Prepared Statement (outside loop) ---
    // Table 'gallery', fields 'title' and 'image'
    $query = "INSERT INTO gallery (title, image) VALUES (?, ?)";
    $stmt = $mysqli->prepare($query);

    if (!$stmt) {
        $_SESSION['message'] = "Error: Database query could not be prepared.";
        $_SESSION['message_type'] = 'error';
        header("location:gallery.php");
        exit();
    }

    // --- Multiple Image Upload Logic (Loop) ---
    $total_files = count($_FILES['images']['name']);
    $files_uploaded_count = 0;

    for ($i = 0; $i < $total_files; $i++) {
        $image_name = $_FILES['images']['name'][$i];

        if (!empty($image_name)) {
            $tmpName    = $_FILES['images']['tmp_name'][$i];

            // 1. Create unique name
            $image_ext = pathinfo($image_name, PATHINFO_EXTENSION);
            $unique_image_name = time() . '_gallery_' . rand(1000, 9999) . '_' . $i . '.' . $image_ext;

            // 2. Upload folder path
            $folder_path = $upload_folder . $unique_image_name;

            // 3. Bind and execute in database (same title for all)
            $stmt->bind_param("ss", $title, $unique_image_name);

            if ($stmt->execute()) {
                move_uploaded_file($tmpName, $folder_path);
                $files_uploaded_count++;
            }
        }
    } // End loop

    $stmt->close();

    // --- Final Message ---
    if ($files_uploaded_count > 0) {
        $_SESSION['message'] = "$files_uploaded_count image(s) with title '$title' have been added successfully!";
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = "No valid images were uploaded.";
        $_SESSION['message_type'] = 'error';
    }

    header("location:gallery.php");
    exit();
}

// Update Gallery Item Logic (Title only)
if (isset($_POST['update_gallery_item'])) {

    $id = $_POST['id'];
    $title = $_POST['title']; // New title

    if (empty($title)) {
        $_SESSION['message'] = "Title cannot be empty.";
        $_SESSION['message_type'] = 'error';
        header("location:gallery.php");
        exit();
    }

    $query = "UPDATE gallery SET title = ? WHERE id = ?";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        $stmt->bind_param("si", $title, $id);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Gallery item title has been updated successfully!";
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = "Failed to update the database record.";
            $_SESSION['message_type'] = 'error';
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "Error: Database query could not be prepared.";
        $_SESSION['message_type'] = 'error';
    }

    header('location:gallery.php');
    exit();
}

// Delete Gallery Image Logic
if (isset($_GET['gallery_delete_id'])) {
    $id = $_GET['gallery_delete_id'];

    // --- Step 1: Find the image name ---
    $select_query = "SELECT image FROM gallery WHERE id = ?";
    $stmt_select = $mysqli->prepare($select_query);
    $image_filename = "";

    if ($stmt_select) {
        $stmt_select->bind_param("i", $id);
        $stmt_select->execute();
        $stmt_select->bind_result($image_filename);
        $stmt_select->fetch();
        $stmt_select->close();
    }

    // --- Step 2: Delete the row from database ---
    $delete_query = "DELETE FROM gallery WHERE id = ?";
    $stmt_delete = $mysqli->prepare($delete_query);

    if ($stmt_delete) {
        $stmt_delete->bind_param("i", $id);

        if ($stmt_delete->execute()) {
            // --- Step 3: Delete the image file from server ---
            $image_path = $upload_folder . $image_filename;

            if (file_exists($image_path) && !empty($image_filename)) {
                unlink($image_path); // Delete the file
            }

            $_SESSION['message'] = "Gallery image has been deleted successfully!";
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = "Could not delete the gallery image.";
            $_SESSION['message_type'] = 'error';
        }
        $stmt_delete->close();
    } else {
        $_SESSION['message'] = "Error: Database query could not be prepared.";
        $_SESSION['message_type'] = 'error';
    }

    header("location:gallery.php");
    exit();
}
// -------------------- Gallery Logics End -------------------------




// ----------------------- blog logic start ---------------------


// --- Add Blog Logic ---
if (isset($_POST['add_blog'])) {
    // English Inputs Only
    $name = $_POST['name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $author_name = $_POST['author_name'];

    // Image Handling
    $image_name = $_FILES['image']['name'];
    $tmpName = $_FILES['image']['tmp_name'];
    $image_ext = pathinfo($image_name, PATHINFO_EXTENSION);
    $unique_image_name = time() . '_uniq_' . rand(1000, 9999) . '.' . $image_ext;
    $folder = 'uploads/blog_images/' . $unique_image_name;

    // Insert Query (Updated without Bangla fields)
    $query = "INSERT INTO blogs (name, category, description, author_name, image) VALUES (?, ?, ?, ?, ?)";

    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        // Bind 5 strings (name, category, description, author_name, image)
        $stmt->bind_param("sssss", $name, $category, $description, $author_name, $unique_image_name);

        if ($stmt->execute()) {
            move_uploaded_file($tmpName, $folder);
            $_SESSION['message'] = "Blog post added successfully!";
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = "Error adding blog.";
            $_SESSION['message_type'] = 'error';
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "Database Error.";
        $_SESSION['message_type'] = 'error';
    }

    header("location:blogs.php");
    exit();
}


// --- Update Blog Logic ---
if (isset($_POST['update_blog'])) {
    $id = $_POST['id'];
    $old_image = $_POST['old_image'];

    // English Data Only
    $name = $_POST['name'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $author_name = $_POST['author_name'];

    // Image Logic
    $image_name = $_FILES['image']['name'];
    $tmpName = $_FILES['image']['tmp_name'];
    $new_image_name = $old_image; // Default to old image

    if (!empty($image_name)) {
        $image_ext = pathinfo($image_name, PATHINFO_EXTENSION);
        $new_image_name = time() . '_uniq_' . rand(1000, 9999) . '.' . $image_ext;
        $folder = 'uploads/blog_images/' . $new_image_name;
        move_uploaded_file($tmpName, $folder);

        // Delete old image if exists
        if (!empty($old_image) && file_exists('uploads/blog_images/' . $old_image)) {
            unlink('uploads/blog_images/' . $old_image);
        }
    }

    // Updated Query (Removed Bangla fields)
    $query = "UPDATE blogs SET name=?, category=?, description=?, author_name=?, image=? WHERE id=?";

    $stmt = $mysqli->prepare($query);
    if ($stmt) {
        // Bind params: 5 strings + 1 integer id
        $stmt->bind_param("sssssi", $name, $category, $description, $author_name, $new_image_name, $id);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Blog updated successfully!";
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = "Error updating blog.";
            $_SESSION['message_type'] = 'error';
        }
        $stmt->close();
    }
    header("location:blogs.php");
    exit();
}


// Delete Blog Logic
if (isset($_GET['blog_delete_id'])) {
    $id = $_GET['blog_delete_id'];

    // --- ধাপ ১: ছবিটি ডিলিট করার জন্য ডেটাবেস থেকে ছবির নামটি আগে খুঁজে বের করা ---
    $select_query = "SELECT image FROM blogs WHERE id = ?";
    $stmt_select = $mysqli->prepare($select_query);

    $image_filename = "";

    if ($stmt_select) {
        $stmt_select->bind_param("i", $id);
        $stmt_select->execute();
        $stmt_select->bind_result($image_filename);
        $stmt_select->fetch();
        $stmt_select->close();
    }

    // --- ধাপ ২: ডেটাবেস থেকে রো'টি ডিলিট করা ---
    $delete_query = "DELETE FROM blogs WHERE id = ?";
    $stmt_delete = $mysqli->prepare($delete_query);

    if ($stmt_delete) {
        $stmt_delete->bind_param("i", $id);

        if ($stmt_delete->execute()) {
            // --- ধাপ ৩: সার্ভার থেকে ছবিটি ডিলিট করা ---
            $image_path = 'uploads/blog_images/' . $image_filename;

            if (file_exists($image_path) && !empty($image_filename)) {
                unlink($image_path); // ছবিটি ডিলিট করা
            }

            $_SESSION['message'] = "Blog post has been deleted successfully!";
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = "Could not delete the blog post.";
            $_SESSION['message_type'] = 'error';
        }
        $stmt_delete->close();
    } else {
        $_SESSION['message'] = "Error: Database query could not be prepared.";
        $_SESSION['message_type'] = 'error';
    }

    // কাজ শেষে blogs.php (Master List) পেজে রিডাইরেক্ট করা
    header("location:blogs.php");
    exit();
}
// ----------------------- blog logic end ---------------------


// ----------------------- event logic start ---------------------

// Add Event Logic
if (isset($_POST['add_event'])) {
    // English Inputs
    $event_name = $_POST['event_name'];
    $details    = $_POST['details'];
    $venue      = $_POST['venue'];

    // Bangla Inputs
    $event_name_bn = $_POST['event_name_bn'];
    $venue_bn      = $_POST['venue_bn'];
    $details_bn    = $_POST['details_bn'];

    // Common Inputs
    $event_date  = $_POST['event_date'];
    $ticket_link = $_POST['ticket_link'];

    // Image Upload
    $image_name = $_FILES['image']['name'];
    $tmpName    = $_FILES['image']['tmp_name'];
    $image_ext  = pathinfo($image_name, PATHINFO_EXTENSION);
    $unique_image_name = time() . '_uniq_' . rand(1000, 9999) . '.' . $image_ext;
    $folder = 'uploads/event_images/' . $unique_image_name;

    // Insert Query (with 9 placeholders)
    // event_name, event_name_bn, details, details_bn, event_date, venue, venue_bn, ticket_link, image
    $query = "INSERT INTO events (event_name, event_name_bn, details, details_bn, event_date, venue, venue_bn, ticket_link, image) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        // sssssssss (9 strings)
        $stmt->bind_param("sssssssss", $event_name, $event_name_bn, $details, $details_bn, $event_date, $venue, $venue_bn, $ticket_link, $unique_image_name);

        if ($stmt->execute()) {
            move_uploaded_file($tmpName, $folder);
            $_SESSION['message'] = "Event has been added successfully!";
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = "Error: Could not add the event.";
            $_SESSION['message_type'] = 'error';
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "Error: Database query could not be prepared.";
        $_SESSION['message_type'] = 'error';
    }

    header("location:events.php");
    exit();
}




// Update Event Logic
if (isset($_POST['update_event'])) {
    $event_update_id = $_POST['id'];
    $old_image = $_POST['old_image'];

    // English Data
    $event_name = $_POST['event_name'];
    $details = $_POST['details'];
    $venue = $_POST['venue'];

    // Bangla Data
    $event_name_bn = $_POST['event_name_bn'];
    $venue_bn = $_POST['venue_bn'];
    $details_bn = $_POST['details_bn'];

    // Common Data
    $event_date = $_POST['event_date'];
    $ticket_link = $_POST['ticket_link'];

    // Image Handling
    $new_image = $_FILES['image']['name'];
    $update_filename = $old_image;

    if (!empty($new_image)) {
        $image_ext = pathinfo($new_image, PATHINFO_EXTENSION);
        $update_filename = time() . '_uniq_' . rand(1000, 9999) . '.' . $image_ext;
        $folder = 'uploads/event_images/' . $update_filename;
        $tmpName = $_FILES['image']['tmp_name'];

        move_uploaded_file($tmpName, $folder);

        if (!empty($old_image) && file_exists('uploads/event_images/' . $old_image)) {
            unlink('uploads/event_images/' . $old_image);
        }
    }

    // Updated Query (with 9 params)
    $query = "UPDATE events SET 
              event_name=?, event_name_bn=?, details=?, details_bn=?, event_date=?, venue=?, venue_bn=?, ticket_link=?, image=? 
              WHERE id=?";

    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        // Bind params: sssssssssi (9 strings, 1 integer)
        $stmt->bind_param("sssssssssi", $event_name, $event_name_bn, $details, $details_bn, $event_date, $venue, $venue_bn, $ticket_link, $update_filename, $event_update_id);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Event updated successfully!";
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = "Failed to update the event.";
            $_SESSION['message_type'] = 'error';
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "Database error.";
        $_SESSION['message_type'] = 'error';
    }

    header('location:events.php');
    exit();
}

// Delete Event Logic
if (isset($_GET['event_delete_id'])) {
    $id = $_GET['event_delete_id'];

    // --- ধাপ ১: ছবিটি ডিলিট করার জন্য ডেটাবেস থেকে ছবির নামটি আগে খুঁজে বের করা ---
    $select_query = "SELECT image FROM events WHERE id = ?"; // events টেবিল
    $stmt_select = $mysqli->prepare($select_query);

    $image_filename = "";

    if ($stmt_select) {
        $stmt_select->bind_param("i", $id);
        $stmt_select->execute();
        $stmt_select->bind_result($image_filename);
        $stmt_select->fetch();
        $stmt_select->close();
    }

    // --- ধাপ ২: ডেটাবেস থেকে রো'টি ডিলিট করা ---
    $delete_query = "DELETE FROM events WHERE id = ?"; // events টেবিল
    $stmt_delete = $mysqli->prepare($delete_query);

    if ($stmt_delete) {
        $stmt_delete->bind_param("i", $id);

        if ($stmt_delete->execute()) {
            // --- ধাপ ৩: সার্ভার থেকে ছবিটি ডিলিট করা ---
            $image_path = 'uploads/event_images/' . $image_filename; // ইভেন্ট ফোল্ডার

            if (file_exists($image_path) && !empty($image_filename)) {
                unlink($image_path); // ছবিটি ডিলিট করা
            }

            $_SESSION['message'] = "Event has been deleted successfully!";
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = "Could not delete the event.";
            $_SESSION['message_type'] = 'error';
        }
        $stmt_delete->close();
    } else {
        $_SESSION['message'] = "Error: Database query could not be prepared.";
        $_SESSION['message_type'] = 'error';
    }

    // কাজ শেষে events.php পেজে রিডাইরেক্ট করা
    header("location:events.php");
    exit();
}
// ----------------------- event logic end ---------------------



// ----------------------- portfolio logic start ---------------------

// --- Add Portfolio Logic ---
if (isset($_POST['add_portfolio'])) {
    // 1. Basic Inputs
    $name = $_POST['name'];
    $typology = $_POST['typology'];
    $year = $_POST['year'];
    $country = $_POST['country'];
    $type = $_POST['type'];
    $gross_cost = $_POST['gross_cost'];
    $short_description = $_POST['short_description'];

    // 2. CKEditor Inputs
    $challenge_des = $_POST['challenge_des'];
    $solution_des = $_POST['solution_des'];
    $outcome_des = $_POST['outcome_des'];

    // --- Image Upload Helper Function ---
    function uploadMultipleImages($fileInputName, $prefix)
    {
        $filenames = [];
        // ফর্মে input name="challenge_images[]" এভাবে array হিসেবে থাকলে
        if (isset($_FILES[$fileInputName]) && !empty($_FILES[$fileInputName]['name'][0])) {
            $total = count($_FILES[$fileInputName]['name']);
            for ($i = 0; $i < $total; $i++) {
                $imgName = $_FILES[$fileInputName]['name'][$i];
                $tmpName = $_FILES[$fileInputName]['tmp_name'][$i];

                $ext = pathinfo($imgName, PATHINFO_EXTENSION);
                // Unique Name logic
                $uniqueName = time() . '_' . $i . '_' . $prefix . '_' . rand(1000, 9999) . '.' . $ext;

                $destination = 'uploads/portfolio_images/' . $uniqueName;

                if (move_uploaded_file($tmpName, $destination)) {
                    $filenames[] = $uniqueName;
                }
            }
        }
        return implode(',', $filenames); // Return comma separated string
    }

    // --- 3. Main Image (Single) ---
    $main_image_name = '';
    if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
        $imgName = $_FILES['image']['name'];
        $tmpName = $_FILES['image']['tmp_name'];
        $ext = pathinfo($imgName, PATHINFO_EXTENSION);
        $main_image_name = time() . '_main_' . rand(1000, 9999) . '.' . $ext;
        move_uploaded_file($tmpName, 'uploads/portfolio_images/' . $main_image_name);
    }

    // --- 4. Multiple Images Processing ---
    // HTML ফর্মে input name গুলো অবশ্যই array হতে হবে (যেমন: challenge_images[])
    $challenge_image_str = uploadMultipleImages('challenge_images', 'chal');
    $solution_image_str  = uploadMultipleImages('solution_images', 'sol');
    $outcome_image_str   = uploadMultipleImages('outcome_images', 'out');


    $query = "INSERT INTO portfolios 
              (name,typology, year, country, type, gross_cost, short_description, image, 
               challenge_des, challenge_image, 
               solution_des, solution_image, 
               outcome_des, outcome_image) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        // Bind Params (11 strings)
        $stmt->bind_param(
            "ssssssssssssss",
            $name,
            $typology,
            $year,
            $country,
            $type,
            $gross_cost,
            $short_description,
            $main_image_name,
            $challenge_des,
            $challenge_image_str,
            $solution_des,
            $solution_image_str,
            $outcome_des,
            $outcome_image_str
        );

        if ($stmt->execute()) {
            $_SESSION['message'] = "Portfolio item added successfully!";
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = "Error adding portfolio.";
            $_SESSION['message_type'] = 'error';
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "Database error: " . $mysqli->error;
        $_SESSION['message_type'] = 'error';
    }

    header('Location: portfolio.php');
    exit();
}



// --- Update Portfolio Logic ---
if (isset($_POST['update_portfolio'])) {
    $id = $_POST['id'];

    // 1. Text Inputs
    $name = $_POST['name'];
    $typology = $_POST['typology'];
    $year = $_POST['year'];
    $country = $_POST['country'];
    $type = $_POST['type'];
    $gross_cost = $_POST['gross_cost'];
    $short_description = $_POST['short_description'];

    // CKEditor Inputs
    $challenge_des = $_POST['challenge_des'];
    $solution_des = $_POST['solution_des'];
    $outcome_des = $_POST['outcome_des'];

    // Hidden Inputs (Existing Images)
    $old_main_image = $_POST['old_main_image'];
    $old_challenge_images = $_POST['old_challenge_images'];
    $old_solution_images = $_POST['old_solution_images'];
    $old_outcome_images = $_POST['old_outcome_images'];

    // --- ধাপ ১: ডাটাবেস থেকে বর্তমান তথ্য আনা (ডিলিট লজিকের জন্য) ---
    $stmt_fetch = $mysqli->prepare("SELECT image, challenge_image, solution_image, outcome_image FROM portfolios WHERE id = ?");
    $stmt_fetch->bind_param("i", $id);
    $stmt_fetch->execute();
    $result_fetch = $stmt_fetch->get_result();
    $db_row = $result_fetch->fetch_assoc();
    $stmt_fetch->close();

    // --- Helper Function: Multiple Image Update Logic ---
    function processUpdateImages($db_img_str, $form_old_img_str, $fileInputName, $prefix)
    {
        $upload_path = 'uploads/portfolio_images/';

        // ১. ফোল্ডার ক্লিনআপ: ডাটাবেসে ছিল কিন্তু ফর্মে নেই -> ডিলিট
        $db_imgs = !empty($db_img_str) ? explode(',', $db_img_str) : [];
        $kept_imgs = !empty($form_old_img_str) ? explode(',', $form_old_img_str) : [];

        $to_delete = array_diff($db_imgs, $kept_imgs);

        foreach ($to_delete as $img) {
            if (file_exists($upload_path . $img)) {
                unlink($upload_path . $img);
            }
        }

        // ২. নতুন ছবি আপলোড এবং লিস্টে যোগ করা
        $final_list = $kept_imgs; // শুরুতে যা রাখা হয়েছে তা নিলাম

        if (isset($_FILES[$fileInputName]) && !empty($_FILES[$fileInputName]['name'][0])) {
            $total = count($_FILES[$fileInputName]['name']);
            for ($i = 0; $i < $total; $i++) {
                $imgName = $_FILES[$fileInputName]['name'][$i];
                $tmpName = $_FILES[$fileInputName]['tmp_name'][$i];

                $ext = pathinfo($imgName, PATHINFO_EXTENSION);
                $uniqueName = time() . '_' . $i . '_' . $prefix . '_' . rand(1000, 9999) . '.' . $ext;

                if (move_uploaded_file($tmpName, $upload_path . $uniqueName)) {
                    $final_list[] = $uniqueName;
                }
            }
        }

        return implode(',', $final_list);
    }

    // --- Processing All Image Sections ---

    // A. Main Image (Single) Logic
    $final_main_image = $old_main_image; // ডিফল্ট: পুরনো ছবি
    if (isset($_FILES['image']) && !empty($_FILES['image']['name'])) {
        // নতুন ছবি আপলোড
        $imgName = $_FILES['image']['name'];
        $tmpName = $_FILES['image']['tmp_name'];
        $ext = pathinfo($imgName, PATHINFO_EXTENSION);
        $new_main_name = time() . '_main_' . rand(1000, 9999) . '.' . $ext;

        if (move_uploaded_file($tmpName, 'uploads/portfolio_images/' . $new_main_name)) {
            $final_main_image = $new_main_name;
            // পুরনো ছবি ডিলিট করা (যদি থাকে)
            if (!empty($old_main_image) && file_exists('uploads/portfolio_images/' . $old_main_image)) {
                unlink('uploads/portfolio_images/' . $old_main_image);
            }
        }
    }

    // B. Multiple Images Logic (Challenge, Solution, Outcome)
    // ফাংশনে প্যারামিটার: (ডাটাবেসের স্ট্রিং, ফর্মের ওল্ড স্ট্রিং, ফাইল ইনপুট নাম, ইউনিক প্রিফিক্স)
    $final_challenge_str = processUpdateImages($db_row['challenge_image'], $old_challenge_images, 'challenge_images', 'chal');
    $final_solution_str  = processUpdateImages($db_row['solution_image'], $old_solution_images, 'solution_images', 'sol');
    $final_outcome_str   = processUpdateImages($db_row['outcome_image'], $old_outcome_images, 'outcome_images', 'out');


    // --- ধাপ ২: ডাটাবেস আপডেট কুয়েরি ---
    $query = "UPDATE portfolios SET 
              name=?, typology=?, year=?, country=?, type=?, gross_cost=?, short_description=?, image=?, 
              challenge_des=?, challenge_image=?, 
              solution_des=?, solution_image=?, 
              outcome_des=?, outcome_image=? 
              WHERE id=?";

    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        $stmt->bind_param(
            "ssssssssssssssi",
            $name,
            $typology,
            $year,
            $country,
            $type,
            $gross_cost,
            $short_description,
            $final_main_image,
            $challenge_des,
            $final_challenge_str,
            $solution_des,
            $final_solution_str,
            $outcome_des,
            $final_outcome_str,
            $id
        );

        if ($stmt->execute()) {
            $_SESSION['message'] = "Portfolio item updated successfully!";
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = "Error updating portfolio.";
            $_SESSION['message_type'] = 'error';
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "Database error: " . $mysqli->error;
        $_SESSION['message_type'] = 'error';
    }

    header('Location: portfolio.php');
    exit();
}


// --- Delete Portfolio Logic ---
if (isset($_GET['portfolio_delete_id'])) {
    $id = $_GET['portfolio_delete_id'];

    // ১. সব ছবির নাম আনা
    $stmt = $mysqli->prepare("SELECT image, challenge_image, solution_image, outcome_image FROM portfolios WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $res = $stmt->get_result();
    $row = $res->fetch_assoc();
    $stmt->close();

    if ($row) {
        $path = 'uploads/portfolio_images/';

        // Helper to delete multiple comma separated images
        function deleteFiles($str, $path)
        {
            if (!empty($str)) {
                $files = explode(',', $str);
                foreach ($files as $f) {
                    if (file_exists($path . trim($f))) unlink($path . trim($f));
                }
            }
        }

        // Delete Main Image
        if (!empty($row['image']) && file_exists($path . $row['image'])) {
            unlink($path . $row['image']);
        }

        // Delete Multiple Images
        deleteFiles($row['challenge_image'], $path);
        deleteFiles($row['solution_image'], $path);
        deleteFiles($row['outcome_image'], $path);

        // ২. ডাটাবেস থেকে ডিলিট
        $delStmt = $mysqli->prepare("DELETE FROM portfolios WHERE id = ?");
        $delStmt->bind_param("i", $id);
        if ($delStmt->execute()) {
            $_SESSION['message'] = "Portfolio deleted successfully!";
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = "Error deleting portfolio.";
            $_SESSION['message_type'] = 'error';
        }
    }

    header('Location: portfolio.php');
    exit();
}
// ----------------------- portfolio logic end ---------------------



// ----------------------- members logic start ---------------------

// Add Member Logic
if (isset($_POST['add_member'])) {
    $name            = $_POST['name'];
    $designation     = $_POST['designation'];


    // --- Image Upload Logic ---
    $image_name = $_FILES['image']['name'];
    $tmpName    = $_FILES['image']['tmp_name'];

    // ১. একটি নতুন ইউনিক নাম তৈরি করা
    $image_ext = pathinfo($image_name, PATHINFO_EXTENSION);
    $unique_image_name = time() . '_member_' . rand(1000, 9999) . '.' . $image_ext;

    // ২. 'uploads/member_images/' ফোল্ডার
    $folder = 'uploads/member_images/' . $unique_image_name;

    // --- Database Insert using Prepared Statements ---
    $query = "INSERT INTO members (name, designation, image) 
              VALUES (?, ?, ?)";

    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        // 2. প্যারামিটার বাইন্ড করা (s, s, s)
        $stmt->bind_param("sss", $name, $designation, $unique_image_name);

        // 3. স্টেটমেন্ট এক্সিকিউট করা
        if ($stmt->execute()) {
            // সফলভাবে ডেটা ইনসার্ট হলে ছবিটি ফোল্ডারে সরানো হচ্ছে
            move_uploaded_file($tmpName, $folder);

            $_SESSION['message'] = "Member has been added successfully!";
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = "Error: Could not add the member.";
            $_SESSION['message_type'] = 'error';
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "Error: Database query could not be prepared.";
        $_SESSION['message_type'] = 'error';
    }

    // কাজ শেষে members.php পেজে রিডাইরেক্ট করা
    header("location:members.php");
    exit();
}


// Update Member Logic
if (isset($_POST['update_member'])) {
    $member_update_id = $_POST['id']; // Hidden field: ID
    $name             = $_POST['name'];
    $designation      = $_POST['designation'];
    $old_image        = $_POST['old_image']; // Hidden field

    // --- Image Handling Logic ---
    $new_image = $_FILES['image']['name'];
    $update_filename = $old_image;

    if ($new_image != "") {
        // 1. যদি নতুন ছবি আপলোড করা হয়
        $image_ext = pathinfo($new_image, PATHINFO_EXTENSION);
        $update_filename = time() . '_member_' . rand(1000, 9999) . '.' . $image_ext;
        $folder = 'uploads/member_images/' . $update_filename;
        $tmpName = $_FILES['image']['tmp_name'];

        move_uploaded_file($tmpName, $folder);

        // পুরনো ছবিটি ডিলিট করা
        $old_image_path = 'uploads/member_images/' . $old_image;
        if (file_exists($old_image_path) && !empty($old_image)) {
            unlink($old_image_path);
        }
    }

    // --- Database Update ---
    $query = "UPDATE `members` SET 
                `name`=?, 
                `designation`=?,         
                `image`=? 
              WHERE `id`=?";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        // প্যারামিটার বাইন্ড করা (s, s, s, i)
        $stmt->bind_param("sssi", $name, $designation, $update_filename, $member_update_id);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Member details have been updated successfully!";
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = "Failed to update member details.";
            $_SESSION['message_type'] = 'error';
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "Error: Database query could not be prepared.";
        $_SESSION['message_type'] = 'error';
    }

    header('location:members.php');
    exit();
}


// Delete Member Logic
if (isset($_GET['member_delete_id'])) {
    $id = $_GET['member_delete_id'];
    $upload_folder = 'uploads/member_images/';

    // --- ধাপ ১: ছবির নামটি খুঁজে বের করা ---
    $select_query = "SELECT image FROM members WHERE id = ?";
    $stmt_select = $mysqli->prepare($select_query);

    $image_filename = "";

    if ($stmt_select) {
        $stmt_select->bind_param("i", $id);
        $stmt_select->execute();
        $stmt_select->bind_result($image_filename);
        $stmt_select->fetch();
        $stmt_select->close();
    }

    // --- ধাপ ২: ডেটাবেস থেকে রো'টি ডিলিট করা ---
    $delete_query = "DELETE FROM members WHERE id = ?";
    $stmt_delete = $mysqli->prepare($delete_query);

    if ($stmt_delete) {
        $stmt_delete->bind_param("i", $id);

        if ($stmt_delete->execute()) {
            // --- ধাপ ৩: সার্ভার থেকে ছবিটি ডিলিট করা ---
            $image_path = $upload_folder . $image_filename;

            if (file_exists($image_path) && !empty($image_filename)) {
                unlink($image_path);
            }

            $_SESSION['message'] = "Member has been deleted successfully!";
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = "Could not delete the member.";
            $_SESSION['message_type'] = 'error';
        }
        $stmt_delete->close();
    } else {
        $_SESSION['message'] = "Error: Database query could not be prepared.";
        $_SESSION['message_type'] = 'error';
    }

    header("location:members.php");
    exit();
}
// ----------------------- members logic end ---------------------


// -----------------------Home About Content Logic (UPDATE ONLY) ---------------------

if (isset($_POST['update_home_about_content'])) {
    // 1. Get Inputs (Title and Content only)
    $title = $_POST['title'];
    $content = $_POST['content'];

    // --- Image Logic Removed ---
    // ইমেজ আপলোড কোড, ফাইল মুভ এবং আনলিংক লজিক সব ডিলিট করা হয়েছে।

    // 2. Update Query (Removed image column)
    $query = "UPDATE `home_about_content` SET 
                `title`=?, 
                `content`=? 
              WHERE `id` = 1";

    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        // Bind parameters: ss -> title, content
        $stmt->bind_param("ss", $title, $content);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Home About Content updated successfully!";
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = "Failed to update content.";
            $_SESSION['message_type'] = 'error';
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "Database Error: " . $mysqli->error;
        $_SESSION['message_type'] = 'error';
    }

    header('location:home-about-content.php');
    exit();
}
// ----------------------- Home About Content Logic End ---------------------


// ----------------------- About Content Logic (UPDATE ONLY) ---------------------

if (isset($_POST['update_about_content'])) {
    // 1. Get Inputs
    $title = $_POST['title'];
    $content = $_POST['description'];

    // আগের ছবিগুলো রাখা (যদি নতুন আপলোড না হয়)
    $old_images_str = $_POST['old_images'];
    $upload_folder = 'uploads/about_images/';

    // 2. Image Processing Logic (Multiple)
    $new_images_str = $old_images_str; // ডিফল্ট হিসেবে পুরনো ছবি থাকবে

    // চেক করা হচ্ছে নতুন কোনো ফাইল সিলেক্ট করা হয়েছে কিনা
    if (isset($_FILES['image']['name']) && $_FILES['image']['name'][0] != "") {

        $uploaded_files = [];
        $file_count = count($_FILES['image']['name']);

        // লুপ চালিয়ে প্রতিটি ছবি আপলোড করা
        for ($i = 0; $i < $file_count; $i++) {
            $file_name = $_FILES['image']['name'][$i];
            $file_tmp = $_FILES['image']['tmp_name'][$i];

            // ইউনিক নাম তৈরি
            $image_ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $unique_filename = time() . '_about_' . rand(1000, 9999) . '_' . $i . '.' . $image_ext;

            if (move_uploaded_file($file_tmp, $upload_folder . $unique_filename)) {
                $uploaded_files[] = $unique_filename;
            }
        }

        // যদি নতুন ছবি সফলভাবে আপলোড হয়
        if (!empty($uploaded_files)) {
            // ১. নতুন ছবির নাম কমা দিয়ে যুক্ত করা
            $new_images_str = implode(',', $uploaded_files);

            // ২. আগের ছবিগুলো সার্ভার থেকে ডিলিট করা (অপশনাল, স্পেস বাঁচাতে চাইলে রাখুন)
            if (!empty($old_images_str)) {
                $old_images_arr = explode(',', $old_images_str);
                foreach ($old_images_arr as $old_img) {
                    if (file_exists($upload_folder . $old_img)) {
                        unlink($upload_folder . $old_img);
                    }
                }
            }
        }
    }

    // 3. Update Query (With Image)
    $query = "UPDATE `about_content` SET 
                `title`=?, 
                `content`=?, 
                `image`=? 
              WHERE `id` = 1";

    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        // Bind parameters: sss -> title, content, image_string
        $stmt->bind_param("sss", $title, $content, $new_images_str);

        if ($stmt->execute()) {
            $_SESSION['message'] = "About Content & Images updated successfully!";
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = "Failed to update content.";
            $_SESSION['message_type'] = 'error';
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "Database Error: " . $mysqli->error;
        $_SESSION['message_type'] = 'error';
    }

    header('location:about-content.php');
    exit();
}
// ----------------------- About Content Logic End ---------------------



// ----------------------- Contact Details Logic (UPDATE ONLY) ---------------------

// --- 1. Update General Contact Info (Phone & Email only) ---
if (isset($_POST['update_general_info'])) {
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $location = $_POST['location'];

    // id=1 এর জন্য আপডেট হবে
    $stmt = $mysqli->prepare("UPDATE contact_details SET phone=?, email=?, location=? WHERE id=1");
    if ($stmt) {
        $stmt->bind_param("sss", $phone, $email, $location);
        if ($stmt->execute()) {
            $_SESSION['message'] = "General info updated!";
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = "Failed to update info.";
            $_SESSION['message_type'] = 'error';
        }
        $stmt->close();
    }
    header('location:contact-info.php');
    exit();
}


// ----------------------- Contact Details Logic End ---------------------



// ----------------------- Admin Profile Logic (UPDATE ONLY) ---------------------

if (isset($_POST['update_profile'])) {
    if (!isset($_SESSION['email'])) {
        header('Location: logout.php');
        exit();
    }
    $session_email = $_SESSION['email']; // বর্তমান সেশন ইমেইল (আইডেন্টিফায়ার হিসেবে)

    // ফর্ম থেকে ডেটা নিন
    $name = $_POST['full_name'];
    $new_email_form = $_POST['email']; // নতুন ইমেইল এড্রেস
    $old_image = $_POST['old_image'];
    $upload_folder = 'uploads/admin_images/';

    $old_password_form = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // --- অতিরিক্ত ধাপ: ইমেইল ইউনিক কি না তা চেক করা ---
    // যদি ইউজার তার ইমেইল পরিবর্তন করতে চায়
    if ($new_email_form !== $session_email) {
        $check_email = $mysqli->prepare("SELECT id FROM admin_login WHERE email = ? AND email != ?");
        $check_email->bind_param("ss", $new_email_form, $session_email);
        $check_email->execute();
        $check_result = $check_email->get_result();

        if ($check_result->num_rows > 0) {
            $_SESSION['message'] = "This email is already taken by another admin.";
            $_SESSION['message_type'] = 'error';
            header('location:my-profile.php');
            exit();
        }
        $check_email->close();
    }

    // --- ধাপ ১: পাসওয়ার্ড আপডেট লজিক (আগের মতোই) ---
    $password_update_query_part = "";
    $password_param = null;

    if (!empty($new_password)) {
        if (empty($old_password_form)) {
            $_SESSION['message'] = "Enter old password to set a new one.";
            $_SESSION['message_type'] = 'error';
            header('location:my-profile.php');
            exit();
        }

        if ($new_password !== $confirm_password) {
            $_SESSION['message'] = "Passwords do not match.";
            $_SESSION['message_type'] = 'error';
            header('location:my-profile.php');
            exit();
        }

        $stmt_pass = $mysqli->prepare("SELECT password FROM admin_login WHERE email = ?");
        $stmt_pass->bind_param("s", $session_email);
        $stmt_pass->execute();
        $db_password_hash = $stmt_pass->get_result()->fetch_assoc()['password'];
        $stmt_pass->close();

        if (password_verify($old_password_form, $db_password_hash)) {
            $password_param = password_hash($new_password, PASSWORD_DEFAULT);
            $password_update_query_part = ", `password` = ?";
        } else {
            $_SESSION['message'] = "Incorrect OLD password.";
            $_SESSION['message_type'] = 'error';
            header('location:my-profile.php');
            exit();
        }
    }

    // --- ধাপ ২: ইমেজ আপলোড লজিক (আগের মতোই) ---
    $update_filename = $old_image;
    if (!empty($_FILES['image']['name'])) {
        $new_image = $_FILES['image']['name'];
        $image_ext = pathinfo($new_image, PATHINFO_EXTENSION);
        $update_filename = time() . '_admin_' . rand(1000, 9999) . '.' . $image_ext;
        if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_folder . $update_filename)) {
            if (file_exists($upload_folder . $old_image) && !empty($old_image)) {
                unlink($upload_folder . $old_image);
            }
        }
    }

    // --- ধাপ ৩: ফাইনাল ডেটাবেস আপডেট (ইমেইল সহ) ---
    // এখানে ইমেইল কলামটি SET এ যোগ করা হয়েছে
    $query = "UPDATE `admin_login` SET `name` = ?, `image` = ?, `email` = ? $password_update_query_part WHERE `email` = ?";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        if ($password_param !== null) {
            // ssss s (name, image, email, password, session_email)
            $stmt->bind_param("sssss", $name, $update_filename, $new_email_form, $password_param, $session_email);
        } else {
            // sss s (name, image, email, session_email)
            $stmt->bind_param("ssss", $name, $update_filename, $new_email_form, $session_email);
        }

        if ($stmt->execute()) {
            $_SESSION['message'] = "Profile updated successfully!";
            $_SESSION['message_type'] = 'success';

            // অত্যন্ত গুরুত্বপূর্ণ: সেশন ডেটা আপডেট করা
            $_SESSION['email'] = $new_email_form;
            $_SESSION['name'] = $name;
        } else {
            $_SESSION['message'] = "Update failed.";
            $_SESSION['message_type'] = 'error';
        }
        $stmt->close();
    }
    header('location:my-profile.php');
    exit();
}
// ----------------------- Admin Profile Logic End ---------------------



// ----------------------- Messages Logic (DELETE ONLY) ---------------------




if (isset($_POST['send_message'])) {
    $recaptcha_secret = "6LcP7zAsAAAAACJeYOtiyANtKb9ET7a06dfqInDm"; // আপনার SECRET KEY
    $recaptcha_response = $_POST['g-recaptcha-response'];

    $verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret={$recaptcha_secret}&response={$recaptcha_response}");
    $response_data = json_decode($verify);

    if (!$response_data->success) {
        $_SESSION['message_sent'] = "Error: Please verify that you are not a robot.";
        header('location:../contact.php');
        exit();
    }
    // 1. ডেটা স্যানিটাইজেশন
    $name    = htmlspecialchars($_POST['name']);
    $email   = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $phone   = htmlspecialchars($_POST['phone']);
    $service = htmlspecialchars($_POST['service']);
    $message = htmlspecialchars($_POST['message']);

    // Admin Email
    $admin_email = 'Carelineofficial@gmail.com';

    // ** New: Reference ID Generation **
    $ref_id = "#VYD-" . date("ymd") . "-" . rand(100, 999);
    $current_year = date("Y");

    // ** Branding Colors **
    $primaryColor = "#6FCFE8";
    $darkColor    = "#111827";
    $lightBg      = "#f3f4f6";

    // ** Updated Fonts **
    $fontHeading  = "'Archivo Black', sans-serif";
    $fontBody     = "'Space Grotesk', sans-serif";
    $fontNav      = "'Montserrat', sans-serif";
    $fontImport   = '<link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Montserrat:wght@700&family=Space+Grotesk:wght@400;500;700&display=swap" rel="stylesheet">';

    // --- Database Insert ---
    $query = "INSERT INTO messages (name, email, phone, service, message) VALUES (?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($query);

    if (!$stmt) {
        $_SESSION['message_sent'] = "Error: Database preparation failed.";
        header('location:../thank-you.php');
        exit();
    }

    if ($stmt->bind_param("sssss", $name, $email, $phone, $service, $message) && $stmt->execute()) {
        $db_insert_success = true;
    } else {
        $db_insert_success = false;
    }
    $stmt->close();

    // --- ইমেল পাঠানো (PHPMailer) ---
    $email_sent_successfully = false;

    try {
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'Carelineofficial@gmail.com';
        $mail->Password   = 'ryyjmcoeqbvzydqu';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;
        $mail->CharSet    = 'UTF-8';

        // **********************************************************
        // A. ইউজার কনফার্মেশন ইমেল
        // **********************************************************
        $mail->setFrom('Carelineofficial@gmail.com', 'Careline Studio');
        $mail->addAddress($email, $name);
        $mail->isHTML(true);
        $mail->Subject = "We received your inquiry regarding {$service} [{$ref_id}]";

        $userBody = "
            <html>
            <head>{$fontImport}</head>
            <body style=\"background-color: {$lightBg}; padding: 40px 0; margin: 0;\">
                <div style=\"max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.05);\">
                    
                    <div style=\"background-color: {$primaryColor}; padding: 30px; text-align: center;\">
                        <h1 style=\"margin: 0; color: #ffffff; font-family: {$fontHeading}; font-size: 24px; letter-spacing: 2px; text-transform: uppercase;\">Careline Studio</h1>
                    </div>

                    <div style=\"padding: 40px; font-family: {$fontBody};\">
                        <h2 style=\"color: {$darkColor}; font-family: {$fontHeading}; margin-top: 0; font-size: 20px; text-transform: uppercase;\">Hello " . ($name) . ",</h2>
                        
                        <p style=\"color: #555; line-height: 1.8; font-size: 15px;\">
                            Thank you for reaching out to us. We confirm that your inquiry regarding <strong>" . ($service) . "</strong> has been received by our architectural team.
                        </p>

                        <p style=\"color: #555; line-height: 1.8; font-size: 15px;\">
                            We are currently reviewing your project details and aim to provide a preliminary response within 24 hours.
                        </p>
                        
                        <div style=\"background-color: #ecfeff; border-left: 4px solid {$primaryColor}; padding: 15px 20px; margin: 30px 0; border-radius: 4px;\">
                            <p style=\"margin: 0; color: #0e7490; font-family: {$fontNav}; font-size: 11px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px;\">Reference ID</p>
                            <p style=\"margin: 5px 0 0 0; color: #155e75; font-size: 20px; font-family: monospace; letter-spacing: 1px;\">{$ref_id}</p>
                            <p style=\"margin: 5px 0 0 0; font-size: 12px; color: #666;\">Please quote this ID in future correspondence.</p>
                        </div>

                        <hr style=\"border: none; border-top: 1px solid #eee; margin: 30px 0;\">
                        
                        <p style=\"margin-bottom: 5px; color: #555; font-size: 14px;\">Best regards,</p>
                        <p style=\"margin-top: 0; font-family: {$fontNav}; font-weight: bold; color: {$darkColor}; text-transform: uppercase; font-size: 13px;\">The Careline Team</p>
                    </div>

                    <div style=\"background-color: #f9fafb; padding: 20px; text-align: center; border-top: 1px solid #eee;\">
                        <p style=\"margin: 0; font-family: {$fontBody}; font-size: 11px; color: #9ca3af;\">© {$current_year} Careline Studio. All rights reserved.</p>
                    </div>
                </div>
            </body>
            </html>
        ";

        $mail->Body = $userBody;
        $mail->send();

        // **********************************************************
        // B. অ্যাডমিন নোটিফিকেশন ইমেল
        // **********************************************************
        $mail->clearAllRecipients();
        $mail->addAddress($admin_email, 'Careline Admin');
        $mail->Subject = "New Lead: " . ($service) . " from " . ($name);

        $adminBody = "
            <html>
            <head>{$fontImport}</head>
            <body style=\"background-color: {$lightBg}; padding: 40px 0; margin: 0;\">
                <div style=\"max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; border: 1px solid #e5e7eb;\">
                    
                    <div style=\"background-color: {$darkColor}; padding: 20px 30px; text-align: left;\">
                        <h2 style=\"margin: 0; color: #ffffff; font-family: {$fontHeading}; font-size: 16px; text-transform: uppercase; letter-spacing: 1px;\">New Inquiry Received</h2>
                    </div>

                    <div style=\"padding: 30px; font-family: {$fontBody};\">
                        <p style=\"color: #555; font-size: 14px; margin-bottom: 20px;\">
                            A new contact form submission has been recorded.
                        </p>

                        <table style=\"width: 100%; border-collapse: collapse; margin-bottom: 20px;\">
                            <tr>
                                <td style=\"padding: 10px; border-bottom: 1px solid #eee; color: #888; width: 35%; font-size: 13px; font-family: {$fontNav}; text-transform: uppercase;\">Reference ID</td>
                                <td style=\"padding: 10px; border-bottom: 1px solid #eee; color: #333; font-weight: bold; font-family: monospace; font-size: 14px;\">{$ref_id}</td>
                            </tr>
                            <tr>
                                <td style=\"padding: 10px; border-bottom: 1px solid #eee; color: #888; font-size: 13px; font-family: {$fontNav}; text-transform: uppercase;\">Client Name</td>
                                <td style=\"padding: 10px; border-bottom: 1px solid #eee; color: #333; font-weight: bold;\">" . ($name) . "</td>
                            </tr>
                            <tr>
                                <td style=\"padding: 10px; border-bottom: 1px solid #eee; color: #888; font-size: 13px; font-family: {$fontNav}; text-transform: uppercase;\">Email</td>
                                <td style=\"padding: 10px; border-bottom: 1px solid #eee; color: {$primaryColor}; font-weight: bold;\">" . ($email) . "</td>
                            </tr>
                            <tr>
                                <td style=\"padding: 10px; border-bottom: 1px solid #eee; color: #888; font-size: 13px; font-family: {$fontNav}; text-transform: uppercase;\">Service</td>
                                <td style=\"padding: 10px; border-bottom: 1px solid #eee; color: #333;\">" . ($service) . "</td>
                            </tr>
                        </table>

                        <div style=\"background-color: #f9fafb; padding: 15px; border-radius: 6px; border: 1px solid #eee;\">
                            <p style=\"margin: 0 0 5px 0; font-family: {$fontNav}; font-size: 11px; color: #888; text-transform: uppercase; letter-spacing: 1px; font-weight:bold;\">Message Content</p>
                            <p style=\"margin: 0; color: #333; line-height: 1.6; font-size: 14px;\">" . nl2br(($message)) . "</p>
                        </div>

                        <div style=\"margin-top: 25px; text-align: center;\">
                            <a href=\"mailto:{$email}\" style=\"background-color: {$primaryColor}; color: #000; padding: 12px 25px; text-decoration: none; border-radius: 4px; font-family: {$fontNav}; font-weight: bold; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;\">Reply to Client</a>
                        </div>
                    </div>
                </div>
            </body>
            </html>
        ";

        $mail->Body = $adminBody;
        $mail->send();
        $email_sent_successfully = true;
    } catch (Exception $e) {
        $email_sent_successfully = false;
    }

    // --- ফাইনাল সেশন মেসেজ সেট করা ---
    if ($db_insert_success) {
        $_SESSION['message_sent'] = "Thank you! Your message has been sent successfully.";
    } else {
        $_SESSION['message_sent'] = "Error: Something went wrong. Please try again later.";
    }

    header("location:../thank-you.php");
    exit();
}
// --- Bulk Delete Logic ---
// --- ২. সিঙ্গেল ডিলিট (Single Delete) ---
if (isset($_GET['message_delete_id'])) {
    $id = intval($_GET['message_delete_id']);
    $query = "DELETE FROM messages WHERE id = ?";
    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            $_SESSION['message'] = "Message deleted successfully!";
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = "Failed to delete message.";
            $_SESSION['message_type'] = 'error';
        }
        $stmt->close();
    }
    header('Location: contact-messages.php');
    exit();
}

// --- বাল্ক ডিলিট লজিক ---
if (isset($_POST['bulk_delete_action'])) {
    if (!empty($_POST['message_ids'])) {
        $ids = $_POST['message_ids'];
        $ids_string = implode(',', array_map('intval', $ids));

        $query = "DELETE FROM messages WHERE id IN ($ids_string)";

        if ($mysqli->query($query)) {
            $_SESSION['message'] = count($ids) . " messages deleted successfully!";
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = "Error deleting messages: " . $mysqli->error;
            $_SESSION['message_type'] = 'error';
        }
    } else {
        $_SESSION['message'] = "Please select at least one message!";
        $_SESSION['message_type'] = 'warning';
    }
    header('Location: contact-messages.php');
    exit();
}

// ----------------------- Messages Logic End ---------------------



// ---------------------- services crud start -----------------------

// --- Add Service Logic  ---
if (isset($_POST['add_service'])) {
    $title       = $_POST['title'];
    $category       = $_POST['category'];
    $description = $_POST['description'];

    // --- Multiple Image Upload Logic ---
    $image_filenames = []; // সব ছবির নাম এখানে জমা হবে

    // চেক করা হচ্ছে কোনো ফাইল সিলেক্ট করা হয়েছে কিনা
    if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {

        $total_files = count($_FILES['images']['name']); // মোট কতগুলো ফাইল

        for ($i = 0; $i < $total_files; $i++) {
            $image_name = $_FILES['images']['name'][$i];
            $tmpName    = $_FILES['images']['tmp_name'][$i];

            // ১. একটি নতুন ইউনিক নাম তৈরি করা
            $image_ext = pathinfo($image_name, PATHINFO_EXTENSION);
            // লুপের মধ্যে ইউনিক নাম নিশ্চিত করতে $i যুক্ত করা হলো
            $unique_image_name = time() . '_' . $i . '_service_' . rand(1000, 9999) . '.' . $image_ext;

            // ২. 'uploads/services_images/' ফোল্ডার
            $folder = 'uploads/services_images/' . $unique_image_name;

            // ৩. ফাইল আপলোড করা
            if (move_uploaded_file($tmpName, $folder)) {
                // সফল হলে অ্যারেতে নাম যোগ করা
                $image_filenames[] = $unique_image_name;
            }
        }
    }

    // ৪. অ্যারে থেকে স্ট্রিং এ কনভার্ট করা (Comma Separated)
    // উদাহরণ: "123_service.jpg,124_service.jpg"
    $image_string = implode(',', $image_filenames);


    // --- Database Insert using Prepared Statements ---
    // আমরা শুধু title, description এবং image ফিল্ডে ডাটা পাঠাবো
    $query = "INSERT INTO services (title, category, description, image) VALUES (?, ?, ?, ?)";

    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        // প্যারামিটার বাইন্ড করা (s, s, s, s) -> title, description, image
        $stmt->bind_param("ssss", $title, $category, $description, $image_string);

        // স্টেটমেন্ট এক্সিকিউট করা
        if ($stmt->execute()) {
            $_SESSION['message'] = "Service added successfully!";
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = "Error: Could not add the service.";
            $_SESSION['message_type'] = 'error';
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "Error: Database query could not be prepared.";
        $_SESSION['message_type'] = 'error';
    }

    // কাজ শেষে services.php পেজে রিডাইরেক্ট করা
    header('location:services.php');
    exit();
}

// --- Update Service Logic  ---
if (isset($_POST['update_service'])) {
    $id = $_POST['id'];
    $old_images_from_form = $_POST['old_image']; // ইউজার যেসব পুরানো ছবি রাখতে চেয়েছে

    // English Data Only
    $title = $_POST['title'];
    $category = $_POST['category'];
    $description = $_POST['description'];

    // --- ধাপ ১: ফোল্ডার ক্লিনআপ লজিক (নতুন কোড) ---
    // আপডেট করার আগে আমরা চেক করব কোন ছবিগুলো ইউজার ডিলিট করে দিয়েছে

    // ১.১ ডাটাবেস থেকে বর্তমান ছবিগুলো আনুন
    $stmt_fetch = $mysqli->prepare("SELECT image FROM services WHERE id = ?");
    $stmt_fetch->bind_param("i", $id);
    $stmt_fetch->execute();
    $result_fetch = $stmt_fetch->get_result();
    $row_fetch = $result_fetch->fetch_assoc();
    $stmt_fetch->close();

    $db_existing_images = [];
    if ($row_fetch && !empty($row_fetch['image'])) {
        $db_existing_images = explode(',', $row_fetch['image']);
    }

    // ১.২ ফর্ম থেকে আসা 'রাখার মতো' ছবিগুলো অ্যারেতে নিই
    $kept_images = [];
    if (!empty($old_images_from_form)) {
        $kept_images = explode(',', $old_images_from_form);
    }

    // ১.৩ তুলনা করুন: ডাটাবেসে ছিল কিন্তু ফর্মে নেই -> মানে ডিলিট করতে হবে
    // array_diff(A, B) মানে A তে আছে কিন্তু B তে নেই
    $images_to_delete = array_diff($db_existing_images, $kept_images);

    // ১.৪ ফোল্ডার থেকে ছবিগুলো ডিলিট করা
    foreach ($images_to_delete as $img_del) {
        $file_path = 'uploads/services_images/' . trim($img_del);
        if (file_exists($file_path)) {
            unlink($file_path); // ফোল্ডার থেকে ফাইল ডিলিট
        }
    }


    // --- ধাপ ২: নতুন ছবি প্রসেসিং এবং ফাইনাল লিস্ট তৈরি ---

    // শুরুতে ফাইনাল লিস্টে সেই ছবিগুলোই থাকবে যা ইউজার রাখতে চেয়েছে
    $final_images_array = $kept_images;

    // চেক করা হচ্ছে নতুন কোনো ছবি আপলোড করা হয়েছে কিনা
    if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {

        $total_files = count($_FILES['images']['name']);
        $new_image_filenames = [];

        for ($i = 0; $i < $total_files; $i++) {
            $image_name = $_FILES['images']['name'][$i];
            $tmpName    = $_FILES['images']['tmp_name'][$i];

            $image_ext = pathinfo($image_name, PATHINFO_EXTENSION);
            // ইউনিক নাম তৈরি
            $unique_image_name = time() . '_' . $i . '_service_' . rand(1000, 9999) . '.' . $image_ext;

            $folder = 'uploads/services_images/' . $unique_image_name;

            if (move_uploaded_file($tmpName, $folder)) {
                $new_image_filenames[] = $unique_image_name;
            }
        }

        // নতুন ছবিগুলো ফাইনাল অ্যারের সাথে যুক্ত করা
        if (!empty($new_image_filenames)) {
            $final_images_array = array_merge($final_images_array, $new_image_filenames);
        }
    }

    // ফাইনাল স্ট্রিং তৈরি
    $final_image_string = implode(',', $final_images_array);


    // --- ধাপ ৩: ডাটাবেস আপডেট ---
    $query = "UPDATE services SET title=?, category=?, description=?, image=? WHERE id=?";

    $stmt = $mysqli->prepare($query);

    if ($stmt) {
        $stmt->bind_param("ssssi", $title, $category, $description, $final_image_string, $id);

        if ($stmt->execute()) {
            $_SESSION['message'] = "Service updated successfully!";
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = "Error updating service.";
            $_SESSION['message_type'] = 'error';
        }
        $stmt->close();
    } else {
        $_SESSION['message'] = "Error: Database query failed.";
        $_SESSION['message_type'] = 'error';
    }

    header('location:services.php');
    exit();
}


// --- Delete Service Logic ---
if (isset($_GET['delete_service_id'])) {
    $id = $_GET['delete_service_id'];

    // --- ধাপ ১: ডাটাবেস থেকে ইমেজের নামগুলো খুঁজে বের করা ---
    $stmt_select = $mysqli->prepare("SELECT image FROM services WHERE id = ?");

    if ($stmt_select) {
        $stmt_select->bind_param("i", $id);
        $stmt_select->execute();
        $result = $stmt_select->get_result();
        $row = $result->fetch_assoc();
        $stmt_select->close();

        // যদি ডাটা পাওয়া যায়
        if ($row) {
            $images_str = $row['image']; // যেমন: "img1.jpg,img2.jpg"

            // --- ধাপ ২: ফোল্ডার থেকে সব ছবি ডিলিট করা ---
            if (!empty($images_str)) {
                // স্ট্রিং ভেঙে অ্যারে তৈরি
                $images_array = explode(',', $images_str);

                foreach ($images_array as $image_name) {
                    $file_path = 'uploads/services_images/' . trim($image_name);

                    // ফাইলটি ফোল্ডারে আছে কিনা চেক করে ডিলিট করা
                    if (file_exists($file_path)) {
                        unlink($file_path);
                    }
                }
            }
        }
    }

    // --- ধাপ ৩: ডাটাবেস থেকে রেকর্ড ডিলিট করা ---
    $stmt_delete = $mysqli->prepare("DELETE FROM services WHERE id = ?");

    if ($stmt_delete) {
        $stmt_delete->bind_param("i", $id);

        if ($stmt_delete->execute()) {
            $_SESSION['message'] = "Service and all associated images deleted successfully!";
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = "Error deleting service.";
            $_SESSION['message_type'] = 'error';
        }
        $stmt_delete->close();
    } else {
        $_SESSION['message'] = "Error: Database query failed.";
        $_SESSION['message_type'] = 'error';
    }

    // কাজ শেষে রিডাইরেক্ট
    header('location:services.php');
    exit();
}
// ---------------------- services crud end -----------------------





// ------------------------ matrics crud start -------------------------


// --- Update Site Metrics ---
if (isset($_POST['update_site_metrics'])) {
    $energy = $_POST['energy_reduction'];
    $leed = $_POST['leed_projects'];
    $net_zero = $_POST['net_zero_buildings'];
    $carbon = $_POST['carbon_committed'];

    $update_query = "UPDATE site_stats SET 
                    energy_reduction = '$energy', 
                    leed_projects = '$leed', 
                    net_zero_buildings = '$net_zero', 
                    carbon_committed = '$carbon' 
                    WHERE id = 1";

    if ($mysqli->query($update_query)) {
        $_SESSION['message'] = "Metrics updated successfully!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Failed to update metrics.";
        $_SESSION['message_type'] = "error";
    }
    header('Location: manage_metrics.php');
    exit();
}

// ------------------------ matrics crud end -------------------------


// ------------------ footer crud start -------------------------

// --- Update Footer Text Logic ---
if (isset($_POST['update_footer_text'])) {
    $footer_description = $mysqli->real_escape_string($_POST['footer_description']);

    $update_query = "UPDATE footer_settings SET footer_description = '$footer_description' WHERE id = 1";

    if ($mysqli->query($update_query)) {
        $_SESSION['message'] = "Footer text updated successfully!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Failed to update footer text.";
        $_SESSION['message_type'] = "error";
    }
    header('Location: manage-footer.php');
    exit();
}


// ------------------ footer crud end -------------------------


// -------------------- social media crud start ----------------



// --- নতুন সোশ্যাল লিঙ্ক অ্যাড করা ---
if (isset($_POST['add_social'])) {
    $platform = mysqli_real_escape_string($mysqli, $_POST['platform_name']);
    $link = mysqli_real_escape_string($mysqli, $_POST['link']);

    $query = "INSERT INTO social_links (platform_name, link) VALUES ('$platform', '$link')";
    if ($mysqli->query($query)) {
        $_SESSION['message'] = "Social link added successfully!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Failed to added social link.";
        $_SESSION['message_type'] = "error";
    }
    header('Location: manage-social.php?add=success');
}

// --- সোশ্যাল লিঙ্ক আপডেট করা ---
if (isset($_POST['update_social'])) {
    $id = mysqli_real_escape_string($mysqli, $_POST['social_id']);
    $platform = mysqli_real_escape_string($mysqli, $_POST['platform_name']);
    $link = mysqli_real_escape_string($mysqli, $_POST['link']);

    $query = "UPDATE social_links SET platform_name='$platform', link='$link' WHERE id='$id'";
    if ($mysqli->query($query)) {
        $_SESSION['message'] = "Social link updated successfully!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Failed to update social link.";
        $_SESSION['message_type'] = "error";
    }
    header('Location: manage-social.php?update=success');
}

// --- সোশ্যাল লিঙ্ক ডিলিট ---
if (isset($_GET['social_delete_id'])) {
    // ১. আইডিটি ইন্টিজারে কনভার্ট করে নেওয়া (সিকিউরিটির জন্য)
    $id = (int)$_GET['social_delete_id'];

    // ২. প্রিপেয়ারড স্টেটমেন্ট তৈরি
    $stmt = $mysqli->prepare("DELETE FROM social_links WHERE id = ?");

    // ৩. 'i' মানে আইডিটি একটি integer
    $stmt->bind_param("i", $id);

    // ৪. কোড রান করা এবং চেক করা
    if ($stmt->execute()) {
        $_SESSION['message'] = "Social link deleted successfully!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Failed to delete social link.";
        $_SESSION['message_type'] = "error";
    }

    $stmt->close();
    header('Location: manage-social.php?deleted=success');
    exit(); // হেডার এর পর সবসময় exit দেওয়া ভালো
}
// -------------------- social media crud end ----------------


// ------------------------- privacy and terms crud start --------------------

// Privacy Update
if (isset($_POST['update_privacy'])) {
    $description = $_POST['privacy_description'];
    $stmt = $mysqli->prepare("UPDATE privacy_policy SET description = ? WHERE id = 1");
    $stmt->bind_param("s", $description);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Privacy Policy Updated!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Error updating Privacy Policy!";
        $_SESSION['message_type'] = "error";
    }
    header("Location: manage_privacy.php");
    exit();
}

// Terms Update
if (isset($_POST['update_terms'])) {
    $description = $_POST['terms_description'];
    $stmt = $mysqli->prepare("UPDATE terms_of_use SET description = ? WHERE id = 1");
    $stmt->bind_param("s", $description);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Terms of Use Updated!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Error updating Terms!";
        $_SESSION['message_type'] = "error";
    }
    header("Location: manage_terms.php");
    exit();
}
// ------------------------- privacy and terms crud end --------------------


// ------------------ category crud start -------------------------


// ১. ক্যাটাগরি অ্যাড করার লজিক
if (isset($_POST['add_category'])) {
    $name = mysqli_real_escape_string($mysqli, $_POST['category_name']);

    if (!empty($name)) {
        $query = "INSERT INTO categories (name) VALUES ('$name')";
        if ($mysqli->query($query)) {
            $_SESSION['message'] = "Category added successfully!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Error adding category.";
            $_SESSION['message_type'] = "error";
        }
    }
    header('Location: manage-categories.php');
    exit();
}

// ২. ক্যাটাগরি ডিলিট করার লজিক
if (isset($_GET['delete_category_id'])) {
    $id = $_GET['delete_category_id'];
    $query = "DELETE FROM categories WHERE id = $id";

    if ($mysqli->query($query)) {
        $_SESSION['message'] = "Category deleted successfully!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Error deleting category.";
        $_SESSION['message_type'] = "error";
    }
    header('Location: manage-categories.php');
    exit();
}
// ------------------ category crud end -------------------------