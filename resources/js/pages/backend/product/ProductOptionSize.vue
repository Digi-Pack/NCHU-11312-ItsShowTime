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
    title: '相關設定-尺寸',
    href: route('admin.productSpec',  { id: 3 }),
  },
];

const props = defineProps({
  response: Array | Object
});

const sortedList = ref((Array.isArray(props.response) ? props.response : []).map(item => ({
  ...item,
  isEditing: false,
})));

const addSize = () => {
  const newSize = {
    id: sortedList.value.length + 1,
    size_name: '',
    isEditing: true,
  };
  sortedList.value.push(newSize);
};

const deleteSize = (index) => {
  sortedList.value.splice(index, 1);
};

const editSizeName = (size) => {
  size.isEditing = false;

  if (size.size.trim() === '') {
    size.hasError = true;
  } else {
    size.hasError = false;
  }
};

const onDragEnd = () => {
};


const submit = () => {
  let hasEmpty = false;
  sortedList.value.forEach((item) => {
    if (!item.size_name || item.size_name.trim() === '') {
      item.hasError = true;
      hasEmpty = true;
    } else {
      item.hasError = false;
    }
  });

  if (hasEmpty) {
    Swal.fire({
      icon: "error",
      title: "請填寫所有尺寸名稱後再儲存",
    });
    return;
  }

  const newItem = sortedList.value.map((item, index) => ({
    id: item.id,
    size_name: item.size_name,
    sort: index + 1,
  }));

  router.put(route('admin.productSpec.update', { id: 3 }), { newItem }, {
    onSuccess: (response) => {
      const result = response?.props?.flash?.message ?? {};
      flashMessage(result, '儲存', route('admin.productSpec',  { id: 3 }));
    },
  });
};

const backBtn = () => router.get(route('admin.product.list'));
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbItems">

    <div class="p-4">
      <Link :href="route('admin.productSpec', { id: 1 })" class="border border-black rounded-sm mr-4 px-4 py-2 hover:bg-slate-300">
        顏色
      </Link>
      <Link :href="route('admin.productSpec', { id: 2 })" class="border border-black rounded-sm mr-4 px-4 py-2 hover:bg-slate-300">
        類型
      </Link>
      <Link :href="route('admin.productSpec', { id: 3 })" class="border border-black rounded-sm mr-4 px-4 py-2 bg-blue-300">
        尺寸
      </Link>

      <div class="py-4">
        <button class="border border-black rounded-sm px-4 py-2 hover:bg-gray-100 my-4" type="button" @click="addSize">
          新增尺寸
        </button>
        <draggable v-model="sortedList" item-key="id" class="flex flex-col gap-4" @end="onDragEnd">
          <template #item="{ element, index }">
            <div class="w-full flex items-center gap-4">
              <div
                class="flex items-center gap-4 w-[500px] bg-gray-100 border border-gray-400 rounded-md p-3 cursor-grab"
                :class="{ 'border-2 border-red-500': element.hasError }">
                <i class="fa-solid fa-bars"></i>
                <div class="flex-grow">
                  <input v-if="element.isEditing" v-model="element.size_name" @blur="editSizeName(element)"
                    @keyup.enter="editSizeName(element)" class="outline-none border-none bg-transparent w-full"
                    placeholder="請輸入尺寸名稱">
                  <span v-else :class="{ 'font-bold text-red-500': element.hasError }"
                    @click="element.isEditing = true">
                    {{ element.size_name || '請輸入尺寸名稱' }}
                  </span>
                </div>
              </div>
              <!-- 刪除該顏色 -->
              <button
                class="w-8 h-8 flex justify-center items-center p-3 bg-gray-200 hover:bg-red-300 rounded-full cursor-pointer"
                type="button" @click="deleteSize(index)">
                <i class="fa-solid fa-minus"></i>
              </button>
            </div>
          </template>
        </draggable>
      </div>

      <div class="w-[500px] flex justify-between mt-8">
        <button class="border border-black px-4 py-2 rounded-sm hover:bg-gray-100" type="button" @click="backBtn">
          取消
        </button>
        <button class="border border-black px-4 py-2 rounded-sm hover:bg-gray-100" type="button" @click="useAlert('確定要儲存嗎?', submit)">
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