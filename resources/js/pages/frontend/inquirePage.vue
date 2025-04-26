<script setup>
import { ref } from 'vue'


</script>

<template>

    <section class="flex flex-col items-center w-full bg-[#1F1B1B]">

        <!-- Banner -->
        <nav class="w-full flex justify-center text-[#F0BD22] py-6">
            <p class="font-noto-jp xl:text-[30px] md:text-[20px] min-[374px]:text-[14px] sm:tracking-[0.06em] mb-2">itsshowtime．無敵の特工服オーダーメイドブランド</p>
        </nav>
        <div class="xl:w-[821.46px] md:w-[45%] w-[80%] mb-12">
            <img src="/image/ITS SHOW TIME.webp" class="w-full h-full object-cover">
        </div>
        <p
            class="xl:w-[493px] font-noto-jp font-bold xl:text-[32px] sm:text-[20px] text-center text-[#F0BD22] border-[#F0BD22] border-[3px] rounded-[4px] py-3 px-5 tracking-[-0.08em] text-nowrap">
            天下無敵、台湾特工服の第一品牌</p>
        <p class="text-white font-noto-jp xl:text-[36px] sm:text-[20px] tracking-[-0.08em] py-4 mb-28">詢價清單列表</p>


        <!-- 購物車icon -->
        <div class="w-[100px] fixed top-60 right-2 z-10 cursor-pointer">
            <div class="relative w-full h-full">
                <img src="/image/svg/shipping-icon.svg" class="w-full h-full object-cover">
                <p class="absolute top-[19px] right-[79px] translate-x-1/2 -translate-y-1/2 
               text-xl font-bold">
                    1
                </p>
            </div>
        </div>

        <!-- NavBar -->
        <div class="hidden md:flex flex-col fixed top-64 xl:left-16 left-10 z-10 font-noto-cjk text-white">
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

        </div>


        <!-- 詢價清單列表 -->
        <div class="xl:w-[1320px] w-[70%] flex items-end mb-6">
            <p class="xl:flex-1 xl:w-0 w-[400px] font-noto-jp font-bold text-[24px] text-[#F0BD22]">商品名稱</p>
            <p class="xl:w-[240px] w-[180px] font-noto-jp font-bold text-[24px] text-[#F0BD22]">規格</p>
            <p class="xl:w-[160px] w-[100px] font-noto-jp font-bold text-[24px] text-[#F0BD22]">金額</p>
            <p
                class="xl:w-[141px] font-noto-jp font-bold xl:text-[24px] text-center text-[#F0BD22] border-[#F0BD22] border-[3px] rounded-[2px] py-4 px-4 cursor-pointer text-nowrap">
                全部刪除</p>
        </div>

        <div class="flex-col xl:w-[1399px] w-[70%] border-y-2 border-[#F0BD22] text-center xl:font-bold font-noto-jp mb-12">

            <div class="min-[956px]:w-full min-[956px]:flex hidden items-center my-10">
                <div class="flex xl:flex-1 items-center ml-4">
                    <div class="xl:w-[125.07px] w-[65px] xl:mr-8 mr-4">
                        <img class="rounded-tl-2xl rounded-tr-2xl" src="/image/4-1.webp" alt="">
                    </div>
                    <p class="xl:w-[394px] lg:w-[200px] md:w-[160px] xl:text-[20px] text-white">【IST】日式暴走頭帶 ⛩ 台灣連合 神風 暴走 特攻 極惡 客製化 刺繡 現貨 快速出貨</p>
                </div>
                <div class="xl:w-[300px] w-[240px] flex justify-center">
                    <p
                        class="xl:w-[146px] w-[86px] xl:text-[24px] text-white border-white border-[3px] rounded-[5px] p-2 cursor-pointer">
                        規格選擇</p>
                </div>
                <p class="xl:w-[200px] w-[140px] flex justify-center xl:text-[24px] text-white">$300~400</p>
                <div class="xl:w-[200px] w-[120px] flex justify-center xl:mr-2 cursor-pointer">
                    <img class="xl:w-[33px] w-[25px]" src="/image/svg/trash.svg" alt="">
                </div>
            </div>

            <div
                class="min-[956px]:hidden w-[30%] flex flex-col gap-2 shadow-[0px_0px_4px_0px_rgba(0,0,0,0.1)] rounded-tl-2xl rounded-tr-2xl my-8">
                <img class="rounded-tl-2xl rounded-tr-2xl" src="/image/4-1.webp" alt="">
                <div class="flex flex-col gap-2 px-2">
                  <p class="flex text-left font-noto-jp text-white leading-[1.2]">
                    IST】日式暴走頭帶 ⛩ 台灣連合 神風 暴走 特攻 極惡 客製化 刺繡 現貨 快速出貨
                  </p>
                  <p
                    class="hidden 2xl:block font-pingfang-r text-[32px] text-[#C89E51] font-normal leading-[100%] tracking-[0.08em] opacity-80 custom-shadow">
                    $1000
                  </p>
                </div>
              </div>



