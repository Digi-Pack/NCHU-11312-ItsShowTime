<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
});

const submit = () => {
  form.post(route('register'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  });
};
</script>

<template>
  <div class="flex fixed z-10 top-12 right-16">
   
    <Link :href="route('login')"
      class="inline-block rounded-sm border border-white px-5 py-1.5 text-xl leading-normal text-white hover:border-white dark:border-white dark:text-[#EDEDEC] dark:hover:border-white mr-2">
    登入
    </Link>
    <Link :href="route('register')"
      class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-xl leading-normal text-white hover:border-white dark:text-[#EDEDEC] dark:hover:border-white">
    註冊
    </Link>

  </div>

  <AuthBase title="建立會員" class="bg-cover h-screen text-white font-bold"
    :style="{ backgroundImage: 'url(/image/login-background.webp)' }">

    <Head title="Register" />

    <form @submit.prevent="submit" class="flex flex-col gap-6">
      <div class="grid gap-6">
        <div class="grid gap-2">
          <Label for="name">姓名</Label>
          <Input id="name" type="text" required autofocus :tabindex="1" autocomplete="name" v-model="form.name"
            placeholder="Full name" />
          <InputError :message="form.errors.name" />
        </div>

        <div class="grid gap-2">
          <Label for="email">信箱</Label>
          <Input id="email" type="email" required :tabindex="2" autocomplete="email" v-model="form.email"
            placeholder="email@example.com" />
          <InputError :message="form.errors.email" />
        </div>

        <div class="grid gap-2">
          <Label for="password">密碼</Label>
          <Input id="password" type="password" required :tabindex="3" autocomplete="new-password"
            v-model="form.password" placeholder="Password" />
          <InputError :message="form.errors.password" />
        </div>

        <div class="grid gap-2">
          <Label for="password_confirmation">確認密碼</Label>
          <Input id="password_confirmation" type="password" required :tabindex="4" autocomplete="new-password"
            v-model="form.password_confirmation" placeholder="Confirm password" />
          <InputError :message="form.errors.password_confirmation" />
        </div>

        <Button type="submit" class="mt-2 w-full bg-blue-500" tabindex="5" :disabled="form.processing">
          <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin" />
          創建帳號
        </Button>
      </div>

      <div class="text-white text-center text-sm text-muted-foreground">
        已經有帳號了?
        <TextLink :href="route('login')" class="underline underline-offset-4 text-white" :tabindex="6">登入</TextLink>
      </div>
    </form>
  </AuthBase>
</template>
