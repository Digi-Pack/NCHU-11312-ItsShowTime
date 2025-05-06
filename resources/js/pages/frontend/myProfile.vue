<script setup>
import { ref, onMounted, onBeforeUnmount, computed, defineProps } from 'vue'
import { Link, router } from '@inertiajs/vue3'

const isOpen = ref(false)

const toggleMenu = () => {
    isOpen.value = !isOpen.value
    document.body.style.overflow = isOpen.value ? 'hidden' : 'auto'
}

</script>


<template>

    <nav class="w-full fixed z-40 bg-white">
        <div class="h-[40px] bg-[#801302]">
        </div>

        <div class="flex sm:justify-center items-center py-2 sm:px-0 px-4 relative">
            <div class="w-[48px] mt-3 mr-2">
                <img src="/image/LOGO-方.webp" alt="logo" class="w-full h-full object-cover">
            </div>

            <div>
                <p class="font-noto-jp text-[#444444] text-[12px] font-black leading-[2] tracking-[-0.08em]">
                    天下無敵、台湾特攻服の第一品牌</p>
                <p
                    class="font-freckle text-[#444444] sm:text-[43px] text-[32px] font-normal leading-[0.7] tracking-[-0.08em]">
                    ITS SHOW TIME</p>
            </div>

            <div class="flex items-center absolute md:top-3 right-8">
                <div class="md:flex items-center hidden">
                    <div class="w-[70px]">
                        <img src="/image/svg/avatar.svg" alt="" class="w-full h-full" />
                    </div>
                    <div class="text-[24px] leading-[0.7] tracking-[0.02em] mr-4 font-noto-jp">Las123</div>
                </div>
                <!-- Ham Btn -->
                <button type="button" class="w-12 h-12 cursor-pointer 2xl:hidden" @click="toggleMenu">
                    <i class="fa-solid fa-bars text-3xl" style="color:#801302"></i>
                </button>
            </div>
        </div>
    </nav>

    <section>
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
                            <div class="text-[20px] text-[#F0BD22] mb-4">個人檔案</div>
                            <div class="text-[20px] mb-8">修改密碼</div>
                        </div>
                        <div class="text-[24px] font-bold mb-4">線上客服</div>
                        <div class="px-4">
                            <div class="text-[20px] mb-4">我的詢價</div>
                            <div class="text-[20px] mb-4">歷史詢價查詢</div>
                        </div>
                    </div>

                    <button type="button"
                        class="border-[1px] border-white text-white text-[24px] px-6 py-2 cursor-pointer absolute left-1/2 transform -translate-x-1/2 bottom-4">登出
                    </button>

                </div>

            </div>

            <div class="2xl:w-[82%] w-full bg-[#D0D0D0] flex justify-center items-end font-noto-jp">
                <div class="w-[95%] bg-white shadow-lg relative">

                    <Link :href="route('home')"
                            class="flex items-center font-normal leading-[1.2] text-black text-[20px] cursor-pointer px-4 py-2 absolute sm:top-4 sm:right-4 right-0 gap-2">
                        回到首頁
                        <img src="/image/svg/Arrow-red.svg" alt=""  class="w-4 h-4"/>
                        </Link>

                    <div class="text-[32px] tracking-[-0.05em] px-20 py-16">我的檔案</div>
                    <div class="flex">
                        <div class="w-[60%] flex flex-col">
                            <div class="px-8 border-r-[1px] border-[#801302]">
                                <div class="flex my-6">
                                    <div class="flex-1 flex justify-end  text-[24px] tracking-[-0.05em] mr-6 mb-6">使用者帳號
                                    </div>
                                    <div class="w-[70%] text-[24px] tracking-[-0.05em]">Las123</div>
                                </div>
                                <div class="flex mb-6">
                                    <div class="flex-1 flex justify-end text-[24px] tracking-[-0.05em] mr-6 mb-6">姓名
                                    </div>
                                    <div class="w-[70%] text-[24px] tracking-[-0.05em]">廖小笙</div>
                                </div>
                                <div class="flex mb-6">
                                    <div class="flex-1 flex justify-end text-[24px] tracking-[-0.05em] mr-6 mb-6">生日
                                    </div>
                                    <div class="w-[70%] text-[24px] tracking-[-0.05em]">2000/04/05</div>
                                </div>
                                <div class="flex mb-6">
                                    <div class="flex-1 flex justify-end text-[24px] tracking-[-0.05em] mr-6 mb-6">手機號碼
                                    </div>
                                    <div class="w-[70%] text-[24px] tracking-[-0.05em]">0912345678</div>
                                </div>
                                <div class="flex mb-20">
                                    <div class="flex-1 flex justify-end text-[24px] tracking-[-0.05em] mr-6 mb-6">Email
                                    </div>
                                    <div class="w-[70%] text-[24px] tracking-[-0.05em]">Las123@gmail.com</div>
                                </div>
                            </div>

                            <!-- 編輯按鈕 -->
                            <div class="px-8 flex mb-6">
                                <div class="flex-1 flex mr-6 my-6"></div>
                                <div class="w-[70%]">
                                    <button type="button"
                                        class="border-[1px] border-[#801302] text-[#801302] text-[24px] px-6 py-2 cursor-pointer">編輯
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- 換頭像 -->
                        <div class="w-[35%] flex flex-col justify-start items-center">
                            <div class="w-[200px]">
                                <img src="/image/svg/avatar.svg" alt="" class="w-full h-full" />
                            </div>
                            <button type="button"
                                class="border-[1px] border-black text-[24px] px-4 py-1 cursor-pointer mb-6">選擇圖片
                            </button>
                            <div class="text-[16px] text-gray-600">
                                檔案大小: 最大1MB
                            </div>
                            <div class="text-[16px] text-gray-600">
                                檔案限制: .JPEG, .PNG
                            </div>





                        </div>
                    </div>


                </div>

            </div>

        </div>



    </section>

</template>