<!-- 
            <div class="w-full flex border-t-2 border-[#F0BD22]">
                <div class="w-full flex items-center my-10">
                    <div class="flex flex-1 items-center ml-4">
                        <div class="w-[125.07px] mr-8">
                            <img class="rounded-tl-2xl rounded-tr-2xl" src="/image/4-1.webp" alt="">
                        </div>
                        <p class="w-[394px] text-[20px] text-white">【IST】日式暴走頭帶 ⛩ 台灣連合 神風 暴走 特攻 極惡 客製化 刺繡 現貨 快速出貨</p>
                    </div>
                    <div class="w-[300px] flex justify-center">
                        <p
                            class="w-[146px] text-[24px] text-white border-white border-[3px] rounded-[5px] p-2 cursor-pointer">
                            規格選擇</p>
                    </div>
                    <p class="w-[200px] flex justify-center text-[24px] text-white">$300~400</p>
                    <div class="w-[200px] flex justify-center mr-2 cursor-pointer">
                        <img class="w-[33px]" src="/image/svg/trash.svg" alt="">
                    </div>
                </div>
            </div> -->

        </div>

        <!-- 商品項目計數 -->
        <div class="xl:w-[1399px] w-[70%] flex-col flex items-end mb-60">
            <p class="xl:text-[24px] text-white mb-2">總計 1 件商品</p>
            <p class="xl:text-[24px] text-white">總金額(NT$)待確認訂單後提供</p>
        </div>


        <!-- 詢價資料表 -->
        <div class="xl:w-[991px] sm:w-[60%] min-[376px]:w-[80%] w-[90%] flex justify-start xl:mb-10 mb-4">
            <p class="text-white font-noto-jp xl:text-[36px] text-[20px] tracking-[-0.08em] xl:ml-10">詢價資料填寫</p>
        </div>

        <div
            class="xl:w-[991px] sm:w-[60%] min-[376px]:w-[80%] w-[90%] flex flex-col xl:items-center border-t-2 border-white font-noto-jp mb-20 py-8 text-white">
            <div class="md:flex">
                <div class="xl:w-[410px] flex flex-1 flex-col xl:mr-6 md:mr-4 mb-10">
                    <label for="username" class="text-white font-noto-jp xl:text-[28px] tracking-[0.02em] mb-4">
                        姓名 | Name
                    </label>
                    <input id="username" type="text"
                        class=" bg-transparent border-[1px] border-white rounded-[8px] px-4 py-3 placeholder:text-[22px] placeholder:text-white/50"
                        placeholder="廖小笙">
                </div>

                <div class="xl:w-[456px] md:w-[50%] flex flex-col mb-10">
                    <label for="birthday" class="text-white font-noto-jp xl:text-[28px] tracking-[0.02em] mb-4">
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
                <label for="phone" class="text-white font-noto-jp xl:text-[28px] tracking-[0.02em] mb-4">
                    聯絡電話 | Phone
                </label>
                <input id="phone" type="text"
                    class="xl:w-[895px] bg-transparent border border-white rounded-[8px] px-4 py-3 placeholder:text-[22px] placeholder:text-white/50"
                    placeholder="0912345678">
            </div>

            <div class="flex flex-col mb-10">
                <label for="email" class="text-white font-noto-jp xl:text-[28px] tracking-[0.02em] mb-4">
                    電子信箱｜Email
                </label>
                <input id="email" type="text"
                    class="xl:w-[895px] bg-transparent border border-white rounded-[8px] px-4 py-3 placeholder:text-[22px] placeholder:text-white/50"
                    placeholder="Las123@gmail.com">
            </div>

            <div class="flex flex-col mb-10">
                <label for="address" class="text-white font-noto-jp xl:text-[28px] tracking-[0.02em] mb-4">
                    聯絡地址 | Address
                </label>
                <input id="address" type="text"
                    class="xl:w-[895px] bg-transparent border border-white rounded-[8px] px-4 py-3 placeholder:text-[22px] placeholder:text-white/50"
                    placeholder="南投市環山路112號">
            </div>

            <div class="flex flex-col mb-10">
                <label for="remark" class="text-white font-noto-jp xl:text-[28px] tracking-[0.02em] mb-4">
                    備註 | Remark
                </label>
                <input id="remark" type="text"
                    class="xl:w-[895px] h-[211px] bg-transparent border border-white rounded-[8px] px-4 py-3 placeholder:text-[22px]">
            </div>

        </div>

        <!-- 送出詢價按鈕 -->
        <p
            class="font-noto-jp font-bold  md:text-[24px] text-[18px] text-center text-[#F0BD22] border-[#F0BD22] border-[3px] rounded-[5px] px-12 py-4 cursor-pointer mb-36">
            送出詢價單</p>
    </section>

</template>
