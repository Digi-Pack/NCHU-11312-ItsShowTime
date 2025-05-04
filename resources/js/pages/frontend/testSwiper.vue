<script setup>
import { ref, onMounted, watch, computed, defineProps } from 'vue'
import ProductSwiper from '@/components/ProductSwiper.vue';


import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/free-mode';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import 'swiper/css/thumbs';
import { FreeMode, Pagination, Navigation, Thumbs, Autoplay } from 'swiper/modules';

const windowWidth = ref(window.innerWidth);


const thumbsSwiper2 = ref(null);
const setThumbsSwiper2 = (swiper) => {
  // 強制重新綁定 swiper
  thumbsSwiper2.value = null;
  nextTick(() => {
    thumbsSwiper2.value = swiper;
  });
};

const modules = [FreeMode, Pagination, Navigation, Thumbs, Autoplay];


const props = defineProps({
  response: Array,
});

const isMoreOpen = ref(false);
const currentProductId = ref(null);

const isInternalClick = ref(false);

// 添加控制Swiper刷新的key
const swiperKey = ref(0);

let scrollPosition = 0;
const openModal = (productId) => {
  // 判斷是否是來自modal內部的點擊
  const wasModalOpen = isMoreOpen.value;
  
  currentProductId.value = productId;
  console.log('碰到了！觸發', productId, wasModalOpen ? '(內部點擊)' : '(外部點擊)');

  if (!isMoreOpen.value) {
    // 外部點擊，打開modal
    isMoreOpen.value = true;
    // 禁用body頁面滾動條
    scrollPosition = window.pageYOffset;
    document.body.style.overflow = 'hidden';
    document.body.style.position = 'fixed';
    document.body.style.top = `-${scrollPosition}px`;
    isInternalClick.value = false;
  } else {
    // 內部點擊，記錄標記
    isInternalClick.value = true;
    // 只刷新Swiper部分
    swiperKey.value++;
  }

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



// 當產品ID更改時重設相關狀態
watch(currentProductId, (newVal) => {
  if (isInternalClick.value) {
    // 如果是內部點擊，強制重新初始化thumbsSwiper
    thumbsSwiper2.value = null;
    
    // 使用nextTick確保DOM已更新
    nextTick(() => {
      // 這裡可以添加其他需要在產品切換後執行的操作
      console.log('已更新產品ID，重新初始化組件');
    });
  }
});

watch(isMoreOpen, (newVal) => {
  if (!newVal) {
    thumbsSwiper2.value = null;
    isInternalClick.value = false;
  }
});

</script>

<template>
  <ProductSwiper :productData="props.response" :loop="true" @more-clicked="openModal"></ProductSwiper>

  <div v-if="isMoreOpen" class="w-full h-dvh fixed bg-black/50 inset-0 z-50  py-12" @click="hideModal"
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
            class="w-full min-[1150px]:w-3/5 flex min-[769px]:flex-row flex-col justify-center min-[641px]:items-center min-[1150px]:gap-6 min-[500px]:gap-[40px] gap-4" :key="swiperKey">
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
          <!-- <div class="w-full min-[1150px]:w-2/5 flex flex-col gap-4">
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
          </div> -->
        </div>
      </div>
      <!-- 推薦商品 -->
      <div class="w-full py-12">
        <p class="text-2xl font-semibold border-b-2 border-white min-[641px]:mx-16 mx-4 pb-6 mb-10">推薦商品</p>
        <!-- 商品列表 Swiper -->
        <ProductSwiper :productData="props.response" @more-clicked="openModal"></ProductSwiper>
      </div>
    </div>
  </div>
</template>

<style>
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
</style>