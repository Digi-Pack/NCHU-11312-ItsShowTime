<script setup>
import { ref } from 'vue'


</script>

<template>

    <section class="flex flex-col items-center w-full bg-[#1F1B1B]">

        <!-- navbar -->
        <nav class="w-full flex justify-center text-[#F0BD22] py-6">
            <p class="font-noto-jp text-[32px] tracking-[0.06em] mb-2">itsshowtime．無敵の特工服オーダーメイドブランド</p>
        </nav>
        <div class="w-[821.46px] mb-12">
            <img src="/image/ITS SHOW TIME.png" class="w-full h-full object-cover">
        </div>
        <p
            class="w-[493px] font-noto-jp font-bold text-[32px] text-[#F0BD22] border-[#F0BD22] border-[3px] rounded-[4px] py-3 px-5 tracking-[-0.08em]">
            天下無敵、台湾特工服の第一品牌</p>
        <p class="text-white font-noto-jp text-[36px] tracking-[-0.08em] py-4 mb-28">詢價清單列表</p>


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


        <!-- 詢價清單列表 -->
        <div class="w-[1320px] flex items-end mb-6">
            <p class="flex-1 font-noto-jp font-bold text-[24px] text-[#F0BD22]">商品名稱</p>
            <p class="w-[240px] font-noto-jp font-bold text-[24px] text-[#F0BD22]">規格</p>
            <p class="w-[160px] font-noto-jp font-bold text-[24px] text-[#F0BD22]">金額</p>
            <p
                class="w-[141px] font-noto-jp font-bold text-[24px] text-center text-[#F0BD22] border-[#F0BD22] border-[3px] rounded-[2px] py-4 cursor-pointer">
                全部刪除</p>
        </div>

        <div class="flex-col w-[1399px] border-y-2 border-[#F0BD22] text-center font-bold font-noto-jp mb-12">
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
            </div>

        </div>

        <!-- 商品項目計數 -->
        <div class="w-[1399px] flex-col flex items-end mb-60">
            <p class="text-[24px] text-white mb-2">總計 1 件商品</p>
            <p class="text-[24px] text-white">總金額(NT$)待確認訂單後提供</p>
        </div>


        <!-- 詢價資料表 -->
        <div class="w-[991px] flex justify-start mb-10">
            <p class="text-white font-noto-jp text-[36px] tracking-[-0.08em] ml-10">詢價資料填寫</p>
        </div>

        <div class="w-[991px] flex flex-col items-center border-t-2 border-white font-noto-jp mb-20 py-8 text-white">
            <div class="flex">
                <div class="flex flex-col mr-6 mb-10">
                    <label for="username" class="text-white font-noto-jp text-[28px] tracking-[0.02em] mb-4">
                        姓名 | Name
                    </label>
                    <input id="username" type="text"
                        class="w-[410px] bg-transparent border-[1px] border-white rounded-[8px] px-4 py-3 placeholder:text-[22px] placeholder:text-white/50"
                        placeholder="廖小笙">
                </div>

                <div class="flex flex-col mb-10">
                    <label for="birthday" class="text-white font-noto-jp text-[28px] tracking-[0.02em] mb-4">
                        出生年月日 | Birthday
                    </label>

                    <div class="relative w-[456px]">
                        <input id="birthday" type="text" class="w-full bg-transparent border border-white rounded-[8px] px-4 py-3 pr-12
                   placeholder:text-[22px] placeholder:text-white/50 text-white" placeholder="年/月/日">

                        <img src="/image/svg/calendar.svg" alt="calendar icon"
                            class="w-[24px] h-[24px] absolute right-4 top-1/2 -translate-y-1/2 cursor-pointer"
                            onclick="document.getElementById('birthday').focus()" />
                    </div>
                </div>



            </div>

            <div class="flex flex-col mb-10">
                <label for="phone" class="text-white font-noto-jp text-[28px] tracking-[0.02em] mb-4">
                    聯絡電話 | Phone
                </label>
                <input id="phone" type="text"
                    class="w-[895px] bg-transparent border border-white rounded-[8px] px-4 py-3 placeholder:text-[22px] placeholder:text-white/50"
                    placeholder="0912345678">
            </div>

            <div class="flex flex-col mb-10">
                <label for="email" class="text-white font-noto-jp text-[28px] tracking-[0.02em] mb-4">
                    電子信箱｜Email
                </label>
                <input id="email" type="text"
                    class="w-[895px] bg-transparent border border-white rounded-[8px] px-4 py-3 placeholder:text-[22px] placeholder:text-white/50"
                    placeholder="Las123@gmail.com">
            </div>

            <div class="flex flex-col mb-10">
                <label for="address" class="text-white font-noto-jp text-[28px] tracking-[0.02em] mb-4">
                    聯絡地址 | Address
                </label>
                <input id="address" type="text"
                    class="w-[895px] bg-transparent border border-white rounded-[8px] px-4 py-3 placeholder:text-[22px] placeholder:text-white/50"
                    placeholder="南投市環山路112號">
            </div>

            <div class="flex flex-col mb-10">
                <label for="remark" class="text-white font-noto-jp text-[28px] tracking-[0.02em] mb-4">
                    備註 | Remark
                </label>
                <input id="remark" type="text"
                    class="w-[895px] h-[211px] bg-transparent border border-white rounded-[8px] px-4 py-3 placeholder:text-[22px]">
            </div>

        </div>

        <!-- 送出詢價按鈕 -->
        <p
            class="font-noto-jp font-bold text-[24px] text-center text-[#F0BD22] border-[#F0BD22] border-[3px] rounded-[2px] px-12 py-6 cursor-pointer mb-36">
            送出詢價單</p>
    </section>

</template>
