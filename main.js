document.addEventListener("DOMContentLoaded", function () {
  // ==========================================
  // ১. Mobile Menu Toggle Logic
  // ==========================================
  const mobileMenuBtn = document.getElementById("mobile-menu-btn");
  const mobileMenu = document.getElementById("mobile-menu");
  const menuIcon = document.getElementById("menu-icon");

  if (mobileMenuBtn && mobileMenu) {
    mobileMenuBtn.addEventListener("click", () => {
      mobileMenu.classList.toggle("hidden");

      // আইকন চেঞ্জ করা (Hamburger থেকে Cross)
      if (mobileMenu.classList.contains("hidden")) {
        menuIcon.setAttribute("d", "M4 6h16M4 12h16M4 18h16"); // 3 lines
      } else {
        menuIcon.setAttribute("d", "M6 18L18 6M6 6l12 12"); // X mark
      }
    });
  }

  // ==========================================
  // ২. Hero Slider Logic
  // ==========================================
  const slides = document.querySelectorAll(".slide");
  const dots = document.querySelectorAll(".slide-dot");

  if (slides.length > 0) {
    let currentSlide = 0;
    const totalSlides = slides.length;

    function showSlide(index) {
      // সব স্লাইড লুকিয়ে ফেলা
      slides.forEach((slide) => {
        slide.classList.remove("opacity-100", "z-10");
        slide.classList.add("opacity-0", "z-0");
      });

      // সব ডট রিসেট করা
      dots.forEach((dot) => {
        dot.classList.remove("bg-brand", "w-8");
        dot.classList.add("bg-white/50", "w-3");
      });

      // বর্তমান স্লাইড দেখানো
      slides[index].classList.remove("opacity-0", "z-0");
      slides[index].classList.add("opacity-100", "z-10");

      // বর্তমান ডট অ্যাকটিভ করা
      if (dots[index]) {
        dots[index].classList.remove("bg-white/50", "w-3");
        dots[index].classList.add("bg-brand", "w-8");
      }
    }

    function nextSlide() {
      currentSlide = (currentSlide + 1) % totalSlides;
      showSlide(currentSlide);
    }

    // প্রতি ৫ সেকেন্ডে অটো স্লাইড হবে
    let slideInterval = setInterval(nextSlide, 5000);

    // ডটে ক্লিক করলে নির্দিষ্ট স্লাইডে যাওয়া
    dots.forEach((dot, index) => {
      dot.addEventListener("click", () => {
        clearInterval(slideInterval); // ক্লিক করলে অটো স্লাইড একটু পজ হবে
        currentSlide = index;
        showSlide(currentSlide);
        slideInterval = setInterval(nextSlide, 5000); // আবার অটো স্লাইড শুরু হবে
      });
    });
  }
});

