<script setup>
import { ref, onMounted, defineProps, defineEmits, watch } from 'vue'

import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/free-mode';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import 'swiper/css/thumbs';
import { FreeMode, Pagination, Navigation, Thumbs, Autoplay } from 'swiper/modules';

const modules = [FreeMode, Pagination, Navigation, Thumbs, Autoplay];

const thumbsSwiper = ref(null);
const setThumbsSwiper = (swiper) => {
  thumbsSwiper.value = swiper;
};

const props = defineProps({
  productData: {
    type: Array,
    required: true,
  },
  loop: {
    type: Boolean,
    default: false
  },
});



const emit = defineEmits(['more-clicked'])
function handleMoreClick(productId) {
  emit('more-clicked', productId) // 通知父層使用者點了 MORE，並帶上 id
}
</script>

<template>
  <div class="h-[600px] product-swiper-container bg-[#333333]">
    <div class="custom-swiper-pagination"></div>
    <swiper :loop="loop" :navigation="true" :spaceBetween="20" :centeredSlides="true" :slidesPerView="'auto'"
      :pagination="{
        el: '.custom-swiper-pagination',
        clickable: true,
      }" :modules="modules" class="product-swiper mt-[80px]">
      <swiper-slide v-for="product in props.productData" :key="product.id">
        <div
          class="w-full relative flex flex-col gap-2 shadow-[0px_0px_4px_0px_rgba(0,0,0,0.1)] rounded-tl-2xl rounded-tr-2xl group">
          <img class="rounded-tl-2xl rounded-tr-2xl" :src="product.img_url" alt="">
          <div class="flex flex-col gap-2 px-2">
            <p class="font-noto-cjk text-[24px] text-white font-bold leading-[1.2]">
              {{ product.name }}
            </p>
            <p
              class="hidden 2xl:block font-pingfang-r text-[32px] text-[#C89E51] font-bold leading-[100%] tracking-[0.08em] opacity-80 custom-shadow">
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
              type="button" @click="handleMoreClick(product.id)">
              MORE
            </button>
          </div>
        </div>
      </swiper-slide>
    </swiper>
  </div>
</template>

<style>
html {
  background-color: #333333;
}

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
</style>