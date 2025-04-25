<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'

import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/free-mode';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import 'swiper/css/thumbs';
import { FreeMode, Pagination, Navigation, Thumbs, Autoplay } from 'swiper/modules';
import { gsap } from 'gsap';

const thumbsSwiper = ref(null);
const setThumbsSwiper = (swiper) => {
  thumbsSwiper.value = swiper
};
const modules = [FreeMode, Pagination, Navigation, Thumbs, Autoplay];

// Nav Fixed
const isFixed = ref(false);
let lastScrollY = 0;

const handleScroll = () => {
  const currentScrollY = window.scrollY;
  if (currentScrollY > 280) {
    isFixed.value = true;
  } else if (currentScrollY < 230) {
    isFixed.value = false;
  };
  lastScrollY = currentScrollY;
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll);
})

onBeforeUnmount(() => {
  window.removeEventListener('scroll', handleScroll);
})

// banner swiper
const slideTexts = [
  { id: 1, 'content': '特攻服', img: '/image/1-1.webp' },
  { id: 2, 'content': '橫須賀', img: '/image/1-2.webp' },
  { id: 3, 'content': '水手服', img: '/image/1-3.webp' },
  { id: 4, 'content': 'Ado 狂言劇場 ', img: '/image/1-4wrong.webp' },
  { id: 5, 'content': '至尊戰袍', img: '/image/1-5.webp' },
  { id: 6, 'content': '舊車會', img: '/image/1-6.webp' },
  { id: 7, 'content': '#SGT4', img: '/image/1-7.webp' },
];

const slidesCount = slideTexts.length;
let activeIndex = ref(0);
let swiperInstance = null;

const slidesCharacters = ref(slideTexts.map(text => text.content.split('')));

// 保存當前活動的動畫
let activeAnimation = null;

const animateSlideText = () => {
  // 終止現有動畫
  if (activeAnimation) {
    activeAnimation.kill();
  }

  // 選擇當前活動幻燈片的字符
  const charElements = document.querySelectorAll('.swiper-slide-active .char');

  if (charElements.length === 0) return;

  // 使用 fromTo 來明確定義起始和結束狀態
  activeAnimation = gsap.fromTo(charElements,
    {
      y: 30,
      opacity: 0
    },
    {
      duration: 0.8,
      y: 0,
      opacity: 1,
      stagger: 0.2,
      ease: "power1.inOut",
      overwrite: "auto"
    }
  );
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

const onAutoplayTimeLeft = (swiper, time, progress) => {
  swiperInstance = swiper;
  updateProgressBars(swiper, progress);
};

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
    paginationHTML += `<div class="custom-progress-container progress-container-${index}" style="width: ${containerWidth}">`;
    paginationHTML += `<div class="custom-progress-bar progress-bar-${index}" style="width: 0%"></div>`;
    paginationHTML += `</div>`;
    paginationHTML += `</div>`;
  }

  paginationHTML += '</div>';
  return paginationHTML;
};

onMounted(() => {
  setTimeout(() => {
    // 設置分頁器點擊事件
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
  }, 500);
});

// 點擊按鈕顯示圖片
const showImage = ref(false);
const currentImage = ref('');

const handleClick = (event) => {
  showImage.value = !showImage.value;
  const imgUrl = event.currentTarget.dataset.img;
  currentImage.value = imgUrl;
}
const hideImage = () => {
  showImage.value = false;
};
</script>

