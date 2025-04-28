<script setup>
import { ref, onMounted } from 'vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/free-mode';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import 'swiper/css/thumbs';
import { FreeMode, Navigation, Thumbs } from 'swiper/modules';

// 初始化縮圖輪播控制器
const thumbsSwiper = ref(null);
const thumbsIndex = ref(0);

// 當前縮圖index
const setActiveThumb = (index) => {
    thumbsIndex.value = index;
    if (mainSwiper.value) {
        mainSwiper.value.slideToLoop(index); // 這才是跳轉主圖
    }
}

// 添加主 Swiper 的引用
const mainSwiper = ref(null);

// 處理主 Swiper 幻燈片變化
const handleSlideChange = () => {
    if (mainSwiper.value) {
        // 獲取實際索引 (考慮到 loop 模式)
        const realIndex = mainSwiper.value.realIndex;
        thumbsIndex.value = realIndex;
    }
};

// 商品圖片列表
const images = ref([
    "/image/1-1.webp",
    "/image/1-2.webp",
    "/image/1-3.webp",
    "/image/1-5.webp",
    "/image/1-6.webp",
    "/image/1-7.webp",
]);

// 圖片加載錯誤處理
const handleImageError = (e) => {
    e.target.src = '/image/svg/no_img.svg';
};

// 商品數據
const product = ref({
    title: "【IST】日式暴走頭帶 ⛩ 台灣連合 神風 暴走 特攻 極惡 客製化 刺繡 現貨 快速出貨",
    description: "台製高質感刺繡頭帶，頭帶約 100*5公分，可客製刺繡，繡出自己的暴走魂",
    price: "300~400",
    colors: ["黑色", "紅色"],
    styles: ["神風", "特攻", "嫉惡", "暴走", "台灣聯合", "客製化"]
});

// 選中的選項
const selectedColor = ref(null);
const selectedStyle = ref(null);
const quantity = ref(1);

// 選擇顏色
const selectColor = (color) => {
    selectedColor.value = color;
};

// 選擇款式
const selectStyle = (style) => {
    selectedStyle.value = style;
};

// 增減數量
const CalcQuantity = (style) => {
    if(style === '-') {
        if (quantity.value > 1) {
            quantity.value--;
        }
    }else {
        quantity.value++;
    }
};

// 添加到購物車
const addToCart = () => {
    console.log('添加到購物車', {
        product: product.value.title,
        color: selectedColor.value,
        style: selectedStyle.value,
        quantity: quantity.value
    });
    alert('已加入購物車！');
};

// 記錄螢幕寬度並監控變化
const screenWidth = ref(window.innerWidth);

// 組件掛載時初始化顏色和款式選擇
onMounted(() => {

    screenWidth.value = window.innerWidth;
    
    // 監控螢幕大小變化
    window.addEventListener('resize', () => {
        screenWidth.value = window.innerWidth;
    });

    selectedColor.value = product.value.colors[0];
    selectedStyle.value = product.value.styles[0];
    thumbsIndex.value = 0;
});
</script>

