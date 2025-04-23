<script setup>
import { ref } from 'vue'



</script>

<template>

    <section class="py-10 px-4">
        <div class="flex ">
            <p class="text-3xl pl-4 mb-10">後台管理</p>
            <button type="button">新增</button>
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


</template>