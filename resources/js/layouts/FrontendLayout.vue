<script setup>
import { ref, onMounted } from 'vue';
import FrontendFooter from '@/components/FrontendFooter.vue';
import LoadingAnimate from '@/pages/settings/animate.vue';

const isLoading = ref(true);

onMounted(() => {
  setTimeout(() => {
    isLoading.value = false;
  }, 1900);
});
</script>

<template>
    <LoadingAnimate v-if="isLoading"/>
    <section v-else>
        <main>
            <slot />
        </main>
        <FrontendFooter />
    </section>
</template>