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
};

const props = defineProps({ response: Array | Object });

const item = ref({
  name: props.response.name,
  price: props.response.price,
  content: props.response.introduction,
  // img_path: props.response.img_path ?? null,
  // img_name: props.response.img_name,
  // new_file: null,
  _method: 'put',
});

// const previewUrl = ref(null);
// const putFile = (e) => {
//   const file = e.target.files[0];
//   item.value.new_file = file;

//   // 圖片預覽
//   if (file && file.type.startsWith("image/")) {
//     previewUrl.value = URL.createObjectURL(file);
//   } else {
//     previewUrl.value = null;
//   };
// };

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
        <p>商品名稱</p>
        <input v-model="item.name" class="w-[calc(60%-100px)] border border-gray-400 rounded-sm" type="text">
      </label>
      <!-- 圖片功能還沒做 -->
      <!-- <label for="" class="flex gap-2 mb-4">
        <p>商品圖片</p>
        <input type="file" class="w-[calc(60%-100px)] border border-gray-400 rounded-sm" @change="putFile">
      </label> -->
      <label for="" class="flex gap-2 mb-4">
        <p>商品價格</p>
        <input v-model="item.price" class="w-[calc(60%-100px)] border border-gray-400 rounded-sm" type="text">
      </label>
      <div class="flex flex-col gap-1">
        <p>商品簡介：</p>
        <main id="sample" class="relative max-w-[1000px]">
          <Editor v-model="item.content" api-key="u7fewj6ygvrabi62o1x3yo4q1icxanoadqqrmlk80apmj8vz"
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