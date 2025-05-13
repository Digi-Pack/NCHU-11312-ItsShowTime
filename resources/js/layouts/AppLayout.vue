<script setup>
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';

// const props = withDefaults(defineProps(), {
//   breadcrumbs: () => [],
// });

const props = defineProps({
  breadcrumbs: {
    type: Array,
    default: () => []
  }
});

</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbs">
    <slot />
  </AppLayout>
</template>

