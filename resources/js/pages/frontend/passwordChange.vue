<script setup>
import { ref, onMounted, onBeforeUnmount, computed, defineProps } from 'vue'
import { Link, router } from '@inertiajs/vue3'



</script>


<template>

    <nav class="w-full fixed z-10 bg-white">
        <div class="h-[40px] bg-[#801302]">
        </div>

        <div class="flex justify-center items-center py-2 relative">
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

            <div class="flex items-center absolute top-3 right-8">
                <div class="w-[70px]">
                    <img src="/image/svg/avatar.svg" alt="" class="w-full h-full" />
                </div>
                <div class="text-[24px] leading-[0.7] tracking-[0.02em] mr-4 font-noto-jp">Las123</div>

                <!-- Ham Btn -->
                <button type="button" class="w-12 h-12 cursor-pointer ">
                    <i class="fa-solid fa-bars text-3xl" style="color:#801302"></i>
                </button>
            </div>
        </div>
    </nav>

    <section>
        <div class="flex h-[100vh]">
            <div class="w-[18%] flex justify-center items-center bg-[#801302] relative">
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

                    <button type="button"
                        class="border-[1px] border-white text-white text-[24px] px-6 py-2 cursor-pointer absolute left-1/2 transform -translate-x-1/2 bottom-4">登出
                    </button>

                </div>

            </div>

            <div class="w-[82%] bg-[#D0D0D0] flex justify-center items-end font-noto-jp">
                <div class="w-[95%] h-[82%] bg-white shadow-lg">

                    <div class="px-20 py-16 mb-10">
                        <div class="text-[32px] tracking-[-0.05em]">修改密碼</div>
                        <div class="text-[20px]">為了保護您帳號的安全，請不要分享密碼給其他人</div>
                    </div>
                   
                        <div class="w-[50%] flex flex-col">
                            <div class="px-8 mb-10">
                                <div class="flex my-6">
                                    <div class="flex-1 flex justify-end  text-[24px] tracking-[-0.05em] mr-6 mb-6">新的密碼
                                    </div>
                                    <div class="w-[62%] text-[24px] tracking-[-0.05em] relative">
                                        <input type="text" class="bg-[#E2E2E2] rounded-[5px] p-2 w-full">
                                        <img src="/image/svg/eye.svg"
                                            class="absolute top-1/2 right-3 transform -translate-y-1/2 w-8 cursor-pointer">
                                    </div>
                                </div>
                                <div class="flex mb-6">
                                    <div class="flex-1 flex justify-end text-[24px] tracking-[-0.05em] mr-6 mb-6">
                                        確認密碼
                                    </div>
                                    <div class="w-[62%] text-[24px] tracking-[-0.05em] relative">
                                        <input type="text" class="bg-[#E2E2E2] rounded-[5px] p-2 w-full">
                                        <img src="/image/svg/eye.svg"
                                            class="absolute top-1/2 right-3 transform -translate-y-1/2 w-8 cursor-pointer">
                                    </div>
                                </div>
                            </div>

                            <!-- 儲存按鈕 -->
                            <div class="flex px-8">
                                <div class="flex-1 flex justify-end mr-6 mb-6">

                                </div>
                                <div class="w-[62%] text-[24px] tracking-[-0.05em] relative">
                                    <button type="button"
                                        class="border-[1px] border-[#801302] text-[#801302] text-[24px] px-6 py-2 cursor-pointer">儲存
                                    </button>
                                </div>
                            </div>
                        </div>


                 


                </div>

            </div>

        </div>



    </section>

</template>
