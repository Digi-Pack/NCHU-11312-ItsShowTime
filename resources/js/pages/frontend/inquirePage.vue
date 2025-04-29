<script setup>

import { ref, onMounted, onBeforeUnmount, computed, defineProps } from 'vue'

import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/free-mode';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import 'swiper/css/thumbs';
import { FreeMode, Navigation, Thumbs } from 'swiper/modules';


const isOpen = ref(false)

const toggleMenu = () => {
    isOpen.value = !isOpen.value
    document.body.style.overflow = isOpen.value ? 'hidden' : 'auto'
}


// nav menu links
const menuItems = [
    { id: 'portfolio', name: '作品集', href: '#portfolio' },
    { id: 'about', name: '品牌理念', href: '#about' },
    { id: 'method', name: '製作方式', href: '#method' },
    { id: 'product', name: '商品列表', href: '#product' },
    { id: 'contact', name: '聯絡方式', href: '#contact' },
]


const isScrolled = ref(false) // 用來控制是否超過 230px

const handleScroll = () => {
    if (window.scrollY >= 230) {
        isScrolled.value = true
    } else {
        isScrolled.value = false
    }
}

onMounted(() => {
    window.addEventListener('scroll', handleScroll)
})

onBeforeUnmount(() => {
    window.removeEventListener('scroll', handleScroll)
})


// 把下單購買資料帶入
const { response } = defineProps({
    response: Array | Object,
})

console.log(response);


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
    // title: "【IST】日式暴走頭帶 ⛩ 台灣連合 神風 暴走 特攻 極惡 客製化 刺繡 現貨 快速出貨",
    description: "台製高質感刺繡頭帶，頭帶約 100*5公分，可客製刺繡，繡出自己的暴走魂",
    // price: "300~400",
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
    if (style === '-') {
        if (quantity.value > 1) {
            quantity.value--;
        }
    } else {
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



// 點擊規格選擇出現選擇商品規格頁面
const isFormatOpen = ref(false);
const currentProductId = ref(null);

const openModal = (productId) => {
    currentProductId.value = productId;

    isFormatOpen.value = true;
    // 禁用body頁面滾動條
    if (isFormatOpen.value) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = 'auto';
    }
}

const hideModal = () => {
    isFormatOpen.value = false;
    document.body.style.overflow = 'auto';
}

const currentProduct = () => {
    if (!currentProductId.value) return null;
    return props.response.find(product => product.id === currentProductId.value) || null;
};


</script>

