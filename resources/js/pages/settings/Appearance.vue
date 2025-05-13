<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

import AppearanceTabs from '@/components/AppearanceTabs.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import { type BreadcrumbItem } from '@/types';

import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';

const breadcrumbItems: BreadcrumbItem[] = [
  {
    title: '外觀設定',
    href: '/settings/appearance',
  },
];
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbItems">
    <Head title="外觀設定" />

    <SettingsLayout>
      <div class="space-y-6">
        <HeadingSmall title="外觀設定" description="更新您的帳號外觀設定" />
        <AppearanceTabs />
      </div>
    </SettingsLayout>
  </AppLayout>
</template>
