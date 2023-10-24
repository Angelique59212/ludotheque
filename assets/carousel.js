import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';

let swiper = new Swiper(".mySwiper", {
    spaceBetween: 30,
    centeredSlides: true,
    autoplay: {
        delay: 2500,
        disableOnInteraction: false,
    },
});



