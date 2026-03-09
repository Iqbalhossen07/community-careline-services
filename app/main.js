// === Sidebar Toggle Logic (Updated for Bottom Menu) ===
const sidebar = document.getElementById("sidebar");
// আপনার বিদ্যমান টগল বাটন (যদি এখনও ড্যাশবোর্ডে থাকে)
const menuToggle = document.getElementById("menu-toggle");
const sidebarClose = document.getElementById("sidebar-close");
// নিচের মোবাইল মেনুবারের বাটন আইডি
const mobileMenuOpenButton = document.getElementById("mobile-menu-open");

// ফাংশন যা সাইডবারকে টগল করবে
const toggleSidebar = () => {
  if (sidebar) {
    // যদি সাইডবার বর্তমানে লুকানো থাকে, তাহলে দেখাও
    if (sidebar.classList.contains("-translate-x-full")) {
      sidebar.classList.remove("-translate-x-full");
      sidebar.classList.add("translate-x-0");
    } else {
      // অন্যথায়, লুকাও
      sidebar.classList.remove("translate-x-0");
      sidebar.classList.add("-translate-x-full");
    }
  }
};

// 1. বটম মেনুবার বাটন থেকে সাইডবার টগল
if (mobileMenuOpenButton) {
  mobileMenuOpenButton.addEventListener("click", toggleSidebar);
}

// 2. ড্যাশবোর্ড মেনু টগল (যদি ব্যবহৃত হয়)
if (menuToggle) {
  menuToggle.addEventListener("click", toggleSidebar);
}

// 3. সাইডবার ক্লোজ বাটন
if (sidebarClose) {
  sidebarClose.addEventListener("click", function () {
    if (sidebar) {
      sidebar.classList.remove("translate-x-0");
      sidebar.classList.add("-translate-x-full");
    }
  });
}

// === AOS Initialization ===
AOS.init({
  duration: 800,
  once: true,
});

// === Single Image Preview Logic (for Add/Edit pages) ===
const fileUpload = document.getElementById("file-upload");
const newImagePreview = document.getElementById("image-preview-new");
const currentImagePreview = document.getElementById("current-image-preview");

if (fileUpload) {
  fileUpload.addEventListener("change", function (event) {
    const file = event.target.files[0];
    if (file) {
      const reader = new FileReader();

      reader.onload = function (e) {
        if (newImagePreview) {
          newImagePreview.src = e.target.result;
          newImagePreview.classList.remove("hidden");
        }
        if (currentImagePreview) {
          currentImagePreview.src = e.target.result;
        }
      };

      reader.readAsDataURL(file);
    }
  });
}

// === নতুন: Modal Toggling Logic (for Gallery page) ===

// সব মডাল টগল বাটন সিলেক্ট করা
document.querySelectorAll("[data-modal-toggle]").forEach((button) => {
  button.addEventListener("click", () => {
    const modalId = button.getAttribute("data-modal-toggle");
    const modal = document.getElementById(modalId);
    if (modal) {
      modal.classList.remove("hidden");
    }
  });
});

// সব মডাল ক্লোজ বাটন সিলেক্ট করা
document.querySelectorAll("[data-modal-close]").forEach((button) => {
  button.addEventListener("click", () => {
    const modalId = button.getAttribute("data-modal-close");
    const modal = document.getElementById(modalId);
    if (modal) {
      modal.classList.add("hidden");
    }
  });
});

// মডালের বাইরে ক্লিক করলে মডাল বন্ধ করা
document.querySelectorAll(".modal").forEach((modal) => {
  modal.addEventListener("click", (event) => {
    // event.target হলো যেখানে ক্লিক করা হয়েছে
    // event.currentTarget হলো .modal div
    if (event.target === event.currentTarget) {
      modal.classList.add("hidden");
    }
  });
});

// === নতুন: Multiple Image Preview Logic (for Gallery Add Modal) ===
const multiFileUpload = document.getElementById("file-upload-multiple");
const previewContainer = document.getElementById("image-preview-container");

if (multiFileUpload && previewContainer) {
  multiFileUpload.addEventListener("change", function (event) {
    // নতুন ফাইল সিলেক্ট করলে আগের প্রিভিউ মুছে ফেলা
    previewContainer.innerHTML = "";

    const files = event.target.files;

    if (files) {
      Array.from(files).forEach((file) => {
        if (file.type.startsWith("image/")) {
          const reader = new FileReader();

          reader.onload = function (e) {
            // প্রতিটি ছবির জন্য একটি div ও img ট্যাগ তৈরি করা
            const imgWrapper = document.createElement("div");
            imgWrapper.className =
              "relative w-full h-24 rounded overflow-hidden shadow";

            const img = document.createElement("img");
            img.src = e.target.result;
            img.className = "w-full h-full object-cover";

            imgWrapper.appendChild(img);
            previewContainer.appendChild(imgWrapper);
          };

          reader.readAsDataURL(file);
        }
      });
    }
  });
}

// Initialize CKEditor
ClassicEditor.create(document.querySelector("#textarea-description")).catch(
  (error) => {
    console.error(error);
  }
);

//  time 

 function updateUKClock() {
        const timeElement = document.getElementById('liveTime');
        const dateElement = document.getElementById('liveDate');
        
        // বর্তমান সময় নেওয়া এবং লন্ডনের টাইমজোনে কনভার্ট করা
        const now = new Date();
        
        // Time Options
        const timeOptions = { 
            timeZone: 'Europe/London', 
            hour: '2-digit', 
            minute: '2-digit', 
            second: '2-digit', 
            hour12: true 
        };
        
        // Date Options
        const dateOptions = { 
            timeZone: 'Europe/London', 
            weekday: 'long', 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric' 
        };

        // Format Time & Date
        const timeString = now.toLocaleTimeString('en-US', timeOptions);
        const dateString = now.toLocaleDateString('en-US', dateOptions);

        // Update HTML
        if(timeElement) timeElement.innerText = timeString;
        if(dateElement) dateElement.innerText = dateString;
    }

    // প্রতি সেকেন্ডে (1000ms) আপডেট হবে
    setInterval(updateUKClock, 1000);


document.addEventListener("DOMContentLoaded", function() {
    // আপনার একটিভ মেনুর ক্লাস হলো 'bg-sky-100' অথবা 'text-primary-end'
    // আমরা সেই এলিমেন্টটিকে খুঁজে বের করছি
    const activeMenu = document.querySelector('.bg-sky-100');

    if (activeMenu) {
        // সাইডবারটিকে স্ক্রল করে একটিভ মেনুর পজিশনে নিয়ে যাওয়া হচ্ছে
        activeMenu.scrollIntoView({
            behavior: 'auto', // সাথে সাথে যাবে, চাইলে 'smooth' দিতে পারেন
            block: 'nearest'  // এটি মেনুটিকে ভিউপোর্টের ভেতরে আনবে
        });
    }
});

document.addEventListener("DOMContentLoaded", () => {
    const dropdownTrigger = document.getElementById("admin-dropdown-trigger");
    const dropdownMenu = document.getElementById("admin-dropdown-menu");

    if (dropdownTrigger && dropdownMenu) {
        // ক্লিক করলে টগল হবে
        dropdownTrigger.addEventListener("click", (e) => {
            e.stopPropagation();
            dropdownMenu.classList.toggle("hidden");
        });

        // বাইরে ক্লিক করলে বন্ধ হবে
        document.addEventListener("click", (e) => {
            if (!dropdownTrigger.contains(e.target)) {
                dropdownMenu.classList.add("hidden");
            }
        });
    }
});