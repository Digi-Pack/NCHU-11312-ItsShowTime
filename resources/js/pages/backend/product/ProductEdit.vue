<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { useAlert } from '@/lib/useAlert';
import { flashMessage } from '@/lib/flashMessage';

import Editor from '@tinymce/tinymce-vue';

// 編輯器初始設定
const editorInit = {
  height: 400,
  menubar: false,
  branding: false,
  toolbar_mode: 'sliding',
  plugins: [
    'anchor', 'autolink', 'charmap', 'codesample', 'emoticons', 'image', 'link', 'lists', 'media', 'searchreplace', 'table', 'visualblocks', 'wordcount',
    'checklist', 'mediaembed', 'casechange', 'formatpainter', 'pageembed', 'a11ychecker', 'tinymcespellchecker', 'permanentpen', 'powerpaste', 'advtable', 'advcode', 'editimage', 'advtemplate', 'ai', 'mentions', 'tinycomments', 'tableofcontents', 'footnotes', 'mergetags', 'autocorrect', 'typography', 'inlinecss', 'markdown', 'importword', 'exportword', 'exportpdf'
  ],
  toolbar:
    'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
  tinycomments_mode: 'embedded',
  tinycomments_author: 'Author name',
  mergetags_list: [
    { value: 'First.Name', title: 'First Name' },
    { value: 'Email', title: 'Email' },
  ],
  ai_request: (request, respondWith) =>
    respondWith.string(() => Promise.reject('See docs to implement AI Assistant')),
  content_style: 'body { background-color: #f3f4f6; }',
};

const props = defineProps({
  response: { type: Object },
  colors: { type: Object },
  types: { type: Object },
  sizes: { type: Object },
});
console.log(props.response);


const item = ref({
  name: props.response.name,
  price: props.response.price,
  introduction: props.response.introduction,
  colors: props.response.colors.map(c => String(c.id)),
  sizes: props.response.sizes.map(s => String(s.id)),
  types: props.response.types.map(t => String(t.id)),
  mainImg_file: props.response.first_img.img_path ?? null,
  subImg_files: props.response.subImgs.map(img => img.img_path) ?? null,

  new_mainFile: null,
  new_subFiles: [],

  _method: 'put',
});


// 首圖
const mainPreviewUrl = ref(props.response.first_img?.img_path ?? null);
const putFile = (e) => {
  const file = e.target.files[0];
  item.value.new_mainFile = file;

  if (file && file.type.startsWith("image/")) {
    mainPreviewUrl.value = URL.createObjectURL(file);
  } else {
    mainPreviewUrl.value = null;
  };
};

// 輔助圖最多4張
const subPreviewUrls = ref(props.response.subImgs.map(img => img.img_path));

const checkFiles = (e) => {
  const files = Array.from(e.target.files);
  item.value.new_subFiles = files;

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
  router.post(route('admin.product.update', props.response.id), item.value, {
    onSuccess: (response) => {
      const result = response?.props?.flash?.message ?? {};
      flashMessage(result, '儲存', route('admin.product.list'));
    },
  });
};

const backBtn = () => router.get(route('admin.product.list'));
</script>

<template>
  <AppLayout>
    <section class="flex flex-col gap-1 mb-4 p-4">

      <label for="" class="flex gap-2 mb-4">
        <p>名稱：</p>
        <input v-model="item.name" class="w-[calc(60%-100px)] border border-gray-400 rounded-sm" type="text">
      </label>

      <label for="" class="flex gap-2 mb-4">
        <p>價格：</p>
        <input v-model="item.price" class="w-[calc(60%-100px)] border border-gray-400 rounded-sm" type="text">
      </label>

      <div class="flex items-center gap-2 mb-4">
        <p>顏色：</p>
        <label v-for="(color, index) in colors" :key="index" :for="`${color?.color_name}`"
          class="flex gap-2 mr-3 cursor-pointer">
          <input v-model="item.colors" :id="`${color?.color_name}`"
            class="border border-gray-400 rounded-sm cursor-pointer" :value="`${color?.id}`" type="checkbox">{{
              color?.color_name }}
        </label>
      </div>

      <div class="flex items-center gap-2 mb-4">
        <p>款式：</p>
        <label v-for="(type, index) in types" :key="index" :for="`${type?.type_name}`"
          class="flex gap-2 mr-3 cursor-pointer">
          <input v-model="item.types" :id="`${type?.type_name}`"
            class="border border-gray-400 rounded-sm cursor-pointer" :value="`${type?.id}`" type="checkbox">{{
              type?.type_name }}
        </label>
      </div>

      <div class="flex items-center gap-2 mb-4">
        <p>尺寸：</p>
        <label v-for="(size, index) in sizes" :key="index" :for="`${size?.size_name}`"
          class="flex gap-2 mr-3 cursor-pointer">
          <input v-model="item.sizes" :id="`${size?.size_name}`"
            class="border border-gray-400 rounded-sm cursor-pointer" :value="`${size?.id}`" type="checkbox">{{
              size?.size_name }}
        </label>
      </div>

      <label for="main-pic" class="flex items-center gap-2">
        <p>首圖：</p>
        <input id="main-pic" type="file" accept="image/*"
          class="w-[calc(60%-100px)] border border-gray-400 rounded-sm cursor-pointer" @change="putFile">
      </label>
      <div class="mt-2 mb-6">
        <p>圖片預覽：</p>
        <img v-if="mainPreviewUrl" :src="mainPreviewUrl" class="w-[200px] mt-2 ml-4" alt="首圖預覽">
      </div>

      <label for="sub-pics" class="flex items-center gap-2">
        <p>輔助圖：</p>
        <input id="sub-pics" type="file" accept="image/*" multiple
          class="w-[calc(60%-100px)] border border-gray-400 rounded-sm cursor-pointer" @change="checkFiles">
      </label>
      <div class="mt-2 mb-6">
        <p>圖片預覽：</p>
        <div class="flex items-center gap-4 ml-4 my-2">
          <img v-if="subPreviewUrls" v-for="(url, index) in subPreviewUrls" :key="index" :src="url" class="w-[200px]"
            alt="輔助圖預覽">
        </div>
      </div>

      <div class="flex flex-col gap-1 mb-4">
        <p>簡介：</p>
        <main id="sample" class="relative max-w-[1000px]">
          <Editor v-model="item.introduction" api-key="8okv62o6rg25pd2ma694ju1axy7984vjrk3mmled1k2rl25a"
            :init="editorInit" />
        </main>
      </div>

      <div class="max-w-[1000px] flex justify-between mt-4">
        <button class="border border-black px-4 py-1 rounded-sm" type="button" @click="backBtn">
          返回
        </button>
        <button class="border border-black px-4 py-1 rounded-sm" type="button" @click="useAlert('確定要儲存嗎?', submit)">
          更新資料
        </button>
      </div>

    </section>
  </AppLayout>
</template>

<style scoped></style>