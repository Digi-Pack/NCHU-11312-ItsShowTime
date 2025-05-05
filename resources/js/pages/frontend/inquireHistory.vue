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
                        <div class="text-[24px] font-bold mb-4">我的帳戶</div>
                        <div class="px-4">
                            <div class="text-[20px] mb-4">個人檔案</div>
                            <div class="text-[20px] mb-8">修改密碼</div>
                        </div>
                        <div class="text-[24px] font-bold mb-4 text-[#F0BD22]">線上客服</div>
                        <div class="px-4">
                            <div class="text-[20px] mb-4">我的詢價</div>
                            <div class="text-[20px] mb-4 text-[#F0BD22] ">歷史詢價查詢</div>
                        </div>
                    </div>

                    <button type="button"
                        class="border-[1px] border-white text-white text-[24px] px-6 py-2 cursor-pointer absolute left-1/2 transform -translate-x-1/2 bottom-4">登出
                    </button>

                </div>

            </div>

            <div class="w-[82%] bg-[#D0D0D0] flex justify-center items-end font-noto-jp">
                <div class="w-[90%] h-[82%] bg-white shadow-lg">
                    <div class="text-[32px] tracking-[-0.05em] px-20 py-16 mb-10">歷史詢價</div>
                    
                    <div class="px-20">
                        <div class="w-full flex items-end mb-6 px-6 xl:text-[24px] text-20">
                            <p
                                class="flex flex-1 font-noto-jp font-bold text-nowrap mr-4">
                                商品名稱</p>
                            <p class="2xl:w-[300px] w-[200px] hidden xl:flex justify-center font-noto-jp font-bold">
                                規格</p>
                            <p class="2xl:w-[200px] w-[100px] hidden xl:flex justify-center font-noto-jp font-bold">
                                金額</p>
                        </div>


                        <div
                            class="w-full border-y-[1px] border-[#B41900] text-center font-noto-jp px-2">

                            <div class="w-full xl:flex hidden items-center my-10 xl:text-[20px] text-[14px]">
                                <div class="flex items-center ml-4">
                                    <div class="xl:w-[125px] w-[96px] mr-4">
                                        <img class="rounded-tl-2xl rounded-tr-2xl" src="/image/4-4.webp"
                                            alt="Product Image">
                                    </div>
                                    <p class="flex flex-1 text-left">
                                        【IST】日式暴走頭帶 ⛩ 台灣連合 神風 暴走 特攻 極惡 客製化 刺繡 現貨 快速出貨</p>
                                </div>
                                <div class="xl:w-[300px] w-[200px] flex justify-center text-nowrap">
                                    紅色 / 特攻特 /1件</div>
                                <p class="xl:w-[200px] w-[140px] flex justify-center ">
                                    $2000
                                </p>
        
                            </div>

                            <!-- min-[956px]以下才出現的選擇規格商品圖 -->
                            <div class="flex flex-wrap">
                                <div
                                    class="xl:hidden md:w-[40%] flex flex-col gap-2 rounded-tl-2xl rounded-tr-2xl my-8 p-1 group relative ml-4">
                                    <img class="rounded-tl-2xl rounded-tr-2xl w-full" src="/image/4-4.webp"
                                        alt="Product Image">

                                    <div class="flex flex-col gap-2 px-2 pb-4 md:h-[100px] ">
                                        <p class="text-left font-noto-jp leading-[1.2]">
                                            【IST】日式暴走頭帶 ⛩ 台灣連合 神風 暴走 特攻 極惡 客製化 刺繡 現貨 快速出貨
                                        </p>
                                        <p>
                                            紅色 / 特攻特 /1件
                                        </p>
                                    </div>
                                   
                                    <div class="flex justify-around">


                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>





                </div>

            </div>

        </div>



    </section>

</template>
