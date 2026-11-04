/**
 * Haber Portalı - Ana Etkileşim Scripti
 */

document.addEventListener('DOMContentLoaded', function () {
  'use strict';

  // --- 1. Manşet Slider (Hero Carousel) ---
  const slides = document.querySelectorAll('.slider-slide');
  const indicators = document.querySelectorAll('.indicator-btn');
  let currentSlide = 0;
  let slideInterval = null;
  const slideDuration = 5000; // 5 saniye

  function showSlide(index) {
    if (!slides.length) return;

    // Sınır kontrolü
    if (index >= slides.length) currentSlide = 0;
    else if (index < 0) currentSlide = slides.length - 1;
    else currentSlide = index;

    slides.forEach((slide, i) => {
      slide.classList.toggle('active', i === currentSlide);
    });

    indicators.forEach((btn, i) => {
      btn.classList.toggle('active', i === currentSlide);
    });
  }

  function nextSlide() {
    showSlide(currentSlide + 1);
  }

  function startAutoSlide() {
    stopAutoSlide();
    slideInterval = setInterval(nextSlide, slideDuration);
  }

  function stopAutoSlide() {
    if (slideInterval) {
      clearInterval(slideInterval);
      slideInterval = null;
    }
  }

  if (slides.length > 0) {
    indicators.forEach((btn) => {
      btn.addEventListener('click', function () {
        const slideIdx = parseInt(this.getAttribute('data-slide'), 10);
        showSlide(slideIdx);
        startAutoSlide(); // Sıfırla ve yeniden başlat
      });
    });

    const sliderContainer = document.querySelector('.manset-slider');
    if (sliderContainer) {
      sliderContainer.addEventListener('mouseenter', stopAutoSlide);
      sliderContainer.addEventListener('mouseleave', startAutoSlide);
    }

    startAutoSlide();
  }

  // --- 2. Mobil Menü Aç/Kapa ---
  const menuToggle = document.querySelector('.menu-toggle');
  const navMenu = document.querySelector('.nav-menu');

  if (menuToggle && navMenu) {
    menuToggle.addEventListener('click', function () {
      navMenu.classList.toggle('active');
      const expanded = menuToggle.getAttribute('aria-expanded') === 'true';
      menuToggle.setAttribute('aria-expanded', !expanded);
    });
  }

  // --- 3. Son Dakika Ticker Hover Pause ---
  const tickerItems = document.querySelector('.ticker-items');
  if (tickerItems) {
    tickerItems.addEventListener('mouseenter', () => {
      tickerItems.style.animationPlayState = 'paused';
    });
    tickerItems.addEventListener('mouseleave', () => {
      tickerItems.style.animationPlayState = 'running';
    });
  }

  // --- 4. Sayfa Başına Dönüş veya İpuçları ---
  console.log('Haber Portalı Sistemi Aktif: Tüm modüller başarıyla yüklendi.');
});
