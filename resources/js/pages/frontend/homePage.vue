<script setup>
import { ref, computed, onMounted, onUnmounted, onBeforeUnmount, watch } from 'vue'
import { Link, router } from '@inertiajs/vue3'


import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/free-mode';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import 'swiper/css/thumbs';
import { FreeMode, Pagination, Navigation, Thumbs, Autoplay } from 'swiper/modules';
import { gsap } from 'gsap';
// import { Link } from 'lucide-vue-next';


// 商品製作的 thumbsSwiper
const thumbsSwiper1 = ref(null);
const setThumbsSwiper1 = (swiper) => {
  thumbsSwiper1.value = swiper;
};

// 下單購買的 thumbsSwiper
const thumbsSwiper2 = ref(null);
const setThumbsSwiper2 = (swiper) => {
  thumbsSwiper2.value = swiper;
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
})

onBeforeUnmount(() => {
  window.removeEventListener('scroll', handleScroll);
  // 還原滾動條狀態
  document.body.style.overflow = 'auto';
  window.removeEventListener('resize', handleResize);
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

// nav menu links
const menuItems = [
  { id: 'portfolio', name: '作品集', href: '#portfolio' },
  { id: 'about', name: '品牌理念', href: '#about' },
  { id: 'method', name: '製作方式', href: '#method' },
  { id: 'product', name: '商品列表', href: '#product' },
  { id: 'contact', name: '聯絡方式', href: '#contact' },
]


const props = defineProps({
  banners: Array | Object ,
  response: Array | Object ,
});

// banner swiper
const slides = props.banners;
const slidesCount = slides.length;
let activeIndex = ref(0);
let swiperInstance = null;

const slidesCharacters = ref(slides.map(item => item.title.split('')));

// 保存當前活動的動畫
let activeAnimation = null;

const animateSlideText = () => {
  // 終止現有動畫
  if (activeAnimation) {
    activeAnimation.kill();
  }

  const charElements = document.querySelectorAll('.swiper-slide-active .char');

  if (charElements.length === 0) return;

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

// 抓下單購買資料
// const props = defineProps({ response: Array | Object });
// console.log(props.response);


// 點擊MORE出現更多資訊頁面
const isMoreOpen = ref(false);
const currentProductId = ref(null);


let scrollPosition = 0;
const openModal = (productId) => {
  currentProductId.value = productId;

  isMoreOpen.value = true;
  // 禁用body頁面滾動條
  scrollPosition = window.pageYOffset;
  document.body.style.overflow = 'hidden';
  document.body.style.position = 'fixed';
  document.body.style.top = `-${scrollPosition}px`;
  // document.body.style.width = '100%';
}

const hideModal = () => {
  isMoreOpen.value = false;
  document.body.style.overflow = 'auto';
  document.body.style.position = '';
  document.body.style.top = '';
  // document.body.style.width = '';

  window.scrollTo(0, scrollPosition);
}

const currentProduct = () => {
  if (!currentProductId.value) return null;
  return props.response.find(product => product.id === currentProductId.value) || null;
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
  const product = currentProduct(productId);
  if (!product) {
    alert('商品ID無效或未找到商品');
    return;
  }

  // 確保商品不重複加入購物車
  if (!productIds.value.includes(product.id)) {
    productIds.value.push(product.id);
    // console.log(`商品ID ${product.id} 已加入詢價`);
  } else {
    // console.log(`商品ID ${product.id} 已存在於詢價清單中`);
    alert(`您已將該商品加入購物車!`);
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
  // console.log(data);
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
  <nav class="max-w-[1903px] mx-auto">
    <div class="fixed top-0 left-0 w-full z-10">
      <div class="max-w-[1903px] h-[40px] bg-[#B41900] mx-auto flex justify-center items-center text-white">
        <p class="font-noto-cjk text-sm font-normal leading-[1.2]">
          台湾無敵の特工服オーダーメイドブランド
        </p>
      </div>
    </div>
    <div id="portfolio"
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
                  天下無敵、台湾特工服の第一品牌
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
                <img src="/image/svg/Polygon 1.svg" alt="">
                <p class="font-noto font-normal leading-[1.2]">Menu</p>
              </div>
              <div
                :class="[isFixed ? 'hidden min-[1201px]:flex gap-6 pl-6' : 'flex flex-wrap min-[577px]:gap-4 gap-x-8 gap-y-4 min-[577px]:pl-4 min-[577px]:flex-col']">
                <a v-for="item in menuItems" :key="item.id" :href="item.href" class="flex items-center gap-[9px]">
                  <img src="/image/svg/Arrow 2.svg" alt="">
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
          <img src="/image/svg/Arrow 2.svg" alt="">
          <p class="font-normal leading-[1.2]">{{ item.name }}</p>
        </a>
      </div>
    </div>
    <div v-if="isFixed" class="bg-white h-[363px]"></div>
  </nav>
  <main class="max-w-[1903px] mx-auto">
    <!-- banner -->
    <section class="w-full">
      <swiper :loop="true" :pagination="{
        el: '.banner-swiper-pagination',
        clickable: true,
        type: 'custom',
        renderCustom: renderCustomPagination
      }" :navigation="false" :autoplay="{ delay: 2500, disableOnInteraction: false }" @transitionEnd="onTransitionEnd"
        @autoplayTimeLeft="onAutoplayTimeLeft" :modules="modules" class="banner-swiper">
        <swiper-slide v-for="(chars, index) in slidesCharacters" :key="index" :class="`slide-${index}`"
          class="banner-swiper-slide">
          <img :src="slides[index].img_path" alt="" class="big-img">
          <div class="container">
            <img :src="slides[index].img_path" alt="" class="center-img">
            <div class="absolute inset-0 flex items-center justify-center">
              <span v-for="(char, charIndex) in chars" :key="charIndex"
                class="char text-white sm:text-[80px] text-[40px] font-bold tracking-[6px] opacity-0 block">
                {{ char }}
              </span>
            </div>
          </div>
        </swiper-slide>
        <div class="banner-swiper-pagination"></div>
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
          <swiper :speed="1" :loop="true" :slidesPerView="'auto'" :navigation="false"
            :thumbs="{ swiper: thumbsSwiper1 }" :modules="modules" :autoplay="{
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
      <div id="product" class="w-full bg-[#333333] flex flex-col gap-4 py-8">
        <div class="flex items-center gap-6 2xl:px-[200px] md:px-10 px-4">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M24 0V24H0L24 0Z" fill="white" />
          </svg>
          <p class="font-noto-cjk 2xl:text-[80px] md:text-[48px] text-[32px] text-white font-bold leading-[1.2]">下單購買
          </p>
        </div>
        <!-- 商品列表 Swiper -->
        <div class="product-swiper-container">
          <div class="custom-swiper-pagination"></div>
          <swiper :loop="true" :navigation="true" :spaceBetween="20" :centeredSlides="true" :slidesPerView="'auto'"
            :pagination="{
              el: '.custom-swiper-pagination',
              clickable: true,
            }" :modules="modules" class="product-swiper">
            <swiper-slide v-for="product in props.response" :key="product.id">
              <div
                class="w-full relative flex flex-col gap-2 shadow-[0px_0px_4px_0px_rgba(0,0,0,0.1)] rounded-tl-2xl rounded-tr-2xl group">
                <img class="rounded-tl-2xl rounded-tr-2xl" :src="product.img_url" alt="">
                <div class="flex flex-col gap-2 px-2">
                  <p class="font-noto-cjk text-[24px] text-white font-bold leading-[1.2]">
                    {{ product.name }}
                  </p>
                  <p
                    class="hidden 2xl:block font-pingfang-r text-[32px] text-[#C89E51] font-normal leading-[100%] tracking-[0.08em] opacity-80 custom-shadow">
                    ${{ product.price }}
                  </p>
                </div>
                <!-- 遮罩 -->
                <div
                  class="absolute inset-0 z-10 transition-all duration-300 ease-in-out group-hover:bg-black group-hover:bg-opacity-50">
                </div>
                <!-- More -->
                <div
                  class="absolute top-[40%] left-1/2 -translate-x-1/2 -translate-y-1/2 opacity-0 transition-opacity duration-300 group-hover:opacity-100 z-20">
                  <button
                    class="border-2 border-[#FFD83C] rounded-[8px] font-noto-jp text-[#FFD83C] text-2xl font-medium px-5 py-2"
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
            <img src="/image/svg/Shopee_logo.svg" alt="">
            <p class="font-noto-cjk text-[#444444] text-lg font-normal leading-[1.5]">蝦皮賣場</p>
            <img src="/image/svg/icon-arrow.svg" alt="">
          </a>
        </div>
      </div>
    </section>
  </main>
  <!-- 商品製作 點擊按鈕出現圖片 -->
  <div v-if="isShowImage" class="w-full fixed bg-black/50 inset-0 z-50" @click="hideImage">
    <div class="w-full absolute inset-0 flex justify-center items-center">
      <img :src="currentImage" class="w-full xl:w-[808px] lg:w-[900px] z-50" alt="">
    </div>
  </div>
  <!-- 下單購買 點擊MORE相關資訊 -->
  <div v-show="isMoreOpen" class="w-full h-dvh fixed bg-black/50 inset-0 z-50  py-12" @click="hideModal"
    :keyup.enter="hideModal">
    <div
      class="more-container relative min-[1200px]:w-[1110px] w-[97%] overflow-y-auto h-full bg-[#2F2F2F] text-white mx-auto z-50"
      @click.stop>
      <button type="button" class="w-14 h-14 absolute top-6 right-6 flex justify-center items-center border-2"
        @click="hideModal">
        <i class="fa-solid fa-xmark text-5xl"></i>
      </button>
      <!-- 商品介紹 -->
      <div class="w-full min-[641px]:px-16 px-4 py-12 ">
        <p class="text-2xl font-semibold mb-10">商品介紹</p>
        <div class="flex items-center min-[1150px]:flex-nowrap flex-wrap min-[641px]:gap-6 gap-4">
          <div
            class="w-full min-[1150px]:w-3/5 flex min-[769px]:flex-row flex-col justify-center min-[641px]:items-center min-[1150px]:gap-6 min-[500px]:gap-[40px] gap-4">
            <!-- 縮圖 -->
            <swiper @swiper="setThumbsSwiper2" :loop="true" :direction="windowWidth <= 768 ? 'horizontal' : 'vertical'"
              :spaceBetween="windowWidth <= 500 ? 16 : 24" :slidesPerView="'auto'" :freeMode="true" :modules="modules"
              class="mySwiper min-[769px]:order-0 order-1">
              <swiper-slide>
                <img :src="currentProduct()?.img_url" alt="">
              </swiper-slide>
              <swiper-slide>
                <img src="https://swiperjs.com/demos/images/nature-2.jpg" alt="">
              </swiper-slide>
              <swiper-slide>
                <img src="https://swiperjs.com/demos/images/nature-3.jpg" alt="">
              </swiper-slide>
              <swiper-slide>
                <img src="https://swiperjs.com/demos/images/nature-4.jpg" alt="">
              </swiper-slide>
            </swiper>
            <!-- 大圖 -->
            <swiper :loop="true" :spaceBetween="5" :pagination="{
              type: 'fraction',
            }" :navigation="true" :thumbs="{ swiper: thumbsSwiper2 }" :modules="modules"
              class="mySwiper2 min-[769px]:order-1 order-0">
              <swiper-slide>
                <img :src="currentProduct()?.img_url" class="aspect-square object-cover object-center" alt="">
              </swiper-slide>
              <swiper-slide>
                <img src="https://swiperjs.com/demos/images/nature-2.jpg"
                  class="aspect-square object-cover object-center" alt="">
              </swiper-slide>
              <swiper-slide>
                <img src="https://swiperjs.com/demos/images/nature-3.jpg"
                  class="aspect-square object-cover object-center" alt="">
              </swiper-slide>
              <swiper-slide>
                <img src="https://swiperjs.com/demos/images/nature-4.jpg"
                  class="aspect-square object-cover object-center" alt="">
              </swiper-slide>
            </swiper>
          </div>
          <!-- 右側商品資訊 -->
          <div class="w-full min-[1150px]:w-2/5 flex flex-col gap-4">
            <p class="text-xl font-bold px-3 py-4 border-b border-white">
              {{ currentProduct()?.name }}
            </p>
            <p class="px-3 pb-4">繡出你的態度，隨時隨地簡單暴走中</p>
            <p class="text-[#FFD83C] text-2xl font-medium px-3 pb-4">
              $300 ~ $400
            </p>
            <div class="space-y-2 px-3 min-[1150px]:pb-10 pb-4">
              <div class="flex items-center gap-2">
                <img src="/image/svg/check.svg" class="w-5 h-6" alt="">
                <p>台製高質感刺繡頭帶</p>
              </div>
              <div class="flex items-center gap-2">
                <img src="/image/svg/check.svg" class="w-5 h-6" alt="">
                <p>頭帶約 100*5公分</p>
              </div>
              <div class="flex items-center gap-2">
                <img src="/image/svg/check.svg" class="w-5 h-6" alt="">
                <p>可客制刺繡，繡出自己的暴走魂</p>
              </div>
              <div class="flex items-center gap-2">
                <img src="/image/svg/check.svg" class="w-5 h-6" alt="">
                <p>灣出產精品品質</p>
              </div>
              <div class="flex items-center gap-2">
                <img src="/image/svg/check.svg" class="w-5 h-6" alt="">
                <p>精美原立包裝 送禮自用兩相宜</p>
              </div>
              <div class="flex items-center gap-2">
                <img src="/image/svg/check.svg" class="w-5 h-6" alt="">
                <p>時隨地簡單暴走中</p>
              </div>
            </div>
            <div class="flex justify-end">

              <button type="button" class="border border-white rounded-[18px] flex items-center gap-2 px-10 py-3"
                @click="addProductId(productId)">
                <img src="/image/svg/inquiry.svg" class="w-[34px] h-[28px]" alt="" />
                <p class="text-white text-2xl font-bold">加入詢價</p>
              </button>

            </div>
          </div>
        </div>
      </div>
      <!-- 推薦商品 -->
      <div class="w-full py-12">
        <p class="text-2xl font-semibold border-b-2 border-white min-[641px]:mx-16 mx-4 pb-6 mb-10">推薦商品</p>
        <!-- 商品列表 Swiper -->
        <div class="product-swiper-container">
          <swiper :loop="false" :navigation="true" :spaceBetween="50" :centeredSlides="false"
            :slidesPerView="windowWidth <= 768 ? 'auto' : 2" :watchOverflow="true" :modules="modules"
            class="product-swiper">
            <swiper-slide v-for="product in props.response" :key="product.id">
              <div
                class="w-full relative flex flex-col gap-2 shadow-[0px_0px_4px_0px_rgba(0,0,0,0.1)] rounded-tl-2xl rounded-tr-2xl group">
                <img class="rounded-tl-2xl rounded-tr-2xl" :src="product.img_url" alt="">
                <div class="flex flex-col gap-2 px-2">
                  <p class="font-noto-cjk text-[24px] text-white font-bold leading-[1.2]">
                    {{ product.name }}
                  </p>
                  <p
                    class="hidden 2xl:block font-pingfang-r text-[32px] text-[#C89E51] font-normal leading-[100%] tracking-[0.08em] opacity-80 custom-shadow">
                    ${{ product.price }}
                  </p>
                </div>
                <!-- 遮罩 -->
                <div
                  class="absolute inset-0 z-10 transition-all duration-300 ease-in-out group-hover:bg-black group-hover:bg-opacity-50">
                </div>
                <!-- More -->
                <div
                  class="absolute top-[40%] left-1/2 -translate-x-1/2 -translate-y-1/2 opacity-0 transition-opacity duration-300 group-hover:opacity-100 z-20">
                  <button
                    class="border-2 border-[#FFD83C] rounded-[8px] font-noto-jp text-[#FFD83C] text-2xl font-medium px-5 py-2"
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
      <img src="/image/svg/shipping-icon.svg" class="w-full h-full object-cover" />
      <p class="absolute top-[19px] right-[79px] translate-x-1/2 -translate-y-1/2 md:text-xl text-[0px] font-bold">
        {{ inquiryCount }}
      </p>
    </div>
  </button>


  <!-- 購物車icon - 769px以下 -->
  <Link v-if="!isLargeScreen && inquiryCount > 0" :href="route('inquirePage')"
    class="w-[50px] fixed top-80 left-2 z-10 cursor-pointer" @click="gotoinquire(productIds)">
  <div class="relative w-full h-full">
    <img src="/image/svg/shipping-cart-small.svg" class="w-full h-full object-cover" />
    <p
      class="absolute top-[-2px] right-[3px] translate-x-1/2 -translate-y-1/2 md:text-[0px] min-[476px]:font-bold text-white bg-red-600 rounded-full md:w-0 min-[476px]:w-[24px] w-[18px] md:h-0 min-[476px]:h-[24px] h-[18px] flex justify-center items-center">
      {{ inquiryCount }}
    </p>
  </div>
  </Link>


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
          class="font-freckle text-white min-[522px]:text-[64.77px] text-[50.31px] font-normal leading-[1.2] tracking-[-0.08em]">
        ITS SHOW TIME</pre>
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

button {
  cursor: pointer;
}

/* banner Swiper */
.banner-swiper-slide {
  width: 100%;
  height: calc(100vh - 100px);
  text-align: center;
  position: relative;
}

.banner-swiper-slide .big-img {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 100%;
  height: 100%;
  object-position: center;
  object-fit: cover;
  background-color: #000;
  opacity: 0.3;
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

@media (max-width: 1000px) {
  .banner-swiper-slide .center-img {
    width: 100%;
    margin: 0 auto;
    height: auto;
  }
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

.banner-swiper-pagination {
  position: absolute;
  bottom: 20px;
  left: 0;
  width: 100%;
  text-align: center;
  z-index: 10;
}

.custom-pagination-container {
  width: 80%;
  margin: 0 auto;
  display: flex;
  justify-content: center;
}

@media (max-width: 1024px) {
  .custom-pagination-container {
    width: 60%;
    gap: 8px;
  }
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

/* 箭頭 hover 效果 */
.swiper-button-prev:hover,
.swiper-button-next:hover {
  transform: scale(1.1);
  transition: transform 0.1s linear;
}

/* more 頁面的 Swiper */
.more-container .swiper {
  width: auto;
  height: auto;
  margin: 0;
  box-sizing: border-box;
  cursor: pointer;
}

.more-container .mySwiper2 {
  width: 450px;
}

@media (max-width: 640px) {
  .more-container .mySwiper2 {
    margin: 0 auto;
  }
}

@media (max-width: 499px) {
  .more-container .mySwiper2 {
    width: 300px;
  }
}

.more-container .mySwiper2 .swiper-slide img {
  border-radius: 5px;
}

.more-container .mySwiper {
  display: inline-flex;
}

.more-container .mySwiper .swiper-wrapper {
  width: auto;
}

@media (max-width: 640px) {
  .more-container .mySwiper .swiper-wrapper {
    margin-left: 0 !important;
    margin-right: auto !important;
  }
}

.more-container .mySwiper .swiper-slide {
  width: auto;
  height: auto;
}

.more-container .mySwiper .swiper-slide:last-child {
  margin: 0 !important;
}

.more-container .mySwiper .swiper-slide img {
  width: 100px;
  aspect-ratio: 1;
  border-radius: 3px;
}

@media (max-width: 640px) {
  .more-container .mySwiper .swiper-slide img {
    width: 70px;
  }
}

@media (max-width: 499px) {
  .more-container .mySwiper .swiper-slide img {
    width: 60px;
  }
}

.more-container .mySwiper .swiper-slide-thumb-active {
  border-radius: 3px;
  border: 2px solid #FFD83C;
}

.more-container .swiper-pagination-fraction {
  position: absolute;
  left: 85%;
  right: 0;
  bottom: 0;
  background-color: black;
  width: auto;
  color: white;
  padding: 5px 0;
}

.more-container .swiper-button-next,
.more-container .swiper-button-prev {
  color: white;
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