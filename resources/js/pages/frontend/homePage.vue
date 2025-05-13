<script setup>
import BannerSwiper from '@/components/BannerSwiper.vue';
import DetailSwiper from '@/components/DetailSwiper.vue';
import FrontendLayout from '@/layouts/FrontendLayout.vue';

import { ref, computed, onMounted, onUnmounted, onBeforeUnmount, watch, nextTick, defineProps } from 'vue'
import { Link, router } from '@inertiajs/vue3'


import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/free-mode';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import 'swiper/css/thumbs';
import { FreeMode, Pagination, Navigation, Thumbs, Autoplay } from 'swiper/modules';
// import { gsap } from 'gsap';


// 商品製作的 thumbsSwiper
const thumbsSwiper1 = ref(null);
const setThumbsSwiper1 = (swiper) => {
  thumbsSwiper1.value = swiper;
};

const modules = [FreeMode, Pagination, Navigation, Thumbs, Autoplay];

// nav fixed
const isFixed = ref(false);
let lastScrollY = 0;

const handleScroll = () => {
  const currentScrollY = window.scrollY;
  // scroll buffer
  if (currentScrollY > 270 && !isFixed.value) {
    isFixed.value = true;
  } else if (currentScrollY < 230 && isFixed.value) {
    isFixed.value = false;
  };
  lastScrollY = currentScrollY;
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll);
  window.addEventListener('resize', handleResize);
  // resetSwiper();
})

onBeforeUnmount(() => {
  window.removeEventListener('scroll', handleScroll);
  // 還原滾動條狀態
  document.body.style.overflow = 'auto';
  window.removeEventListener('resize', handleResize);
  // resetSwiper();
})

// hamberger menu
const isOpen = ref(false);
const windowWidth = ref(window.innerWidth);

const toggleMenu = () => {
  isOpen.value = !isOpen.value;

  if (isOpen.value) {
    document.body.style.overflow = 'hidden';
  } else {
    document.body.style.overflow = 'auto';
  };
};

const closeHamMenu = () => {
  isOpen.value = false;
  document.body.style.overflow = 'auto';
}

const handleResize = () => {
  windowWidth.value = window.innerWidth;
  // 螢幕寬度超過1200px，自動關閉漢堡選單
  if (windowWidth.value >= 1201) {
    isOpen.value = false;
    document.body.style.overflow = 'auto';
  }
};


const props = defineProps({
  banners: Array | Object,
  response: Array | Object,
  auth: Object,
});


// 判斷會員是否登入判斷
const isLoggedIn = computed(() => !!props.auth?.user);


// nav menu links
const menuItems = [
  { id: 'portfolio', name: '作品集', href: '#portfolio' },
  { id: 'about', name: '品牌理念', href: '#about' },
  { id: 'method', name: '製作方式', href: '#method' },
  { id: 'product', name: '商品列表', href: '#product' },
  { id: 'contact', name: '聯絡方式', href: '#contact' },
  {
    id: 'profile',
    name: isLoggedIn.value ? '我的檔案' : '會員登入',
    href: isLoggedIn.value ? '/myprofile' : '/login',
  },

];


// 商品製作點擊按鈕顯示圖片
const isShowImage = ref(false);
const currentImage = ref('');

const handleClick = (event) => {
  isShowImage.value = !isShowImage.value;
  const imgUrl = event.currentTarget.dataset.img;
  currentImage.value = imgUrl;
}
const hideImage = () => {
  isShowImage.value = false;
};

// 點擊MORE出現更多資訊頁面
const isMoreOpen = ref(false);
const selectedProduct = ref([]);

const modalContainer = ref(null);

