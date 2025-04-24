<script setup>
import { ref } from 'vue'

import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/free-mode';
import 'swiper/css/navigation';
import 'swiper/css/thumbs';
import { FreeMode, Navigation, Thumbs, Autoplay } from 'swiper/modules';
const thumbsSwiper = ref(null);
const setThumbsSwiper = (swiper) => {
  thumbsSwiper.value = swiper
};
const modules = [FreeMode, Navigation, Thumbs, Autoplay];

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
    <div class="fixed top-0 left-0 w-full z-10">
      <div class="max-w-[1903px] h-[40px] bg-[#B41900] mx-auto flex justify-center items-center text-white">
        <p class="font-noto-cjk text-sm font-normal leading-[1.2]">
          台湾無敵の特工服オーダーメイドブランド
        </p>
      </div>
    </div>
    <!-- nav fixed -z-10 -->
    <!-- <div class="absolute top-[236px] left-0 right-0  z-50">
      <div class="w-full mx-auto sticky top-0 left-0 right-0 shadow-[0px_4px_8px_0px_rgba(0,0,0,0.1)] z-15 bg-amber-400">
        <div class="h-[40px] bg-[#B41900]"></div>
        <div class="flex justify-between items-center px-[200px] py-[10px]">
          <div class="flex items-center gap-2">
            <img src="/image/nav-logo.png" alt="">
            <div class="flex flex-col">
              <p class="font-noto-jp text-[#444444] text-[12px] font-black leading-[2] tracking-[-0.08em]">
                天下無敵、台湾特工服の第一品牌
              </p>
              <pre
                class="font-freckle text-[#444444] text-[43.48px] font-normal leading-[0.8] tracking-[-0.08em]">ITS SHOW  TIME</pre>
            </div>
          </div>
          <div class="flex gap-6 pl-6">
            <button type="button" class="flex items-center gap-[9px]">
              <img src="/image/svg/Polygon 1.svg" alt="">
              <p class="font-noto-cjk font-normal leading-[1.2]">作品集</p>
            </button>
            <button type="button" class="flex items-center gap-[9px]">
              <img src="/image/svg/Polygon 1.svg" alt="">
              <p class="font-noto-cjk font-normal leading-[1.2]">品牌理念</p>
            </button>
            <button type="button" class="flex items-center gap-[9px]">
              <img src="/image/svg/Polygon 1.svg" alt="">
              <p class="font-noto-cjk font-normal leading-[1.2]">製作方式</p>
            </button>
            <button type="button" class="flex items-center gap-[9px]">
              <img src="/image/svg/Polygon 1.svg" alt="">
              <p class="font-noto-cjk font-normal leading-[1.2]">商品頁</p>
            </button>
            <button type="button" class="flex items-center gap-[9px]">
              <img src="/image/svg/Polygon 1.svg" alt="">
              <p class="font-noto-cjk font-normal leading-[1.2]">聯絡方式</p>
            </button>
          </div>
        </div>
      </div>
    </div> -->

    <!-- header -->
    <div class="w-full mt-[40px] h-[210px] bg-white relative min-[577px]:h-[300px]">
      <!-- h-[334px] top-[69px] -->
      <div class="w-full absolute flex flex-col justify-center min-[577px]:flex-row min-[577px]:top-[60px]">
        <!-- 左：logo absolute top-[-29px] -->
        <div class="w-full min-[577px]:w-[50%] relative mb-[10px] lg:pl-[10px] xl:pl-[100px] md:ms-10 lg:ms-0">
          <div
            class="relative w-full h-[93px] px-[21px] pt-7 xl:w-[724px] xl:h-[132.84px] 2xl:w-[1041px] 2xl:h-[191px]">
            <img
              class="absolute top-[32px] left-[20px md:left-[60px] 2xl:top-[0.5px] 2xl:left-[82px] w-[52.71px] md:w-[80px] lg:w-[107.81px] 2xl:w-[155.01px] "
              src="/image/LOGO-方.webp" alt="logo">
            <p
              class="h-[8px] text-[11px] md:text-[20px] lg:h-[16px] lg:text-[22.26px] 2xl:h-[23px] 2xl:text-[32px] font-noto-jp text-[#444444] font-black leading-[1.2] tracking-[-0.08em] absolute top-[30px] left-[80px] md:top-[35px] md:left-[150px] lg:left-[180px] xl:top-[40px] 2xl:left-[240px] 2xl:top-[10px]">
              天下無敵、台湾特工服の第一品牌
            </p>
            <p
              class="h-[36px] text-[47.61px] md:text-[54px] lg:text-[97.37px] 2xl:h-[107px] 2xl:text-[140px] font-freckle text-[#444444] font-normal leading-[1] tracking-[-0.08em] absolute bottom-[10px] left-[80px] md:bottom-0 md:left-[150px] lg:left-[180px] xl:bottom-[30px] 2xl:left-[240px] 2xl:bottom-[50px]">
              ITS SHOW TIME
            </p>
          </div>
        </div>
        <!-- 右：menu absolute top-[-29px] -->
        <div
          class="w-full h-auto pl-4 relative font-noto-cjk justify-center text-[#000000] min-[577px]:flex min-[577px]:w-[50%]">
          <div class=" flex flex-col gap-3">
            <div class="flex items-center gap-[5px]">
              <img src="/image/svg/Polygon 1.svg" alt="">
              <p class="font-noto font-normal leading-[1.2]">Menu</p>
            </div>
            <div class="flex flex-wrap gap-3 pl-4 min-[577px]:flex-col">
              <div class="flex items-center gap-[9px]">
                <img src="/image/svg/Arrow 2.svg" alt="">
                <p class="font-normal leading-[1.2]">作品集</p>
              </div>
              <div class="flex items-center gap-[9px]">
                <img src="/image/svg/Arrow 2.svg" alt="">
                <p class="font-normal leading-[1.2]">品牌理念</p>
              </div>
              <div class="flex items-center gap-[9px]">
                <img src="/image/svg/Arrow 2.svg" alt="">
                <p class="font-normal leading-[1.2]">製作方式</p>
              </div>
              <div class="flex items-center gap-[9px]">
                <img src="/image/svg/Arrow 2.svg" alt="">
                <p class="font-normal leading-[1.2]">商品列表</p>
              </div>
              <div class="flex items-center gap-[9px]">
                <img src="/image/svg/Arrow 2.svg" alt="">
                <p class="font-normal leading-[1.2]">聯絡方式</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>
  <main class="max-w-[1903px] mx-auto">
    <!-- 第一張大圖 -->
    <section class="w-full flex justify-center items-center">
      <div class="w-2/5">
        <img class="w-full object-cover" src="/image/1-1.webp" alt="">
      </div>
      <div class="w-3/5">
        <img class="w-full object-cover" src="/image/1-2.webp" alt="">
      </div>
    </section>
    <!-- 網站功能簡介 -->
    <section
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
      <div class="w-full flex justify-center items-center min-[1180px]:px-10 px-4 py-20">
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
                :watchSlidesProgress="true" :modules="modules" class="mySwiper">
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
                <a href="https://drive.google.com/drive/folders/1zAGxhT8ZS04H4BatSjquVLYd9lLlQOKF">
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
            }" class="mySwiper2">
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
              <a href="https://drive.google.com/drive/folders/1zAGxhT8ZS04H4BatSjquVLYd9lLlQOKF">
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
      <div class="w-full bg-[#333333] flex flex-col gap-4 min-[1904px]:px-[200px] min-[1201px]:px-[120px] px-10 py-8">
        <div class="flex items-center gap-6">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M24 0V24H0L24 0Z" fill="white" />
          </svg>
          <p class="font-noto-cjk min-[1201px]:text-[80px] text-[48px] text-white font-bold leading-[1.2]">下單購買</p>
        </div>
        <div class="min-[1201px]:flex grid grid-cols-1 gap-4">
          <div
            class="min-[1201px]:w-1/3 w-full flex flex-col gap-2 shadow-[0px_0px_4px_0px_rgba(0,0,0,0.1)] rounded-tl-2xl rounded-tr-2xl">
            <img class="rounded-tl-2xl rounded-tr-2xl" src="/image/4-1.webp" alt="">
            <div class="flex flex-col gap-2 px-2">
              <p class="font-noto-cjk text-[24px] text-white font-bold leading-[1.2]">
                日式特攻服 暴走族 🎌 [白色] 素色特攻服 客製化 團體服
              </p>
              <p
                class="font-pingfang-r text-[32px] text-[#C89E51] font-normal leading-[100%] tracking-[0.08em] opacity-80 [text-shadow:1px_1px_0_#B41900,-1px_1px_0_#B41900,1px_-1px_0_#B41900,-1px_-1px_0_#B41900,0px_1px_0_#B41900,0px_-1px_0_#B41900,1px_0px_0_#B41900,-1px_0px_0_#B41900]">
                $50
              </p>
            </div>
          </div>
          <div
            class="min-[1201px]:w-1/3 w-full flex flex-col gap-2 shadow-[0px_0px_4px_0px_rgba(0,0,0,0.1)] rounded-tl-2xl rounded-tr-2xl">
            <img class="rounded-tl-2xl rounded-tr-2xl" src="/image/4-2.webp" alt="">
            <div class="flex flex-col gap-2 px-2">
              <p class="font-noto-cjk text-[24px] text-white font-bold leading-[1.2]">
                日式中版特攻服 暴走族 🎌 素色特攻服 客製化 團體服
              </p>
              <p
                class="font-pingfang-r text-[32px] text-[#C89E51] font-normal leading-[100%] tracking-[0.08em] opacity-80 [text-shadow:1px_1px_0_#B41900,-1px_1px_0_#B41900,1px_-1px_0_#B41900,-1px_-1px_0_#B41900,0px_1px_0_#B41900,0px_-1px_0_#B41900,1px_0px_0_#B41900,-1px_0px_0_#B41900]">
                $50
              </p>
            </div>
          </div>
          <div
            class="min-[1201px]:w-1/3 w-full flex flex-col gap-2 shadow-[0px_0px_4px_0px_rgba(0,0,0,0.1)] rounded-tl-2xl rounded-tr-2xl">
            <img class="rounded-tl-2xl rounded-tr-2xl" src="/image/4-3.webp" alt="">
            <div class="flex flex-col gap-2 px-2">
              <p class="font-noto-cjk text-[24px] text-white font-bold leading-[1.2]">
                刺繡 電腦刺繡 客製化 刺繡範例 請看商品描述 歡迎聊聊詢問
              </p>
              <p
                class="font-pingfang-r text-[32px] text-[#C89E51] font-normal leading-[100%] tracking-[0.08em] opacity-80 [text-shadow:1px_1px_0_#B41900,-1px_1px_0_#B41900,1px_-1px_0_#B41900,-1px_-1px_0_#B41900,0px_1px_0_#B41900,0px_-1px_0_#B41900,1px_0px_0_#B41900,-1px_0px_0_#B41900]">
                $50
              </p>
            </div>
          </div>
        </div>
        <div class="w-full flex justify-center">
          <button
            class="bg-white flex items-center gap-[10px] px-10 py-4 rounded-2xl shadow-[0px_4px_4px_0px_rgba(0,0,0,0.25)]"
            type="button">
            <img src="/image/svg/Shopee_logo.svg" alt="">
            <p class="font-noto-cjk text-[#444444] text-lg font-normal leading-[1.5]">蝦皮賣場</p>
            <img src="/image/svg/icon-arrow.svg" alt="">
          </button>
        </div>
      </div>
    </section>
  </main>
  <div v-if="showImage" class="w-full fixed inset-0 z-50" @click="hideImage">
    <div class="absolute inset-0 bg-black opacity-50"></div>
    <!-- src="/image/5-1.webp" -->
    <div class=" w-full  absolute inset-0 flex justify-center items-center">
      <img :src="currentImage" class="w-full xl:w-[808px] lg:w-[900px]  z-50" alt="">
    </div>
  </div>
  <!-- footer -->
  <footer
    class="max-w-[1903px] bg-[#272727] flex flex-col min-[522px]:justify-center min-[522px]:items-center gap-10 mx-auto min-[769px]:py-10 relative min-[476px]:px-4 px-3 pt-[110px] pb-10">
    <!-- 回到頂部 -->
    <button type="button"
      class="bg-[#444444] border-2 border-[#4D4D4D] font-noto-cjk text-white font-bold text-lg leading-[125%] tracking-[1.5px] min-[522px]:p-5 min-[522px]:w-[103px] w-[95px] min-[522px]:h-[65px] h-[41px] absolute top-7 right-4">
      回頂部
    </button>
    <!-- logo -->
    <div class="flex items-start min-[476px]:gap-2 gap-[6px]">
      <img src="/image/LOGO-中.webp" alt="" class="min-[522px]:w-[73.85px] w-[57.36px]">
      <div class="flex-col gap-[5.76px]">
        <p
          class="font-noto-jp text-white min-[522px]:text-[14.8px] text-[11.5px] font-black leading-[1.2] tracking-[-0.08em]">
          天下無敵、台湾特工服の第一品牌
        </p>
        <p
          class="font-freckle text-white min-[522px]:text-[64.77px] text-[50.31px] font-normal leading-[1.2] tracking-[-0.08em]">
          ITS SHOW TIME
        </p>
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
        <button type="button" class="w-[198px] bg-[#333333] flex items-center gap-1 px-2 py-1 rounded-[26px]">
          <img src="/image/svg/facebook.svg" alt="">
          <p class="font-taipei-sans-tc-r text-white font-normal text-lg leading-[1.25] tracking-[1.35px]">Itsshowtime
          </p>
        </button>
        <button type="button" class="w-[198px] bg-[#333333] flex items-center gap-1 px-2 py-1 rounded-[26px]">
          <img src="/image/svg/instagram.svg" alt="">
          <p class="font-taipei-sans-tc-r text-white font-normal text-lg leading-[1.25] tracking-[1.35px]">
            itsshowtime_tw</p>
        </button>
        <button type="button" class="w-[198px] bg-[#333333] flex items-center gap-1 px-2 py-1 rounded-[26px]">
          <img src="/image/svg/shopee.svg" alt="">
          <p class="font-taipei-sans-tc-r text-white font-normal text-lg leading-[1.25] tracking-[1.35px]">蝦皮賣場</p>
        </button>
        <button type="button" class="w-[198px] bg-[#333333] flex items-center gap-1 px-2 py-1 rounded-[26px]">
          <img src="/image/svg/maps.svg" alt="">
          <p class="font-taipei-sans-tc-r text-white  text-lg leading-[1.25] tracking-[1.35px]">Google地圖</p>
        </button>

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

.mySwiper {
  display: inline-flex;
  width: 100%;
  box-sizing: border-box;
}

.mySwiper .swiper-slide {
  width: 190.33px;
  text-align: center;
  display: flex;
  justify-content: center;
  align-items: center;
  margin-right: 80px;
}

@media (max-width: 1500px) {
  .mySwiper .swiper-slide {
    width: calc((100% - 10px*2) / 3);
    margin-right: 10px;
  }
}

@media (max-width: 1500px) {
  .mySwiper .swiper-slide button {
    height: 70px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    font-weight: 700;
  }
}

@media (max-width: 1120px) {
  .mySwiper .swiper-slide button {
    height: 58px;
  }
}

.mySwiper .swiper-slide-thumb-active button {
  background-color: #444444;
  color: #ffffff;
}

.mySwiper2 {
  width: 626.9px;
}

@media (max-width: 1119px) {
  .mySwiper2 {
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

button {
  cursor: pointer;
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