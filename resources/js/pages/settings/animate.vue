<script setup>

</script>

<template>
<div class="relative w-full h-screen flex justify-center items-center bg-black">

<div class="showtime-text absolute text-[#F0BD22] text-[2rem]">It’s Showtime</div>

<div class="image-left">
    <img src="/image/left.png" alt="" class="">
</div>
<div class="image-right ">
    <img src="/image/right.png" alt="" class="">
</div>
</div>
</template>



<style scoped>

.image-left img {
            animation: left 3s ease-in-out infinite;
        }

        .image-right img {
            animation: right 3s ease-in-out infinite;
        }

        .showtime-text {
            opacity: 0;
            animation: showText 3s ease-in-out infinite;
            z-index: 10;
        }

        @keyframes showText {
            0% {
                opacity: 0;
            }
            50% {
                opacity: 1;
            }
            
            100% {
                opacity: 0;
            }
        }

        @keyframes left {
            0% {
                transform: translateX(20px);
            }

            100% {
                transform: translateX(-10px);
            }
        }

        @keyframes right {
            0% {
                transform: translateX(-20px);
            }

            100% {
                transform: translateX(10px);
            }
        }
</style>