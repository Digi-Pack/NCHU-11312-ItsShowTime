<script setup>
import { ref, onMounted, onBeforeUnmount, computed, defineProps } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import LoadingAnimate from '@/pages/settings/animate.vue';

const isOpen = ref(false)

const toggleMenu = () => {
    isOpen.value = !isOpen.value
    document.body.style.overflow = isOpen.value ? 'hidden' : 'auto'
}

// const isLoading = ref(true);

// onMounted(() => {
//     setTimeout(() => {
//         isLoading.value = false;
//     }, 1900);
// });

</script>


<template>
    <!-- <LoadingAnimate v-if="isLoading" />
    <section v-else> -->
    <nav class="w-full relative z-40 bg-white">
        <div class="h-10 bg-[#801302] px-2"></div>

        <div class="flex sm:justify-center items-center py-2 px-4 sm:px-0 relative">
            <div class="w-12 mt-3 mr-2">
                <img src="/image/LOGO-方.webp" alt="logo" class="w-full h-full object-cover" />
            </div>

            <div>
                <p class="font-noto-jp text-[#444444] text-xs font-black leading-[2] tracking-tight">
                    天下無敵、台湾特攻服の第一品牌
                </p>
                <p
                    class="font-freckle text-[#444444] sm:text-[43px] text-[32px] font-normal leading-[0.7] tracking-tight">
                    ITS SHOW TIME
                </p>
            </div>

            <div class="flex items-center absolute lg:top-3 lg:right-8 right-2">
                <div class="hidden lg:flex items-center">
                    <div class="w-[70px]">
                        <img src="/image/svg/avatar.svg" alt="avatar" class="w-full h-full" />
                    </div>
                    <div class="text-2xl leading-none tracking-wide mr-4 font-noto-jp">Las123</div>
                </div>

                <!-- Home -->
                <Link :href="route('home')" class="flex sm:hidden items-center sm:px-2 cursor-pointer">
                <img src="/image/svg/home.svg" alt="home" class="w-10 h-10" />
                </Link>

                <!-- Hambtn -->
                <button type="button" class="sm:w-12 w-8 sm:h-12 h-8 2xl:hidden" @click="toggleMenu">
                    <i class="fa-solid fa-bars text-3xl text-[#801302]"></i>
                </button>
            </div>
        </div>
    </nav>

    <section>
        <div class="min-h-screen flex">
            <div v-if="isOpen" class="fixed inset-0 bg-black bg-opacity-50 z-10 2xl:hidden" @click="toggleMenu"></div>
            <div v-if="isOpen" class="fixed inset-0 bg-black bg-opacity-50 z-10 2xl:hidden" @click="toggleMenu"></div>

            <div :class="[
                'bg-[#801302] justify-center items-center transition-all duration-300 z-10',
                'fixed top-0 left-0 h-full lg:w-[40%] sm:w-[60%] w-full',
                isOpen ? 'flex h-screen' : 'hidden',
                '2xl:flex 2xl:w-[20%] 2xl:relative 2xl:h-auto 2xl:z-auto'
            ]">

                <div class="flex flex-col">
                    <div class="flex mb-8">
                        <div class="2xl:w-[75px] w-[50px] mr-4">
                            <img src="/image/svg/avatar-1.svg" alt="" class="w-full h-full" />
                        </div>
                        <div class="flex-col font-noto-jp">
                            <div class="text-white xl:text-[24px] mb-2">Las123</div>
                            <Link :href="route('myprofile')" class="flex cursor-pointer">
                            <div class="w-[25px] mr-1">
                                <img src="/image/svg/edit-sign.svg" alt="" class="w-full h-full" />
                            </div>
                            <div class="text-white xl:text-[20px]">編輯個人簡介</div>
                            </Link>
                        </div>
                    </div>

                    <div class="border-t-[1px] border-white text-white py-8 font-noto-jp mb-12">
                        <div class="2xl:text-[24px] text-[20px] font-bold text-white mb-4">我的帳戶</div>
                        <div class="px-4 flex flex-col">
                            <Link :href="route('myprofile')" class="2xl:text-[20px] mb-4 cursor-pointer">個人檔案</Link>
                            <Link :href="route('password')" class="2xl:text-[20px] mb-8 text-white cursor-pointer">修改密碼
                            </Link>
                        </div>
                        <div class="2xl:text-[24px] text-[20px] text-[#F0BD22] font-bold mb-4">線上客服</div>
                        <div class="px-4">
                            <!-- <div class="2xl:text-[20px] mb-4 cursor-pointer">我的詢價</div> -->
                            <div class="2xl:text-[20px] text-[#F0BD22] cursor-pointer">歷史詢價查詢
                            </div>

                        </div>
                    </div>
                    <div class="flex justify-center">
                        <!-- <button type="button"
                            class="border-[1px] border-white text-white 2xl:text-[24px] px-6 py-2 cursor-pointer">登出
                        </button> -->
                        <Link class="border-[1px] border-white text-white 2xl:text-[24px] px-6 py-2 cursor-pointer"
                            method="post" :href="route('logout')" as="button">
                        <LogOut class="mr-2 h-4 w-4" />
                        登出
                        </Link>
                    </div>
                </div>

            </div>


            <main class="flex-1 bg-[#D0D0D0] p-4 sm:p-8 font-noto-jp">
                <div class="bg-white shadow-lg p-6 sm:p-10 relative min-h-full">

                    <Link :href="route('home')" class="hidden sm:flex items-center gap-2 absolute top-4 right-4">
                    <img src="/image/svg/home.svg" alt="home" class="w-10 h-10" />
                    </Link>

                    <div class="mb-10">
                        <h1 class="text-2xl sm:text-3xl font-bold">歷史詢價</h1>
                    </div>

                    <div class="hidden xl:flex text-lg font-bold border-b border-[#B41900] pb-2 mb-4 px-6">
                        <span class="flex-1">商品名稱</span>
                        <span class="w-[250px] text-center">規格</span>
                        <span class="w-[150px] text-center">金額</span>
                    </div>

                    <div class="hidden xl:flex items-center mb-8 px-6">
                        <div class="flex items-center flex-1">
                            <img src="/image/4-4.webp" alt="商品圖"
                                class="w-[96px] h-auto mr-4 rounded-tl-2xl rounded-tr-2xl" />
                            <p>【IST】日式暴走頭帶 ⛩ 台灣連合 神風 暴走 特攻 極惡 客製化 刺繡 現貨 快速出貨</p>
                        </div>
                        <div class="w-[250px] text-center text-nowrap">紅色 / 特攻特 / 1件</div>
                        <div class="w-[150px] text-center">$2000</div>
                    </div>


                    <div class="xl:hidden flex flex-col gap-4 mb-8 px-2">
                        <div class="rounded-xl overflow-hidden shadow bg-white">
                            <div class="flex flex-col sm:flex-row">

                                <div class="sm:w-[40%] w-full">
                                    <img src="/image/4-4.webp" alt="商品圖" class="w-full h-full object-cover" />
                                </div>

                                <div class="p-4 sm:w-[60%] space-y-1">
                                    <p class="font-bold leading-snug">【IST】日式暴走頭帶 ⛩ 台灣連合 神風 暴走 特攻 極惡 客製化 刺繡 現貨 快速出貨</p>
                                    <p class="text-[#B41900]">紅色 / 特攻特 / 1件</p>
                                    <p class="text-[#B41900]">$2000</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </main>
        </div>
    </section>
    <!-- </section> -->
</template>


<style>
::-webkit-scrollbar {
    width: 17px;
    height: 14px;
    background-color: #e9e7e2;
}

/* 滾動條軌道 */
::-webkit-scrollbar-track {
    background: #e9e7e2;
    border: 2px solid #e9e7e2;
    box-shadow: inset 0 0 5px rgba(255, 0, 0, 0.2);
}

/* 自訂 scrollbar 方塊樣式 */
::-webkit-scrollbar-thumb {
    background: #e9e7e2;
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
    background-color: #e9e7e2;
}
</style>