let scrollPosition = 0;
const openModal = (productId) => {
  selectedProduct.value = props.response.find(product => product.id === productId) || null;

  if (!isMoreOpen.value) {
    // 禁用body頁面滾動條
    scrollPosition = window.pageYOffset;
    document.body.style.top = `-${scrollPosition}px`;
    // document.body.style.position = 'fixed';
    document.body.style.overflow = 'hidden';
  }

  isMoreOpen.value = true;

  nextTick(() => {
    if (modalContainer.value) {
      modalContainer.value.scrollTop = 0;
    }
  });
};

const hideModal = () => {

  isMoreOpen.value = false;
  document.body.style.overflow = 'auto';
  // document.body.style.position = '';
  document.body.style.top = '';

  window.scrollTo(0, scrollPosition);

};


// 新增商品ID到購物車
const productIds = ref([]);

// 計算目前詢價的商品數量
const inquiryCount = computed(() => productIds.value.length);
// 當inquiryCount大於0，商品彈窗自動關閉
watch(inquiryCount, (newVal) => {
  if (newVal > 0 && isMoreOpen.value) {
    setTimeout(() => {
      hideModal();
    }, 150);
  }
});

const addProductId = (productId) => {
  const product = selectedProduct.value;

  if (!product) {
    alert('商品ID無效或未找到商品');
    return;
  }

  // 確保商品不重複加入詢價
  if (!productIds.value.includes(product.id)) {
    productIds.value.push(product.id);
  } else {
    Swal.fire({
      title: "您已將該商品加入詢價!",
      icon: "success",
      draggable: true
    });
    return;
  }
};

// 點選購物車跳轉至詢價頁
const gotoinquire = (ids) => {
  if (!ids || ids.length === 0) {
    // !ids-> 防止傳進來的是 undefined 或 null(確保空陣列也會被擋下)
    alert('您尚未添加任何商品，無法進入詢價頁面');
    return;
  }

  const data = { id: ids };
  router.get(route('inquirePage'), data);
};


// 偵測螢幕寬度變化並更新購物車顯示
const isLargeScreen = ref(windowWidth.value >= 769);

const shippingCartsize = () => {
  windowWidth.value = window.innerWidth;
  isLargeScreen.value = windowWidth.value >= 769;
};

onMounted(() => {
  window.addEventListener('resize', shippingCartsize);
});

// 移除監聽器
onUnmounted(() => {
  window.removeEventListener('resize', shippingCartsize);
});
</script>

