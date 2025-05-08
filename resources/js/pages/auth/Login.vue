<script setup lang="ts">
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';



defineProps<{
  status?: string;
  canResetPassword: boolean;
}>();

const form = useForm({
  email: '',
  password: '',
  remember: false,
});

const submit = () => {
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
  });
};
</script>


<template>
  <!-- <Head title="Welcome">
    <link rel="preconnect" href="https://rsms.me/" />
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
  </Head> -->

  <div class="flex fixed z-40 top-12 right-16">
    <!-- <Link v-if="$page.props.auth.user" :href="route('dashboard')"
      class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a] dark:border-[#3E3E3A] dark:text-[#EDEDEC] dark:hover:border-[#62605b]">
    Dashboard
    </Link> -->
    <Link :href="route('login')"
      class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-xl leading-normal text-white hover:border-white dark:text-[#EDEDEC] dark:hover:border-white mr-2">
    登入
    </Link>
    <Link :href="route('register')"
      class="inline-block rounded-sm border border-white px-5 py-1.5 text-xl leading-normal text-white hover:border-white dark:border-white dark:text-[#EDEDEC] dark:hover:border-white">
    註冊
    </Link>
  </div>


  <AuthBase title="會員登入" class="bg-cover h-screen text-white font-bold"
    :style="{ backgroundImage: 'url(/image/login-background.webp)' }">

    <Head title="Log in" />

    <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
      {{ status }}
    </div>

    <form @submit.prevent="submit" class="flex flex-col gap-6">
      <div class="grid gap-6">
        <div class="grid gap-2">
          <Label for="email">帳號</Label>
          <Input id="email" type="email" required autofocus :tabindex="1" autocomplete="email" v-model="form.email"
            placeholder="email@example.com" />
          <InputError :message="form.errors.email" />
        </div>

        <div class="grid gap-2">
          <div class="flex items-center justify-between">
            <Label for="password">密碼</Label>
            <TextLink v-if="canResetPassword" :href="route('password.request')" class="text-sm text-white"
              :tabindex="5"> 忘記密碼? </TextLink>
          </div>
          <Input id="password" type="password" required :tabindex="2" autocomplete="current-password"
            v-model="form.password" placeholder="Password" class="text-black bg-white" />
          <InputError :message="form.errors.password" />
        </div>


        <div class="flex items-center justify-between" :tabindex="3">
          <Label for="remember" class="flex items-center space-x-3">
            <Checkbox id="remember" v-model:checked="form.remember" :tabindex="4" />
            <span>記住我</span>
          </Label>
        </div>

        <Button type="submit" class="mt-4 w-full bg-blue-500" :tabindex="4" :disabled="form.processing">
          <LoaderCircle v-if="form.processing" class="h-4 w-4 animate-spin " />
          登入
        </Button>
      </div>

      <div class="text-center text-sm text-muted-foreground text-white">
        沒有帳號?
        <TextLink :href="route('register')" :tabindex="5" class="text-white">註冊</TextLink>
      </div>
    </form>

  </AuthBase>
</template>
