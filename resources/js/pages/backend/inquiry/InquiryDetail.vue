<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { useAlert } from '@/lib/useAlert';
import { flashMessage } from '@/lib/flashMessage';

const breadcrumbItems = [
  {
    title: '詢價單管理',
    href: route('admin.inquiry.list'),
  },
  {
    title: '查看詳細資訊',
    href: 'admin/inquiry/edit/{id}',
  },
];

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

const formatSpec = (item) => {
  return [item.color, item.type, item.size].filter(Boolean).join(' / ');
};

const handleReplyInput = () => {
  // const msg = item.value.replyMailMessage.trim();
  // item.value.status = msg === '' ? '0' : '1';
  const msg = item.value.replyMailMessage.trim();

  // 如果狀態原本是 0（未回覆），輸入文字就自動變成 1（已回覆）
  if (msg !== '' && item.value.status === 0) {
    item.value.status = 1;
  }

  // 如果文字被清空，且目前狀態是 1（已回覆），則還原成 0（未回覆）
  if (msg === '' && item.value.status === 1) {
    item.value.status = 0;
  }
};

const item = ref({
  status: props.response?.status || 0,
  replyMailMessage: props.response?.mail_message || '',
})

const submit = () => {
  router.put(route('admin.inquiry.update', props.response.id), item.value, {
    onSuccess: (response) => {
      const result = response?.props?.flash?.message ?? {};
      flashMessage(result, '儲存', route('admin.inquiry.list'));
    },
  });
};

const backBtn = () => router.get(route('admin.inquiry.list'));
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbItems">
    <div class="w-full p-4">
      <!-- 個人資料 -->
      <div>
        <p class="text-2xl font-bold mb-4">個人資料</p>
        <div class="flex flex-col gap-5 pl-1">
          <p>姓名：{{ props.response?.name }}</p>
          <p>電話：{{ props.response?.phone }}</p>
          <p>信箱：{{ props.response?.email }}</p>
          <p>地址：{{ props.response?.address }}</p>
        </div>
      </div>
      <hr class="border-2 border-gray-300 my-8 rounded-sm">
      <!-- 詢價商品 -->
      <div class="pr-2 py-2">
        <p class="text-2xl font-bold mb-4">詢價商品</p>
        <div class="flex items-start gap-20">
          <div class="w-1/2 flex flex-col gap-10 pl-1">
            <div v-for="(item, index) in props.response?.order_lists"
              class="flex flex-col gap-5 border border-gray-300 px-4 py-4 rounded-xl">
              <div class="flex">
                <p class=" whitespace-nowrap">商品名稱：</p>
                <p>{{ item?.product }}</p>
              </div>
              <p>商品規格：{{ formatSpec(item) }}</p>
              <p>商品數量：{{ item?.quantity }} 件</p>
              <p>詢價時間：{{ formatDate(props.response?.created_at) }}</p>
            </div>
          </div>
          <div class="w-1/2 h-[300px] flex flex-col">
            <p class="whitespace-nowrap mb-2">備註：</p>
            <div class="flex-1  border border-gray-600 p-3 rounded-sm">
              {{ props.response?.remark }}
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
            <select v-model="item.status" class="border border-gray-400 rounded-sm px-2 py-1">
              <option :value="0" :disabled="item.replyMailMessage.trim() !== ''">未回覆</option>
              <option :value="1">已回覆</option>
              <option :value="2">取消</option>
            </select>
          </div>
          <div class="w-[750px] h-[200px] flex">
            <p class="whitespace-nowrap">訊息回覆：</p>
            <textarea v-model="item.replyMailMessage"
              class="flex-1 h-full resize-none border border-gray-400 p-2 rounded-sm"
              @input="handleReplyInput" :readonly="props.response?.status === 1"></textarea>
          </div>
        </div>
      </div>

      <!-- 按鈕 -->
      <div class="w-[755px] flex justify-between">
        <button class="border border-black px-6 py-2 rounded-sm hover:bg-gray-300" type="button" @click="backBtn">
          取消
        </button>
        <button class="border border-black px-6 py-2 rounded-sm hover:bg-red-200" type="button"
          @click="useAlert('確定要回覆嗎?', submit)">
          回覆
        </button>
      </div>

    </div>
  </AppLayout>
</template>

<style>
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