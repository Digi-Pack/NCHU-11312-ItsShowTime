<script setup>
import { ref, onMounted, onBeforeUnmount, computed, defineProps } from 'vue'
import { Link, router } from '@inertiajs/vue3'
import LoadingAnimate from '@/pages/settings/animate.vue';

// const props = defineProps({
//   response: Array | Object,
// });
// console.log(props.response);
const props = defineProps({
    response: {
        type: Object,
        required: true,
    },
});


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


// 編輯/儲存功能
const isEditing = ref(false);

// 目前是預設的，之後要依照信箱從資料庫抓資料
const username = ref('Las123');
const name = ref('廖小笙');
const birthday = ref('2000-04-05');
const phone = ref('0912345678');
const email = ref('Las123@gmail.com');


const toggleEdit = () => {
    if (isEditing.value) {
        // 此處，你可以執行保存邏輯，比如發送請求到服務器
        console.log('保存:', {
            username: username.value,
            name: name.value,
            birthday: birthday.value,
            phone: phone.value,
        });

        Swal.fire({
            position: "center",
            icon: "success",
            title: "儲存成功",
            showConfirmButton: false,
            timer: 1500
        });
    }

    isEditing.value = !isEditing.value;
};



// loading動畫
const isLoading = ref(true);

onMounted(() => {
    setTimeout(() => {
        isLoading.value = false;
    }, 1900);
});


</script>


