<script setup>
import { ref } from 'vue'


</script>

<template>

    <section class="flex flex-col items-center w-full h-screen bg-[#1F1B1B]">

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
        <div class="w-[100px] fixed top-10 right-0 z-10">
            <img src="/image/svg/shipping-icon.svg" class="w-full h-full object-cover">
        </div>


        <!-- 詢價清單列表 -->


        <div class="w-[1320px] flex items-end mb-6">
            <p class="flex-1 font-noto-jp font-bold text-[24px] text-[#F0BD22]">商品名稱</p>
            <p class="w-[240px] font-noto-jp font-bold text-[24px] text-[#F0BD22]">規格</p>
            <p class="w-[160px] font-noto-jp font-bold text-[24px] text-[#F0BD22]">金額</p>
            <p
                class="w-[141px] font-noto-jp font-bold text-[24px] text-center text-[#F0BD22] border-[#F0BD22] border-[3px] rounded-[2px] py-4">
                全部刪除</p>
        </div>


        <div class="flex w-[1399px] border-t-2 border-[#F0BD22] text-center font-bold font-noto-jp">
            <div class="w-full flex items-center my-10">
                <div class="flex flex-1 items-center ml-6">
                    <div class="w-[125.07px] mr-8">
                        <img class="rounded-tl-2xl rounded-tr-2xl" src="/image/4-1.webp" alt="">
                    </div>
                    <p class="w-[394px] text-[20px] text-white">IST】日式暴走頭帶 ⛩ 台灣連合 神風 暴走 特攻 極惡 客製化 刺繡 現貨 快速出貨</p>
                </div>
                <div class="w-[320px] flex justify-center">
                    <p
                        class="w-[146px] text-[24px] text-white border-white border-[3px] rounded-[5px] p-2">
                        規格選擇</p>
                </div>
                <p class="w-[200px] flex justify-center text-[24px] text-white">$300~400</p>
                <div class="w-[200px] flex justify-center">
                    <img class="w-[33px]" src="/image/svg/trash.svg" alt="">
                </div>
            </div>
        </div>








    </section>

</template>