<template>
  <nav class="max-w-[1903px] mx-auto">
    <!-- 最上方品牌名稱 -->
    <div class="static sm:fixed top-0 left-0 w-full z-10">
      <div class="max-w-[1903px] h-[40px] bg-[#B41900] mx-auto flex justify-center items-center text-white">
        <p class="font-noto-cjk text-sm font-normal leading-[1.2]">
          台湾無敵の特工服オーダーメイドブランド
        </p>
      </div>
    </div>
    <!-- nav fixed --->
    <div :class="[isFixed ? 'sm:block' : 'sm:hidden']" class="hidden absolute top-[236px] left-0 right-0 z-50">
      <div
        class="max-w-[1903px] mx-auto fixed top-[40px] left-0 right-0 shadow-[0px_4px_8px_0px_rgba(0,0,0,0.1)] z-15 bg-white">
        <div class="flex justify-between items-center 2xl:px-[200px] px-[150px] py-[10px]">
          <div class="flex items-center gap-2">
            <img src="/image/LOGO-方.webp" class="w-12 -mb-2" alt="">
            <div class="flex flex-col">
              <p class="font-noto-jp text-[#444444] text-[12px] font-black leading-[2] tracking-[-0.08em]">
                天下無敵、台湾特工服の第一品牌
              </p>
              <pre
                class="font-freckle text-[#444444] text-[43.48px] font-normal leading-[0.7] tracking-[-0.08em]">ITS SHOW  TIME</pre>
            </div>
          </div>
          <div class="hidden 2xl:flex gap-6 pl-6">
            <a href="#portfolio" class="flex items-center gap-[9px]">
              <img src="/image/svg/Arrow 2.svg" alt="">
              <p class="font-normal leading-[1.2]">作品集</p>
            </a>
            <a href="#about" class="flex items-center gap-[9px]">
              <img src="/image/svg/Arrow 2.svg" alt="">
              <p class="font-normal leading-[1.2]">品牌理念</p>
            </a>
            <a href="#method" class="flex items-center gap-[9px]">
              <img src="/image/svg/Arrow 2.svg" alt="">
              <p class="font-normal leading-[1.2]">製作方式</p>
            </a>
            <a href="#product" class="flex items-center gap-[9px]">
              <img src="/image/svg/Arrow 2.svg" alt="">
              <p class="font-normal leading-[1.2]">商品列表</p>
            </a>
            <a href="#contact" class="flex items-center gap-[9px]">
              <img src="/image/svg/Arrow 2.svg" alt="">
              <p class="font-normal leading-[1.2]">聯絡方式</p>
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- 沒 fixed 的 nav -->
    <div id="portfolio" :class="[isFixed ? 'hidden' : 'block']" class="w-full flex items-center sm:mt-[40px] bg-white min-[577px]:h-[363px]">
      <div class="w-full  flex flex-col justify-between min-[577px]:flex-row">
        <!-- 左：logo -->
        <div class="w-full relative lg:pl-[30px] xl:pl-[100px] sm:pt-6 pt-0 md:ms-10 lg:ms-0">
          <div
            class="logo-container relative w-full h-[93px] xl:w-[724px] xl:h-[132.84px] 2xl:w-[1041px] 2xl:h-[191px] mr-auto">
            <img
              class="absolute top-[32px] left-[20px] md:left-[60px] 2xl:top-[0.5px] 2xl:left-[82px] w-[52.71px] md:w-[80px] lg:w-[107.81px] 2xl:w-[155.01px] "
              src="/image/LOGO-方.webp" alt="logo">
            <p
              class="h-[8px] text-[11px] md:text-[20px] lg:h-[16px] lg:text-[22.26px] 2xl:h-[23px] 2xl:text-[32px] font-noto-jp text-[#444444] font-black leading-[1.2] tracking-[-0.08em] absolute top-[30px] left-[80px] md:top-[35px] md:left-[150px] lg:left-[180px] xl:top-[40px] 2xl:left-[240px] 2xl:top-[10px]">
              天下無敵、台湾特工服の第一品牌
            </p>
            <pre
              class="h-[36px] text-[47.61px] md:text-[54px] lg:text-[97.37px] 2xl:h-[107px] 2xl:text-[140px] font-freckle text-[#444444] font-normal leading-[1.1] tracking-[-0.08em] absolute bottom-[10px] left-[80px] md:bottom-0 md:left-[150px] lg:left-[180px] xl:bottom-[30px] 2xl:left-[240px] 2xl:bottom-[50px]">ITS SHOW  TIME</pre>
          </div>
        </div>
        <!-- 右：menu -->
        <div
          class="w-full h-auto relative font-noto-cjk justify-center text-[#000000] min-[577px]:flex min-[577px]:w-[50%] sm:pr-20 px-4 min-[577px]:pb-0 pb-6 min-[557px]:pt-0 pt-3">
          <div class=" flex flex-col gap-4">
            <div class="flex items-center gap-[5px]">
              <img src="/image/svg/Polygon 1.svg" alt="">
              <p class="font-noto font-normal leading-[1.2]">Menu</p>
            </div>
            <div
              class="menu-items flex flex-wrap min-[577px]:gap-4 gap-x-8 gap-y-4 min-[577px]:pl-4 min-[577px]:flex-col">
              <a href="#portfolio" class="flex items-center gap-[9px]">
                <img src="/image/svg/Arrow 2.svg" alt="">
                <p class="font-normal leading-[1.2]">作品集</p>
              </a>
              <a href="#about" class="flex items-center gap-[9px]">
                <img src="/image/svg/Arrow 2.svg" alt="">
                <p class="font-normal leading-[1.2]">品牌理念</p>
              </a>
              <a href="#method" class="flex items-center gap-[9px]">
                <img src="/image/svg/Arrow 2.svg" alt="">
                <p class="font-normal leading-[1.2]">製作方式</p>
              </a>
              <a href="#product" class="flex items-center gap-[9px]">
                <img src="/image/svg/Arrow 2.svg" alt="">
                <p class="font-normal leading-[1.2]">商品列表</p>
              </a>
              <a href="#contact" class="flex items-center gap-[9px]">
                <img src="/image/svg/Arrow 2.svg" alt="">
                <p class="font-normal leading-[1.2]">聯絡方式</p>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-if="isFixed" class="h-[363px] bg-white"></div>
  </nav>
  <main class="max-w-[1903px] mx-auto">
    <!-- banner -->
    <section class="w-full">
      <swiper :loop="true" :pagination="{
        el: '.swiper-custom-pagination',
        clickable: true,
        type: 'custom',
        renderCustom: renderCustomPagination
      }" :navigation="false" :autoplay="{ delay: 2500, disableOnInteraction: false }" @transitionEnd="onTransitionEnd"
        @autoplayTimeLeft="onAutoplayTimeLeft" :modules="modules" class="banner-swiper">

        <swiper-slide v-for="(chars, index) in slidesCharacters" :key="index" :class="`slide-${index}`"
          class="banner-swiper-slide">
          <img :src="slideTexts[index].img" alt="" class="big-img">
          <div class="container">
            <img :src="slideTexts[index].img" alt="" class="center-img">
            <div class="absolute inset-0 flex items-center justify-center">
              <span v-for="(char, charIndex) in chars" :key="charIndex"
                class="char text-white text-[80px] font-bold tracking-[6px] opacity-0 block">
                {{ char }}
              </span>
            </div>
          </div>
        </swiper-slide>
        <div class="swiper-custom-pagination"></div>
      </swiper>
    </section>
    <!-- 網站功能簡介 -->
    <section id="about"
      class="w-full bg-white flex flex-col gap-6 border-b px-[20px] md:px-[40px] lg:px-[100px] xl:px-[200px] py-20">
      <p class="font-noto-cjk text-[#7A7A7A] font-normal leading-[1.2] ">網站功能簡介</p>
      <div class="flex gap-2 md:gap-6">
        <div class="w-1/3 flex flex-col gap-4">
          <div class="flex flex-col sm:flex-row justify-start items-center sm:items-end md:gap-[15px] text-[#444444]">
            <p class="font-jockey text-[50px] xl:text-[64px] 2xl:text-[96px] font-normal leading-[96px] uppercase">10+
            </p>
            <p
              class="font-pingfang text-nowrap text-[16px] xl:text-[24px] 2xl:text-[30px] font-medium leading-[1.14] tracking-[2.25px] pb-4">
              年電繡經驗</p>
          </div>
          <p
            class="h-[54px] font-pingfang-r text-[#444444] text-lg font-normal leading-[1.5] tracking-[1.35px] hidden md:block">
            保證刺出不羈的靈魂，讓每一位顧客擁有最優質的服務。
          </p>
        </div>
        <div class="w-1/3 flex flex-col gap-4">
          <div class="flex flex-col sm:flex-row justify-start items-center sm:items-end md:gap-[15px] text-[#444444]">
            <p class="font-jockey text-[50px] xl:text-[64px] 2xl:text-[96px] font-normal leading-[96px] uppercase">
              2,000+</p>
            <p
              class="font-pingfang text-nowrap text-[16px] xl:text-[24px] 2xl:text-[30px] font-medium leading-[1.14] tracking-[2.25px] pb-4">
              番長指定</p>
          </div>
          <p
            class="h-[54px] font-pingfang-r text-[#444444] text-lg font-normal leading-[1.5] tracking-[1.35px] hidden md:block">
            治霸全國指定品牌，日常暴走穿搭首選。
          </p>
        </div>
        <div class="w-1/3 flex flex-col gap-4">
          <div class="flex flex-col sm:flex-row justify-start items-center sm:items-end md:gap-[15px] text-[#444444]">
            <div class="h-[96px] flex items-center">
              <img class="w-[55.05px] xl:w-[70.78px] xl:h-[35.63px] 2xl:w-[151px] 2xl:h-full"
                src="/image/svg/infinity.svg" alt="">
            </div>
            <p
              class="font-pingfang text-nowrap text-[16px] xl:text-[24px] 2xl:text-[30px] font-medium leading-[1.14] tracking-[2.25px] pb-4">
              無極限客製</p>
          </div>
          <p
            class="h-[54px] font-pingfang-r text-[#444444] text-lg font-normal leading-[1.5] tracking-[1.35px] hidden md:block">
            多種版型可供下載，客製化屬於你自己的自由靈魂。
          </p>
        </div>
      </div>
    </section>
    <!-- 第二張大圖 -->
    <section class="w-full bg-[#333333] flex justify-center items-center gap-10 2xl:pl-[200px] flex-col 2xl:flex-row">
      <div class="w-full 2xl:w-1/2 flex flex-col gap-6 pb-20 px-2 md:px-20 2xl:py-20 2xl:px-0 order-1 2xl:order-0">
        <p class=" font-bakudai-r text-white text-[52.51px] md:text-[64px] font-normal leading-[1.2]">
          繡上自由想法,
          <span class="iniline-block md:inline 2xl:inline-block">秀出自信態度</span>
        </p>
        <p class="font-noto-cjk text-[#D9D9D9] font-normal leading-[1.6] px-2">
          桀驁不馴，既是對社會規範的挑戰，也是對自身風格的堅持。
          我們堅信透過刺繡，繡上的每一針一線都能傳遞情感與故事。​​無論是個人訂製還是團體需求，我們都以專業態度滿足，期望每件作品都能成為您生活中的亮點。
        </p>
      </div>
      <div class="w-full order-0 2xl:order-1">
        <img class="w-full object-cover" src="/image/2.webp" alt="">
      </div>
    </section>
    <!-- 商品製作 -->
    <section class="w-full bg-white">
      <!-- 設計自己的暴走魂 -->
      <div id="method" class="w-full flex justify-center items-center min-[1180px]:px-10 px-4 py-20">
        <div
          class="w-full max-w-[1503px] flex flex-col min-[1120px]:flex-row justify-center items-center min-[1500px]:gap-10 min-[1120px]:gap-6 gap-4 mx-auto">
          <div class="w-full min-[1120px]:w-[calc(100% - 666.9px)] flex-1 flex flex-col justify-center gap-6">
            <!-- 訂製方式 -->
            <div class="w-full flex flex-col justify-center gap-6 min-[1120px]:py-6 py-4">
              <p class="font-noto-cjk text-[#7A7A7A] font-normal leading-[1.2]">訂製方式</p>
              <div class="flex items-center min-[769px]:gap-6 gap-3">
                <img src="/image/svg/Polygon 1.svg" class="w-6 h-6" alt="">
                <p
                  class="font-noto-cjk text-[#444444] min-[1501px]:text-[64px] min-[769px]:text-[48px] text-[32px] font-bold leading-[1.2]">
                  設計自己的暴走魂</p>
              </div>
              <p class="font-Noto-serif-jp text-[#444444] min-[567px]:text-lg text-[16px] font-normal leading-[1.5]">
                完全客製化，透過連結下載模板自行設計，有長版/短版/特工褲各4色可做挑選。</p>
            </div>
            <!-- 進度條 -->
            <div class="w-full min-[1120px]:max-w-[731px] relative">
              <swiper @swiper="setThumbsSwiper" :loop="true" :slidesPerView="'auto'" :freeMode="true"
                :watchSlidesProgress="true" :modules="modules" class="thumb-swiper">
                <!-- min-[1314px]:gap-20 min-[1201px]:gap-10 gap-2 -->
                <swiper-slide class="flex flex-col items-center gap-2">
                  <p class="font-noto text-[#444444] text-lg min-[1500px]:font-normal 
                    font-bold leading-[1.5] tracking-[1.35px]">
                    Step1.
                  </p>
                  <button type="button"
                    class="w-full font-noto-cjk border border-[#444444] min-[1120px]:text-lg text-[14px] font-normal leading-[100%] rounded-[8px] py-2">
                    特攻服初稿
                  </button>
                </swiper-slide>
                <swiper-slide class="flex flex-col items-center gap-2">
                  <p class="font-noto text-[#444444] text-lg min-[1500px]:font-normal 
                    font-bold leading-[1.5] tracking-[1.35px] relative step-line">
                    Step2.
                  </p>
                  <button type="button"
                    class="w-full font-noto-cjk border border-[#444444] min-[1120px]:text-lg text-[14px] font-normal leading-[100%] rounded-[8px] py-2">
                    <span>回傳給小編</span>
                    <span>排搞+估價</span>
                  </button>
                </swiper-slide>
                <swiper-slide class="flex flex-col items-center gap-2">
                  <p class="font-noto text-[#444444] text-lg min-[1500px]:font-normal 
                    font-bold leading-[1.5] tracking-[1.35px]">
                    Step3.
                  </p>
                  <button type="button"
                    class="w-full font-noto-cjk border border-[#444444] min-[1120px]:text-lg text-[14px] font-normal leading-[100%] rounded-[8px] py-2">
                    <span>完成訂製、</span>
                    <span>付訂金</span>
                  </button>
                </swiper-slide>
              </swiper>
            </div>
            <!-- 價目樣式參考表 -->
            <div class="hidden min-[1120px]:flex flex-col gap-6 py-6">
              <div class="flex min-[769px]:gap-6 gap-3 mb-6">
                <img src="/image/svg/Polygon 1.svg" class="w-6 h-6" alt="">
                <p class="font-noto-cjk text-[#7A7A7A] font-normal leading-[1.2]">
                  價目樣式參考表
                </p>
              </div>
              <p class="font-Noto-serif-jp text-[#444444] text-lg font-normal leading-[1.5] mb-6 text-nowrap">
                完全客製化，透過連結下載模板自行設計
              </p>
              <div class="w-full min-[1500px]:flex grid grid-cols-2 gap-4">
                <button type="button"
                  class="h-10 bg-[#444444] font-noto-cjk text-lg text-white font-normal leading-[100%] rounded-[8px] min-[567px]:px-8 px-4 py-2"
                  data-img="/image/5-1.webp" @click="handleClick">
                  中文字體樣式
                </button>
                <button type="button"
                  class="h-10 bg-[#444444] font-noto-cjk text-lg text-white font-normal leading-[100%] rounded-[8px] min-[567px]:px-8 px-4 py-2"
                  data-img="/image/5-2.webp" @click="handleClick">
                  英文字體樣式
                </button>
                <button type="button"
                  class="h-10 bg-[#444444] font-noto-cjk text-lg text-white font-normal leading-[100%] rounded-[8px] min-[567px]:px-8 px-4 py-2"
                  data-img="/image/5-3.webp" @click="handleClick">
                  繡字價目表
                </button>
                <a href="#">
                  <div class="h-10 bg-[#FFC051] flex justify-center items-center gap-1 rounded-[8px] px-10 py-2">
                    <img src="/image/svg/material-symbols_download.svg" alt="">
                    <span
                      class="font-Microsoft text-lg text-[#4D4D4D] font-bold leading-[100%] tracking-[1.35px] text-nowrap">
                      下載模板</span>
                  </div>
                </a>
              </div>
            </div>
          </div>
          <swiper :speed="1" :loop="true" :slidesPerView="'auto'" :navigation="false" :thumbs="{ swiper: thumbsSwiper }"
            :modules="modules" :autoplay="{
              delay: 3000,
              disableOnInteraction: false
            }" class="process-swiper">
            <swiper-slide>
              <img src="/image/3-1.webp" alt="" />
            </swiper-slide>
            <swiper-slide>
              <img src="/image/3-2.webp" alt="" />
            </swiper-slide>
            <swiper-slide>
              <img src="/image/3-3.webp" alt="" />
            </swiper-slide>
          </swiper>
          <!-- 價目參考樣式(後面) -->
          <div class="w-full flex min-[1120px]:hidden flex-col gap-6 py-6">
            <div class="flex min-[769px]:gap-6 gap-3 mb-6">
              <img src="/image/svg/Polygon 1.svg" class="w-6 h-6" alt="">
              <p class="font-noto-cjk text-[#7A7A7A] font-normal leading-[1.2]">
                價目樣式參考表
              </p>
            </div>
            <p class="font-Noto-serif-jp text-[#444444] text-lg font-normal leading-[1.5] mb-6 text-nowrap">
              完全客製化，透過連結下載模板自行設計
            </p>
            <div class="w-full grid grid-cols-2 gap-4">
              <button type="button"
                class="h-10 bg-[#444444] font-noto-cjk text-lg text-white font-normal leading-[100%] rounded-[8px] text-nowrap py-2"
                data-img="/image/5-1.webp" @click="handleClick">
                中文字體樣式
              </button>
              <button type="button"
                class="h-10 bg-[#444444] font-noto-cjk text-lg text-white font-normal leading-[100%] rounded-[8px] text-nowrap py-2"
                data-img="/image/5-2.webp" @click="handleClick">
                英文字體樣式
              </button>
              <button type="button"
                class="h-10 bg-[#444444] font-noto-cjk text-lg text-white font-normal leading-[100%] rounded-[8px] py-2 text-nowrap"
                data-img="/image/5-3.webp" @click="handleClick">
                繡字價目表
              </button>
              <a href="#">
                <div class="h-10 bg-[#FFC051] flex justify-center items-center gap-1 rounded-[8px] py-2">
                  <img src="/image/svg/material-symbols_download.svg" alt="">
                  <span
                    class="font-Microsoft text-lg text-[#4D4D4D] font-bold leading-[100%] tracking-[1.35px] text-nowrap">
                    下載模板</span>
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
      <!-- 下單購買 -->
      <!-- min-[1904px]:px-[200px] min-[1201px]:px-[120px] px-10 -->
      <div id="product" class="w-full bg-[#333333] flex flex-col gap-4 py-8">
        <div class="flex items-center gap-6 2xl:px-[200px] md:px-10 px-4">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M24 0V24H0L24 0Z" fill="white" />
          </svg>
          <p class="font-noto-cjk 2xl:text-[80px] md:text-[48px] text-[32px] text-white font-bold leading-[1.2]">下單購買
          </p>
        </div>
        <!-- 商品列表Swiper -->
        <div class="product-swiper-container">
          <div class="custom-swiper-pagination"></div>
          <swiper :loop="true" :navigation="true" :spaceBetween="20" :centeredSlides="true" :slidesPerView="'auto'"
            :pagination="{
              el: '.custom-swiper-pagination',
              clickable: true,
            }" :modules="modules" class="product-swiper">
            <swiper-slide>
              <div
                class="w-full flex flex-col gap-2 shadow-[0px_0px_4px_0px_rgba(0,0,0,0.1)] rounded-tl-2xl rounded-tr-2xl">
                <img class="rounded-tl-2xl rounded-tr-2xl" src="/image/4-1.webp" alt="">
                <div class="flex flex-col gap-2 px-2">
                  <p class="font-noto-cjk text-[24px] text-white font-bold leading-[1.2]">
                    日式特攻服 暴走族 🎌 [白色] 素色特攻服 客製化 團體服
                  </p>
                  <p
                    class="hidden 2xl:block font-pingfang-r text-[32px] text-[#C89E51] font-normal leading-[100%] tracking-[0.08em] opacity-80 custom-shadow">
                    $1000
                  </p>
                </div>
              </div>
            </swiper-slide>
            <swiper-slide>
              <div
                class="w-full flex flex-col gap-2 shadow-[0px_0px_4px_0px_rgba(0,0,0,0.1)] rounded-tl-2xl rounded-tr-2xl">
                <img class="rounded-tl-2xl rounded-tr-2xl" src="/image/4-2.webp" alt="">
                <div class="flex flex-col gap-2 px-2">
                  <p class="font-noto-cjk text-[24px] text-white font-bold leading-[1.2]">
                    日式中版特攻服 暴走族 🎌 素色特攻服 客製化 團體服
                  </p>
                  <p
                    class="hidden 2xl:block font-pingfang-r text-[32px] text-[#C89E51] font-normal leading-[100%] tracking-[0.08em] opacity-80 custom-shadow">
                    $2000
                  </p>
                </div>
              </div>
            </swiper-slide>
            <swiper-slide>
              <div
                class="w-full flex flex-col gap-2 shadow-[0px_0px_4px_0px_rgba(0,0,0,0.1)] rounded-tl-2xl rounded-tr-2xl">
                <img class="rounded-tl-2xl rounded-tr-2xl" src="/image/4-3.webp" alt="">
                <div class="flex flex-col gap-2 px-2">
                  <p class="font-noto-cjk text-[24px] text-white font-bold leading-[1.2]">
                    刺繡 電腦刺繡 客製化 刺繡範例 請看商品描述 歡迎聊聊詢問
                  </p>
                  <p
                    class="hidden 2xl:block font-pingfang-r text-[32px] text-[#C89E51] font-normal leading-[100%] tracking-[0.08em] opacity-80 custom-shadow">
                    $3000
                  </p>
                </div>
              </div>
            </swiper-slide>
            <swiper-slide>
              <div
                class="w-full flex flex-col gap-2 shadow-[0px_0px_4px_0px_rgba(0,0,0,0.1)] rounded-tl-2xl rounded-tr-2xl">
                <img class="rounded-tl-2xl rounded-tr-2xl" src="/image/4-1.webp" alt="">
                <div class="flex flex-col gap-2 px-2">
                  <p class="font-noto-cjk text-[24px] text-white font-bold leading-[1.2]">
                    日式特攻服 暴走族 🎌刺繡特攻服 東京卍會 佐野萬次郎 客製化 刺繡
                  </p>
                  <p
                    class="hidden 2xl:block font-pingfang-r text-[32px] text-[#C89E51] font-normal leading-[100%] tracking-[0.08em] opacity-80 custom-shadow">
                    $4000
                  </p>
                </div>
              </div>
            </swiper-slide>
            <swiper-slide>
              <div
                class="w-full flex flex-col gap-2 shadow-[0px_0px_4px_0px_rgba(0,0,0,0.1)] rounded-tl-2xl rounded-tr-2xl">
                <img class="rounded-tl-2xl rounded-tr-2xl" src="/image/4-2.webp" alt="">
                <div class="flex flex-col gap-2 px-2">
                  <p class="font-noto-cjk text-[24px] text-white font-bold leading-[1.2]">
                    日式暴走頭帶 ⛩ 台灣連合 神風 暴走 特攻 極惡 客製化 刺繡
                  </p>
                  <p
                    class="hidden 2xl:block font-pingfang-r text-[32px] text-[#C89E51] font-normal leading-[100%] tracking-[0.08em] opacity-80 custom-shadow">
                    $5000
                  </p>
                </div>
              </div>
            </swiper-slide>
            <swiper-slide>
              <div
                class="w-full flex flex-col gap-2 shadow-[0px_0px_4px_0px_rgba(0,0,0,0.1)] rounded-tl-2xl rounded-tr-2xl 2xl:pb-0 pb-10">
                <img class="rounded-tl-2xl rounded-tr-2xl" src="/image/4-3.webp" alt="">
                <div class="flex flex-col gap-2 px-2">
                  <p class="font-noto-cjk text-[24px] text-white font-bold leading-[1.2]">
                    刺繡 電腦刺繡 客製化 刺繡範例 請看商品描述 歡迎聊聊詢問
                  </p>
                  <p
                    class="hidden 2xl:block font-pingfang-r text-[32px] text-[#C89E51] font-normal leading-[100%] tracking-[0.08em] opacity-80 custom-shadow">
                    $6000
                  </p>
                </div>
              </div>
            </swiper-slide>
          </swiper>

        </div>
        <div class="w-full flex justify-center">
          <a href="#"
            class="bg-white flex items-center gap-[10px] px-10 py-4 rounded-2xl shadow-[0px_4px_4px_0px_rgba(0,0,0,0.25)]">
            <img src="/image/svg/Shopee_logo.svg" alt="">
            <p class="font-noto-cjk text-[#444444] text-lg font-normal leading-[1.5]">蝦皮賣場</p>
            <img src="/image/svg/icon-arrow.svg" alt="">
          </a>
        </div>
      </div>
    </section>
  </main>
  <div v-if="showImage" class="w-full fixed inset-0 z-50" @click="hideImage">
    <div class="absolute inset-0 bg-black opacity-50"></div>
    <div class=" w-full  absolute inset-0 flex justify-center items-center">
      <img :src="currentImage" class="w-full xl:w-[808px] lg:w-[900px]  z-50" alt="">
    </div>
  </div>
  <!-- footer -->
  <footer id="contact"
    class="max-w-[1903px] bg-[#272727] flex flex-col min-[522px]:justify-center min-[522px]:items-center gap-10 mx-auto min-[769px]:py-10 relative min-[476px]:px-4 px-3 pt-[110px] pb-10">
    <!-- 回到頂部 -->
    <a href="#">
      <div
        class="bg-[#444444] flex justify-center items-center border-2 border-[#4D4D4D] font-noto-cjk text-white font-bold text-lg leading-[125%] tracking-[1.5px] min-[522px]:p-5 min-[522px]:w-[103px] w-[95px] min-[522px]:h-[65px] h-[41px] absolute top-7 right-4">
        回頂部
      </div>
    </a>
    <!-- logo -->
    <div class="flex items-start min-[476px]:gap-2 gap-[6px]">
      <img src="/image/LOGO-中.webp" alt="" class="2xl:hidden min-[522px]:w-[73.85px] w-[57.36px]">
      <div class="flex-col gap-[5.76px]">
        <p
          class="font-noto-jp text-white min-[522px]:text-[14.8px] text-[11.5px] font-black leading-[1.2] tracking-[-0.08em]">
          天下無敵、台湾特工服の第一品牌
        </p>
        <pre
          class="font-freckle text-white min-[522px]:text-[64.77px] text-[50.31px] font-normal leading-[1.2] tracking-[-0.08em]">ITS SHOW  TIME</pre>
      </div>
    </div>
    <!-- 聯絡 -->
    <div class="min-[769px]:flex items-center gap-10">
      <!-- 字體 Taipei Sans TC Beta -->
      <span class="font-taipei-sans-tc-r text-white leading-[192%] tracking-[1.2px]">
        <span class="font-taipei-sans-tc-bold">聯絡我們</span><br>
        聯絡地址：台中市東區精武路173號<br>
        客服電話：0984 090 320
      </span>
      <div class="min-[1201px]:flex grid min-[522px]:grid-cols-2 grid-cols-1 gap-4 py-8">
        <a href="#" class="w-[198px] bg-[#333333] flex items-center gap-1 px-2 py-1 rounded-[26px]">
          <img src="/image/svg/facebook.svg" alt="">
          <p class="font-taipei-sans-tc-r text-white font-normal text-lg leading-[1.25] tracking-[1.35px]">
            Itsshowtime
          </p>
        </a>
        <a href="#" class="w-[198px] bg-[#333333] flex items-center gap-1 px-2 py-1 rounded-[26px]">
          <img src="/image/svg/instagram.svg" alt="">
          <p class="font-taipei-sans-tc-r text-white font-normal text-lg leading-[1.25] tracking-[1.35px]">
            itsshowtime_tw
          </p>
        </a>
        <a href="#" class="w-[198px] bg-[#333333] flex items-center gap-1 px-2 py-1 rounded-[26px]">
          <img src="/image/svg/shopee.svg" alt="">
          <p class="font-taipei-sans-tc-r text-white font-normal text-lg leading-[1.25] tracking-[1.35px]">
            蝦皮賣場
          </p>
        </a>
        <a href="#" class="w-[198px] bg-[#333333] flex items-center gap-1 px-2 py-1 rounded-[26px]">
          <img src="/image/svg/maps.svg" alt="">
          <p class="font-taipei-sans-tc-r text-white  text-lg leading-[1.25] tracking-[1.35px]">
            Google地圖
          </p>
        </a>
      </div>

    </div>
    <div class="border-t border-[#BBBDBD] pt-10 pb-5">
      <p class="font-noto text-white font-normal leading-[1.6] tracking-[1.2px]">
        Copyright © 2025 衣織繡態企業社 ． Web Design → Digi-pack
      </p>
    </div>
  </footer>
