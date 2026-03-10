  <footer class="bg-[#111827] text-gray-300 py-16">
      <div class="max-w-7xl mx-auto px-6 lg:px-8">
          <div class="grid grid-cols-1 md:grid-cols-4 gap-12 border-b border-gray-800 pb-12 mb-8">
              <div class="col-span-1 md:col-span-1 flex flex-col items-start">
                  <a href="index.php" class="group inline-flex items-center mb-6">
                      <div class="w-48 md:w-56 h-auto ">
                          <img src="img/logo.png" alt="Community Careline Services (Bexley) Ltd"
                              class="w-full h-full object-contain brightness-0 invert">
                      </div>
                  </a>

                  <?php
                    // ১. ডাটাবেস থেকে ফুটার সেটিংস নিয়ে আসা
                    $footer_query = "SELECT footer_description FROM footer_settings LIMIT 1";
                    $footer_result = $mysqli->query($footer_query);
                    $footer_data = $footer_result->fetch_assoc();

                    // ডাটা না থাকলে ডিফল্ট টেক্সট রাখার ব্যবস্থা
                    $footer_desc = !empty($footer_data['footer_description'])
                        ? $footer_data['footer_description']
                        : "Premium home support helping families across the United Kingdom maintain independence and joy.";
                    ?>

                  <p class="text-sm text-gray-400 leading-relaxed max-w-xs font-body">
                      <?php echo htmlspecialchars($footer_desc); ?>
                  </p>
              </div>

              <div>
                  <h4 class="text-white font-bold font-heading mb-4 text-lg">Quick Links</h4>
                  <ul class="space-y-3 text-sm">
                      <li><a href="index.php" class="hover:text-brand transition-colors">Home</a></li>
                      <li><a href="about.php" class="hover:text-brand transition-colors">About Us</a></li>
                      <li><a href="services.php" class="hover:text-brand transition-colors">Our Services</a></li>
                      <li><a href="careers.php" class="hover:text-brand transition-colors">Careers</a></li>
                      <li><a href="contact.php" class="hover:text-brand transition-colors">Contact</a></li>
                  </ul>
              </div>

              <div>
                  <?php
                    // ১. ডাটাবেস থেকে সার্ভিসগুলোর টাইটেল এবং আইডি নিয়ে আসা (লেটেস্ট ৫টি)
                    $footer_services_query = "SELECT id, title FROM services ORDER BY id DESC LIMIT 5";
                    $footer_services_result = $mysqli->query($footer_services_query);
                    ?>

                  <h4 class="text-white font-bold font-heading mb-4 text-lg">Services</h4>
                  <ul class="space-y-3 text-sm">
                      <?php if ($footer_services_result && $footer_services_result->num_rows > 0): ?>
                      <?php while ($f_service = $footer_services_result->fetch_assoc()): ?>
                      <li>
                          <a href="service-details.php?id=<?php echo $f_service['id']; ?>"
                              class="hover:text-brand transition-colors">
                              <?php echo htmlspecialchars($f_service['title']); ?>
                          </a>
                      </li>
                      <?php endwhile; ?>
                      <?php else: ?>
                      <li><a href="services.php" class="hover:text-brand transition-colors">Personal Care</a></li>
                      <li><a href="services.php" class="hover:text-brand transition-colors">Respite Care</a></li>
                      <?php endif; ?>
                  </ul>
              </div>

              <div>
                  <?php
                    // যদি আগে কোথাও contact_details ফেচ করা না থাকে, তবে এই কুয়েরিটি লাগবে
                    $footer_contact_query = "SELECT location, phone, email FROM contact_details ORDER BY id DESC LIMIT 1";
                    $footer_contact_result = $mysqli->query($footer_contact_query);
                    $f_contact = $footer_contact_result->fetch_assoc();

                    // ডাটা হ্যান্ডেলিং
                    $f_phone = !empty($f_contact['phone']) ? $f_contact['phone'] : '01634 853 187';
                    $f_email = !empty($f_contact['email']) ? $f_contact['email'] : 'info@communitycareline.uk';
                    $f_address = !empty($f_contact['location']) ? $f_contact['location'] : 'First floor office, 74 High street, Rainham, Kent, ME8 7JH';
                    ?>

                  <h4 class="text-white font-bold font-heading mb-4 text-lg">Contact Us</h4>
                  <ul class="space-y-3 text-sm">
                      <li class="flex items-center gap-2">
                          <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                          </svg>
                          <a href="tel:<?php echo str_replace(' ', '', $f_phone); ?>"
                              class="hover:text-brand transition-colors">
                              <?php echo htmlspecialchars($f_phone); ?>
                          </a>
                      </li>

                      <li class="flex items-center gap-2">
                          <svg class="w-4 h-4 text-brand" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                          </svg>
                          <a href="mailto:<?php echo htmlspecialchars($f_email); ?>"
                              class="hover:text-brand transition-colors">
                              <?php echo htmlspecialchars($f_email); ?>
                          </a>
                      </li>

                      <li class="flex items-start gap-2">
                          <svg class="w-4 h-4 text-brand mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                          </svg>
                          <span class="leading-relaxed">
                              <?php echo htmlspecialchars($f_address); ?>
                          </span>
                      </li>
                  </ul>
              </div>
          </div>

          <div class="flex flex-col md:flex-row justify-between items-center text-sm text-gray-500">
              <p>
                  ©2021 by Community Careline Services (Medway) Ltd. Proudly created with Wix.com</p>
              <div class="flex space-x-4 mt-4 md:mt-0">
                  <a href="privacy-policy.php" class="hover:text-white transition-colors">Privacy Policy</a>
                  <a href="terms-and-conditions.php" class="hover:text-white transition-colors">Terms & Conditions</a>
              </div>
          </div>
      </div>
  </footer>



  <!-- social media icon -->

  <div class="fixed bottom-8 right-8 z-50">
      <div class="flex justify-center">
          <?php
            // ১. ডাটাবেস থেকে সব একটিভ সোশ্যাল লিংক নিয়ে আসা
            $social_query = "SELECT platform_name, link FROM social_links ORDER BY id ASC";
            $social_result = $mysqli->query($social_query);
            ?>

          <div class="flex flex-col gap-4 bg-white/20 p-2 md:p-0 rounded-full">
              <?php
    if ($social_result && $social_result->num_rows > 0):
        while ($social = $social_result->fetch_assoc()):
            $platform = strtolower(trim($social['platform_name']));
            $link = $social['link'];

            // ডিফল্ট কালার এবং আইকন
            $bg_color = "#666"; 
            $icon_svg = '<i class="fa-solid fa-share-nodes text-xl"></i>';

            // প্ল্যাটফর্ম অনুযায়ী কালার এবং আইকন লজিক
            if ($platform == 'whatsapp') {
                $bg_color = "#25D366";
                $icon_svg = '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 md:w-6 md:h-6" viewBox="0 0 24 24" fill="currentColor"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.451-4.437-9.884-9.888-9.884-5.452 0-9.885 4.434-9.888 9.884.001 2.228.651 4.39 1.849 6.22l-1.072 3.912 3.912-1.074z"/></svg>';
            } elseif ($platform == 'facebook') {
                $bg_color = "#1877F2";
                $icon_svg = '<i class="fa-brands fa-facebook-f text-xl"></i>';
            } elseif ($platform == 'youtube') {
                $bg_color = "#FF0000";
                $icon_svg = '<i class="fa-brands fa-youtube text-xl"></i>';
            } elseif ($platform == 'instagram') {
                $bg_color = "#E4405F";
                $icon_svg = '<i class="fa-brands fa-instagram text-xl"></i>';
            } elseif ($platform == 'telegram') {
                $bg_color = "#26A5E4";
                $icon_svg = '<i class="fa-brands fa-telegram text-xl"></i>';
            } elseif ($platform == 'tiktok') {
                $bg_color = "#000000";
                $icon_svg = '<i class="fa-brands fa-tiktok text-xl"></i>';
            } elseif ($platform == 'twitter' || $platform == 'x') {
                $bg_color = "#1DA1F2"; // X এর জন্য কালো (#000000) দিতে পারেন
                $icon_svg = '<i class="fa-brands fa-x-twitter text-xl"></i>';
            } elseif ($platform == 'linkedin') {
                $bg_color = "#0077B5";
                $icon_svg = '<i class="fa-brands fa-linkedin-in text-xl"></i>';
            }
    ?>
              <a href="<?php echo htmlspecialchars($link); ?>" aria-label="Chat on <?php echo ucwords($platform); ?>"
                  target="_blank" rel="noopener noreferrer"
                  class="w-10 h-10 md:w-12 md:h-12 rounded-full flex items-center justify-center text-white shadow-lg transform hover:scale-110 transition-transform duration-200 ease-in-out"
                  style="background-color: <?php echo $bg_color; ?>;">
                  <?php echo $icon_svg; ?>
              </a>
              <?php
        endwhile;
    endif;
    ?>
          </div>
      </div>
  </div>


  <div id="cookie-banner"
      class="fixed bottom-6 left-6 right-6 lg:left-8 lg:right-auto lg:max-w-md bg-white/95 backdrop-blur-md p-8 rounded-[2rem] shadow-[0_20px_50px_rgba(0,0,0,0.1)] border border-gray-100 z-[9999] hidden transform translate-y-10 opacity-0 transition-all duration-500">

      <div class="flex items-start gap-5">
          <div class="w-16 h-16 bg-brand/10 rounded-2xl flex items-center justify-center flex-shrink-0 animate-pulse">
              <i class="fa-solid fa-cookie-bite text-brand text-3xl"></i>
          </div>

          <div>
              <h4 class="font-heading text-xs font-bold uppercase tracking-[0.2em] text-gray-400 mb-2">
                  Cookie Notice
              </h4>

              <h3 class="font-heading text-xl font-bold text-darkText mb-3">
                  We value your privacy
              </h3>

              <p class="font-body text-sm text-gray-500 leading-relaxed mb-6">
                  We use cookies to enhance your experience and analyze our traffic. By clicking "Accept All", you
                  consent to our use of cookies.
                  <a href="privacy-policy.php" class="text-brand font-bold hover:underline underline-offset-4">
                      Read Policy
                  </a>.
              </p>

              <div class="flex items-center gap-3">
                  <button onclick="acceptCookies()"
                      class="flex-1 bg-brand text-white px-6 py-3.5 text-[11px] font-bold uppercase tracking-widest rounded-xl shadow-lg shadow-brand/20 hover:bg-darkText hover:shadow-none transition-all duration-300 transform active:scale-95">
                      Accept All
                  </button>

                  <button onclick="closeCookieBanner()"
                      class="px-6 py-3.5 text-[11px] font-bold uppercase tracking-widest text-gray-400 hover:text-darkText transition-colors">
                      Decline
                  </button>
              </div>
          </div>
      </div>
  </div>