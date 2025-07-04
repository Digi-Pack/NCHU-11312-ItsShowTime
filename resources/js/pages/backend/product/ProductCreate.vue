<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { useAlert } from '@/lib/useAlert';
import { flashMessage } from '@/lib/flashMessage';
import Editor from '@/components/Editor.vue';

const breadcrumbItems = [
  {
    title: '商品管理',
    href: route('admin.product.list'),
  },
  {
    title: '新增',
    href: route('admin.product.create'),
  },
];


const props = defineProps({
  colors: { type: Object },
  types: { type: Object },
  sizes: { type: Object },
});

const item = ref({
  name: '',
  price: '',
  colors: [],
  types: [],
  sizes: [],
  mainImg_file: '',
  subImg_files: [],
  introduction: '',
});



// 首圖
const mainPreviewUrl = ref(null);
const putFile = (e) => {
  const file = e.target.files[0];
  item.value.mainImg_file = file;

  if (file && file.type.startsWith("image/")) {
    mainPreviewUrl.value = URL.createObjectURL(file);
  } else {
    mainPreviewUrl.value = null;
  };
};

// 輔助圖最多4張
const subPreviewUrls = ref([]);

const checkFiles = (e) => {
  const files = Array.from(e.target.files);
  item.value.subImg_files = files;

  if (files.length > 4) {
    Swal.fire({
      icon: "error",
      title: "最多只能選擇 4 張圖片！",
    });
    e.target.value = '';
    subPreviewUrls.value = [];
    return;
  }

  subPreviewUrls.value = files.map(file => URL.createObjectURL(file));
};

const submit = () => {
  router.post(route('admin.product.store'), item.value, {
    onSuccess: (response) => {
      const result = response?.props?.flash?.message ?? {};
      flashMessage(result, '儲存', route('admin.product.list'));
    },
  });
};

const backBtn = () => router.get(route('admin.product.list'));
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbItems">
    <section class="flex flex-col gap-1 mb-4 p-4">

      <label for="" class="flex gap-2 mb-4">
        <p>名稱：</p>
        <input v-model="item.name" class="w-[calc(60%-100px)] dark:bg-black dark:text-white border border-gray-400 rounded-sm" type="text">
      </label>

      <label for="" class="flex gap-2 mb-4">
        <p>價格：</p>
        <input v-model="item.price" class="w-[calc(60%-100px)] dark:bg-black dark:text-white border border-gray-400 rounded-sm" type="text">
      </label>

      <div class="flex items-center gap-2 mb-4">
        <p>顏色：</p>
        <label v-for="(color, index) in colors" :key="index" :for="`${color?.color_name}`" class="flex gap-2 mr-3 cursor-pointer">
          <input v-model="item.colors" :id="`${color?.color_name}`" class="border border-gray-400 rounded-sm cursor-pointer" :value="`${color?.id}`"
            type="checkbox">{{ color?.color_name }}
        </label>
      </div>

      <div class="flex items-center gap-2 mb-4">
        <p>款式：</p>
        <label v-for="(type, index) in types" :key="index" :for="`${type?.type_name}`" class="flex gap-2 mr-3 cursor-pointer">
          <input v-model="item.types" :id="`${type?.type_name}`" class="border border-gray-400 rounded-sm cursor-pointer" :value="`${type?.id}`" type="checkbox">{{
            type?.type_name }}
        </label>
      </div>

      <div class="flex items-center gap-2 mb-4">
        <p>尺寸：</p>
        <label v-for="(size, index) in sizes" :key="index" :for="`${size?.size_name}`" class="flex gap-2 mr-3 cursor-pointer">
          <input v-model="item.sizes" :id="`${size?.size_name}`" class="border border-gray-400 rounded-sm cursor-pointer" :value="`${size?.id}`" type="checkbox">{{
            size?.size_name }}
        </label>
      </div>

      <label for="main-pic" class="flex items-center gap-2">
        <p>主要圖片：</p>
        <input id="main-pic" type="file" accept="image/*"
          class="w-[calc(60%-100px)] border border-gray-400 rounded-sm cursor-pointer" @change="putFile">
      </label>
      <div class="mt-2 mb-6">
        <p>圖片預覽：</p>
        <img v-if="mainPreviewUrl" :src="mainPreviewUrl" class="w-[200px] mt-2 ml-4" alt="首圖預覽">
      </div>

      <label for="sub-pics" class="flex items-center gap-2">
        <p>詳細圖片：</p>
        <input id="sub-pics" type="file" accept="image/*" multiple
          class="w-[calc(60%-100px)] border border-gray-400 rounded-sm cursor-pointer" @change="checkFiles">
      </label>
      <div class="mt-2 mb-6">
        <p>圖片預覽：</p>
        <div class="flex items-center gap-4 ml-4 my-2">
          <div v-if="subPreviewUrls">
            <img  v-for="(url, index) in subPreviewUrls" :key="index" :src="url" class="w-[200px]" alt="輔助圖預覽">
          </div>
        </div>
      </div>

      <div class="flex flex-col gap-1 mb-4">
        <p>商品介紹：</p>
        <div id="sample" class="relative max-w-[1000px] h-[300px]">
          <Editor v-model="item.introduction" />
        </div>
      </div>

      <div class="max-w-[1000px] flex justify-between mt-4">
        <button class="border border-black dark:border-gray-700 px-4 py-2 rounded-sm hover:bg-slate-300 dark:hover:bg-slate-700" type="button" @click="backBtn">
          返回
        </button>
        <button class="border border-black dark:border-gray-700 px-4 py-2 rounded-sm hover:bg-blue-200 dark:hover:bg-blue-950" type="button" @click="useAlert('確定要儲存嗎?', submit)">
          新增資料
        </button>
      </div>

    </section>
  </AppLayout>
</template>

<style scoped></style>