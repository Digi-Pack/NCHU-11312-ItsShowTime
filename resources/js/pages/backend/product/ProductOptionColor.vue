<script setup>
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { useAlert } from '@/lib/useAlert';
import { flashMessage } from '@/lib/flashMessage';
import draggable from 'vuedraggable';

const props = defineProps({
  response: Array | Object
});

const sortedList = ref((Array.isArray(props.response) ? props.response : []).map(item => ({
  ...item,
  isEditing: false,
})));

const addColor = () => {
  const newColor = {
    id: sortedList.value.length + 1,
    color_name: '',
    isEditing: true,
  };
  sortedList.value.push(newColor);
};

const deleteColor = (index) => {
  sortedList.value.splice(index, 1);
};

const editColorName = (color) => {
  color.isEditing = false;

  if (color.color_name.trim() === '') {
    color.hasError = true;
  } else {
    color.hasError = false;
  }
};

const onDragEnd = () => {
  console.log(sortedList.value);

};


const submit = () => {
  let hasEmpty = false;
  sortedList.value.forEach((item) => {
    if (!item.color_name || item.color_name.trim() === '') {
      item.hasError = true;
      hasEmpty = true;
    } else {
      item.hasError = false;
    }
  });

  if (hasEmpty) {
    Swal.fire({
      icon: "error",
      title: "請填寫所有顏色名稱後再儲存",
    });
    return;
  }

  const newItem = sortedList.value.map((item, index) => ({
    id: item.id,
    color_name: item.color_name,
    sort: index + 1,
  }));

  router.put(route('admin.productSpec.update', { id: 1 }), { newItem }, {
    onSuccess: (response) => {
      const result = response?.props?.flash?.message ?? {};
      flashMessage(result, '儲存', route('admin.product.list'));
    },
  });
};

const backBtn = () => router.get(route('admin.product.list'));
</script>

<template>
  <AppLayout>
    <div class="p-4">
      <Link :href="route('admin.productSpec', { id: 1 })"
        class="border border-black rounded-sm mr-4 px-4 py-2 bg-blue-300">
      顏色
      </Link>
      <Link :href="route('admin.productSpec', { id: 2 })"
        class="border border-black rounded-sm mr-4 px-4 py-2 hover:bg-slate-300">
      類型
      </Link>
      <Link :href="route('admin.productSpec', { id: 3 })"
        class="border border-black rounded-sm mr-4 px-4 py-2 hover:bg-slate-300">
      尺寸
      </Link>

      <div class="py-4">
        <button class="border border-black rounded-sm px-4 py-2 hover:bg-gray-100 my-4" type="button" @click="addColor">
          新增顏色
        </button>
        <draggable v-model="sortedList" item-key="id" class="flex flex-col gap-4" @end="onDragEnd">
          <template #item="{ element, index }">
            <div class="w-full flex items-center gap-4">
              <div
                class="flex items-center gap-4 w-[500px] bg-gray-100 border border-gray-400 rounded-md p-3 cursor-grab"
                :class="{ 'border-2 border-red-500': element.hasError }">
                <i class="fa-solid fa-bars"></i>
                <div class="flex-grow">
                  <input v-if="element.isEditing" v-model="element.color_name" @blur="editColorName(element)"
                    @keyup.enter="editColorName(element)" class="outline-none border-none bg-transparent w-full"
                    placeholder="請輸入顏色名稱">
                  <span v-else :class="{ 'font-bold text-red-500': element.hasError }"
                    @click="element.isEditing = true">
                    {{ element.color_name || '請輸入顏色名稱' }}
                  </span>
                </div>
              </div>
              <!-- 刪除該顏色 -->
              <button
                class="w-8 h-8 flex justify-center items-center p-3 bg-gray-200 hover:bg-red-300 rounded-full cursor-pointer"
                type="button" @click="deleteColor(index)">
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
        <button class="border border-black px-4 py-2 rounded-sm hover:bg-gray-100" type="button"
          @click="useAlert('確定要儲存嗎?', submit)">
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