</template>

<style>
html,
body {
  font-size: 16px;
  background-color: #0A1109;
  margin: 0;
  padding: 0;
}

/* banner Swiper */
.banner-swiper-slide {
  width: 100%;
  height: 600px;
  text-align: center;
  position: relative;
}

@media (max-width: 1240px) {
  .banner-swiper-slide {
    height: 500px;
  }
}

.banner-swiper-slide .big-img {
  position: absolute;
  width: 100%;
  height: auto;
  object-position: center;
  object-fit: cover;
  background-color: #000;
  opacity: 0.5;
}

.banner-swiper-slide .container {
  position: relative;
  height: 100%;
  margin: auto;
  display: flex;
  align-items: center;
  justify-content: center;
}

.banner-swiper-slide .center-img {
  width: auto;
  margin: 0 auto;
  height: 100%;
  object-fit: cover;
  object-position: center;
}


.banner-swiper-slide .slide-content {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 20px;
}

.banner-swiper-slide .char {
  display: inline-block;
  position: relative;
}

.swiper-custom-pagination {
  position: absolute;
  bottom: 20px;
  left: 0;
  width: 100%;
  text-align: center;
  z-index: 10;
}

.custom-pagination-container {
  display: flex;
  justify-content: center;
  gap: 20px;
}

