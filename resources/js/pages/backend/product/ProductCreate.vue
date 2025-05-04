<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';

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

const item = ref({
  name: 1123,
  content: '',
});

const saveBtn = () => {
  router.post(route('admin.product.store'), item.value);
};
 

</script>

<template>
  <AppLayout>
    <main id="sample" class="relative max-w-[1000px] m-4">
      <!-- initial-value="Welcome to TinyMCE!" -->
      <Editor v-model="item.content" api-key="u7fewj6ygvrabi62o1x3yo4q1icxanoadqqrmlk80apmj8vz" :init="editorInit" />

      <!-- @click="save" -->
      <button type="button" class="absolute right-0 border border-blue-500 rounded-sm mt-6 px-4 py-1 hover:bg-blue-300" @click="saveBtn">
        儲存
      </button>

    </main>
  </AppLayout>
</template>

<style scoped></style>