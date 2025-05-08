<script setup>
import { ref, onMounted } from 'vue';
import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/free-mode';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import 'swiper/css/thumbs';
import { FreeMode, Navigation, Thumbs } from 'swiper/modules';


// 從父層取得的資料
const { hideModal, getColor, getType, getSize, item } = defineProps({
    hideModal: { type: Function },
    getColor: { type: Function },
    getType: { type: Function },
    getSize: { type: Function },
    item: { type: Object },
});

const colors = item.colors.map(item => item.name);

const types = item.types.map(item => item.name);

const sizes = item.sizes.map(item => item.name);

const hasValidColors = computed(() => {
    return Array.isArray(colors) && colors.some(c => c !== null);
});

const hasValidTypes = computed(() => {
    return Array.isArray(types) && types.some(t => t !== null);
});

const hasValidSize = computed(() => {
    return Array.isArray(sizes) && sizes.some(s => s !== null);
});


// 初始化縮圖輪播控制器
const thumbsIndex = ref(0);

// 當前縮圖index
const setActiveThumb = (index) => {
    thumbsIndex.value = index;
    if (mainSwiper.value) {
        mainSwiper.value.slideToLoop(index); // 這才是跳轉主圖
    }
}

const rawThumbsSwiper = ref(null);

// 確保 thumbsSwiper 這個 Swiper 實例目前是有效存在的、而且尚未被銷毀
// 如果使用v-if或是重新渲染元件的話 swiper可能會自動銷毀，
// 當使用者把已被銷毀的 swiper 實例傳進主 Swiper 的 thumbs.swiper時候就有可能會報錯
const thumbsSwiper = computed(() => {
    return rawThumbsSwiper.value && !rawThumbsSwiper.value.destroyed
        ? rawThumbsSwiper.value
        : null;
});

const updateThumbsSwiper = (newSwiper) => {
    rawThumbsSwiper.value = newSwiper;  // 直接修改 rawThumbsSwiper
};

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
const images = item.images.map(path => path.img_path);

// 圖片加載錯誤處理
const handleImageError = (e) => {
    e.target.src = '/image/svg/no_img.svg';
};

// 要將選擇的相關資訊丟回父層應用
const emit = defineEmits(['updateColor', 'updateStyle', 'updateSize', 'updateQuantity', 'addToCart']);

// 選中的選項
const selectedColor = ref(null);
const selectedStyle = ref(null);
const selectedSize = ref(null);
const quantity = ref(1);

// 選擇顏色
const selectColor = (color) => {
    selectedColor.value = color;
    emit('updateColor', color);
};

// 選擇款式
const selectStyle = (style) => {
    selectedStyle.value = style;
    emit('updateStyle', style);
};

// 選擇尺寸
const selectSize = (size) => {
    selectedSize.value = size;
    emit('updateSize', size);
};

// 增減數量
const CalcQuantity = (style) => {
    if (style === '-') {
        if (quantity.value > 1) {
            quantity.value--;
        }
    } else {
        quantity.value++;
    }
    emit('updateQuantity', quantity.value);
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

    // 直接使用處理好的 colors、types 和 sizes 資料來設定初始值
    if (colors && colors.length > 0) {
        selectedColor.value = colors[0];
        emit('updateColor', selectedColor.value);
    } else {
        selectedColor.value = null;
        emit('updateColor', null);
    }

    if (types && types.length > 0) {
        selectedStyle.value = types[0];
        emit('updateStyle', selectedStyle.value);
    } else {
        selectedStyle.value = null;
        emit('updateStyle', null);
    }

    if (sizes && sizes.length > 0) {
        selectedSize.value = sizes[0];
        emit('updateSize', selectedSize.value);
    } else {
        selectedSize.value = null;
        emit('updateSize', null);
    }

    thumbsIndex.value = 0;
});

// 觸發父層addToCart事件
const handleAddToCart = function () {
    emit('addToCart');
};

</script>

