<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const breadcrumbs: BreadcrumbItem[] = [
  {
    title: '後台首頁',
    href: '/dashboard',
  },
];
</script>

<template>
  <Head title="後台首頁" />

  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="h-full font-sans flex justify-center items-center text-[60px] font-bold tracking-widest">
      歡迎回來
    </div>
  </AppLayout>
</template>