<template>
    <div class="relative w-full min-h-screen flex justify-center items-center bg-black/50 p-4">
        <div class="text-white p-4 md:p-20 w-full lg:w-[80%] bg-black rounded-xl">
            <div class="text-xl mb-4">商品介紹</div>
            <div class="flex flex-col juscenter items-center xl:flex-row gap-20">
                <!-- 左側圖片展示區 -->
                <div class="w-full lg:w-1/2">
                    <div class="flex flex-col md:flex-row gap-4 items-center justify-center">
                        <!-- 主圖輪播 -->
                        <div class="max-h-[250px] md:max-h-[400px] lg:max-h-[500px] order-1 md:order-2">
                            <Swiper 
                                :modules="[FreeMode, Navigation, Thumbs]" 
                                :loop="true" 
                                :space-between="10"
                                :navigation="false" 
                                :thumbs="{ swiper: thumbsSwiper }"
                                class="flex-1 aspect-square max-h-[250px] md:max-h-[400px] lg:max-h-[500px] border rounded overflow-hidden"
                                @swiper="(swiper) => { mainSwiper = swiper; }" 
                                @slideChange="handleSlideChange"
                            >
                                <SwiperSlide v-for="(img, i) in images" :key="'main-' + i">
                                    <img :src="img" @error="handleImageError" class="w-full h-full object-cover rounded"
                                        loading="lazy" a lt="商品圖片" />
                                </SwiperSlide>
                            </Swiper>
                        </div>
                        <!-- 縮圖垂直排列在左側 -->
                        <div class="flex flex-col justify-center order-2 md:order-1">
                            <Swiper 
                                :loop="true" 
                                :modules="[FreeMode, Thumbs]" 
                                :direction="screenWidth < 768 ? 'horizontal' : 'vertical'"
                                :slides-per-view="screenWidth < 768 ? 4 : 5"
                                :space-between="10" 
                                :free-mode="true" 
                                watch-slides-progress
                                class="w-60 h-15 md:w-20 md:h-full max-h-[250px] md:max-h-[400px] lg:max-h-[500px]" 
                                @swiper="(swiper) => thumbsSwiper = swiper"
                            >
                                <SwiperSlide 
                                    class="h-16" 
                                    v-for="(img, i) in images" 
                                    :key="'thumb-' + i"
                                    @click="setActiveThumb(i)"
                                >
                                    <img :src="img" @error="handleImageError"
                                        class="w-full h-full object-cover cursor-pointer rounded border"
                                        :class="{ 'border-yellow-400 border-2': i === thumbsIndex }" loading="lazy"
                                        alt="商品縮圖" />
                                </SwiperSlide>
                            </Swiper>
                        </div>
                    </div>
                </div>
                <!-- 右側商品資訊 -->
                <div class="w-full lg:w-1/2 flex flex-col gap-6">
                    <div class="text-xl font-medium">{{ product.title }}</div>
                    <hr class="border">
                    <div>{{ product.description }}</div>
                    <div class="text-2xl text-[#C89E51] font-bold">${{ product.price }}</div>

                    <!-- 顏色選擇 -->
                    <div class="flex items-center gap-6">
                        <span class="w-[10%] text-nowrap">顏色</span>
                        <div class="w-[90%] flex gap-3 flex-wrap">
                            <button v-for="color in product.colors" :key="color" type="button"
                                class="border py-1 px-4 rounded transition-colors"
                                :class="{ 'border-yellow-400': selectedColor === color }"
                                @click="selectColor(color)">
                                {{ color }}
                            </button>
                        </div>
                    </div>

                    <!-- 款式選擇 -->
                    <div class="flex items-start gap-6">
                        <span class="w-[10%] text-nowrap">款式</span>
                        <div class="w-[90%] flex gap-3 flex-wrap">
                            <button v-for="style in product.styles" :key="style" type="button"
                                class="border py-1 px-4 rounded transition-colors"
                                :class="{ 'border-yellow-400': selectedStyle === style }"
                                @click="selectStyle(style)">
                                {{ style }}
                            </button>
                        </div>
                    </div>

                    <!-- 數量選擇 -->
                    <div class="flex items-center gap-6">
                        <span class="w-[10%] text-nowrap">數量</span>
                        <div class="w-[90%] flex">
                            <button type="button" class="border py-1 px-4 hover:bg-gray-700 transition-colors rounded-l"
                                @click="CalcQuantity('-')">
                                -
                            </button>
                            <input class="text-center bg-black border w-20" type="text" name="" id="" :value="quantity">
                            <!-- <p class="border-t border-b py-1 w-20 text-center">{{ quantity }}</p> -->
                            <button type="button" class="border py-1 px-4 hover:bg-gray-700 transition-colors rounded-r"
                                @click="CalcQuantity('+')">
                                +
                            </button>
                        </div>
                    </div>

                    <!-- 加入購物車按鈕 -->
                    <div class="mt-6 flex justify-center">
                        <button type="button"
                            class="py-2 px-6 border rounded-xl flex items-center gap-2 hover:bg-gray-700 transition-colors"
                            @click="addToCart">
                            <img class="size-[30px]" src="image/svg/ShoppingCartIcon.svg" alt="">
                            <span class="text-lg">加入購物車</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
/* 確保垂直輪播正常工作 */
.swiper-slide {
    height: auto;
}
</style>