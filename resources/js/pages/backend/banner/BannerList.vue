<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue';
import { useAlert } from '@/lib/useAlert';
import { flashMessage } from '@/lib/flashMessage';

const breadcrumbItems = [
  {
    title: '橫幅管理',
    href: route('admin.banner.list'),
  },
];

const props = defineProps({ response: Array | Object });

const addBtn = () => router.get(route('admin.banner.create'));
const editBtn = (id) => router.get(route('admin.banner.edit', id));

const deleteSumbit = (id) => {
  router.delete(route('admin.banner.delete', id), {
    onSuccess: (response) => {
      const result = response?.props?.flash?.message ?? {};
      flashMessage(result, '刪除', route('admin.banner.list'));
    },
  });
};
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbItems">
    <Head title="橫幅管理" />

    <div class="p-4">
      <button class="border border-black rounded-sm px-5 py-2 hover:bg-slate-300" type="button"
        @click="addBtn">新增</button>
      <div class="overflow-x-auto py-4">
        <table class="w-full border border-gray-700 border-collapse">
          <thead class="bg-gray-100">
            <tr>
              <th class="border border-gray-700 px-4 py-2 text-center">標題</th>
              <th class="border border-gray-700 px-4 py-2 text-center">圖片</th>
              <th class="border border-gray-700 px-4 py-2 text-center">操作</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="banner in props.response" :key="banner.id">
              <td class="border border-gray-700 px-4 py-2 text-center">{{ banner.title }}</td>
              <td class="border border-gray-700 px-4 py-4">
                <div class="flex justify-center">
                  <img :src="banner.img_path" alt="" class="w-[200px] object-cover object-center" />
                </div>
              </td>
              <td class="border border-gray-700 px-4 py-2">
                <div class="flex justify-center items-center">
                  <button class="border border-green-500 px-4 py-2 rounded-sm hover:bg-green-300 mr-3" type="button"
                    @click="editBtn(banner.id)">
                    編輯
                  </button>
                  <button class="border border-red-500 px-4 py-2 rounded-sm hover:bg-red-300" type="button"
                    @click="useAlert('確定要刪除嗎?', () => deleteSumbit(banner.id))">
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
}
</style>