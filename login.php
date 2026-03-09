<?php include('head.php') ?>

<body
    class="font-body text-gray-600 antialiased bg-lightBg min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">

    <div
        class="max-w-md w-full space-y-8 bg-white p-10 rounded-[2.5rem] shadow-2xl shadow-black/5 border border-gray-100 relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-2 bg-brand"></div>

        <div class="text-center">
            <a href="index.php" class="inline-block mb-6 transition-transform duration-300 hover:scale-105">
                <img class="mx-auto h-20 w-auto object-contain" src="img/logo.png" alt="Community Careline Logo">
            </a>
            <h2 class="text-3xl font-heading font-bold text-darkText tracking-tight">
                Login Page
            </h2>
            <p class="mt-2 text-sm text-gray-400">
                Please sign in to access your dashboard
            </p>
        </div>

        <form class="mt-8 space-y-6" action="dashboard.php" method="POST">
            <div class="rounded-md space-y-4">
                <div>
                    <label for="email-address"
                        class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Email
                        Address</label>
                    <input id="email-address" name="email" type="email" required
                        class="appearance-none relative block w-full px-5 py-4 border border-gray-200 placeholder-gray-400 text-darkText rounded-2xl focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition-all sm:text-sm bg-lightBg/30"
                        placeholder="admin@communitycareline.uk">
                </div>
                <div class="relative">
                    <label for="password"
                        class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2 ml-1">Password</label>
                    <input id="password" name="password" type="password" required
                        class="appearance-none relative block w-full px-5 py-4 border border-gray-200 placeholder-gray-400 text-darkText rounded-2xl focus:outline-none focus:ring-2 focus:ring-brand/20 focus:border-brand transition-all sm:text-sm bg-lightBg/30"
                        placeholder="••••••••">
                </div>
            </div>



            <div>
                <button type="submit"
                    class="group relative w-full flex justify-center py-4 px-4 border border-transparent text-sm font-bold rounded-2xl text-white bg-brand hover:bg-brandDark shadow-[0_15px_30px_-5px_rgba(0,0,0,0.25)] hover:shadow-[0_20px_40px_-5px_rgba(0,0,0,0.35)] transition-all duration-300 transform hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <svg class="h-5 w-5 text-white/50 group-hover:text-white/80 transition-colors"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                    Sign in to Portal
                </button>
            </div>
        </form>

        <div class="text-center mt-6">
            <p class="text-xs text-gray-400">
                &copy; 2026 Community Careline Services (Bexley) Ltd. <br>
                All rights reserved. Secure staff access only.
            </p>
        </div>
    </div>

</body>

</html>