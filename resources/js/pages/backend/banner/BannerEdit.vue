<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';

const props = defineProps({ response: Array | Object });

const item = ref({
    'title': props.response.title,
    'img_path': props.response.img_path,
});

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
      router.put(route('admin.banner.update', props.response.id), item.value, {
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
      <section class="flex flex-col gap-2 w-[500px] p-4">
        <section class="flex flex-col gap-2 w-full">
          <label for="" class="flex gap-2">
            <span>標題</span>
            <input class="border w-[calc(100%-60px)]" type="text" v-model="item.title">
          </label>
          <label for="" class="flex gap-2">
            <span>圖片</span>
            <input class="border w-[calc(100%-60px)]" type="text" v-model="item.img_path">
          </label>
          </section>
        <section class="flex justify-between">
          <button type="button" @click="backBtn">返回</button>
          <button type="button" @click="submit">更新資料</button>
        </section>
    </section>
  </AppLayout>
</template>

<style scoped></style>