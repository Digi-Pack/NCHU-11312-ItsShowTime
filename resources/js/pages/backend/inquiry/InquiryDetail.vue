<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { useAlert } from '@/lib/useAlert';
import { flashMessage } from '@/lib/flashMessage';

const props = defineProps({
  response: Array | Object,
});
console.log(props.response);

const formatDate = (datetime) => {
  if (!datetime) return '';
  const date = new Date(datetime);
  const pad = (n) => String(n).padStart(2, '0');

  return `${date.getFullYear()}-${pad(date.getMonth() + 1)}-${pad(date.getDate())} 
            ${pad(date.getHours())}:${pad(date.getMinutes())}:${pad(date.getSeconds())}`;
};

</script>

<template>
  <AppLayout>
    <div class="w-full p-4">
      <!-- 個人資料 -->
      <div>
        <p class="text-2xl font-bold mb-4">個人資料</p>
        <div class="flex flex-col gap-5 pl-1">
          <p>姓名：{{ props.response?.name }}</p>
          <p>電話：{{ props.response?.phone }}</p>
          <p>信箱：{{ props.response?.email }}</p>
          <p>地址：{{ props.response?.adress }}</p>
        </div>
      </div>
      <hr class="border-2 border-gray-300 my-8 rounded-sm">
      <!-- 詢價商品 -->
      <div class="pr-2 py-2">
        <p class="text-2xl font-bold mb-4">詢價商品</p>
        <div class="flex gap-20">
          <div class="w-1/2 flex flex-col gap-5 pl-1">
            <div class="flex">
              <p class=" whitespace-nowrap">商品名稱：</p>
              <p>{{ props.response?.product.name }}</p>
            </div>
            <p>商品規格：{{ props.response?.birthday }}</p>
            <p>商品件數：{{ props.response?.phone }}</p>
            <p>詢價時間：{{ formatDate(props.response?.created_at) }}</p>
          </div>
          <div class="w-1/2 flex flex-col">
            <p class="whitespace-nowrap">備註：</p>
            <div class="flex-1 border border-gray-600 p-3 rounded-sm">
              {{ props.response?.product.name }}
            </div>
          </div>
        </div>
      </div>
      <hr class="border-2 border-gray-300 my-8 rounded-sm">
      <!-- 訂單狀態 & 回覆訊息 -->
      <div class="w-1/2 mb-10">
        <p class="text-2xl font-bold mb-4">訂單狀態/回覆訊息</p>
        <div class="flex flex-col gap-5 pl-1">
          <div class="flex items-center">
            <p>訂單狀態：</p>
            <select class="border border-gray-400 rounded-sm px-2 py-1">
              <option value="未回覆">未回覆</option>
              <option value="已回覆">已回覆</option>
              <option value="取消">取消</option>
            </select>
          </div>
          <div class="w-[750px] h-[200px] flex">
            <p class="whitespace-nowrap">訊息回覆：</p>
            <textarea class="flex-1 h-full resize-none border border-gray-400 p-2 rounded-sm"></textarea>
          </div>
        </div>
      </div>

      <!-- 按鈕 -->
      <div class="w-[755px] flex justify-between">
        <button class="border border-black px-6 py-1 rounded-sm hover:bg-gray-300" type="button" @click="backBtn">
          取消
        </button>
        <button class="border border-black px-6 py-1 rounded-sm hover:bg-blue-300" type="button" @click="useAlert('確定要儲存嗎?', submit)">
          儲存
        </button>
      </div>

    </div>
  </AppLayout>
</template>

<style scoped>
html,
body {
  font-size: 16px;
  margin: 0;
  padding: 0;
  overflow-x: scroll;
}

table {
  overflow-x: scroll;
}
</style>