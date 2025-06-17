<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { useAlert } from '@/lib/useAlert';
import { flashMessage } from '@/lib/flashMessage';

const breadcrumbItems = [
  {
    title: '橫幅管理',
    href: route('admin.banner.list'),
  },
  {
    title: '新增',
    href: route('admin.banner.create'),
  },
];

const item = ref({
  title: '',
  img_path: '',
});

// 放圖片檔案
const previewUrl = ref(null);

const putFile = (e) => {
  const file = e.target.files[0];
  item.value.img_path = file;

  // 圖片預覽
  if (file && file.type.startsWith("image/")) {
    previewUrl.value = URL.createObjectURL(file);
  } else {
    previewUrl.value = null;
  };
};

const submit = () => {
  router.post(route('admin.banner.store'), item.value, {
    onSuccess: (response) => {
      const result = response?.props?.flash?.message ?? {};
      flashMessage(result, '儲存', route('admin.banner.list'));
    },
  });
};

const backBtn = () => router.get(route('admin.banner.list'));
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbItems">
    <section class="w-[500px] flex flex-col gap-5 p-4">
      <section class="w-full flex flex-col gap-4 mb-4">
        <label for="" class="flex gap-2">
          <p>標題</p>
          <input v-model="item.title" type="text" class="w-[calc(100%-60px)] dark:bg-black dark:text-white border border-gray-400 rounded-sm">
        </label>
        <label for="" accept="image/*" class="flex items-center gap-2">
          <p>圖片</p>
          <input type="file" class="w-[calc(100%-60px)] border border-gray-400 rounded-sm cursor-pointer" @change="putFile">
        </label>
        <div class="mt-2">
          <p>圖片預覽：</p>
          <img v-if="previewUrl" :src="previewUrl" class="w-[400px] mt-2 ml-4" alt="圖片預覽">
        </div>
      </section>
      <section class="flex justify-between">
        <button class="border border-black dark:border-gray-700 px-4 py-2 rounded-sm hover:bg-slate-300 dark:hover:bg-slate-700" type="button" @click="backBtn">
          返回
        </button>
        <button class="border border-black dark:border-gray-700 px-4 py-2 rounded-sm hover:bg-blue-200 dark:hover:bg-blue-950" type="button" @click="useAlert('確定要儲存嗎?', submit)">
          送出
        </button>
      </section>
    </section>
  </AppLayout>
</template>

<style scoped></style>