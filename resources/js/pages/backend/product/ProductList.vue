<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue';
import { useAlert } from '@/lib/useAlert';
import { flashMessage } from '@/lib/flashMessage';

const props = defineProps({ response: Array | Object });
console.log(props.response);


const addBtn = () => router.get(route('admin.product.create'));
const editBtn = (id) => router.get(route('admin.product.edit', id));

const deleteSumbit = (id) => {
  router.delete(route('admin.product.delete', id), {
    onSuccess: (response) => {
      const result = response?.props?.flash?.message ?? {};
      flashMessage(result, '刪除', route('admin.product.list'));
    },
  });
};
</script>

<template>
  <AppLayout>
    <div class="p-4">
      <button class="border border-black rounded-sm px-3 py-2 hover:bg-slate-300" type="button"
        @click="addBtn">新增</button>
      <div class="py-4">
        <table class="table-auto border border-gray-700 border-collapse">
          <thead class="bg-gray-100">
            <tr>
              <th class="border border-gray-700 px-4 py-2 text-center">操作</th>
              <th class="border border-gray-700 px-4 py-2 text-center">名稱</th>
              <th class="border border-gray-700 px-4 py-2 text-center">價格</th>
              <th class="border border-gray-700 px-4 py-2 text-center">簡介</th>
              <th class="border border-gray-700 px-4 py-2 text-center">圖片</th>
            </tr>
          </thead>
          <tbody class="text-xs">
            <tr v-for="product in props.response" :key="product.id">
              <td class="border border-gray-700 px-4 py-2">
                <button class="border border-green-500 px-2 py-1 rounded-sm hover:bg-green-300 mr-3" type="button"
                  @click="editBtn(product.id)">
                  編輯
                </button>
                <button class="border border-red-500 px-2 py-1 rounded-sm hover:bg-red-300" type="button"
                  @click="useAlert('確定要刪除嗎?', () => deleteSumbit(product.id))">
                  刪除
                </button>
              </td>
              <td class="border border-gray-700 px-4 py-2">
                {{ product?.name }}
              </td>
              <td class="border border-gray-700 px-4 py-2">
                {{ product?.price }}
              </td>
              <td class="border border-gray-700 px-4 py-2">
                <div v-html="product.introduction"></div>
              </td>
              <td class="border border-gray-700 px-4 py-2">
                <div class="flex flex-col gap-2">
                  <img v-for="(image, index) in product.product_image" :key="index" :src="image.img_path" class="min-w-[120px] object-contain object-center" alt="">
                </div>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
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