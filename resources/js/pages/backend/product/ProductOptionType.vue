<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { useAlert } from '@/lib/useAlert';
import { flashMessage } from '@/lib/flashMessage';
import draggable from 'vuedraggable';

const breadcrumbItems = [
  {
    title: '商品管理',
    href: route('admin.product.list'),
  },
  {
    title: '相關設定-類型',
    href: route('admin.productSpec',  { id: 2 }),
  },
];

const props = defineProps({
  response: Array | Object
});

const sortedList = ref((Array.isArray(props.response) ? props.response : []).map(item => ({
  ...item,
  isEditing: false,
})));

const addType = () => {
  const newType = {
    id: sortedList.value.length + 1,
    type_name: '',
    isEditing: true,
  };
  sortedList.value.push(newType);
};

const deleteType = (index) => {
  sortedList.value.splice(index, 1);
};

const editTypeName = (type) => {
  type.isEditing = false;

  if (type.type_name.trim() === '') {
    type.hasError = true;
  } else {
    type.hasError = false;
  }
};

const onDragEnd = () => {

};


const submit = () => {
  let hasEmpty = false;
  sortedList.value.forEach((item) => {
    if (!item.type_name || item.type_name.trim() === '') {
      item.hasError = true;
      hasEmpty = true;
    } else {
      item.hasError = false;
    }
  });

  if (hasEmpty) {
    Swal.fire({
      icon: "error",
      title: "請填寫所有類型名稱後再儲存",
    });
    return;
  }

  const newItem = sortedList.value.map((item, index) => ({
    id: item.id,
    type_name: item.type_name,
    sort: index + 1,
  }));

  router.put(route('admin.productSpec.update', { id: 2 }), { newItem }, {
    onSuccess: (response) => {
      const result = response?.props?.flash?.message ?? {};
      flashMessage(result, '儲存', route('admin.productSpec',  { id: 2 }));
    },
  });
};

const backBtn = () => router.get(route('admin.product.list'));
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbItems">

    <div class="p-4">
      <Link :href="route('admin.productSpec', { id: 1 })" class="border border-black dark:border-gray-700 rounded-sm mr-4 px-4 py-2 hover:bg-slate-300 dark:hover:bg-slate-700">
        顏色
      </Link>
      <Link :href="route('admin.productSpec', { id: 2 })" class="border border-black dark:border-gray-700 rounded-sm mr-4 px-4 py-2 bg-blue-300 dark:bg-blue-950">
        類型
      </Link>
      <Link :href="route('admin.productSpec', { id: 3 })" class="border border-black dark:border-gray-700 rounded-sm mr-4 px-4 py-2 hover:bg-slate-300 dark:hover:bg-slate-700">
        尺寸
      </Link>

      <div class="py-4">
        <button class="border border-black dark:border-gray-700 rounded-sm px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 my-4" type="button" @click="addType">
          新增類型
        </button>
        <draggable v-model="sortedList" item-key="id" class="flex flex-col gap-4" @end="onDragEnd">
          <template #item="{ element, index }">
            <div class="w-full flex items-center gap-4">
              <div
                class="flex items-center gap-4 w-[500px] bg-gray-100 dark:bg-black border border-gray-400 rounded-md p-3 cursor-grab"
                :class="{ 'border-2 border-red-500': element.hasError }">
                <i class="fa-solid fa-bars"></i>
                <div class="flex-grow">
                  <input v-if="element.isEditing" v-model="element.type_name" @blur="editTypeName(element)"
                    @keyup.enter="editTypeName(element)" class="outline-none border-none bg-transparent w-full"
                    placeholder="請輸入類型名稱">
                  <span v-else :class="{ 'font-bold text-red-500': element.hasError }"
                    @click="element.isEditing = true">
                    {{ element.type_name || '請輸入類型名稱' }}
                  </span>
                </div>
              </div>
              <!-- 刪除該顏色 -->
              <button
                class="w-8 h-8 flex justify-center items-center p-3 bg-gray-200 dark:bg-gray-600 hover:bg-red-300 dark:hover:bg-red-400 rounded-full cursor-pointer"
                type="button" @click="deleteType(index)">
                <i class="fa-solid fa-minus"></i>
              </button>
            </div>
          </template>
        </draggable>
      </div>

      <div class="w-[500px] flex justify-between mt-8">
        <button class="border border-black dark:border-gray-700 px-4 py-2 rounded-sm hover:bg-gray-100 dark:hover:bg-gray-700" type="button" @click="backBtn">
          取消
        </button>
        <button class="border border-black dark:border-gray-700 px-4 py-2 rounded-sm hover:bg-gray-100 dark:hover:bg-gray-700" type="button" @click="useAlert('確定要儲存嗎?', submit)">
          儲存
        </button>
      </div>
    </div>
  </AppLayout>
</template>

<style>
html,
body {
  font-size: 16px;
  margin: 0;
  padding: 0;
}
</style>