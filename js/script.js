console.log("JS connected");

document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("searchForm");
    const result = document.getElementById("result");

    if (!form) return;

    form.addEventListener("submit", function (event) {
        event.preventDefault();

        let idInput = document.getElementById("searchInput");

        if (!idInput) return;

        let id = idInput.value.trim();

        if (id === "123456789") {

            result.innerHTML = (lang === "ar")
                ? "طلبك قيد المراجعة"
                : "Your request is pending";

        } else if (id === "987654321") {

            result.innerHTML = (lang === "ar")
                ? "تم قبول الطلب"
                : "Request approved";

        } else if (id === "111111111") {

            result.innerHTML = (lang === "ar")
                ? "تم رفض الطلب"
                : "Request rejected";

        } else {

            result.innerHTML = (lang === "ar")
                ? "لا يوجد طلب بهذا الرقم"
                : "No request found with this ID";
        }
    });

    window.toggleLangMenu = function () {
        document.getElementById("langMenu").classList.toggle("show");
    };

    document.addEventListener("click", function (e) {

        const menu = document.getElementById("langMenu");
        const btn = document.querySelector(".lang-btn");

        if (menu && btn &&
            !menu.contains(e.target) &&
            !btn.contains(e.target)) {

            menu.classList.remove("show");
        }
    });

    flatpickr(".date-picker", {
        dateFormat: "Y-m-d",
        locale: (lang === "ar") ? "ar" : "default"
    });

});
document.addEventListener("DOMContentLoaded", function () {
    const navbar = document.querySelector('.navbar');
    
    window.addEventListener('scroll', function () {
        if (window.scrollY > 50) {
            navbar.style.padding = "10px 5%";
            navbar.style.boxShadow = "0 4px 25px rgba(24, 76, 56, 0.15)";
            navbar.style.backgroundColor = "#fafdfb"; 
        } else {
            navbar.style.padding = "15px 5%";
            navbar.style.boxShadow = "0 4px 20px rgba(24, 76, 56, 0.08)";
            navbar.style.backgroundColor = "#ffffff";
        }
    });
});
document.addEventListener("DOMContentLoaded", function() {
    
    document.querySelectorAll('.video-wrapper').forEach(wrapper => {
        const video = wrapper.querySelector('.clickable-video');
        const audioBtn = wrapper.querySelector('.video-audio-btn i');

        if (wrapper && video && audioBtn) {
            wrapper.addEventListener('click', function() {
                if (video.muted) {
                    video.muted = true;
                    audioBtn.className = 'fa-solid fa-volume-high'; 
                } else {
                    video.muted = true;
                    audioBtn.className = 'fa-solid fa-volume-xmark'; 
                }
            });
        }
    });

});


const currentLang = document.documentElement.lang === 'en' ? 'en' : 'ar';

const offersData = {
    summer: {
        title: currentLang === 'ar' ? '☀️ خصومات الصيف' : '☀️ Summer Discounts',
        desc: currentLang === 'ar' ? 'عروض صيفية مميزة وخصومات تصل إلى 30% على أجمل الرحلات السياحية الشاطئية والعائلية.' : 'Special summer offers with up to 30% discount on the best beach and family travel packages.',
        priceLabel: currentLang === 'ar' ? 'السعر المخفض:' : 'Price:',
        price: "250$",
        images: ['summer1.jpg', 'summer2.jpg', 'summer3.jpg', 'summer4.jpg', 'summer5.jpg']
    },
    dubai: {
        title: currentLang === 'ar' ? '✈️ رحلات دبي الفاخرة' : '✈️ Luxury Dubai Trips',
        desc: currentLang === 'ar' ? 'استمتع بأفضل الرحلات والعروض الفاخرة إلى دبي مع فنادق مميزة وأسعار خاصة شاملة كافة الخدمات.' : 'Enjoy the best luxury travel deals to Dubai with premium hotels and special all-inclusive prices.',
        priceLabel: currentLang === 'ar' ? 'تبدأ من:' : 'Starts from:',
        price: "350$",
        images: ['dubai1.jpg', 'dubai2.jpg', 'dubai3.jpg', 'dubai4.jpg', 'dubai5.jpg']
    },
    europe: {
        title: currentLang === 'ar' ? '🇪🇺 رحلات أوروبا الفاخرة' : '🇪🇺 Luxury Europe Trips',
        desc: currentLang === 'ar' ? 'اكتشف سحر العواصم الأوروبية العريقة مع جولاتنا السياحية المنظمة وخصوماتنا الحصرية على الفنادق المميزة.' : 'Discover the magic of historic European capitals with our organized tours and exclusive discounts on premium hotels.',
        priceLabel: currentLang === 'ar' ? 'تبدأ جولاتنا من:' : 'Our tours start from:',
        price: "590$",
        images: ['europe1.jpg', 'europe2.jpg', 'europe3.jpg', 'europe4.jpg', 'europe5.jpg']
    }
};

