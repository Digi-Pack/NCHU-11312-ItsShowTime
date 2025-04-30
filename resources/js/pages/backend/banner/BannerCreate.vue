<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';

const item = ref({
    'title': '',
    'img_path': '',
});

const submit = () => {
  Swal.fire({
    title: "確定要儲存嗎?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "確定",
    cancelButtonText: "取消",
  }).then((result) => {
    if (result.isConfirmed) {
      router.post(route('admin.banner.store'), item.value);
      Swal.fire({
        icon: "success",
        title: "儲存成功",
        showConfirmButton: false,
        timer: 1500,
      });
    }
  });
};

const backBtn = () => router.get(route('admin.banner.list'));
// const submit = () => router.post(route('admin.banner.store'), item.value);
</script>

<template>
  <AppLayout>
    <section class="w-[500px] flex flex-col gap-5 p-4">
      <section class="w-full flex flex-col gap-4 mb-10">
        <label for="" class="flex gap-2">
          <p>標題</p>
          <input v-model="item.title" class="border w-[calc(100%-60px)]" type="text">
        </label>
        <label for="" class="flex gap-2">
          <p>圖片</p>
          <input v-model="item.img_path" class="border w-[calc(100%-60px)]" type="text">
        </label>
      </section>
      <section class="flex justify-between">
        <button class="border border-black px-4 py-1 rounded-sm" type="button" @click="backBtn">返回</button>
        <button class="border border-black px-4 py-1 rounded-sm" type="button" @click="submit">送出</button>
      </section>
    </section>
  </AppLayout>
</template>

<style scoped></style>