<script setup>

</script>

<template>

  <Head title="Welcome">
    <link rel="preconnect" href="https://rsms.me/" />
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
  </Head>
  <div class="flex">
    <Link v-if="$page.props.auth.user" :href="route('dashboard')"
      class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a]">
    Dashboard
    </Link>
    <template v-else>
      <Link :href="route('login')"
        class="inline-block rounded-sm border border-transparent px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#19140035]">
      Log in
      </Link>
      <Link :href="route('register')"
        class="inline-block rounded-sm border border-[#19140035] px-5 py-1.5 text-sm leading-normal text-[#1b1b18] hover:border-[#1915014a]">
      Register
      </Link>
    </template>
  </div>
</template>