<template>
  <FrontendLayout>
    <nav class="max-w-[1903px] mx-auto">
      <div class="fixed top-0 left-0 w-full z-10">
        <div class="max-w-[1903px] h-[40px] bg-[#B41900] mx-auto flex justify-center items-center text-white">
          <p class="font-noto-cjk text-sm font-normal leading-[1.2]">
            台湾無敵の特攻服オーダーメイドブランド
          </p>
        </div>
      </div>
      <div
        :class="[isFixed ? 'max-w-[1903px] mx-auto fixed top-[40px] left-0 right-0 shadow-[0px_4px_8px_0px_rgba(0,0,0,0.1)] z-10 bg-white' : ' ']">
        <div
          :class="[isFixed ? 'justify-between 2xl:px-[200px] lg:px-[100px] px-5 py-[10px]' : 'mt-[40px] min-[577px]:h-[363px]']"
          class="w-full bg-white flex items-center">
          <div
            :class="[isFixed ? 'w-full flex justify-between items-center' : 'w-full flex flex-col justify-between min-[577px]:flex-row']">
            <!-- 左：logo -->
            <div
              :class="[isFixed ? 'flex items-center gap-2' : 'w-full relative lg:pl-[30px] xl:pl-[100px] sm:pt-6 pt-0 md:ms-10 lg:ms-0']">
              <div
                :class="[isFixed ? 'flex items-center gap-2' : 'relative w-full h-[93px] xl:w-[724px] xl:h-[132.84px] 2xl:w-[1041px] 2xl:h-[191px] mr-auto']">
                <img
                  :class="[isFixed ? 'w-12 -mb-2' : 'absolute top-[32px] left-[20px] md:left-[60px] 2xl:top-[0.5px] 2xl:left-[82px] w-[52.71px] md:w-[80px] lg:w-[107.81px] 2xl:w-[155.01px]']"
                  src="/image/LOGO-方.webp" alt="logo">
                <div :class="[isFixed ? 'flex flex-col' : ' ']">
                  <p
                    :class="[isFixed ? 'font-noto-jp text-[#444444] text-[12px] font-black leading-[2] tracking-[-0.08em]' : 'h-[8px] text-[11px] md:text-[20px] lg:h-[16px] lg:text-[22.26px] 2xl:h-[23px] 2xl:text-[32px] font-noto-jp text-[#444444] font-black leading-[1.2] tracking-[-0.08em] absolute top-[30px] left-[80px] md:top-[35px] md:left-[150px] lg:left-[180px] xl:top-[40px] 2xl:left-[240px] 2xl:top-[10px]']">
                    天下無敵、台湾特攻服の第一品牌
                  </p>
                  <pre
                    :class="[isFixed ? 'font-freckle text-[#444444] sm:text-[40px] text-[32px] font-normal leading-[0.7] tracking-[-0.08em]' : 'h-[36px] text-[47.61px] md:text-[54px] lg:text-[97.37px] 2xl:h-[107px] 2xl:text-[140px] font-freckle text-[#444444] font-normal leading-[1.1] tracking-[-0.08em] absolute bottom-[10px] left-[80px] md:bottom-0 md:left-[150px] lg:left-[180px] xl:bottom-[30px] 2xl:left-[240px] 2xl:bottom-[50px]']">ITS SHOW  TIME</pre>
                </div>
              </div>
            </div>
            <!-- 右：menu -->
            <div
              :class="[isFixed ? ' ' : 'w-full h-auto relative font-noto-cjk justify-center text-[#000000] min-[577px]:flex min-[577px]:w-[50%] sm:pr-20 px-4 min-[577px]:pb-0 pb-6 min-[557px]:pt-0 pt-3']"
              class="">
              <!-- hamberger menu icon -->
              <button type="button"
                :class="[isFixed ? 'w-9 h-9 flex min-[1201px]:hidden justify-center items-center cursor-pointer p-6 hover:bg-slate-100' : 'hidden']"
                @click="toggleMenu">
                <i :class="[isOpen ? 'fa-xmark text-4xl' : 'fa-bars text-3xl']" class="fa-solid"></i>
              </button>
              <!-- menu -->
              <div :class="[isFixed ? ' ' : 'flex flex-col gap-4']">
                <div :class="[isFixed ? 'hidden' : 'flex items-center gap-[5px]']">
                  <img src="/image/svg/Polygon 1.svg" alt="Polygon_icon">
                  <p class="font-noto font-normal leading-[1.2]">Menu</p>
                </div>
                <div
                  :class="[isFixed ? 'hidden min-[1201px]:flex gap-6 pl-6' : 'flex flex-wrap min-[577px]:gap-4 gap-x-8 gap-y-4 min-[577px]:pl-4 min-[577px]:flex-col']">
                  <a v-for="item in menuItems" :key="item.id" :href="item.href" class="flex items-center gap-[9px]">
                    <img src="/image/svg/Arrow 2.svg" alt="Arrow_icon">
                    <p class="font-normal leading-[1.2]">{{ item.name }}</p>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- hamberger menu -->
        <div v-show="isOpen"
          class="min-[1201px]:hidden w-full h-[calc(100vh-100px)] flex flex-col justify-center items-center gap-8 text-xl">
          <a v-for="item in menuItems" :key="item.id" :href="item.href" class="flex items-center gap-[9px]"
            @click="closeHamMenu">
            <img src="/image/svg/Arrow 2.svg" alt="Arrow_icon">
            <p class="font-normal leading-[1.2]">{{ item.name }}</p>
          </a>
        </div>
      </div>
      <div v-if="isFixed" class="bg-white h-[363px]"></div>
    </nav>
    <main class="max-w-[1903px] mx-auto">
      <!-- banner -->
      <section id="portfolio" class="w-full">
        <BannerSwiper :bannerData="props.banners"></BannerSwiper>
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
                  src="/image/svg/infinity.svg" alt="infinity_icon">
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
          <img class="w-full object-cover" src="/image/2.webp" alt="/image/2.webp">
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
                  <img src="/image/svg/Polygon 1.svg" class="w-6 h-6" alt="Polygon_icon">
                  <p
                    class="font-noto-cjk text-[#444444] min-[1501px]:text-[64px] min-[769px]:text-[48px] text-[32px] font-bold leading-[1.2]">
                    設計自己的暴走魂</p>
                </div>
                <p class="font-Noto-serif-jp text-[#444444] min-[567px]:text-lg text-[16px] font-normal leading-[1.5]">
                  完全客製化，透過連結下載模板自行設計，有長版/短版/特攻褲各4色可做挑選。</p>
              </div>
              <!-- 進度條 -->
              <div class="w-full min-[1120px]:max-w-[731px] relative">
                <swiper @swiper="setThumbsSwiper1" :loop="true" :slidesPerView="'auto'" :freeMode="true"
                  :watchSlidesProgress="true" :modules="modules" class="thumb-swiper">
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
                  <img src="/image/svg/Polygon 1.svg" class="w-6 h-6" alt="Polygon_icon">
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
                      <img src="/image/svg/material-symbols_download.svg" alt="download_svg">
                      <span
                        class="font-Microsoft text-lg text-[#4D4D4D] font-bold leading-[100%] tracking-[1.35px] text-nowrap">
                        下載模板</span>
                    </div>
                  </a>
                </div>
              </div>
            </div>
            <swiper :speed="1" :loop="true" :slidesPerView="'auto'" :navigation="false"
              :thumbs="{ swiper: thumbsSwiper1 }" :modules="modules" :autoplay="{
                delay: 3000,
                disableOnInteraction: false
              }" class="process-swiper">
              <swiper-slide>
                <img src="/image/3-1.webp" alt="/image/3-1.webp" />
              </swiper-slide>
              <swiper-slide>
                <img src="/image/3-2.webp" alt="/image/3-2.webp" />
              </swiper-slide>
              <swiper-slide>
                <img src="/image/3-3.webp" alt="/image/3-3.webp" />
              </swiper-slide>
            </swiper>
            <!-- 價目參考樣式(後面) -->
            <div class="w-full flex min-[1120px]:hidden flex-col gap-6 py-6">
              <div class="flex min-[769px]:gap-6 gap-3 mb-6">
                <img src="/image/svg/Polygon 1.svg" class="w-6 h-6" alt="Polygon_icon">
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
                    <img src="/image/svg/material-symbols_download.svg" alt="download_icon">
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
        <div id="product" class="w-full bg-[#333333] flex flex-col gap-4 py-8">
          <div class="flex items-center gap-6 2xl:px-[200px] md:px-10 px-4">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M24 0V24H0L24 0Z" fill="white" />
            </svg>
            <p class="font-noto-cjk 2xl:text-[80px] md:text-[48px] text-[32px] text-white font-bold leading-[1.2]">下單購買
            </p>
          </div>
          <!-- 商品列表 Swiper -->
          <div class="relative w-full m-0 p-0">
            <div class="custom-swiper-pagination"></div>
            <swiper :loop="true" :navigation="true" :spaceBetween="20" :centeredSlides="true" :slidesPerView="'auto'"
              :pagination="{
                el: '.custom-swiper-pagination',
                clickable: true,
              }" :modules="modules" class="product-swiper">
              <swiper-slide v-for="product in props.response" :key="product.id">
                <div
                  class="w-full h-full relative flex flex-col gap-2 shadow-[0px_0px_4px_0px_rgba(0,0,0,0.1)] rounded-tl-2xl rounded-tr-2xl group p-2 cursor-pointer">
                  <div class="relative z-10 group">
                    <img class="rounded-tl-2xl rounded-tr-2xl" :src="product.first_img?.img_path" :alt="product.first_img?.img_name">
                    <div
                      class="absolute inset-0 group-hover:bg-black/50 transition duration-300 rounded-tl-2xl rounded-tr-2xl">
                    </div>
                  </div>
                  <div class="h-full flex flex-col justify-between gap-2 px-2">
                    <p class="font-noto-cjk text-[24px] text-white font-bold leading-[1.2] line-clamp-2">
                      {{ product.name }}
                    </p>
                    <p
                      class="hidden 2xl:block font-pingfang-r text-[32px] text-[#C89E51] font-bold leading-[100%] tracking-[0.08em] opacity-80 custom-shadow">
                      {{ product.price }}
                    </p>
                  </div>
                  <!-- More -->
                  <div
                    class="absolute top-[38%] left-1/2 -translate-x-1/2 -translate-y-1/2 opacity-0 transition-opacity duration-300 group-hover:opacity-100 z-20">
                    <button
                      class="border-2 border-[#FFD83C] rounded-[8px] font-noto-jp text-[#FFD83C] min-[1535px]:text-2xl text-xl font-medium px-5 py-2"
                      type="button" @click="openModal(product.id)">
                      MORE
                    </button>
                  </div>
                </div>
              </swiper-slide>
            </swiper>
          </div>
          <div class="w-full flex justify-center">
            <a href="#"
              class="bg-white flex items-center gap-[10px] px-10 py-4 rounded-2xl shadow-[0px_4px_4px_0px_rgba(0,0,0,0.25)]">
              <img src="/image/svg/Shopee_logo.svg" alt="Shopee_logo">
              <p class="font-noto-cjk text-[#444444] text-lg font-normal leading-[1.5]">蝦皮賣場</p>
              <img src="/image/svg/icon-arrow.svg" alt="arrow_icon">
            </a>
          </div>
        </div>
      </section>
    </main>
    <!-- 商品製作 點擊按鈕出現圖片 -->
    <div v-if="isShowImage" class="w-full fixed bg-black/50 inset-0 z-50" @click="hideImage">
      <div class="w-full absolute inset-0 flex justify-center items-center">
        <img :src="currentImage" class="w-full xl:w-[808px] lg:w-[900px] z-50" :alt="currentImage">
      </div>
    </div>
    <!-- 下單購買 點擊MORE相關資訊 -->
    <div v-if="isMoreOpen" class="w-full h-dvh fixed bg-black/50 inset-0 z-50  py-12" @click="hideModal"
      :keyup.enter="hideModal">
      <div ref="modalContainer"
        class="more-container relative min-[1200px]:w-[1110px] w-[97%] overflow-y-auto h-full bg-[#2F2F2F] text-white mx-auto z-50"
        @click.stop>
        <button type="button" class="w-14 h-14 absolute top-6 right-6 flex justify-center items-center border-2 hover:bg-white/80 hover:text-[#2F2F2F]"
          @click="hideModal">
          <i class="fa-solid fa-xmark text-5xl"></i>
        </button>
        <!-- 商品介紹 -->
        <div class="w-full min-[641px]:px-16 px-4 py-12 ">
          <p class="text-2xl font-semibold mb-10">商品介紹</p>
          <div class="flex items-center min-[1150px]:flex-nowrap flex-wrap min-[641px]:gap-6 gap-4">
            <div
              class="w-full min-[1150px]:w-3/5 flex min-[769px]:flex-row flex-col justify-center min-[641px]:items-center min-[1150px]:gap-6 min-[500px]:gap-[40px] gap-4">

              <DetailSwiper :images="selectedProduct.images" :key="selectedProduct.id"></DetailSwiper>
            </div>
            <!-- 右側商品資訊 -->
            <div class="w-full min-[1150px]:w-2/5 flex flex-col gap-4">
              <p class="text-xl font-bold px-3 py-4 border-b border-white">
                {{ selectedProduct?.name }}
              </p>
              <p class="px-3 pb-4">繡出你的態度，隨時隨地簡單暴走中</p>
              <p class="text-[#FFD83C] text-2xl font-medium px-3 pb-4">
                {{ selectedProduct?.price }}
              </p>
              <div v-html="selectedProduct.introduction" class="space-y-2 px-3 min-[1150px]:pb-10 pb-4"></div>
              <div class="flex justify-end">
                <button type="button" class="border border-white rounded-[18px] flex items-center gap-2 px-10 py-3"
                  @click="addProductId(productId)">
                  <img src="/image/svg/inquiry.svg" class="w-[34px] h-[28px]" alt="inquiry_icon" />
                  <p class="text-white text-2xl font-bold">加入詢價</p>
                </button>
              </div>
            </div>
          </div>
        </div>
        <!-- 推薦商品 -->
        <div class="w-full py-12">
          <p class="text-2xl font-semibold border-b-2 border-white min-[641px]:mx-16 mx-4 pb-6 mb-10">
            推薦商品
          </p>
          <!-- 商品列表 Swiper -->
          <div class="relative w-full m-0 p-0">
            <swiper :loop="false" :navigation="true" :spaceBetween="50" :centeredSlides="false"
              :slidesPerView="windowWidth <= 768 ? 'auto' : 2" :watchOverflow="true" :modules="modules"
              class="product-swiper">
              <swiper-slide v-for="product in props.response" :key="product.id">
                <div
                  class="w-full h-full relative flex flex-col gap-2 shadow-[0px_0px_4px_0px_rgba(0,0,0,0.1)] rounded-tl-2xl rounded-tr-2xl group p-2 cursor-pointer">
                  <div class="relative z-10 group">
                    <img class="rounded-tl-2xl rounded-tr-2xl" :src="product.first_img?.img_path" :alt="product.first_img?.img_name">
                    <div
                      class="absolute inset-0 group-hover:bg-black/50 transition duration-300 rounded-tl-2xl rounded-tr-2xl">
                    </div>
                  </div>
                  <div class="flex-1 flex flex-col justify-between gap-2 px-2">
                    <p class="font-noto-cjk text-[24px] text-white font-bold leading-[1.2] line-clamp-2">
                      {{ product.name }}
                    </p>
                    <p
                      class="hidden 2xl:block font-pingfang-r text-[32px] text-[#C89E51] font-bold leading-[100%] tracking-[0.08em] opacity-80 custom-shadow">
                      {{ product.price }}
                    </p>
                  </div>
                  <!-- More -->
                  <div
                    class="absolute top-[38%] left-1/2 -translate-x-1/2 -translate-y-1/2 opacity-0 transition-opacity duration-300 group-hover:opacity-100 z-20">
                    <button
                      class="border-2 border-[#FFD83C] rounded-[8px] font-noto-jp text-[#FFD83C] min-[1535px]:text-2xl text-xl font-medium px-5 py-2"
                      type="button" @click="openModal(product.id)">
                      MORE
                    </button>
                  </div>
                </div>
              </swiper-slide>
            </swiper>
          </div>

        </div>
      </div>
    </div>

    <!-- 購物車icon -769px以上 -->
    <button v-if="isLargeScreen && inquiryCount > 0" type="button"
      class="w-[100px] fixed top-60 right-2 z-10 cursor-pointer" @click="gotoinquire(productIds)">
      <div class="relative w-full h-full">
        <img src="/image/svg/shipping-icon.svg" class="w-full h-full object-cover" alt="shipping-icon"/>
        <p class="absolute top-[19px] right-[79px] translate-x-1/2 -translate-y-1/2 md:text-xl text-[0px] font-bold">
          {{ inquiryCount }}
        </p>
      </div>
    </button>

    <!-- 購物車icon - 769px以下 -->
    <Link v-if="!isLargeScreen && inquiryCount > 0" :href="route('inquirePage')"
      class="w-[50px] fixed top-80 left-2 z-10 cursor-pointer" @click="gotoinquire(productIds)">
    <div class="relative w-full h-full">
      <img src="/image/svg/shipping-cart-small.svg" class="w-full h-full object-cover" alt="shipping-cart-icon"/>
      <p
        class="absolute top-[-2px] right-[3px] translate-x-1/2 -translate-y-1/2 md:text-[0px] min-[476px]:font-bold text-white bg-red-600 rounded-full md:w-0 min-[476px]:w-[24px] w-[18px] md:h-0 min-[476px]:h-[24px] h-[18px] flex justify-center items-center">
        {{ inquiryCount }}
      </p>
    </div>
    </Link>

  </FrontendLayout>