// Job Filtering Logic
document.addEventListener("DOMContentLoaded", function () {
  // --- ১. ক্যারিয়ার ফিল্টার লজিক ---
const typeFilter = document.getElementById("filter-type");
const locationFilter = document.getElementById("filter-location");
const resetButton = document.getElementById("reset-filters");
const jobCards = document.querySelectorAll(".job-card");
const noResults = document.getElementById("no-results");

const filterJobs = () => {
  const selectedType = typeFilter.value.toLowerCase();
  const selectedLocation = locationFilter.value.toLowerCase();
  let visibleCount = 0;

  jobCards.forEach((card) => {
    const cardType = card.getAttribute("data-type").toLowerCase();
    const cardLocation = card.getAttribute("data-location").toLowerCase();

    const typeMatch = selectedType === "all" || cardType === selectedType;
    const locationMatch =
      selectedLocation === "all" || cardLocation === selectedLocation;

    if (typeMatch && locationMatch) {
      card.style.display = "block";
      visibleCount++;
    } else {
      card.style.display = "none";
    }
  });

  // রেজাল্ট না থাকলে মেসেজ দেখানো
  if (visibleCount === 0) {
    noResults.classList.remove("hidden");
  } else {
    noResults.classList.add("hidden");
  }
};

// ইভেন্ট লিসেনার
if (typeFilter) typeFilter.addEventListener("change", filterJobs);
if (locationFilter) locationFilter.addEventListener("change", filterJobs);

// রিসেট বাটন ফিক্স
if (resetButton) {
  resetButton.addEventListener("click", function () {
    typeFilter.value = "all";
    locationFilter.value = "all";
    filterJobs(); // ভ্যালু 'all' করে আবার ফিল্টার কল করা হলো
  });
}

  // --- ২. ব্লগ ফিল্টার লজিক ---
  const filterBtns = document.querySelectorAll(".filter-btn");
  const blogCards = document.querySelectorAll(".blog-card");
  const postCount = document.getElementById("post-count");

  if (filterBtns.length > 0) {
    // চেক করছি ব্লগের বাটনগুলো পেইজে আছে কি না
    filterBtns.forEach((btn) => {
      btn.addEventListener("click", () => {
        // বাটন স্টাইল আপডেট
        filterBtns.forEach((b) => {
          b.classList.remove(
            "bg-brand",
            "text-white",
            "shadow-lg",
            "shadow-brand/20",
            "border-brand",
          );
          b.classList.add("bg-white", "text-darkText", "border-gray-200");
        });

        btn.classList.remove("bg-white", "text-darkText", "border-gray-200");
        btn.classList.add(
          "bg-brand",
          "text-white",
          "shadow-lg",
          "shadow-brand/20",
          "border-brand",
        );

        const filter = btn.getAttribute("data-filter");
        let visibleCount = 0;

        blogCards.forEach((card) => {
          const category = card.getAttribute("data-category");
          if (filter === "all" || category === filter) {
            card.style.display = "flex";
            visibleCount++;
          } else {
            card.style.display = "none";
          }
        });

        if (postCount) postCount.textContent = visibleCount;
      });
    });
  }
});

// contact map

// const mapBtn = document.getElementById("map-switch-btn");
// const normalMap = document.getElementById("normal-map");
// const streetMap = document.getElementById("street-view-map");
// const btnText = document.getElementById("btn-text");
// const btnSub = document.getElementById("btn-subtext");

// if (mapBtn) {
//   let isStreetView = false;
//   mapBtn.addEventListener("click", () => {
//     if (!isStreetView) {
//       // Switch to Street View
//       normalMap.classList.add("opacity-0", "pointer-events-none");
//       streetMap.classList.remove("opacity-0", "pointer-events-none");
//       btnText.innerText = "Back to Regular Map";
//       btnSub.innerText = "Location View";
//       isStreetView = true;
//     } else {
//       // Switch back to Normal Map
//       streetMap.classList.add("opacity-0", "pointer-events-none");
//       normalMap.classList.remove("opacity-0", "pointer-events-none");
//       btnText.innerText = "Switch to Street View";
//       btnSub.innerText = "Interactive";
//       isStreetView = false;
//     }
//   });
// }

// about faq

document.querySelectorAll(".faq-btn").forEach((button) => {
  button.addEventListener("click", () => {
    const accordionItem = button.parentElement;
    const answer = button.nextElementSibling;
    const icon = button.querySelector(".faq-icon");

    // Close other items
    document.querySelectorAll(".faq-answer").forEach((item) => {
      if (item !== answer) {
        item.style.maxHeight = null;
        item.parentElement.classList.remove("border-brand/30", "shadow-lg");
        item.previousElementSibling.querySelector(".faq-icon").style.transform =
          "rotate(0deg)";
      }
    });

    // Toggle current item
    if (answer.style.maxHeight) {
      answer.style.maxHeight = null;
      accordionItem.classList.remove("border-brand/30", "shadow-lg");
      icon.style.transform = "rotate(0deg)";
    } else {
      answer.style.maxHeight = answer.scrollHeight + "px";
      accordionItem.classList.add("border-brand/30", "shadow-lg");
      icon.style.transform = "rotate(180deg)";
    }
  });
});


