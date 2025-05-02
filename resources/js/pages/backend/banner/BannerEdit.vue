<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';

const props = defineProps({ response: Array | Object });

const item = ref({
  title: props.response.title,
  img_path: props.response.img_path,
  img_name: props.response.img_name,
  new_file: null,
  _method: 'put',
});

const previewUrl = ref(null);
const putFile = (e) => {
  const file = e.target.files[0];
  item.value.new_file = file;

  // 圖片預覽
  if (file && file.type.startsWith("image/")) {
    previewUrl.value = URL.createObjectURL(file);
  } else {
    previewUrl.value = null;
  };
};

const submit = () => {
  Swal.fire({
    title: "確定要修改嗎?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "確定",
    cancelButtonText: "取消",
  }).then((result) => {
    if (result.isConfirmed) {
      router.post(route('admin.banner.update', props.response.id), item.value, {
        onSuccess: (response) => {
          const result = response?.props?.flash?.message ?? {};

          if (result.res === 'success') {
            Swal.fire({
              icon: "success",
              title: result.msg || "儲存成功",
              showConfirmButton: false,
              timer: 1000,
            }).then(() => {
              router.get(route('admin.banner.list'));
            });
          } else {
            Swal.fire({
              icon: "error",
              title: result.msg || "儲存失敗",
            });
          };
        },
      });
    }
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
          <input class="border w-[calc(100%-60px)]" type="text" v-model="item.title">
        </label>
        <label for="" class="flex gap-2">
          <span>圖片</span>
          <input class="border w-[calc(100%-60px)] cursor-pointer" type="file" @change="putFile">
        </label>
        <div class="mt-2 pb-3">
          <p>圖片預覽：</p>
          <img v-if="previewUrl" :src="previewUrl" alt="圖片預覽" class="w-[400px] mt-2 ml-4">
        </div>
        <!-- <div>
          <p>目前檔案：{{ item.img_name }}</p>
          <img :src="item.img_path" alt="" class="w-[300px] object-cover object-center mt-3 ml-5" />
        </div> -->
      </section>
      <section class="flex justify-between mt-3">
        <button class="border border-black px-4 py-2 rounded-sm" type="button" @click="backBtn">返回</button>
        <button class="border border-black px-4 py-2 rounded-sm" type="button" @click="submit">更新資料</button>
      </section>
    </section>
  </AppLayout>
</template>

<style scoped></style>