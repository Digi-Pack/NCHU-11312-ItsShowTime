<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue';
import { useAlert } from '@/lib/useAlert';
import { flashMessage } from '@/lib/flashMessage';

const props = defineProps({ response: Array | Object });
// console.log(props.response);

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
      <button class="border border-black rounded-sm px-3 py-2 hover:bg-slate-300" type="button" @click="addBtn">
        新增商品
      </button>
      <button class="border border-black rounded-sm ml-3 px-3 py-2 hover:bg-blue-200" type="button" @click="addBtn">
        相關設定
      </button>
      <div class="py-4">
        <table class="w-full table-fixed border border-gray-700 border-collapse">
          <thead class="bg-gray-100">
            <tr>
              <th class="w-[350px] border border-gray-700 px-4 py-2 text-center">名稱</th>
              <th class="w-[200px] border border-gray-700 px-4 py-2 text-center">價格</th>
              <th class="w-[100px] border border-gray-700 px-4 py-2 text-center">顏色</th>
              <th class="w-[150px] border border-gray-700 px-4 py-2 text-center">款式</th>
              <th class="w-[100px] border border-gray-700 px-4 py-2 text-center">尺寸</th>
              <th class="w-[200px] border border-gray-700 px-4 py-2 text-center">主要圖片(1張)</th>
              <th class="w-[200px] border border-gray-700 px-4 py-2 text-center">操作</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="product in props.response" :key="product.id">
              <td class="border border-gray-700 px-4 py-2">
                {{ product?.name }}
              </td>
              <td class="border border-gray-700 px-4 py-2 text-center">
                {{ product?.price }}
              </td>
              <td class="border border-gray-700 px-4 py-2">
                <div class="flex flex-col justify-center items-center gap-1">
                  <span v-for="(color, index) in product?.colors">
                    {{ color?.name }}
                  </span>
                </div>
              </td>
              <td class="border border-gray-700 px-4 py-2">
                <div class="flex flex-col justify-center items-center gap-1">
                  <span v-for="(type, index) in product?.types">
                    {{ type?.name }}
                  </span>
                </div>
              </td>
              <td class="border border-gray-700 px-4 py-2">
                <div class="flex flex-col justify-center items-center gap-1">
                  <span v-for="(size, index) in product?.sizes">
                    {{ size?.name }}
                  </span>
                </div>
              </td>
              <td class="border border-gray-700 px-4 py-2">
                <div class="flex flex-col gap-2">
                  <img :src="product?.first_img?.img_path" class="min-w-[120px] object-contain object-center" alt="">
                </div>
              </td>
              <td class="border border-gray-700 px-4 py-2">
                <div class="flex justify-center items-center">
                  <button class="border border-green-500 px-2 py-1 rounded-sm hover:bg-green-300 mr-4" type="button"
                    @click="editBtn(product.id)">
                    編輯
                  </button>
                  <button class="border border-red-500 px-2 py-1 rounded-sm hover:bg-red-300" type="button"
                    @click="useAlert('確定要刪除嗎?', () => deleteSumbit(product.id))">
                    刪除
                  </button>
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
</style>