<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Link } from '@inertiajs/vue3';
import { BookOpen, Folder, LayoutGrid } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const mainNavItems: NavItem[] = [
  // {
  //   title: 'Dashboard',
  //   href: '/dashboard',
  //   icon: LayoutGrid,
  // },
  {
    title: '橫幅管理',
    href: route('admin.banner.list'),
    icon: LayoutGrid,
  },
  {
    title: '商品管理',
    href: route('admin.product.list'),
    icon: LayoutGrid,
  },
  {
    title: '詢價單管理',
    href: route('admin.inquiry.list'),
    icon: LayoutGrid,
  },
  
];

// const footerNavItems: NavItem[] = [
//   {
//     title: 'Github Repo',
//     href: 'https://github.com/laravel/vue-starter-kit',
//     icon: Folder,
//   },
//   {
//     title: 'Documentation',
//     href: 'https://laravel.com/docs/starter-kits',
//     icon: BookOpen,
//   },
// ];
</script>

<template>
  <Sidebar collapsible="icon" variant="inset">
    <SidebarHeader>
      <SidebarMenu>
        <SidebarMenuItem>
          <SidebarMenuButton size="lg" as-child>
            <Link :href="route('home')">
              <AppLogo />
            </Link>
          </SidebarMenuButton>
        </SidebarMenuItem>
      </SidebarMenu>
    </SidebarHeader>

    <SidebarContent>
      <NavMain :items="mainNavItems" />
    </SidebarContent>

    <SidebarFooter>
      <!-- <NavFooter :items="footerNavItems" /> -->
      <NavUser />
    </SidebarFooter>
  </Sidebar>
  <slot />
</template>

<style>
html, body {
  font-size: 16px;
}
</style>