<template>
    <LoadingAnimate v-if="isLoading" />
    <section v-else>
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

                <div class="flex items-center absolute lg:top-3 lg:right-8 right-2">
                    <div class="hidden lg:flex items-center">
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
            <div class="flex">
                <div v-if="isOpen" class="fixed inset-0 bg-black bg-opacity-50 z-10 2xl:hidden" @click="toggleMenu">
                </div>

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
                                <div class="flex cursor-pointer">
                                    <div class="w-[25px] mr-1">
                                        <img src="/image/svg/edit-sign.svg" alt="" class="w-full h-full" />
                                    </div>
                                    <div class="text-white xl:text-[20px]">編輯個人簡介</div>
                                </div>
                            </div>
                        </div>

                        <div class="border-t-[1px] border-white text-white py-8 font-noto-jp mb-12">
                            <div class="2xl:text-[24px] text-[20px] font-bold text-[#F0BD22] mb-4">我的帳戶</div>
                            <div class="px-4 flex flex-col">
                                <div class="2xl:text-[20px] text-[#F0BD22] mb-4 cursor-pointer">
                                    個人檔案
                                </div>
                                <Link :href="route('password')" class="2xl:text-[20px] mb-8 text-white cursor-pointer">
                                修改密碼
                                </Link>
                            </div>
                            <div class="2xl:text-[24px] text-[20px] font-bold mb-4">線上客服</div>
                            <div class="px-4">
                                <!-- <div class="2xl:text-[20px] mb-4 cursor-pointer">我的詢價</div> -->
                                <Link :href="route('history')" class="2xl:text-[20px] text-white cursor-pointer">歷史詢價查詢
                                </Link>

                            </div>
                        </div>
                        <div class="flex justify-center">
                            <!-- <button type="button"
                            class="border-[1px] border-white text-white 2xl:text-[24px] px-6 py-2 cursor-pointer">登出
                        </button> -->
                            <Link class="border-[1px] border-white text-white 2xl:text-[24px] px-6 py-2 cursor-pointer"
                                method="post" :href="route('logout')" as="button">
                            <LogOut class="mr-2 h-4 w-4" />
                            登出
                            </Link>
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

                        <div class="flex flex-col lg:flex-row px-6 sm:px-20 gap-12 lg:mt-8 mt-0">
                            <!--  1024px以下 頭像區 -->
                            <div
                                class="lg:hidden w-full border-b border-[#801302] flex flex-col items-center gap-4 pb-8">
                                <div
                                    class="w-[160px] sm:w-[200px] aspect-square rounded-full overflow-hidden bg-gray-100">
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
                                <div class="space-y-10">
                                    <div class="grid grid-cols-5 gap-8 items-center lg:text-[24px]">
                                        <div class="col-span-2 text-right">使用者帳號</div>
                                        <div class="col-span-3">
                                            <span v-if="!isEditing">{{ username }}</span>
                                            <input v-else v-model="username" type="text"
                                                class="w-2/3 px-4 py-2 border border-gray-300 rounded" />
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-5 gap-8 items-center lg:text-[24px]">
                                        <div class="col-span-2 text-right">姓名</div>
                                        <div class="col-span-3">
                                            <span v-if="!isEditing">{{ name }}</span>
                                            <input v-else v-model="name" type="text"
                                                class="w-2/3 px-4 py-2 border border-gray-300 rounded" />
                                        </div>
                                    </div>

                                    <!-- <div class="grid grid-cols-5 gap-8 items-center lg:text-[24px]">
                                        <div class="col-span-2 text-right">生日</div>
                                        <div class="col-span-3">
                                            <span v-if="!isEditing">{{ birthday }}</span>
                                            <input v-else v-model="birthday" type="date"
                                                class="w-2/3 px-4 py-2 border border-gray-300 rounded" />
                                        </div>
                                    </div> -->

                                    <div class="grid grid-cols-5 gap-8 items-center lg:text-[24px]">
                                        <div class="col-span-2 text-right">手機號碼</div>
                                        <div class="col-span-3">
                                            <span v-if="!isEditing">{{ phone }}</span>
                                            <input v-else v-model="phone" type="text"
                                                class="w-2/3 px-4 py-2 border border-gray-300 rounded" />
                                        </div>
                                    </div>

                                    <!-- Email 不可以給客戶改，只可讀取 -->
                                    <div class="grid grid-cols-5 gap-8 items-center lg:text-[24px]">
                                        <div class="col-span-2 text-right">Email</div>
                                        <div class="col-span-3">{{ email }}</div>
                                    </div>

                                    <!-- 編輯/儲存 Btn -->
                                    <div class="grid grid-cols-5 gap-8 items-center text-[18px] lg:text-[24px] mt-10">
                                        <div class="col-span-2"></div>
                                        <div class="col-span-3">
                                            <button @click="toggleEdit" type="button"
                                                class="border border-[#801302] text-[#801302] text-[20px] sm:text-[24px] px-6 py-2 text-nowrap cursor-pointer">
                                                {{ isEditing ? '儲存' : '編輯' }}
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <!-- 1024px以上 頭像區 -->
                            <div class="lg:w-[35%] hidden lg:flex flex-col items-center gap-4">
                                <div
                                    class="w-[160px] sm:w-[200px] aspect-square rounded-full overflow-hidden bg-gray-100">
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
    </section>
</template>


<style>
::-webkit-scrollbar {
    width: 17px;
    height: 14px;
    background-color: #e9e7e2;
}

/* 滾動條軌道 */
::-webkit-scrollbar-track {
    background: #e9e7e2;
    border: 2px solid #e9e7e2;
    box-shadow: inset 0 0 5px rgba(255, 0, 0, 0.2);
}

/* 自訂 scrollbar 方塊樣式 */
::-webkit-scrollbar-thumb {
    background: #e9e7e2;
    position: relative;
    border-radius: 0;
    background-image: url("/public/image/svg/scroll_bar_text_red.svg");
    background-repeat: no-repeat;
    background-position: center;
    background-size: contain;
    border-radius: 100px;
}

/* 滑鼠hover在方塊上的樣式 */
::-webkit-scrollbar-thumb:hover {
    background-image: url("/public/image/svg/scroll_bar_text_black.svg");
}

/* 滑動條角落 */
::-webkit-scrollbar-corner {
    background-color: #e9e7e2;
}
</style>
