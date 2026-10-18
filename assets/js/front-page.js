document.querySelectorAll('.home-portfolio-grid').forEach(function (el) {
  var slideCount = el.querySelectorAll('.swiper-slide').length;
  var controls = el.parentElement.querySelector('.home-portfolio-grid__controls');

  new Swiper(el, {
    slidesPerView: 1,
    loop: slideCount > 1,
    navigation: controls ? {
      nextEl: controls.querySelector('.swiper-button-next'),
      prevEl: controls.querySelector('.swiper-button-prev'),
    } : false,
    breakpoints: {
      1081: {
        enabled: false,
      },
    },
  });
});
