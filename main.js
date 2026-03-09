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
  const jobCards = document.querySelectorAll(".job-card");

  if (typeFilter && locationFilter) {
    // চেক করছি এই এলিমেন্টগুলো পেইজে আছে কি না
    const filterJobs = () => {
      const selectedType = typeFilter.value.toLowerCase();
      const selectedLocation = locationFilter.value.toLowerCase();

      jobCards.forEach((card) => {
        const cardType = card.getAttribute("data-type").toLowerCase();
        const cardLocation = card.getAttribute("data-location").toLowerCase();

        const typeMatch =
          selectedType === "all" || cardType.includes(selectedType);
        const locationMatch =
          selectedLocation === "all" || cardLocation.includes(selectedLocation);

        card.style.display = typeMatch && locationMatch ? "block" : "none";
      });
    };

    typeFilter.addEventListener("change", filterJobs);
    locationFilter.addEventListener("change", filterJobs);
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
