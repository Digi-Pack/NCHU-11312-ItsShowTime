<template>
    <div id="app" class="relative w-full h-screen bg-black flex justify-center items-center">
      <transition
        name="move"
        @before-enter="beforeEnter"
        @enter="enter"
        @leave="leave"
      >
        <img
          v-if="showLogo"
          :src="logoSrc"
          alt="Logo"
          class="logo w-48"  
        />
      </transition>
      <button @click="toggleLogo" class="absolute bottom-10 px-6 py-2 text-white bg-blue-500 rounded-full hover:bg-blue-600 transition-all">
        控制
      </button>
    </div>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  
  // 替換成你的 LOGO 路徑
  const logoSrc = '/image/LOGO-底部有字.webp';
  
  // 用來控制 LOGO 顯示
  const showLogo = ref(true);
  
  // 轉場前後的鉤子函數
  const beforeEnter = (el) => {
    el.style.opacity = 0;
    el.style.transform = 'translateX(-100%)'; // 從左邊進來
  };
  
  const enter = (el, done) => {
    el.offsetHeight; // 觸發重排 (force reflow)
    el.style.transition = 'transform 2s ease, opacity 1s';
    el.style.opacity = 1;
    el.style.transform = 'translateX(0)'; // 到達原位置
    done();
  };
  
  const leave = (el, done) => {
    el.style.transition = 'transform 2s ease, opacity 1s';
    el.style.opacity = 0;
    el.style.transform = 'translateX(100%)'; // 從右邊滾回去
    done();
  };
  
  // 切換 LOGO 顯示狀態
  const toggleLogo = () => {
    showLogo.value = !showLogo.value;
  };
  </script>
  
  <style scoped>
  /* 動畫過渡效果 */
  .move-enter-active, .move-leave-active {
    transition: transform 2s ease, opacity 1s;
  }
  
  .move-enter, .move-leave-to /* .move-leave-active in <2.1.8 */ {
    transform: translateX(100%);
    opacity: 0;
  }
  
  /* 這裡不需要更多自定義 CSS，因為 Tailwind 已經處理了 */
  </style>
  