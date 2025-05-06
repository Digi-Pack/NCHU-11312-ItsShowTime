<script setup>
import { ref, onMounted, onBeforeUnmount, computed, defineProps } from 'vue'
import { Link, router } from '@inertiajs/vue3'

const isOpen = ref(false)

const toggleMenu = () => {
    isOpen.value = !isOpen.value
    document.body.style.overflow = isOpen.value ? 'hidden' : 'auto'
}

const fileInput = ref(null)
const avatarPreview = ref(null)
const uploadError = ref(null)

function triggerFileInput() {
    fileInput.value.click()
}

function handleFileChange(event) {
    const file = event.target.files[0]
    uploadError.value = null

    if (!file) return

    const isValidType = ['image/jpeg', 'image/png'].includes(file.type)
    const isValidSize = file.size <= 1024 * 1024

    if (!isValidType) {
        uploadError.value = '請選擇 .jpg 或 .png 格式的圖片'
        return
    }

    if (!isValidSize) {
        uploadError.value = '圖片大小不可超過 1MB'
        return
    }

    // 預覽圖片
    const reader = new FileReader()
    reader.onload = () => {
        avatarPreview.value = reader.result
    }
    reader.readAsDataURL(file)

    // 若要實際上傳，可在此處執行 API 請求
}



</script>


