<script setup>

</script>

<template>
    <div class="relative w-full h-screen flex justify-center items-center bg-black">

        <div class="showtime-text font-noto-cjk absolute text-[#F0BD22] text-[2.5rem]">It’s Showtime</div>

        <!-- <div class="container"> -->
            <div class="image-left">
                <img src="/image/left-1.png" alt="">
            </div>
            <div class="image-right">
                <img src="/image/right-1.png" alt="">
            </div>
        <!-- </div> -->
    </div>
</template>



<style scoped>
/* .container {
    animation: spin 2s ease-in-out infinite;
} */


.image-left img {
    animation: left 2s ease-in-out;
}

.image-right img {
    animation: right 2s ease-in-out;
}

.showtime-text {
    opacity: 0;
    animation: showText 2s ease-in-out;
    z-index: 10;
}


/* @keyframes spin {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
} */


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

    /* 40% {
                transform: translateX(-10px);
            }
            70% {
                transform: translateX(-50px);
            } */
    100% {
        transform: translateX(-100px);
    }
}

@keyframes right {
    0% {
        transform: translateX(-20px);
    }

    /* 40% {
                transform: translateX(10px);
            }
            70% {
                transform: translateX(50px);
            } */
    100% {
        transform: translateX(100px);
    }
}
</style>