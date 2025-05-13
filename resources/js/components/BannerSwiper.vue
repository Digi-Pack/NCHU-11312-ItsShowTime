<script setup>
import { ref, onMounted, defineProps } from 'vue'

import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/free-mode';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import { FreeMode, Pagination, Navigation, Autoplay } from 'swiper/modules';
import { gsap } from 'gsap';

const modules = [FreeMode, Pagination, Navigation, Autoplay];

const props = defineProps({
  bannerData: {
    type: Array,
    required: true,
  }
});

const slides = props.bannerData;

const slidesCount = slides.length;
let activeIndex = ref(0);
let swiperInstance = null;

const slidesCharacters = ref(slides.map(item => item.title.split('')));

const charRefs = ref(
  slidesCharacters.value.map(chars => Array(chars.length).fill(null))
);

// 保存當前活動的動畫
let activeAnimation = null;

const animateSlideText = () => {
  // 終止現有動畫
  if (activeAnimation) {
    activeAnimation.kill();
  }

  const charDOM = charRefs.value[activeIndex.value];

  if (charDOM.length === 0) return;

  gsap.set(charDOM, {
    y: 30,
    opacity: 0
  });
  activeAnimation = gsap.to(charDOM, {
    duration: 0.8,
    y: 0,
    opacity: 1,
    stagger: 0.2,
    ease: "power1.inOut",
    overwrite: "auto"
  });
};

const updateProgressBars = (swiper, progress = null) => {
  activeIndex.value = swiper.realIndex;

  for (let i = 0; i < slidesCount; i++) {
    const progressContainer = document.querySelector(`.progress-container-${i}`);
    const progressBar = document.querySelector(`.progress-bar-${i}`);

    if (progressContainer) {
      progressContainer.style.width = i === activeIndex.value ? '100px' : '50px';
    }

    if (progressBar) {
      if (i === activeIndex.value && progress !== null) {
        progressBar.style.width = `${(1 - progress) * 100}%`;
      } else {
        progressBar.style.width = '0%';
      }
    }
  }
};

// 追蹤自動撥放剩餘時間
const onAutoplayTimeLeft = (swiper, time, progress) => {
  swiperInstance = swiper;
  updateProgressBars(swiper, progress);
};

// slide過渡動畫完成後觸發
const onTransitionEnd = (swiper) => {
  swiperInstance = swiper;
  updateProgressBars(swiper);
  animateSlideText();
};

const renderCustomPagination = (swiper, current, total) => {
  swiperInstance = swiper;
  let paginationHTML = '<div class="custom-pagination-container">';

  for (let i = 1; i <= total; i++) {
    const index = i - 1;
    const isActive = i === current;
    const activeClass = isActive ? 'active' : '';
    const containerWidth = isActive ? '300px' : '100px';

    paginationHTML += `<div class="pagination-item-group swiper-pagination-bullet ${activeClass}" data-slide-index="${index}">`;
    paginationHTML += `<span class="custom-bullet ${activeClass}"></span>`;
    paginationHTML += `<div class="hidden min-[900px]:block custom-progress-container progress-container-${index}" style="width: ${containerWidth}">`;
    paginationHTML += `<div class="custom-progress-bar progress-bar-${index}" style="width: 0%"></div>`;
    paginationHTML += `</div>`;
    paginationHTML += `</div>`;
  }
  paginationHTML += '</div>';
  return paginationHTML;
};

onMounted(() => {
  setTimeout(() => {
    // 分頁器點擊事件
    document.querySelectorAll('.pagination-item-group').forEach((bullet) => {
      bullet.addEventListener('click', () => {
        const index = parseInt(bullet.getAttribute('data-slide-index'));
        if (swiperInstance) {
          swiperInstance.slideTo(index + 1);
        }
      });
    });

    // 初始動畫
    animateSlideText();
  }, 100);
});
</script>

<template>
  <swiper :loop="true" :pagination="{
    el: '.banner-swiper-pagination',
    clickable: true,
    type: 'custom',
    renderCustom: renderCustomPagination
  }" :navigation="false" @transitionEnd="onTransitionEnd" 
  :autoplay="{ delay: 2500, disableOnInteraction: false }" @autoplayTimeLeft="onAutoplayTimeLeft" :modules="modules"
    class="h-[calc(100vh-100px)]">
    <swiper-slide v-for="(chars, index) in slidesCharacters" :key="index" :class="`slide-${index}`">
      <div class="absolute inset-0 bg-cover bg-center blur-sm brightness-50"
        :style="{ backgroundImage: `url(${slides[index].img_path})` }"></div>
      <div class="relative w-full h-full flex justify-center items-center">
        <img :src="slides[index].img_path" class="md:h-full h-[50%] object-contain" :alt="slides[index].img_name">
        <div class="absolute top-[50%] left-[50%] -translate-x-1/2 -translate-y-1/2">
          <span v-for="(char, charIndex) in chars" :key="charIndex" 
            :ref="el => charRefs[index][charIndex] = el"
            class="relative inline-block text-white sm:text-[80px] text-[40px] font-bold tracking-[6px] opacity-0">
            {{ char }}
          </span>
        </div>
      </div>
    </swiper-slide>
    <div class="banner-swiper-pagination"></div>
  </swiper>
</template>

<style>
.banner-swiper-pagination {
  position: absolute;
  bottom: 20px;
  left: 0;
  width: 100%;
  text-align: center;
  z-index: 10;
}

.banner-swiper-pagination .custom-pagination-container {
  width: 80%;
  margin: 0 auto;
  display: flex;
  justify-content: center;
  gap: 8px
}

@media (max-width: 1024px) {
  .banner-swiper-pagination .custom-pagination-container {
    width: 60%;
    gap: 8px;
  }
}

.banner-swiper-pagination .pagination-item-group {
  display: flex;
  flex-direction: row;
  align-items: center;
  gap: 8px;
  cursor: pointer;
  width: auto !important;
  height: auto !important;
  border-radius: 0 !important;
  margin: 0 !important;
  background: transparent !important;
  opacity: 1 !important;
}

.banner-swiper-pagination .custom-bullet {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  background-color: #9e9e9e;
  display: block;
  flex-shrink: 0;
  transition: background-color 0.3s;
}

.banner-swiper-pagination .custom-bullet.active {
  background-color: white;
}

.banner-swiper-pagination .custom-progress-container {
  height: 3px;
  background-color: #9e9e9e;
  overflow: hidden;
  border-radius: 1.5px;
}

.banner-swiper-pagination .custom-progress-bar {
  height: 100%;
  background-color: white;
  width: 0%;
  transition: width 0.1s linear;
}
</style>