<template>

    <nav class="w-full relative z-40 bg-white">
        <div class="h-10 bg-[#801302] px-2"></div>

        <div class="flex sm:justify-center items-center py-2 px-4 sm:px-0 relative">
            <div class="w-12 mt-3 mr-2">
                <img src="/image/LOGO-方.webp" alt="logo" class="w-full h-full object-cover" />
            </div>

            <div>
                <p class="font-noto-jp text-[#444444] text-xs font-black leading-[2] tracking-tight">
                    天下無敵、台湾特攻服の第一品牌
                </p>
                <p
                    class="font-freckle text-[#444444] sm:text-[43px] text-[32px] font-normal leading-[0.7] tracking-tight">
                    ITS SHOW TIME
                </p>
            </div>

            <div class="flex items-center absolute md:top-3 md:right-8 right-2">
                <div class="hidden md:flex items-center">
                    <div class="w-[70px]">
                        <img src="/image/svg/avatar.svg" alt="avatar" class="w-full h-full" />
                    </div>
                    <div class="text-2xl leading-none tracking-wide mr-4 font-noto-jp">Las123</div>
                </div>

                <!-- Home -->
                <Link :href="route('home')" class="flex sm:hidden items-center sm:px-2 cursor-pointer">
                <img src="/image/svg/home.svg" alt="home" class="w-10 h-10" />
                </Link>

                <!-- Hambtn -->
                <button type="button" class="sm:w-12 w-8 sm:h-12 h-8 2xl:hidden" @click="toggleMenu">
                    <i class="fa-solid fa-bars text-3xl text-[#801302]"></i>
                </button>
            </div>
        </div>
    </nav>


    <section>
        <div class="flex h-screen">
            <div v-if="isOpen" class="fixed inset-0 bg-black bg-opacity-50 z-10 2xl:hidden" @click="toggleMenu"></div>

            <div :class="[
                'bg-[#801302] justify-center items-center transition-all duration-300 z-10',
                'fixed top-0 left-0 h-full lg:w-[40%] sm:w-[60%] w-full',
                isOpen ? 'flex h-screen' : 'hidden',
                '2xl:flex 2xl:w-[20%] 2xl:relative 2xl:h-auto 2xl:z-auto'
            ]">

                <div class="flex flex-col">
                    <div class="flex mb-8">
                        <div class="2xl:w-[75px] w-[50px] mr-4">
                            <img src="/image/svg/avatar-1.svg" alt="" class="w-full h-full" />
                        </div>
                        <div class="flex-col font-noto-jp">
                            <div class="text-white xl:text-[24px] mb-2">Las123</div>
                            <div class="flex">
                                <div class="w-[25px] mr-1">
                                    <img src="/image/svg/edit-sign.svg" alt="" class="w-full h-full" />
                                </div>
                                <div class="text-white xl:text-[20px]">編輯個人簡介</div>
                            </div>
                        </div>
                    </div>

                    <div class="border-t-[1px] border-white text-white py-8 font-noto-jp mb-12">
                        <div class="2xl:text-[24px] text-[20px] font-bold text-[#F0BD22] mb-4">我的帳戶</div>
                        <div class="px-4">
                            <div class="2xl:text-[20px] mb-4 cursor-pointer">個人檔案</div>
                            <div class="2xl:text-[20px] mb-8 text-[#F0BD22] cursor-pointer">修改密碼</div>
                        </div>
                        <div class="2xl:text-[24px] text-[20px] font-bold mb-4">線上客服</div>
                        <div class="px-4">
                            <!-- <div class="2xl:text-[20px] mb-4 cursor-pointer">我的詢價</div> -->
                            <div class="2xl:text-[20px] cursor-pointer">歷史詢價查詢</div>

                        </div>
                    </div>
                    <div class="flex justify-center">
                        <button type="button"
                            class="border-[1px] border-white text-white 2xl:text-[24px] px-6 py-2 cursor-pointer">登出
                        </button>
                    </div>
                </div>
            </div>

            <div class="2xl:w-[82%] w-full h-screen bg-[#D0D0D0] flex justify-center font-noto-jp py-12 px-4">
                <div class="w-full bg-white shadow-lg relative overflow-y-auto pb-8">

                    <!-- 返回首頁 -->
                    <Link :href="route('home')"
                        class="hidden sm:flex items-center gap-2 px-4 py-2 absolute top-4 right-4">
                    <img src="/image/svg/home.svg" alt="home" class="w-10 h-10" />
                    </Link>

                    <div class="text-[24px] lg:text-[32px] font-bold tracking-tight px-8 lg:px-20 py-8 lg:py-16">
                        我的檔案
                    </div>

                    <div class="flex flex-col lg:flex-row px-6 sm:px-20 gap-12">

                        <!--  1024px以下 頭像區 -->
                        <div class="lg:hidden w-full border-b border-[#801302] flex flex-col items-center gap-4 pb-8">
                            <div class="w-[160px] sm:w-[200px] aspect-square rounded-full overflow-hidden bg-gray-100">
                                <img :src="avatarPreview || '/image/svg/avatar.svg'" alt="頭像預覽"
                                    class="w-full h-full object-cover" />
                            </div>

                            <input type="file" ref="fileInput" class="hidden" accept=".jpg,.jpeg,.png"
                                @change="handleFileChange" />
                            <button type="button"
                                class="border border-black text-[16px] sm:text-[20px] px-4 py-1 rounded hover:bg-black hover:text-white transition"
                                @click="triggerFileInput">
                                選擇圖片
                            </button>

                            <div class="text-[14px] text-gray-600 text-center leading-tight">
                                檔案大小: 最大1MB<br />
                                檔案限制: .JPEG, .PNG
                            </div>

                            <div v-if="uploadError" class="text-red-600 text-sm mt-2">{{ uploadError }}</div>
                        </div>

            
                        <div class="lg:w-[65%] lg:border-r border-[#801302] pr-0 lg:pr-8">
                            <div class="space-y-6">
                                <div class="grid grid-cols-5 gap-4 items-center  lg:text-[24px]">
                                    <div class="col-span-2 text-right">使用者帳號</div>
                                    <div class="col-span-3">Las123</div>
                                </div>

                                <div class="grid grid-cols-5 gap-4 items-center  lg:text-[24px]">
                                    <div class="col-span-2 text-right">姓名</div>
                                    <div class="col-span-3">廖小笙</div>
                                </div>

                                <div class="grid grid-cols-5 gap-4 items-center  lg:text-[24px]">
                                    <div class="col-span-2 text-right">生日</div>
                                    <div class="col-span-3">2000/04/05</div>
                                </div>

                                <div class="grid grid-cols-5 gap-4 items-center  lg:text-[24px]">
                                    <div class="col-span-2 text-right">手機號碼</div>
                                    <div class="col-span-3">0912345678</div>
                                </div>

                                <div class="grid grid-cols-5 gap-4 items-center  lg:text-[24px]">
                                    <div class="col-span-2 text-right">Email</div>
                                    <div class="col-span-3">Las123@gmail.com</div>
                                </div>

                                <!-- 編輯按鈕 -->
                                <div class="grid grid-cols-5 gap-4 items-center text-[18px] lg:text-[24px] mt-10">
                                    <div class="col-span-2"></div>
                                    <div class="col-span-3">
                                            <button type="button"
                                                class="border border-[#801302] text-[#801302] text-[20px] sm:text-[24px] px-6 py-2 cursor-pointer">
                                                編輯
                                            </button>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- 1024px以上 頭像區 -->
                        <div class="lg:w-[35%] hidden lg:flex flex-col items-center gap-4">
                            <div class="w-[160px] sm:w-[200px] aspect-square rounded-full overflow-hidden bg-gray-100">
                                <img :src="avatarPreview || '/image/svg/avatar.svg'" alt="頭像預覽"
                                    class="w-full h-full object-cover" />
                            </div>

                            <input type="file" ref="fileInput" class="hidden" accept=".jpg,.jpeg,.png"
                                @change="handleFileChange" />
                            <button type="button"
                                class="border border-black text-[16px] sm:text-[20px] px-4 py-1 rounded hover:bg-black hover:text-white transition"
                                @click="triggerFileInput">
                                選擇圖片
                            </button>

                            <div class="text-[14px] text-gray-600 text-center leading-tight">
                                檔案大小: 最大1MB<br />
                                檔案限制: .JPEG, .PNG
                            </div>

                            <div v-if="uploadError" class="text-red-600 text-sm mt-2">{{ uploadError }}</div>
                        </div>
                    </div>
                </div>
            </div>

        </div>



    </section>

</template>
