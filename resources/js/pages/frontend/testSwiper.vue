<script setup>
import { ref, onMounted, onBeforeUnmount, computed, defineProps } from 'vue'
import BannerSwiper from '@/components/BannerSwiper.vue';

const props = defineProps({
  response: Array,
});

</script>

<template>
<BannerSwiper :bannerData="props.response"></BannerSwiper>
</template>

<style scoped>
</style>