// testimonial
function openTestimonialModal(name, designation, description) {
  const modal = document.getElementById("testiModal");
  const modalContent = document.getElementById("modalContent");
  const marquee = document.querySelector(".animate-marquee"); // স্লাইডার সিলেক্ট করা

  // ১. স্লাইডার পজ করা
  if (marquee) {
    marquee.style.animationPlayState = "paused";
  }

  // ২. ডাটা সেট করা
  document.getElementById("modalName").innerText = name;
  document.getElementById("modalDesignation").innerText = designation;
  document.getElementById("modalDes").innerText = `"${description}"`;

  const initials = name
    .split(" ")
    .map((n) => n[0])
    .join("")
    .toUpperCase()
    .substring(0, 2);
  document.getElementById("modalInitials").innerText = initials;

  // ৩. মডাল দেখানো (এটি এখন <body> এর চাইল্ড হবে যাতে ব্লার ঠিকঠাক কাজ করে)
  modal.classList.remove("hidden");
  modal.classList.add("flex");

  setTimeout(() => {
    modalContent.classList.remove("scale-95", "opacity-0");
    modalContent.classList.add("scale-100", "opacity-100");
  }, 10);
}

function closeTestimonialModal() {
  const modal = document.getElementById("testiModal");
  const modalContent = document.getElementById("modalContent");
  const marquee = document.querySelector(".animate-marquee");

  modalContent.classList.remove("scale-100", "opacity-100");
  modalContent.classList.add("scale-95", "opacity-0");

  setTimeout(() => {
    modal.classList.remove("flex");
    modal.classList.add("hidden");
    // স্লাইডার আবার চালু করা
    if (marquee) {
      marquee.style.animationPlayState = "running";
    }
  }, 300);
}

// বাইরের জায়গায় ক্লিক করলে মডাল ক্লোজ হবে
window.onclick = function(event) {
    const modal = document.getElementById('testiModal');
    if (event.target == modal) {
        closeTestimonialModal();
    }
}



// ১. কুকি সেট করার হেল্পার ফাংশন
// ১. কুকি সেট করার হেল্পার ফাংশন
function setCookie(name, value, days) {
    let expires = "";
    if (days) {
        let date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "") + expires + "; path=/; SameSite=Lax";
}

// ২. কুকি গেট করার হেল্পার ফাংশন
function getCookie(name) {
    let nameEQ = name + "=";
    let ca = document.cookie.split(';');
    for(let i=0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

// ৩. কুকি একসেপ্ট করার ফাংশন
function acceptCookies() {
    // ১ বছরের জন্য কুকি সেট করা
    setCookie("careline_consent", "accepted", 365);
    
    const banner = document.getElementById("cookie-banner");
    if (banner) {
        // স্মুথ এক্সিট এনিমেশন
        banner.classList.add("translate-y-10", "opacity-0");
        setTimeout(() => {
            banner.classList.add("hidden");
        }, 500);
    }
}

// ৪. ডিক্লাইন বা ক্লোজ করার ফাংশন
function closeCookieBanner() {
    const banner = document.getElementById("cookie-banner");
    if (banner) {
        banner.classList.add("translate-y-10", "opacity-0");
        setTimeout(() => {
            banner.classList.add("hidden");
        }, 500);
    }
}

// ৫. পেজ লোড হওয়ার ২ সেকেন্ড পর ব্যানার দেখানোর লজিক
document.addEventListener("DOMContentLoaded", function () {
    const consent = getCookie("careline_consent");

    // যদি কুকি না পাওয়া যায়, তবেই ২ সেকেন্ড পর ব্যানার দেখাবে
    if (!consent) {
        setTimeout(function () {
            const banner = document.getElementById("cookie-banner");
            if (banner) {
                // হিডেন রিমুভ করে এনিমেশন স্টার্ট করা
                banner.classList.remove("hidden");
                // অল্প ডিলে দিয়ে ট্রানজিশন ট্রিগার করা (Tailwind transition এর জন্য)
                setTimeout(() => {
                    banner.classList.remove("translate-y-10", "opacity-0");
                    banner.classList.add("translate-y-0", "opacity-100");
                }, 100);
            }
        }, 2000); 
    }
});