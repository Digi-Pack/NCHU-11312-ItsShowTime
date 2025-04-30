<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';

const props = defineProps({ response: Array | Object });

const item = ref({
    'title': props.response.title,
    'img_path': props.response.img_path,
});

const backBtn = () => router.get(route('admin.banner.list'));
const updateBtn = () => router.post(route('admin.banner.update', props.response.id), item.value);
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
          <button type="button" @click="updateBtn">更新資料</button>
        </section>
    </section>
  </AppLayout>
</template>

<style scoped></style>