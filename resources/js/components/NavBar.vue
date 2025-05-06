<script setup>
import { ref } from 'vue'
import { Link, router } from '@inertiajs/vue3'


const isOpen = ref(false)

const toggleMenu = () => {
    isOpen.value = !isOpen.value
    document.body.style.overflow = isOpen.value ? 'hidden' : 'auto'
}


</script>


<template>

    <nav class="w-full fixed z-40 bg-white">
        <div class="h-[40px] bg-[#801302] flex justify-start px-2">
        </div>

        <div class="flex sm:justify-center items-center py-2 sm:px-0 px-4 relative">
            <div class="w-[48px] mt-3 mr-2">
                <img src="/image/LOGO-方.webp" alt="logo" class="w-full h-full object-cover">
            </div>

            <div>
                <p class="font-noto-jp text-[#444444] text-[12px] font-black leading-[2] tracking-[-0.08em]">
                    天下無敵、台湾特工服の第一品牌</p>
                <p
                    class="font-freckle text-[#444444] sm:text-[43px] text-[32px] font-normal leading-[0.7] tracking-[-0.08em]">
                    ITS SHOW TIME</p>
            </div>

            <div class="flex items-center absolute md:top-3 right-8">
                <div class="lg:flex items-center hidden">
                    <div class="w-[70px]">
                        <img src="/image/svg/avatar.svg" alt="" class="w-full h-full" />
                    </div>
                    <div class="text-[24px] leading-[0.7] tracking-[0.02em] mr-4 font-noto-jp">Las123</div>
                </div>

                <!-- 回到首頁 -->
                <Link :href="route('home')" class="flex sm:hidden items-center cursor-pointer px-2">
                <img src="/image/svg/home.svg" alt="" class="w-10 h-10" />
                </Link>
                <!-- Ham Btn -->
                <button type="button" class="w-12 h-12 cursor-pointer 2xl:hidden" @click="toggleMenu">
                    <i class="fa-solid fa-bars text-3xl" style="color:#801302"></i>
                </button>
            </div>
        </div>
    </nav>

  
        <div class="flex h-[100vh]">
            <div v-if="isOpen" class="fixed inset-0 bg-black bg-opacity-50 z-9 2xl:hidden" @click="toggleMenu"></div>
            <div :class="[
                'bg-[#801302] justify-center items-center transition-all duration-300 z-10',
                'fixed top-0 left-0 h-full lg:w-[40%] sm:w-[60%] w-full',
                isOpen ? 'flex' : 'hidden',
                '2xl:flex 2xl:w-[20%] 2xl:relative'
            ]">
                <div class="flex-col">
                    <div class="flex mb-10">
                        <div class="w-[75px] mr-4">
                            <img src="/image/svg/avatar-1.svg" alt="" class="w-full h-full" />
                        </div>
                        <div class="flex-col font-noto-jp">
                            <div class="text-white text-[24px] mb-2">Las123</div>
                            <div class="flex">
                                <div class="w-[25px] mr-1">
                                    <img src="/image/svg/edit-sign.svg" alt="" class="w-full h-full" />
                                </div>
                                <div class="text-white text-[20px]">編輯個人簡介</div>
                            </div>
                        </div>
                    </div>

                    <div class="border-t-[1px] border-white text-white py-8 font-noto-jp mb-10">
                        <div class="text-[24px] font-bold text-[#F0BD22] mb-4">我的帳戶</div>
                        <div class="px-4">
                            <div class="text-[20px] mb-4">個人檔案</div>
                            <div class="text-[20px] mb-8 text-[#F0BD22]">修改密碼</div>
                        </div>
                        <div class="text-[24px] font-bold mb-4">線上客服</div>
                        <div class="px-4">
                            <div class="text-[20px] mb-4">我的詢價</div>
                            <div class="text-[20px] mb-4">歷史詢價查詢</div>

                        </div>

                    </div>
                    <!-- <Link :href="route('home')" class="flex items-center text-white text-[20px] font-bold cursor-pointer gap-2">
                    回到首頁
                    <img src="/image/svg/Arrow-white.svg" alt="" class="w-4 h-4" />
                    </Link> -->

                    <button type="button"
                        class="border-[1px] border-white text-white text-[24px] px-6 py-2 cursor-pointer absolute left-1/2 transform -translate-x-1/2 bottom-4">登出
                    </button>
                </div>
            </div>
        </div>

</template>