<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue';

const props = defineProps({ response: Array | Object });

const addBtn = () => router.get(route('admin.product.create'));
const editBtn = (id) => router.get(route('admin.product.edit', id));

// const deleteSumbit = (id) => {
//   Swal.fire({
//     title: "確定要刪除嗎?",
//     icon: "warning",
//     showCancelButton: true,
//     confirmButtonColor: "#3085d6",
//     cancelButtonColor: "#d33",
//     confirmButtonText: "確定",
//     cancelButtonText: "取消",
//   }).then((result) => {
//     if (result.isConfirmed) {
//       router.delete(route('admin.product.delete', id), {
//         onSuccess: (response) => {
//           const result = response?.props?.flash?.message ?? {};
          
//           if (result.res === 'success') {
//             Swal.fire({
//               icon: "success",
//               title: result.msg || "刪除成功",
//               showConfirmButton: false,
//               timer: 1000,
//             }).then(() => {
//               router.get(route('admin.banner.list'));
//             });
//           } else {
//             Swal.fire({
//               icon: "error",
//               title: result.msg || "刪除失敗",
//             });
//           };
//         },
//       });
//     }
//   });
// };
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
              <th class="border border-gray-700 px-4 py-2 text-center">名稱</th>
              <th class="border border-gray-700 px-4 py-2 text-center">圖片</th>
              <th class="border border-gray-700 px-4 py-2 text-center">價格</th>
              <th class="border border-gray-700 px-4 py-2 text-center">簡介</th>
              <!-- <th class="border border-gray-700 px-4 py-2 text-center">HTML簡介</th> -->
              <th class="border border-gray-700 px-4 py-2 text-center">操作</th>
            </tr>
          </thead>
          <tbody class="text-sm">
            <tr v-for="product in props.response" :key="product.id">
              <td class="border border-gray-700 px-4 py-2">
                {{ product?.name }}
              </td>
              <td class="border border-gray-700 px-4 py-2">
                <!-- <img :src="product.img_path" alt="" class="w-[200px] object-cover object-center" /> -->
              </td>
              <td class="border border-gray-700 px-4 py-2">
                {{ product?.price }}
              </td>
              <td class="border border-gray-700 px-4 py-2">
                <div v-html="product.introduction"></div>
              </td>
              <!-- <td class="border border-gray-700 px-4 py-2">
                {{ product?.introduction }}
              </td> -->
              <td class="border border-gray-700 px-4 py-2">
                <button class="border border-green-500 px-2 py-1 rounded-sm hover:bg-green-300 mr-3" type="button"
                  @click="editBtn(product.id)">編輯</button>
                <button class="border border-red-500 px-2 py-1 rounded-sm hover:bg-red-300" type="button"
                  @click="deleteSumbit(product.id)">刪除</button>
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