let currentCategory = 'summer';
let currentSlideIndex = 0;
let autoSliderInterval;

function loadSliderImages() {
    const container = document.getElementById('imageSlider');
    if (!container) return;
    
    container.innerHTML = '';
    const images = offersData[currentCategory].images;
    
    images.forEach((img, index) => {
        const imgElement = document.createElement('img');
        imgElement.src = `../assets/images/${img}`;
        imgElement.className = `offerSlide ${index === 0 ? 'active' : ''}`;
        imgElement.alt = currentCategory;
        container.appendChild(imgElement);
    });
    currentSlideIndex = 0;
}

function switchCategory(category) {
    currentCategory = category;
    
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
    
    if (event && event.target) {
        event.target.classList.add('active');
    }
    
    document.getElementById('offerTitle').innerText = offersData[category].title;
    document.getElementById('offerDesc').innerText = offersData[category].desc;
    document.getElementById('priceLabel').innerText = offersData[category].priceLabel;
    document.getElementById('offerPrice').innerText = offersData[category].price;
    
    loadSliderImages();
    resetAutoSlider();
}

function showSlide(index) {
    const slides = document.querySelectorAll(".offerSlide");
    if (slides.length === 0) return;
    slides.forEach(slide => slide.classList.remove("active"));
    slides[index].classList.add("active");
}

function nextSlide() {
    const slides = document.querySelectorAll(".offerSlide");
    if (slides.length === 0) return;
    currentSlideIndex = (currentSlideIndex + 1) % slides.length;
    showSlide(currentSlideIndex);
}

function prevSlide() {
    const slides = document.querySelectorAll(".offerSlide");
    if (slides.length === 0) return;
    currentSlideIndex = (currentSlideIndex - 1 + slides.length) % slides.length;
    showSlide(currentSlideIndex);
}

function resetAutoSlider() {
    clearInterval(autoSliderInterval);
    autoSliderInterval = setInterval(nextSlide, 5000);
}

document.addEventListener("DOMContentLoaded", function() {
    loadSliderImages();
    resetAutoSlider();
});
function switchAuthTab(tabName) {
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
    document.querySelectorAll('.auth-panel').forEach(panel => panel.classList.remove('active'));
    
    if (tabName === 'login') {
        event.currentTarget.classList.add('active');
        document.getElementById('login-form-panel').classList.add('active');
    } else {
        event.currentTarget.classList.add('active');
        document.getElementById('register-form-panel').classList.add('active');
    }
}
  document.addEventListener("DOMContentLoaded", function() {
        const navLinks = document.querySelector('.nav-links');
        const menuBtn = document.getElementById('menuToggle');
        
        if (menuBtn && navLinks) {
            menuBtn.addEventListener('click', function(e) {
                e.stopPropagation(); 
                navLinks.classList.toggle('show-menu');
            });

            document.addEventListener('click', function(e) {
                if (!navLinks.contains(e.target) && !menuBtn.contains(e.target)) {
                    navLinks.classList.remove('show-menu');
                }
            });
        }
    });