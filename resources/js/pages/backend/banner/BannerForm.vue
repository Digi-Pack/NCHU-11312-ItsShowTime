<script setup>
import { ref, computed, onMounted } from 'vue';
import { router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { useAlert } from '@/lib/useAlert';
import { flashMessage } from '@/lib/flashMessage';

const props = defineProps({
  response: {
    type: Object,
    default: null,
  }
});

// 判斷是 新增模式 or 編輯模式
const isEdit = computed(() => !!props.response?.id);
// 用哪種方法傳送
const method = computed(() => isEdit.value ? 'put' : 'post');

const item = ref({
  title: props.response?.title ?? '',
  img_path: props.response?.img_path ?? null,
  img_name: props.response?.img_name ?? '',
  new_file: null,
  // _method: isEdit ? 'put' : 'post',
});

// 預覽圖片
const previewUrl = ref(null);

onMounted(() => {
  if (isEdit.value) {
    previewUrl.value = props.response?.img_path || null;
  }
});

const putFile = (e) => {
  const file = e.target.files[0];

  if (isEdit.value) {
    item.value.new_file = file;
  } else {
    item.value.img_path = file;
  };

  if (file && file.type.startsWith("image/")) {
    previewUrl.value = URL.createObjectURL(file);
  } else {
    previewUrl.value = null;
  };
};

const submit = () => {

  const formData = new FormData();
  formData.append('title', item.value.title);
  formData.append('_method', method.value);

  if (isEdit.value && item.value.new_file) {
    formData.append('new_file', item.value.new_file);
  } else if (!isEdit.value && item.value.img_path) {
    formData.append('img_path', item.value.img_path);
  };

  const formActionUrl = isEdit.value 
    ? route('admin.banner.update', props.response.id) 
    : route('admin.banner.store');

  router.post(formActionUrl, formData, {
    onSuccess: (response) => {
      const result = response?.props?.flash?.message ?? {};
      flashMessage(result, '儲存', route('admin.banner.list'));
    },
  });
};

const backBtn = () => router.get(route('admin.banner.list'));
</script>

<template>
  <AppLayout>
    <section class="flex flex-col gap-3 w-[500px] p-4">
      <section class="flex flex-col gap-3 w-full">
        <label for="" class="flex gap-2">
          <span>標題</span>
          <input v-model="item.title" type="text" class="w-[calc(100%-60px)] border border-gray-400 rounded-sm">
        </label>
        <label for="" class="flex items-center gap-2">
          <span>圖片</span>
          <input type="file" accept="image/*" class="w-[calc(100%-60px)] border border-gray-400 rounded-sm cursor-pointer" @change="putFile">
        </label>
        <div class="mt-2 pb-3">
          <p>圖片預覽：</p>
          <img v-if="previewUrl" :src="previewUrl" alt="圖片預覽" class="w-[400px] mt-2 ml-4">
        </div>
        <!-- <div v-if="isEdit">
          <p>目前檔案：{{ item.img_name }}</p>
          <img :src="item.img_path" alt="" class="w-[300px] object-cover object-center mt-3 ml-5" />
        </div> -->
      </section>
      <section class="flex justify-between mt-3">
        <button class="border border-black px-4 py-2 rounded-sm" type="button" @click="backBtn">返回</button>
        <button class="border border-black px-4 py-2 rounded-sm" type="button" @click="useAlert('確定要儲存嗎?', submit)">
          {{ isEdit ? '更新資料' : '新增資料' }}
        </button>
      </section>
    </section>
  </AppLayout>
</template>

<style scoped></style>