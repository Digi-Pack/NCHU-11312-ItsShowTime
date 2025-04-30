<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue';

const props = defineProps({ response: Array | Object });

const addBtn = () => router.get(route('admin.banner.create'));
const editBtn = (id) => router.get(route('admin.banner.edit', id));
const deleteBtn = (id) => router.get(route('admin.banner.delete', id));
</script>

<template>
  <AppLayout>
    <div class="p-4">
      <button class="border border-black rounded-sm px-3 py-2 hover:bg-slate-300" type="button"
        @click="addBtn">新增資料</button>
      <div class="overflow-x-auto py-4">
        <table class="table-auto w-full border border-gray-700 border-collapse">
          <thead class="bg-gray-100">
            <tr>
              <th class="border border-gray-700 px-4 py-2 text-left">標題</th>
              <th class="border border-gray-700 px-4 py-2 text-left">圖片路徑</th>
              <th class="border border-gray-700 px-4 py-2 text-left"></th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="banner in props.response" :key="banner.id">
              <td class="border border-gray-700 px-4 py-2">{{ banner.title }}</td>
              <td class="border border-gray-700 px-4 py-2">
                <p>{{ banner.img_path }}</p>
                <!-- <img :src="item.image" alt="圖片" class="w-24 h-24 object-cover" /> -->
              </td>
              <td class="border border-gray-700 px-4 py-2">
                <button class="border border-green-500 px-2 py-1 rounded-sm hover:bg-green-300 mr-3" type="button"
                  @click="editBtn(banner.id)">編輯</button>
                <button class="border border-red-500 px-2 py-1 rounded-sm hover:bg-red-300" type="button"
                  @click="deleteBtn(banner.id)">刪除</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AppLayout>
</template>

<style>
html,
body {
  margin: 0;
  padding: 0;
}
</style>