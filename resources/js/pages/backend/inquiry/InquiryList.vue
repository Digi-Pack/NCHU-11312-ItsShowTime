<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue';
import { useAlert } from '@/lib/useAlert';
import { flashMessage } from '@/lib/flashMessage';

const props = defineProps({ response: Array | Object });
// console.log(props.response);

const formatDate = (datetime) => {
    if (!datetime) return '';
    const date = new Date(datetime);
    const pad = (n) => String(n).padStart(2, '0');

    return `${date.getFullYear()}-${pad(date.getMonth() + 1)}-${pad(date.getDate())} 
            ${pad(date.getHours())}:${pad(date.getMinutes())}:${pad(date.getSeconds())}`;
  }

const deleteSumbit = (id) => {
  router.delete(route('admin.inquiry.delete', id), {
    onSuccess: (response) => {
      const result = response?.props?.flash?.message ?? {};
      flashMessage(result, '刪除', route('admin.inquiry.list'));
    },
  });
};
</script>

<template>
  <AppLayout>
    <div class="p-4">
      <table class="table-auto border border-gray-700 border-collapse">
        <thead class="bg-gray-100">
          <tr>
            <th class="border border-gray-700 px-4 py-2 text-center">姓名</th>
            <th class="border border-gray-700 px-4 py-2 text-center">信箱</th>
            <th class="border border-gray-700 px-4 py-2 text-center">電話</th>
            <th class="border border-gray-700 px-4 py-2 text-center">詢價商品</th>
            <th class="border border-gray-700 px-4 py-2 text-center">件數</th>
            <th class="border border-gray-700 px-4 py-2 text-center">下單時間</th>
            <th class="border border-gray-700 px-4 py-2 text-center">操作</th>
          </tr>
        </thead>
        <tbody class="text-sm">
          <tr v-for="inquiry in props.response" :key="inquiry.id">
            <td class="border border-gray-700 px-4 py-2">
              {{ inquiry?.name }}
            </td>
            <td class="border border-gray-700 px-4 py-2">
              {{ inquiry?.email }}
            </td>
            <td class="border border-gray-700 px-4 py-2">
              {{ inquiry?.phone }}
            </td>
            <td class="border border-gray-700 px-4 py-2">
              {{ inquiry?.product.name }}
            </td>
            <td class="border border-gray-700 px-4 py-2 text-center">
              {{ inquiry?.quantity }}
            </td>
            <td class="border border-gray-700 px-4 py-2">
              {{ formatDate(inquiry?.created_at) }}
            </td>
            <td class="border border-gray-700 px-4 py-2">
              <button class="border border-red-500 px-2 py-1 rounded-sm hover:bg-red-300" type="button"
                @click="useAlert('確定要刪除嗎?', () => deleteSumbit(inquiry.id))">
                刪除
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </AppLayout>
</template>

<style scoped>
html,
body {
  margin: 0;
  padding: 0;
  overflow-x: scroll;
}

table {
  white-space: nowrap;
}
</style>