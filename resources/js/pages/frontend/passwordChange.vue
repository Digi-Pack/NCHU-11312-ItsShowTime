<script setup>
import { ref, onMounted, onBeforeUnmount, computed, defineProps } from 'vue'
import { Link } from '@inertiajs/vue3'

import LoadingAnimate from '@/pages/settings/animate.vue';
// import NavBar from '@/components/NavBar.vue';

import InputError from '@/components/InputError.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { Head, useForm } from '@inertiajs/vue3';


import HeadingSmall from '@/components/HeadingSmall.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';


const passwordInput = ref < HTMLInputElement | null > (null);

const currentPasswordInput = ref < HTMLInputElement | null > (null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: (errors) => {
            if (errors.password) {
                form.reset('password', 'password_confirmation');
                if (passwordInput.value instanceof HTMLInputElement) {
                    passwordInput.value.focus();
                }
            }

            if (errors.current_password) {
                form.reset('current_password');
                if (currentPasswordInput.value instanceof HTMLInputElement) {
                    currentPasswordInput.value.focus();
                }
            }
        },
    });
};



const isOpen = ref(false)

const toggleMenu = () => {
    isOpen.value = !isOpen.value
    document.body.style.overflow = isOpen.value ? 'hidden' : 'auto'
}


const currentPassword = ref('');
const newPassword = ref('');
const confirmPassword = ref('');

const PasswordVisibleCurrent = ref(false);
const PasswordVisibleOne = ref(false);
const PasswordVisibleTwo = ref(false);

const toggleConfirmPasswordCurrent = () => {
    PasswordVisibleCurrent.value = !PasswordVisibleCurrent.value;
};

const toggleConfirmPasswordOne = () => {
    PasswordVisibleOne.value = !PasswordVisibleOne.value;
};
const toggleConfirmPasswordTwo = () => {
    PasswordVisibleTwo.value = !PasswordVisibleTwo.value;
};


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
        <div class="min-h-screen flex">

            <div v-if="isOpen" class="fixed inset-0 bg-black bg-opacity-50 z-10 2xl:hidden" @click="toggleMenu">
            </div>

            <div :class="[
                'bg-[#801302] justify-center items-center transition-all duration-300 z-10',
                'fixed top-0 left-0 lg:w-[40%] sm:w-[60%] w-full',
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
                            <Link :href="route('myprofile')" class="flex cursor-pointer">
                            <div class="w-[25px] mr-1">
                                <img src="/image/svg/edit-sign.svg" alt="" class="w-full h-full" />
                            </div>
                            <div class="text-white xl:text-[20px]">編輯個人簡介</div>
                            </Link>
                        </div>
                    </div>

                    <div class="border-t-[1px] border-white text-white py-8 font-noto-jp mb-12">
                        <div class="2xl:text-[24px] text-[20px] font-bold text-[#F0BD22] mb-4">我的帳戶</div>
                        <div class="px-4 flex flex-col">
                            <Link :href="route('myprofile')" class="2xl:text-[20px] mb-4 cursor-pointer">個人檔案</Link>
                            <div class="2xl:text-[20px] mb-8 text-[#F0BD22] cursor-pointer">修改密碼
                            </div>
                        </div>
                        <div class="2xl:text-[24px] text-[20px] font-bold mb-4">線上客服</div>
                        <div class="px-4">

                            <Link :href="route('history')" class="2xl:text-[20px] text-white cursor-pointer">歷史詢價查詢
                            </Link>

                        </div>
                    </div>
                    <div class="flex justify-center">
                        <Link class="border-[1px] border-white text-white 2xl:text-[24px] px-6 py-2 cursor-pointer"
                            method="post" :href="route('logout')" as="button">
                        <LogOut class="mr-2 h-4 w-4" />
                        登出
                        </Link>
                    </div>
                </div>

            </div>


            <div class="2xl:w-[82%] w-full min-h-screen bg-[#D0D0D0] flex justify-center font-noto-jp p-4 lg:p-8">
                <div class="w-full bg-white shadow-lg relative justify-center px-4 py-6">

                    <Link :href="route('home')"
                        class="hidden sm:flex items-center gap-2 px-4 py-2 absolute top-4 right-4">
                    <img src="/image/svg/home.svg" alt="home" class="w-10 h-10" />
                    </Link>

                    <div class="sm:px-20 px-10 sm:py-16 py-8 mb-10">
                        <h1 class="text-3xl tracking-tight">修改密碼</h1>
                        <p class="text-lg mt-2">為了保護您帳號的安全，請不要分享密碼給其他人</p>
                    </div>

                    <div class="w-full space-y-6 sm:pl-20 sm:mx-0 mx-auto ">
                        <form @submit.prevent="updatePassword" class="space-y-6">
                            <div class="grid gap-2 relative">
                                <Label for="current_password" class="text-[20px]">現在密碼</Label>
                                <div class="relative">
                                    <Input id="current_password" ref="currentPasswordInput"
                                        v-model="form.current_password"
                                        :type="PasswordVisibleCurrent ? 'text' : 'password'"
                                        class="mt-1 block w-full pr-10" autocomplete="current-password"
                                        placeholder="Current password" />

                                    <img :src="PasswordVisibleCurrent ? '/image/svg/eye-open.svg' : '/image/svg/eye-close.svg'"
                                        alt="Toggle password visibility"
                                        class="absolute top-1/2 right-3 transform -translate-y-1/2 w-6 cursor-pointer"
                                        @click="toggleConfirmPasswordCurrent" />
                                </div>
                            </div>

                            <div class="grid gap-2 relative">
                                <Label for="password" class="text-[20px]">新的密碼</Label>
                                <div class="relative">
                                    <Input id="password" ref="passwordInput" v-model="form.password"
                                        :type="PasswordVisibleOne ? 'text' : 'password'" class="mt-1 block w-full pr-10"
                                        autocomplete="new-password" placeholder="New password" />
                                    <InputError :message="form.errors.password" />
                                    <img :src="PasswordVisibleOne ? '/image/svg/eye-open.svg' : '/image/svg/eye-close.svg'"
                                        alt="Toggle password visibility"
                                        class="absolute top-1/2 right-3 transform -translate-y-1/2 w-6 cursor-pointer"
                                        @click="toggleConfirmPasswordOne" />
                                </div>
                            </div>

                            <div class="grid gap-2 relative">
                                <Label for="password_confirmation" class="text-[20px]">確認密碼</Label>
                                <div class="relative">
                                    <Input id="password_confirmation" v-model="form.password_confirmation"
                                        :type="PasswordVisibleTwo ? 'text' : 'password'" class="mt-1 block w-full pr-10"
                                        autocomplete="new-password" placeholder="Confirm password" />
                                    <InputError :message="form.errors.password_confirmation" />
                                    <img :src="PasswordVisibleTwo ? '/image/svg/eye-open.svg' : '/image/svg/eye-close.svg'"
                                        alt="Toggle password visibility"
                                        class="absolute top-1/2 right-3 transform -translate-y-1/2 w-6 cursor-pointer"
                                        @click="toggleConfirmPasswordTwo" />
                                </div>
                            </div>

                            <div class="flex items-center gap-4">
                                <Button :disabled="form.processing" class="border text-nowrap cursor-pointer">儲存</Button>

                                <Transition enter-active-class="transition ease-in-out" enter-from-class="opacity-0"
                                    leave-active-class="transition ease-in-out" leave-to-class="opacity-0">
                                    <p v-show="form.recentlySuccessful" class="text-sm text-red-700">已儲存.</p>
                                </Transition>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
        </div>
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