.pagination-item-group {
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

.custom-bullet {
  width: 10px;
  height: 10px;
  border-radius: 50%;
  background-color: #9e9e9e;
  display: block;
  flex-shrink: 0;
  transition: background-color 0.3s;
}

.custom-bullet.active {
  background-color: white;
}

.custom-progress-container {
  height: 3px;
  background-color: #9e9e9e;
  overflow: hidden;
  border-radius: 1.5px;
}

.custom-progress-bar {
  height: 100%;
  background-color: white;
  width: 0%;
  transition: width 0.1s linear;
}

/* 商品製作 Swiper */
.thumb-swiper {
  display: inline-flex;
  width: 100%;
  box-sizing: border-box;
}

.thumb-swiper .swiper-slide {
  width: 190.33px;
  text-align: center;
  display: flex;
  justify-content: center;
  align-items: center;
  margin-right: 80px;
}

@media (max-width: 1500px) {
  .thumb-swiper .swiper-slide {
    width: calc((100% - 10px*2) / 3);
    margin-right: 10px;
  }
}

@media (max-width: 1500px) {
  .thumb-swiper .swiper-slide button {
    height: 70px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    font-weight: 700;
  }
}

@media (max-width: 1120px) {
  .thumb-swiper .swiper-slide button {
    height: 58px;
  }
}

.thumb-swiper .swiper-slide-thumb-active button {
  background-color: #444444;
  color: #ffffff;
}

.process-swiper {
  width: 626.9px;
}

@media (max-width: 1119px) {
  .process-swiper {
    width: 100%;
  }
}

.swiper-slide img {
  display: block;
  width: 626.9px;
  height: auto;
  object-fit: contain;
  border-radius: 6.86px;
}

@media (max-width: 1200px) {
  .swiper-slide img {
    width: 100%;
    border-radius: 6.86px;
  }
}

.step-line::before {
  content: '';
  position: absolute;
  width: 122px;
  border: 1px solid #444444;
  top: 50%;
  left: -25px;
  transform: translate(-100%, -50%);
}

.step-line::after {
  content: '';
  position: absolute;
  width: 122px;
  border: 1px solid #444444;
  top: 50%;
  right: -25px;
  transform: translate(100%, -50%);
}

@media (max-width: 1500px) {
  .step-line::before {
    width: 32px;
    left: -10px;
  }

  .step-line::after {
    width: 32px;
    right: -10px;
  }
}

/* 商品列表swiper */
.product-swiper-container {
  position: relative;
  width: 100%;
  margin: 0;
  padding: 0;
}

.product-swiper {
  width: 100%;
  height: auto;
}

.custom-swiper-pagination {
  position: absolute;
  top: -50px !important;
  right: 0px;
  height: 30px;
  display: flex;
  justify-content: end;
  align-items: center;
  padding-right: 30px;
}

.swiper-pagination-bullet {
  width: 10px;
  height: 10px;
  background: #fff;
  border-radius: 50%;
  margin: 0 8px !important;
  opacity: 0.2;
}

@media (max-width: 640px) {
  .swiper-pagination-bullet {
    margin: 0 4px !important;
  }
}

.swiper-pagination-bullet-active {
  background: #fff;
  opacity: 1;
}

.product-swiper .swiper-slide {
  width: 490.33px;
  display: flex;
  justify-content: center;
  align-items: center;
}

@media (max-width: 1535px) {
  .product-swiper .swiper-slide {
    width: 362.67px;
  }
}

/* 左箭頭 */
.product-swiper .swiper-button-prev {
  left: 50px;
}

.product-swiper .swiper-button-prev::after {
  font-size: 40px;
  font-weight: 900;
  color: white;
  text-shadow: 5px 5px 10px black;
}

/* 右箭頭 */
.product-swiper .swiper-button-next {
  right: 50px;
}

.product-swiper .swiper-button-next::after {
  font-size: 40px;
  font-weight: 900;
  color: white;
  text-shadow: 5px 5px 10px black;
}

.product-swiper .swiper-button-prev:hover,
.product-swiper .swiper-button-next:hover {
  transform: scale(1.1);
  transition: transform 0.1s linear;
}

button {
  cursor: pointer;
}

/* .custom-shadow {
  @apply [text-shadow:1px_1px_0_#B41900, -1px_1px_0_#B41900, 1px_-1px_0_#B41900, -1px_-1px_0_#B41900, 0px_1px_0_#B41900, 0px_-1px_0_#B41900, 1px_0px_0_#B41900, -1px_0px_0_#B41900];
} */

/* 暴走族特工服風格滾動條 - 黑紅配色 */
/* 滾動條整體樣式 */
::-webkit-scrollbar {
  width: 17px;
  height: 14px;
  background-color: #000;
}

/* 滾動條軌道 */
::-webkit-scrollbar-track {
  background: #111;
  border: 2px solid #333;
  box-shadow: inset 0 0 5px rgba(255, 0, 0, 0.2);
}

/* 自訂 scrollbar 方塊樣式 */
::-webkit-scrollbar-thumb {
  background: #FFC051;
  position: relative;
  border-radius: 0;
  background-image: url("/public/image/svg/scroll_bar_text_black.svg");
  background-repeat: no-repeat;
  background-position: center;
  background-size: contain;
  border-radius: 100px;
}

/* 滑鼠hover在方塊上的樣式 */
::-webkit-scrollbar-thumb:hover {
  background-image: url("/public/image/svg/scroll_bar_text_red.svg");
}

/* 滑動條角落 */
::-webkit-scrollbar-corner {
  background-color: #000;
}
</style>