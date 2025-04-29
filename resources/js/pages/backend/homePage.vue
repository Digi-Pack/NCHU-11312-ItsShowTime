<script setup>
import { ref } from 'vue'



</script>

<template>
    <nav class="py-10 px-8 bg-slate-500 text-3xl text-white font-bold">後台管理
    </nav>

    <div class="w-full h-screen flex">
        <section class="flex-1 bg-slate-400 ">
            <div class="flex items-center flex-col py-10 text-2xl text-white font-bold gap-8 cursor-pointer">
                <p>首頁設定</p>
                <p>前台畫面</p>
                <p>後台管理</p>
            </div>


        </section>


        <section class="w-[80%] py-10 px-8">
            <div class="flex justify-end px-4">
                <p class="mr-2">search:</p>
                <input class=" border-2 border-gray-500"></input>
            </div>
            <div class="overflow-x-auto p-4">
                <table class="min-w-full border border-gray-300">
                    <thead class="bg-gray-200 text-gray-700">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm md:text-base xl:text-lg 2xl:text-xl">新增日期</th>
                            <th class="px-4 py-2 text-left text-sm md:text-base xl:text-lg 2xl:text-xl">發布日期</th>
                            <th class="px-4 py-2 text-left text-sm md:text-base xl:text-lg 2xl:text-xl">標題</th>
                            <th class="px-4 py-2 text-left text-sm md:text-base xl:text-lg 2xl:text-xl">操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-t">
                            <td class="px-4 py-2 text-sm md:text-base xl:text-lg 2xl:text-xl">資料 1-1</td>
                            <td class="px-4 py-2 text-sm md:text-base xl:text-lg 2xl:text-xl">資料 1-2</td>
                            <td class="px-4 py-2 text-sm md:text-base xl:text-lg 2xl:text-xl">資料 1-3</td>
                            <td class="px-4 py-2 text-sm md:text-base xl:text-lg 2xl:text-xl">資料 1-4</td>
                        </tr>
                        <tr class="border-t">
                            <td class="px-4 py-2 text-sm md:text-base xl:text-lg 2xl:text-xl">資料 2-1</td>
                            <td class="px-4 py-2 text-sm md:text-base xl:text-lg 2xl:text-xl">資料 2-2</td>
                            <td class="px-4 py-2 text-sm md:text-base xl:text-lg 2xl:text-xl">資料 2-3</td>
                            <td class="px-4 py-2 text-sm md:text-base xl:text-lg 2xl:text-xl">資料 2-4</td>
                        </tr>
                        <tr class="border-t">
                            <td class="px-4 py-2 text-sm md:text-base xl:text-lg 2xl:text-xl">資料 3-1</td>
                            <td class="px-4 py-2 text-sm md:text-base xl:text-lg 2xl:text-xl">資料 3-2</td>
                            <td class="px-4 py-2 text-sm md:text-base xl:text-lg 2xl:text-xl">資料 3-3</td>
                            <td class="px-4 py-2 text-sm md:text-base xl:text-lg 2xl:text-xl">資料 3-4</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>

</template>