</template>

<style>
html,
body {
  font-size: 16px;
  background-color: #0A1109;
  margin: 0;
  padding: 0;
}

button {
  cursor: pointer;
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

.thumb-swiper .swiper-slide img {
  display: block;
  width: 626.9px;
  height: auto;
  object-fit: contain;
}

@media (max-width: 1200px) {
  .swiper-slide img {
    width: 100%;
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
.product-swiper {
  width: 100%;
  padding: 4px;
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

@media (max-width: 767px) {
  .swiper-pagination-bullet {
    width: 5px;
    height: 5px;
    margin: 0 4px !important;
  }
}

.swiper-pagination-bullet-active {
  background: #fff;
  opacity: 1;
}

.product-swiper .swiper-slide {
  width: 490.33px;
  height: 429.42px;
  display: flex;
  justify-content: center;
  align-items: center;
}

@media (max-width: 1535px) {
  .product-swiper .swiper-slide {
    width: 362.67px;
    height: 306.56px;
  }
}

.product-swiper .swiper-slide img {
  width: 100%;
  height: 307.83px;
  object-fit: cover;
  object-position: center;
}

@media (max-width: 1535px) {
  .product-swiper .swiper-slide img {
    height: 224.97px;
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

/* 箭頭 hover 效果 */
.swiper-button-prev:hover,
.swiper-button-next:hover {
  transform: scale(1.1);
  transition: transform 0.1s linear;
}

/* more 商品列表swiper */
.more-container .product-swiper-container {
  position: relative;
  width: 100%;
  margin: 0;
}

.more-container .product-swiper {
  width: 100%;
  padding: 0 50px;
}

.more-container .product-swiper-container .swiper-wrapper {
  display: flex;
  align-items: center;
}

@media (max-width: 768px) {
  .more-container .product-swiper .swiper-slide {
    width: 400px !important;
  }
}

@media (max-width: 520px) {
  .more-container .product-swiper .swiper-slide {
    width: 260px !important;
  }
}

/* 左箭頭 */
.more-container .product-swiper .swiper-button-prev {
  left: 15px;
}

.more-container .product-swiper .swiper-button-prev::after {
  font-size: 40px;
  font-weight: 900;
  color: white;
}

/* 右箭頭 */
.more-container .product-swiper .swiper-button-next {
  right: 15px;
}

.more-container .product-swiper .swiper-button-next::after {
  font-size: 40px;
  font-weight: 900;
  color: white;
}

.custom-shadow {
  text-shadow:
    1px 0 0 #B41900,
    -1px 0 0 #B41900,
    0 1px 0 #B41900,
    0 -1px 0 #B41900,
    1px 1px 0 #B41900,
    -1px 1px 0 #B41900,
    1px -1px 0 #B41900,
    -1px -1px 0 #B41900;
}

/* 暴走族特攻服風格滾動條 - 黑紅配色 */
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