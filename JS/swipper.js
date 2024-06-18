const swiper1 = new Swiper(".swiper_1", {
  effect: "fade",
  loop: true,
  autoplay: {
    delay: 4000,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  keyboard: {
    enabled: true,
  },
  mousewheel: {
    enabled: false,
  },
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
});

const swiper2 = new Swiper(".swiper_2", {
  slidesPerView: 4,
  autoplay:{
    delay:5000
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  breakpoints: {
    0: {
      slidesPerView: 1,
    },
    480: {
      slidesPerView: 2,
    },
    768: {
      slidesPerView: 2,
    },
    1040:{
      slidesPerView: 3
    },
    1280: {
      slidesPerView: 4,
    },
  },
});