<template>

    <section class="flex flex-col items-center w-full bg-[#1F1B1B]">

        <!-- NavBar -->
        <nav :class="[
            'w-full flex min-[476px]:justify-center py-6 text-nowrap',
            isScrolled ? 'fixed top-0 left-0 bg-stone-50 font-bold z-20' : ''
        ]">
            <div class="lg:block flex">
                <p
                    class="font-noto-jp text-[#F0BD22] 2xl:text-[30px] md:text-[20px] min-[476px]:text-[14px] min-[374px]:text-[12px] sm:tracking-[0.06em] mb-2 min-[476px]:pl-0 pl-3">
                    itsshowtime．無敵の特工服オーダーメイドブランド
                </p>

                <nav class="lg:hidden fixed top-0 left-0 w-full z-20 font-noto-jp">
                    <!-- Ham Btn -->
                    <button type="button"
                        class="w-9 h-9 flex justify-center items-center cursor-pointer p-6 fixed min-[476px]:top-4 top-2 right-4 z-20"
                        @click="toggleMenu">
                        <i class="fa-solid fa-bars text-3xl" style="color:#F0BD22"></i>
                    </button>

                    <div :class="[
                        'fixed left-0 top-0 w-full h-[380px] bg-slate-100 z-10',
                        'flex flex-col justify-center gap-6 p-8 overflow-y-auto',
                        isOpen ? 'flex' : 'hidden'
                    ]">
                        <a v-for="item in menuItems" :key="item.id" :href="item.href" @click="toggleMenu"
                            class="flex items-center gap-[9px] text-xl ">
                            <img src="/image/svg/Arrow 2.svg" alt="" />
                            <p class="font-normal leading-[1.2] text-[#1f1b1b]">{{ item.name }}</p>
                        </a>
                    </div>
                </nav>
            </div>
        </nav>


        <!-- NavBar 1204px以上 -->
        <nav class="hidden lg:flex flex-col fixed top-64 2xl:left-16 left-10 z-10 font-noto-cjk text-white">
            <div class="w-[80px] mb-4">
                <img src="/image/LOGO-底部有字.webp" class="w-full h-full object-cover">
            </div>
            <img src="/image/svg/Menu.svg" class="w-full h-full object-cover mb-4">

            <div class="gap-6">
                <a href="#about" class="flex items-center gap-[9px]">
                    <p class="font-normal leading-[1.8]">品牌理念</p>
                    <img src="/image/svg/Arrow.svg" alt="">
                </a>
                <a href="#portfolio" class="flex items-center gap-[9px]">
                    <p class="font-normal leading-[1.8]">作品集</p>
                    <img src="/image/svg/Arrow.svg" alt="">
                </a>
                <a href="#method" class="flex items-center gap-[9px]">
                    <p class="font-normal leading-[1.8]">製作方式</p>
                    <img src="/image/svg/Arrow.svg" alt="">
                </a>
                <a href="#product" class="flex items-center gap-[9px]">
                    <p class="font-normal leading-[1.8]">商品列表</p>
                    <img src="/image/svg/Arrow.svg" alt="">
                </a>
                <a href="#contact" class="flex items-center gap-[9px]">
                    <p class="font-normal leading-[1.8]">聯絡方式</p>
                    <img src="/image/svg/Arrow.svg" alt="">
                </a>
            </div>
        </nav>



        <!-- Banner -->
        <div class="2xl:w-[821.46px] md:w-[45%] w-[80%] mb-12">
            <img src="/image/ITS SHOW TIME.webp" class="w-full h-full object-cover">
        </div>
        <p
            class="2xl:w-[493px] font-noto-jp font-bold 2xl:text-[32px] sm:text-[20px] text-center text-[#F0BD22] border-[#F0BD22] border-[3px] rounded-[4px] py-3 px-5 tracking-[-0.08em] text-nowrap">
            天下無敵、台湾特工服の第一品牌</p>
        <p class="text-white font-noto-jp 2xl:text-[36px] sm:text-[20px] tracking-[-0.08em] py-4 mb-28">詢價清單列表</p>



        <!-- 詢價清單列表 -->
        <div class="2xl:w-[1320px] w-[70%] flex items-end mb-6 2xl:px-0 xl:px-1">
            <p
                class="2xl:flex-1 2xl:w-0 w-[400px] font-noto-jp font-bold sm:text-[24px] text-[18px] text-[#F0BD22] 2xl:mr-0 xl:mr-4">
                商品名稱</p>
            <p class="xl:w-[240px] w-[180px] font-noto-jp font-bold min-[956px]:text-[24px] text-[0px] text-[#F0BD22]">
                規格</p>
            <p class="xl:w-[160px] w-[100px] font-noto-jp font-bold min-[956px]:text-[24px] text-[0px] text-[#F0BD22]">
                金額</p>
            <p
                class="xl:w-[141px] font-noto-jp font-bold xl:text-[24px] text-center text-[#F0BD22] border-[#F0BD22] border-[3px] rounded-[2px] py-4 px-4 cursor-pointer text-nowrap">
                全部刪除</p>
        </div>


        <!-- min-[956px]以上的選擇規格商品圖 -->
        <div v-if="response && response.length > 0"
            class="flex-col 2xl:w-[1399px] w-[70%] border-y-2 border-[#F0BD22] text-center 2xl:font-bold font-noto-jp mb-12">

            <!-- 使用 v-for 遍歷 response 陣列 -->
            <div v-for="(product, index) in response" :key="product.id"
                class="min-[956px]:w-full min-[956px]:flex hidden items-center my-10">
                <div class="flex 2xl:flex-1 items-center ml-4">
                    <!-- 顯示商品圖片 -->
                    <div class="2xl:w-[125.07px] w-[65px] 2xl:mr-8 mr-4">
                        <img class="rounded-tl-2xl rounded-tr-2xl" :src="product.img_url" alt="Product Image">
                    </div>
                    <!-- 顯示商品名稱 -->
                    <p class="2xl:w-[394px] lg:w-[200px] md:w-[160px] 2xl:text-[20px] text-white text-left">{{
                        product.name }}</p>
                </div>
                <div class="xl:w-[300px] w-[240px] flex justify-center">
                    <button type="button"
                        class="xl:w-[146px] w-[86px] xl:text-[24px] text-white border-white border-[3px] rounded-[5px] p-2 cursor-pointer" @click="openModal(product.id); ShoppingCartData(product.id)" >
                        規格選擇
                    </button>
                </div>
                <p class="xl:w-[200px] w-[140px] flex justify-center xl:text-[24px] text-white ">
                    ${{ product.price }}
                </p>
                <div class="xl:w-[200px] w-[120px] flex justify-center xl:mr-2 cursor-pointer">
                    <img class="xl:w-[33px] w-[25px]" src="/image/svg/trash.svg" alt="">
                </div>
            </div>

            <!-- min-[956px]以下才出現的選擇規格商品圖 -->
        <div class="flex flex-wrap">
            <div v-for="(product, index) in response" :key="product.id"
                class="min-[956px]:hidden md:w-[30%] flex flex-col gap-2 rounded-tl-2xl rounded-tr-2xl my-8 p-1 group relative overflow-hidden ml-4">
                <img class="rounded-tl-2xl rounded-tr-2xl w-full" :src="product.img_url" alt="Product Image">

                <div class="flex flex-col gap-2 px-2 pb-4">
                    <p class="text-left font-noto-jp text-white leading-[1.2]">
                        {{ product.name }}
                    </p>
                </div>
                <div
                    class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center z-10 pb-16">
                    <button class="border-[#F0BD22] border-2 text-[#F0BD22] px-6 py-2 rounded-md" @click="openModal(product.id)">
                        規格
                    </button>
                </div>
            </div>
        </div> 

        </div>


        <!-- 商品項目計數 -->
        <div class="2xl:w-[1399px] w-[70%] flex-col flex items-end mb-60">
            <p class="2xl:text-[24px] text-white mb-2">總計 1 件商品</p>
            <p class="2xl:text-[24px] text-white">總金額(NT$)待確認訂單後提供</p>
        </div>

        <!-- 選擇商品規格 -->
        <div v-show="isFormatOpen"
            class="w-full h-dvh fixed bg-black/50 inset-0 z-50  py-12 flex justify-center items-center"
            @click="hideModal">
            <div class="relative text-white p-4 md:p-20 w-full lg:w-[80%] h-[80%] bg-black rounded-xl overflow-y-auto xl:overflow-hidden" @click.stop>
                <button type="button" class="w-14 h-14 absolute top-6 right-6 flex justify-center items-center border-2 mb-7"
                    @click="hideModal">
                    <i class="fa-solid fa-xmark text-5xl"></i>
                </button>
                <div class="text-xl mb-4 mt-8 md:mt-auto">商品介紹</div>
                <div class="flex flex-col juscenter items-center xl:flex-row gap-20 xl:gap-28 2xl:gap-20">
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
                                    @slideChange="handleSlideChange">
                                    <SwiperSlide v-for="(img, i) in images" :key="'main-' + i">
                                        <img :src="response.img_url" @error="handleImageError"
                                            class="w-full h-full object-cover rounded" loading="lazy" a lt="商品圖片" />
                                    </SwiperSlide>
                                </Swiper>
                            </div>
                            <!-- 縮圖垂直排列在左側 -->
                            <div class="flex flex-col justify-center order-2 md:order-1">
                                <Swiper 
                                    :loop="true" :modules="[FreeMode, Thumbs]"
                                    :direction="screenWidth < 768 ? 'horizontal' : 'vertical'"
                                    :slides-per-view="screenWidth < 768 ? 4 : 5" 
                                    :space-between="10" 
                                    :free-mode="true"
                                    watch-slides-progress
                                    class="w-60 h-15 md:w-20 md:h-full max-h-[250px] md:max-h-[400px] lg:max-h-[500px]"
                                    @swiper="(swiper) => thumbsSwiper = swiper">
                                    <SwiperSlide class="h-16" v-for="(img, i) in images" :key="'thumb-' + i"
                                        @click="setActiveThumb(i)">
                                        <img :src="response.img_url" @error="handleImageError"
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
                        <div class="text-xl font-medium">{{ response.name }}</div>
                        <hr class="border">
                        <div>{{ product.description }}</div>
                        <div class="text-2xl text-[#C89E51] font-bold">${{ response.price }}</div>

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
                                <button type="button"
                                    class="border py-1 px-4 hover:bg-gray-700 transition-colors rounded-l"
                                    @click="CalcQuantity('-')">
                                    -
                                </button>
                                <input class="text-center bg-black border w-20" type="text" name="" id=""
                                    :value="quantity">
                                <!-- <p class="border-t border-b py-1 w-20 text-center">{{ quantity }}</p> -->
                                <button type="button"
                                    class="border py-1 px-4 hover:bg-gray-700 transition-colors rounded-r"
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
                                <img class="size-[30px]" src="/image/svg/ShoppingCartIcon.svg" alt="">
                                <span class="text-lg">加入購物車</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <!-- 詢價資料表 -->
        <div class="2xl:w-[991px] sm:w-[60%] min-[376px]:w-[80%] w-[90%] flex justify-start 2xl:mb-10 mb-4">
            <p class="text-white font-noto-jp 2xl:text-[36px] text-[20px] tracking-[-0.08em] 2xl:ml-10">詢價資料填寫</p>
        </div>

        <div
            class="2xl:w-[991px] sm:w-[60%] min-[376px]:w-[80%] w-[90%] flex flex-col 2xl:items-center border-t-2 border-white font-noto-jp mb-20 py-8 text-white">
            <div class="md:flex">
                <div class="2xl:w-[410px] flex flex-1 flex-col 2xl:mr-6 md:mr-4 mb-10">
                    <label for="username" class="text-white font-noto-jp 2xl:text-[28px] tracking-[0.02em] mb-4">
                        姓名 | Name
                    </label>
                    <input id="username" type="text"
                        class=" bg-transparent border-[1px] border-white rounded-[8px] px-4 py-3 placeholder:text-[22px] placeholder:text-white/50"
                        placeholder="廖小笙">
                </div>

                <div class="2xl:w-[456px] md:w-[50%] flex flex-col mb-10">
                    <label for="birthday" class="text-white font-noto-jp 2xl:text-[28px] tracking-[0.02em] mb-4">
                        出生年月日 | Birthday
                    </label>

                    <div class="relative ">
                        <input id="birthday" type="text" class="w-full bg-transparent border border-white rounded-[8px] px-4 py-3 pr-12
                   placeholder:text-[22px] placeholder:text-white/50 text-white" placeholder="年/月/日">

                        <img src="/image/svg/calendar.svg" alt="calendar icon"
                            class="w-[24px] h-[24px] absolute right-4 top-1/2 -translate-y-1/2 cursor-pointer"
                            onclick="document.getElementById('birthday').focus()" />
                    </div>
                </div>

            </div>

            <div class="flex flex-col mb-10">
                <label for="phone" class="text-white font-noto-jp 2xl:text-[28px] tracking-[0.02em] mb-4">
                    聯絡電話 | Phone
                </label>
                <input id="phone" type="text"
                    class="2xl:w-[895px] bg-transparent border border-white rounded-[8px] px-4 py-3 placeholder:text-[22px] placeholder:text-white/50"
                    placeholder="0912345678">
            </div>

            <div class="flex flex-col mb-10">
                <label for="email" class="text-white font-noto-jp 2xl:text-[28px] tracking-[0.02em] mb-4">
                    電子信箱｜Email
                </label>
                <input id="email" type="text"
                    class="2xl:w-[895px] bg-transparent border border-white rounded-[8px] px-4 py-3 placeholder:text-[22px] placeholder:text-white/50"
                    placeholder="Las123@gmail.com">
            </div>

            <div class="flex flex-col mb-10">
                <label for="address" class="text-white font-noto-jp 2xl:text-[28px] tracking-[0.02em] mb-4">
                    聯絡地址 | Address
                </label>
                <input id="address" type="text"
                    class="2xl:w-[895px] bg-transparent border border-white rounded-[8px] px-4 py-3 placeholder:text-[22px] placeholder:text-white/50"
                    placeholder="南投市環山路112號">
            </div>

            <div class="flex flex-col mb-10">
                <label for="remark" class="text-white font-noto-jp 2xl:text-[28px] tracking-[0.02em] mb-4">
                    備註 | Remark
                </label>
                <textarea id="remark"
                    class="2xl:w-[895px] w-full h-[211px] bg-transparent border border-white rounded-[8px] px-4 py-3 placeholder:text-[22px] ">
        </textarea>
            </div>

        </div>


        <!-- 送出詢價按鈕 -->
        <p
            class="font-noto-jp font-bold  md:text-[24px] text-[18px] text-center text-[#F0BD22] border-[#F0BD22] border-[3px] rounded-[5px] px-12 py-4 cursor-pointer mb-36">
            送出詢價單</p>
    </section>

</template>

<style>
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
    background: #fff7e0;
    position: relative;
    border-radius: 0;
    background-image: url("/public/image/svg/scroll_bar_text_red.svg");
    background-repeat: no-repeat;
    background-position: center;
    background-size: contain;
    border-radius: 100px;
}

/* 滑鼠hover在方塊上的樣式 */
::-webkit-scrollbar-thumb:hover {
    background-image: url("/public/image/svg/scroll_bar_text_black.svg");
}

/* 滑動條角落 */
::-webkit-scrollbar-corner {
    background-color: #000;
}


/* 確保垂直輪播正常工作 */
.swiper-slide {
    height: auto;
}
</style>
