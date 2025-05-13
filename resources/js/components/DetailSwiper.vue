<script setup>
import { ref, onMounted, defineProps, onUnmounted } from 'vue'

import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/free-mode';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import 'swiper/css/thumbs';
import { FreeMode, Pagination, Navigation, Thumbs, Autoplay } from 'swiper/modules';

const modules = [FreeMode, Pagination, Navigation, Thumbs, Autoplay];

const windowWidth = ref(window.innerWidth);
const handleResize = () => {
  windowWidth.value = window.innerWidth
};

onMounted(() => {
  window.addEventListener('resize', handleResize)
});

onUnmounted(() => {
  window.removeEventListener('resize', handleResize)
});

const rawThumbsSwiper = ref(null);
const rawMainSwiper = ref(null);

const thumbsSwiper = computed(() =>
  rawThumbsSwiper.value && !rawThumbsSwiper.value.destroyed
    ? rawThumbsSwiper.value
    : null
);

const setThumbsSwiper = (swiper) => {
  rawThumbsSwiper.value = swiper;
};

const setMainSwiper = (swiper) => {
  rawMainSwiper.value = swiper;
};

const props = defineProps({
  images: {
    type: Array,
    required: true
  },
});
</script>

<template>
  <!-- 縮圖 -->
  <swiper @swiper="setThumbsSwiper" :loop="false" :direction="windowWidth <= 768 ? 'horizontal' : 'vertical'"
    :spaceBetween="windowWidth <= 500 ? 16 : 18" :slidesPerView="'auto'" :freeMode="true" :watchSlidesProgress="true"
    :modules="modules" class="detailThumbsSwiper min-[769px]:order-0 order-1">

    <swiper-slide v-for="(item, index) in props.images" :key="index">
      <img :src="item?.img_path" :alt="item?.img_name">
    </swiper-slide>

  </swiper>
  <!-- 大圖 -->
  <swiper @swiper="setMainSwiper" :loop="true" :spaceBetween="1" :pagination="{
    type: 'fraction',
  }" :navigation="true" :thumbs="{ swiper: thumbsSwiper }" :modules="modules"
    class="detailMainSwiper min-[769px]:order-1 order-0">

    <swiper-slide v-for="(item, index) in props.images" :key="index">
      <img :src="item?.img_path" :alt="item?.img_name">
    </swiper-slide>

  </swiper>
</template>

<style>
html,
body {
  font-size: 16px;
  background-color: #333333;
}

/* more 頁面的 Swiper */
.swiper {
  width: auto;
  /* height: auto; */
  margin: 0;
  box-sizing: border-box;
  cursor: pointer;
}

.detailMainSwiper {
  width: 450px;
  height: 450px;
}

@media (max-width: 640px) {
  .detailMainSwiper {
    margin: 0 auto;
  }
}

@media (max-width: 499px) {
  .detailMainSwiper {
    width: 300px;
    height: 300px;
  }
}

.detailMainSwiper .swiper-slide {
  width: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  height: auto;
}

.detailMainSwiper .swiper-slide img {
  width: 100%;
  height: 100%;
  margin: 0 auto;
  border-radius: 5px;
  object-fit: contain;
  object-position: center;
}

.detailThumbsSwiper {
  display: inline-flex;
}

.detailThumbsSwiper .swiper-wrapper {
  width: auto;
}

@media (max-width: 640px) {
  .detailThumbsSwiper .swiper-wrapper {
    margin-left: 0 !important;
    margin-right: auto !important;
  }
}

.detailThumbsSwiper .swiper-slide {
  width: auto;
  height: auto;
}

.detailThumbsSwiper .swiper-slide:last-child {
  margin: 0 !important;
}

.detailThumbsSwiper .swiper-slide img {
  width: 100px;
  aspect-ratio: 1;
  object-fit: contain;
  object-position: center;
  border-radius: 3px;
}

@media (max-width: 640px) {
  .detailThumbsSwiper .swiper-slide img {
    width: 70px;
  }
}

@media (max-width: 499px) {
  .detailThumbsSwiper .swiper-slide img {
    width: 60px;
  }
}

.detailThumbsSwiper .swiper-slide-thumb-active {
  border-radius: 3px;
  border: 2px solid #FFD83C;
}

.swiper-pagination-fraction {
  position: absolute;
  left: 85%;
  right: 0;
  bottom: 0;
  background-color: black;
  width: auto;
  color: white;
  padding: 5px 0;
}

.swiper-button-next,
.swiper-button-prev {
  color: white;
}
</style>