<?php
include('db.php'); // db.php-তে session_start() আছে

if (isset($_SESSION['id']) && !empty($_SESSION['id'])) {
    // যদি লগইন করা থাকে, তাহলে ড্যাশবোর্ডে রিডাইরেক্ট করুন
    header('Location: index.php');
    exit;
}

// --- ধাপ ১: এরর এবং পুরনো ইনপুট সেশন থেকে ভেরিয়েবলে নেওয়া ---
$errors = $_SESSION['errors'] ?? [];
$old_input = $_SESSION['old_input'] ?? [];

// --- ধাপ ২: সেশন মুছে ফেলা যাতে রিফ্রেশ করলে এরর চলে যায় ---
unset($_SESSION['errors']);
unset($_SESSION['old_input']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('head.php') ?>
    <title>Admin Panel Login - Careline</title>
</head>

<body class="bg-gray-100 font-body">
    <div class="flex min-h-screen items-center justify-center p-4">

        <div class="w-full max-w-4xl" data-aos="fade-up">

            <div class="flex flex-col lg:flex-row bg-white rounded-xl shadow-2xl overflow-hidden">

                <div class="w-full lg:w-1/2 p-8 md:p-12">

                    <div class="text-center mb-8">
                        <a href="../index.php"><img src="../img/logo.png" alt="Logo" class="w-auto h-16 mx-auto mb-4"></a>
                        <h2 class="text-2xl md:text-3xl font-bold font-heading text-gray-800">Admin Login</h2>
                    </div>

                    <form action="logics.php" method="POST" class="space-y-6 font-body">

                        <div>
                            <label for="email" class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-widest">Email Address</label>
                            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($old_input['email'] ?? ''); ?>" class="w-full px-4 py-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end focus:border-transparent font-body" placeholder="admin@example.com" required>
                        </div>

                        <?php if (isset($errors['email'])): ?>
                            <p class="text-red-600 text-xs -mt-2 ml-1 font-bold font-body"><?php echo $errors['email']; ?></p>
                        <?php endif; ?>

                        <div>
                            <label for="password" class="block text-xs font-bold text-gray-700 mb-2 uppercase tracking-widest">Password</label>
                            <div class="relative">
                                <input type="password" id="password" name="password" class="w-full px-4 py-3 border rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-primary-end focus:border-transparent font-body" placeholder="••••••••" required>

                                <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-600 hover:text-primary-start">
                                    <svg id="eye-icon" class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639l4.43-4.43a1.012 1.012 0 011.619 0l4.43 4.43c.243.243.243.638 0 .882l-4.43 4.43a1.012 1.012 0 01-1.619 0l-4.43-4.43z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    <svg id="eye-slash-icon" class="w-5 h-5 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <?php if (isset($errors['password'])): ?>
                            <p class="text-red-600 text-xs -mt-2 ml-1 font-bold font-body"><?php echo $errors['password']; ?></p>
                        <?php endif; ?>

                        <div>
                            <button type="submit" name="admin_login" class="font-nav w-full flex justify-center items-center bg-gradient-to-r from-primary-start to-primary-end text-white px-6 py-4 rounded-lg shadow-lg hover:from-primary-end hover:to-primary-start transition-all duration-300 font-bold text-sm uppercase tracking-widest">
                                Login to Dashboard
                            </button>
                        </div>

                    </form>
                </div>

                <div class="hidden lg:block lg:w-1/2 relative">
                    <img src="https://images.unsplash.com/photo-1516321318423-f06f85e504b3?crop=entropy&cs=tinysrgb&fit=max&fm=jpg&ixid=M3wzNzk1NnwwfDF8c2VhcmNofDE4fHx3b3JrJTIwbGFwdG9wfGVufDB8fHx8MTczMTcwNjY0NXww&ixlib=rb-4.0.3&q=80&w=800" alt="Login Background" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black/40 p-8 flex flex-col justify-end">
                        <h2 class="text-3xl md:text-4xl font-bold font-heading text-white leading-tight">
                            Welcome Back <br> Admin Panel
                        </h2>
                        <p class="text-white/80 mt-4 font-body text-sm leading-relaxed">
                            Authorized personnel only. Please login to manage your content and monitor performance.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
        });

        // Show/Hide Password Logic
        const togglePassword = document.getElementById('togglePassword');
        const password = document.getElementById('password');
        const eyeIcon = document.getElementById('eye-icon');
        const eyeSlashIcon = document.getElementById('eye-slash-icon');

        togglePassword.addEventListener('click', function(e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            eyeIcon.classList.toggle('hidden');
            eyeSlashIcon.classList.toggle('hidden');
        });
    </script>
</body>

</html>