<template>
    <div class="w-full min-h-screen flex justify-center items-center bg-black/50 p-4">
        <div class="relative text-white p-4 md:p-8 w-full lg:w-[80%] 2xl:w-[60%] bg-black rounded-xl" @click.stop>
            <button type="button"
                class="w-14 h-14 absolute top-6 right-6 flex justify-center items-center border-2 mb-7"
                @click="hideModal">
                <i class="fa-solid fa-xmark text-5xl"></i>
            </button>
            <div class="text-xl mb-4">商品介紹</div>
            <div class="flex flex-col juscenter items-center xl:flex-row gap-10">
                <!-- 左側圖片展示區 -->
                <div class="w-full lg:w-1/2 mt-10">
                    <div class="flex flex-col md:flex-row gap-4 items-center justify-center">
                        <!-- 主圖輪播 -->
                        <div class="max-h-[250px] md:max-h-[400px] lg:max-h-[500px] order-1 md:order-2">
                            <Swiper :modules="[FreeMode, Navigation, Thumbs]" :loop="true" :space-between="10"
                                :navigation="false" :thumbs="{ swiper: thumbsSwiper }"
                                class="flex-1 aspect-square max-h-[250px] md:max-h-[400px] border rounded overflow-hidden"
                                @swiper="(swiper) => { mainSwiper = swiper; }" @slideChange="handleSlideChange">
                                <SwiperSlide v-for="(img, i) in images" :key="'main-' + i">
                                    <img :src="img" @error="handleImageError" class="w-full h-full object-cover rounded"
                                        loading="lazy" a lt="商品圖片" />
                                </SwiperSlide>
                            </Swiper>
                        </div>
                        <!-- 縮圖垂直排列在左側 -->
                        <div class="flex flex-col justify-center order-2 md:order-1">
                            <Swiper :loop="true" :modules="[FreeMode, Thumbs]"
                                :direction="screenWidth < 768 ? 'horizontal' : 'vertical'"
                                :slides-per-view="screenWidth < 768 ? 4 : 5" :space-between="10" :free-mode="true"
                                watch-slides-progress class="w-60 h-15 md:w-20 md:h-full max-h-[250px] md:max-h-[400px]"
                                @swiper="(swiper) => updateThumbsSwiper = swiper">
                                <SwiperSlide class="h-16" v-for="(img, i) in images" :key="'thumb-' + i"
                                    @click="setActiveThumb(i)">
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
                <div class="w-full lg:w-1/2 flex flex-col gap-3 mr-10">
                    <div class="text-xl font-medium">{{ item?.name }}</div>
                    <hr class="border">
                    <div class="text-2xl text-[#C89E51] font-bold">{{ item?.price }}</div>

                    <!-- 顏色選擇 -->
                    <div v-if="hasValidColors" class="flex items-center gap-6">
                        <span class="w-[10%] text-nowrap">顏色</span>
                        <div class="w-[90%] flex gap-3 flex-wrap">
                            <button v-for="color in colors" :key="color" type="button"
                                class="border py-1 px-4 rounded transition-colors"
                                :class="{ 'border-yellow-400': selectedColor === color }" @click="selectColor(color)">
                                {{ color }}
                            </button>
                        </div>
                    </div>

                    <!-- 款式選擇 -->
                    <div v-if="hasValidTypes" class="flex items-start gap-6">
                        <span class="w-[10%] text-nowrap">款式</span>
                        <div class="w-[90%] flex gap-3 flex-wrap">
                            <button v-for="style in types" :key="style" type="button"
                                class="border py-1 px-4 rounded transition-colors"
                                :class="{ 'border-yellow-400': selectedStyle === style }" @click="selectStyle(style)">
                                {{ style }}
                            </button>
                        </div>
                    </div>

                    <!-- 尺寸選擇 -->
                    <div v-if="hasValidSize" class="flex items-start gap-6">
                        <span class="w-[10%] text-nowrap">尺寸</span>
                        <div class="w-[90%] flex gap-3 flex-wrap">
                            <button v-for="size in sizes" :key="size" type="button"
                                class="border py-1 px-4 rounded transition-colors"
                                :class="{ 'border-yellow-400': selectedSize === size }" @click="selectSize(size)">
                                {{ size }}
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
                            @click="handleAddToCart">
                            <img class="size-[30px]" src="image/svg/ShoppingCartIcon.svg" alt="">
                            <span class="text-lg">確認規格</span>
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