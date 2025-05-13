<script setup>
import FrontendFooter from '@/components/FrontendFooter.vue';
import LoadingAnimate from '@/pages/settings/animate.vue';
import ShoppingCart from '@/components/ShoppingCart.vue'
import { phoneRegex, emailRegex, dateRegex } from '@/lib/regex';


import { ref, onMounted, onBeforeUnmount, computed, defineProps, watch } from 'vue'
import { Link, router } from '@inertiajs/vue3'

import { Swiper, SwiperSlide } from 'swiper/vue';
import 'swiper/css';
import 'swiper/css/free-mode';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import 'swiper/css/thumbs';
import { FreeMode, Navigation, Thumbs } from 'swiper/modules';


const isOpen = ref(false)

const toggleMenu = () => {
    isOpen.value = !isOpen.value
    document.body.style.overflow = isOpen.value ? 'hidden' : 'auto'
}

// nav
const menuItems = [
    { id: 'about', name: '品牌理念', href: 'home' },
    { id: 'portfolio', name: '作品集', href: 'home' },
    { id: 'method', name: '製作方式', href: 'home' },
    { id: 'product', name: '商品列表', href: 'home' },
    { id: 'contact', name: '聯絡方式', href: 'home' },
    // { id: 'userlogin', name: '會員登入', href:'userlogin'},
]

const isScrolled = ref(false) // 用來控制是否超過 230px

const handleScroll = () => {
    if (window.scrollY >= 230) {
        isScrolled.value = true
    } else {
        isScrolled.value = false
    }
}

onMounted(() => {
    window.addEventListener('scroll', handleScroll)
})

onBeforeUnmount(() => {
    window.removeEventListener('scroll', handleScroll)
})


// 把下單購買資料傳過來 , color, type
const { response } = defineProps({
    response: Array | Object,
});
// console.log(response);


// 用新的變數來執行程式並加上uid
const selectProducts = ref();
const uidCounter = ref(0);
selectProducts.value = JSON.parse(JSON.stringify(response));
const addUid = () => {
    selectProducts.value.forEach(item => {
        if (item.uid === undefined || item.uid === null) {
            item.uid = uidCounter.value++;
        }
    });
};

addUid();

watch(
    () => selectProducts.value.length,
    (newLen, oldLen) => {
        if (newLen > oldLen) {
            addUid(); // 只在新增時執行
        }
    }
);


// 給子層的相關資料
const getColor = () => {
    return selectProducts.value.map(item => {
        if (!item.colors || item.colors.length === 0) return null;

        return item.colors.map(color => `${color.name}色`);
    });
}

const getType = () => {
    return selectProducts.value.map(item => {
        if (!item.types || item.types.length === 0) return null;

        return item.types.map(type => type.name);
    });
};


const getSize = () => {
    return selectProducts.value.map(item => {
        if (!item.sizes || item.sizes.length === 0) return null;

        return item.sizes.map(size => size.name);
    });
};

// 商品總計
const productCount = computed(() => selectProducts.value.length);


// 選中的選項
const handleColor = ref(null);
const handleStyle = ref(null);
const handleSize = ref(null);
const handleQuantity = ref(1);

// 選擇顏色
const handleColorUpdate = (color) => {
    handleColor.value = color;
};

// 選擇款式
const handleStyleUpdate = (style) => {
    handleStyle.value = style;
};

// 選擇尺寸
const handleSizeUpdate = (size) => {
    handleSize.value = size;
};

// 增減數量
const handleQuantityUpdate = (newQuantity) => {
    handleQuantity.value = newQuantity;
};

// 點擊規格選擇出現選擇商品規格頁面
const isFormatOpen = ref(false);
const currentProductUid = ref(null);
const selectedIndex = ref();

const openModal = (productId) => {
    currentProductUid.value = productId;

    isFormatOpen.value = true;
    // 禁用body頁面滾動條
    if (isFormatOpen.value) {
        document.body.style.overflow = 'hidden';
    } else {
        document.body.style.overflow = 'auto';
    }

}

const hideModal = () => {
    isFormatOpen.value = false;
    document.body.style.overflow = 'auto';
    currentProductUid.value = null;
}

const currentProduct = () => {
    if (!currentProductUid.value) return null;
    return selectProducts.value.find(product => product.uid === currentProductUid.value) || null;
};

// 全部刪除
const clearAllBtn = () => {
    Swal.fire({
        title: "是否清除所有資料，返回首頁？",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "取消",
        confirmButtonText: "確認刪除"
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                position: "center",
                icon: "success",
                title: "確認刪除，回到首頁",
                showConfirmButton: false,
                timer: 1500
            });


            // 清空資料並跳轉回首頁
            selectProducts.value.length = 0;
            setTimeout(() => {
                router.visit(route('home'));
            }, 500);
        }
    });
};

// 刪除個別資料(垃圾桶icon)
const deleteProduct = (productId) => {
    const index = selectProducts.value.findIndex(product => product.uid === productId);
    if (index !== -1) {
        Swal.fire({
            title: "是否清除該商品資料？",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            cancelButtonText: "取消",
            confirmButtonText: "確認刪除"
        }).then((result) => {
            if (result.isConfirmed) {
                selectProducts.value.splice(index, 1);
                updateShoppingCart.value.splice(index, 1);

                // 刪除商品後清空規格選項
                delete selectedSpecs.value[productId];

                Swal.fire({
                    title: "確認刪除",
                    icon: "success"
                });

                if (selectProducts.value.length === 0) {
                    Swal.fire({
                        title: "已刪除所有商品",
                        text: "是否返回首頁？",
                        icon: "info",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "返回首頁",
                        cancelButtonText: "保持當前頁面"
                    }).then((homeResult) => {
                        if (homeResult.isConfirmed) {
                            setTimeout(() => {
                                router.visit(route('home'));
                            }, 500);
                        }
                    });
                }
            }
        });
    }
};

// nav跳轉(未完成)跳轉
const goHome = () => {
    router.push('/home');
};

// 列表當中被點選的欄位資料
const currentItem = computed(() => {
    const uid = currentProductUid.value;
    const item = selectProducts.value.find(item => item.uid === uid);
    return item || null;
});

// 當顏色、風格或尺寸有資料時回傳第一個值(用來)
const getDefaultValue = (arr) => {
    // 如果陣列不為 null 且長度大於 0，返回陣列的第一個值
    if (arr && Array.isArray(arr) && arr.length > 0) {
        return arr[0];  // 回傳第一個選項
    }
    return null;  // 如果為 null 或陣列長度為 0，則不設置預設值
}

// const updateShoppingCart = ref(null);
const updateShoppingCart = ref([]);

// 添加到購物車
const addToCart = () => {
    const id = currentProductUid.value;
    const item = currentItem.value;

    if (!item) {
        console.log('選擇的商品無效');
        return;
    }

    // 如果尚未選擇，套用預設值
    const selectedColor = handleColor.value ?? (getColor()[id] ? getDefaultValue(getColor()[id]) : null);
    const selectedStyle = handleStyle.value ?? (getType()[id] ? getDefaultValue(getType()[id]) : null);
    const selectedSize = handleSize.value ?? (getSize()[id] ? getDefaultValue(getSize()[id]) : null);
    const selectedQuantity = handleQuantity.value || 1;

    const newData = {
        uid: item.uid,
        id: item.id,
        product: item.name,
        color: selectedColor,
        style: selectedStyle,
        size: selectedSize,
        quantity: selectedQuantity
    };

    // updateShoppingCart.value.push(newData);


    // 檢查是否已經存在相同 id 的商品
    const existingIndex = updateShoppingCart.value.findIndex(
        (product) => product.uid === item.uid
    );

    if (existingIndex !== -1) {
        // 覆蓋已存在的項目（根據 uid）
        updateShoppingCart.value[existingIndex] = newData;
    } else {
        // 新增
        updateShoppingCart.value.push(newData);
    }

    console.log(updateShoppingCart.value);

    // 儲存選擇的規格到 selectedSpecs
    selectedSpecs.value[item.uid] = {
        color: selectedColor,
        style: selectedStyle,
        size: selectedSize,
        quantity: selectedQuantity
    };

    // 重設選項
    handleColor.value = getDefaultValue(getColor()[0]);
    handleStyle.value = getDefaultValue(getType()[0]);
    handleSize.value = getDefaultValue(getSize()[0]);
    handleQuantity.value = 1;

    Swal.fire({
        icon: "success",
        title: "已加入規格！",
        showConfirmButton: false,
        timer: 1500
    });

    hideModal();
};

// 用來存取當前點擊的該筆資料當中規格選擇的結果
const selectedSpecs = ref({});

const getSelectSpecs = (productId) => {
    const spec = selectedSpecs.value[productId];
    if (spec) {
        // return `${spec.color} / ${spec.style}`;
        return {
            color: spec.color ?? '',
            style: spec.style ?? '',
            size: spec.size ?? '',
            quantity: spec.quantity,
        }
    }
    return {
        color: '',
        style: '',
        size: '',
        quantity: 1,  // 預設數量
    };
};

// 在模板中使用的動態格式化函數
const formatSpecs = (productId) => {
    const specs = getSelectSpecs(productId);
    const parts = [];

    if (specs.color) parts.push(specs.color);
    if (specs.style) parts.push(specs.style);
    if (specs.size) parts.push(specs.size);

    const specText = parts.join(' / ');
    return specText ? `${specText} / ${specs.quantity}件` : `${specs.quantity}件`;
};

// 取得數量
const getQuantity = (productId) => {
    return selectedSpecs.value[productId]?.quantity ?? handleQuantity.value;
};

// 送出詢價單篩選(這裡要記得加上規格要選完才能送出)

const username = ref('');
const phone = ref('');
const email = ref('');
const address = ref('');
const remark = ref('');
const products = ref([]);

const handleSubmit = () => {
    console.log(selectProducts.value);

    if (username.value === "") {
        Swal.fire("姓名欄位必填！請填寫您的姓名");
        return;
    }

    if (phone.value === "") {
        Swal.fire("您尚未填寫您的聯絡電話");
        return;
    }
    if (!phoneRegex.test(phone.value)) {
        Swal.fire("聯絡電話格式不正確！請填寫有效的電話號碼");
        return;
    }

    if (email.value === "") {
        Swal.fire("您尚未填寫您的電子信箱");
        return;
    }
    if (!emailRegex.test(email.value)) {
        Swal.fire("電子信箱格式不正確！請填寫有效的電子郵件地址");
        return;
    }

    if (!birthday.value) {
        Swal.fire("生日欄位必填！請填寫您的生日");
        return;
    }
    if (!dateRegex.test(birthday.value)) {
        Swal.fire("生日格式不正確！請填寫有效的日期（YYYY-MM-DD）");
        return;
    }

    const item = ref({
        username: username.value,
        phone: phone.value,
        email: email.value,
        address: address.value,
        remark: remark.value,
        products: updateShoppingCart.value,
    });

    router.post(route('admin.inquiry.store'), item.value, {
        onSuccess: (response) => {
            const result = response?.props?.flash?.message ?? {};
            if (result.res === 'success') {
                Swal.fire({
                    icon: "success",
                    title: result.msg,
                    showConfirmButton: false,
                    timer: 1000,
                }).then(() => {
                    router.get(route('home'));
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: result.msg,
                });
            };
        },
    });

    // 這段目前怎麼樣都會顯示成功，需再補充和後台確認才顯示成功的功能
    // Swal.fire({
    //     title: "詢價單已成功送出！",
    //     icon: "success",
    //     draggable: true
    // });
};


// 日期選擇器
const triggerDatePicker = () => {
    const dateInput = document.getElementById('birthday');
    if (dateInput.showPicker) {
        dateInput.showPicker();
    }
};

// 新增同商品但不同尺寸可以做選擇
const addProductItem = (id, index) => {
    const product = selectProducts.value[index];

    if (!product || product.id !== id) {
        console.warn(`找不到對應 index=${index} 的產品`);
        return;
    }

    // const newProduct = { ...product };
    const newProduct = JSON.parse(JSON.stringify(product));

    const insertedIndex = insertProductByNameGroup(selectProducts.value, newProduct);
    // 只給新資料一個新的 uid
    selectProducts.value[insertedIndex].uid = uidCounter.value++;

    // 取得新加的那筆資料的 uid（用 index 方式重新加 uid，所以是這筆插入的位置）
    currentProductUid.value = selectProducts.value[insertedIndex].uid;
    selectedIndex.value = index;

};

// 將相同名稱的產品群組化，而不是添加在陣列的最後一筆位置
const insertProductByNameGroup = (arr, newItem) => {
    // 找出陣列中最後一個相同 name 的索引
    const index = [...arr].reverse().findIndex(item => item.name === newItem.name);

    // 如果沒有相同 name，就直接 push
    if (index === -1) {
        arr.push(newItem);
        return arr.length - 1;
    } else {
        const insertIndex = arr.length - index;
        arr.splice(insertIndex, 0, newItem); // 插入到對應位置
        return insertIndex;
    }
};

// 檢查當前商品名稱是否為該名稱的最後一筆(判斷只有相同名稱的最後一筆才有新增的按鈕)
const isLastProductName = (product, index) => {
    // 找到所有與當前商品名稱相同的商品
    const sameNameProducts = selectProducts.value.filter(p => p.name === product.name);

    return sameNameProducts.indexOf(product) === sameNameProducts.length - 1;
}

// 跳轉頁面loading
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
        <div class="flex flex-col items-center w-full bg-[#1F1B1B]">

            <!-- NavBar -->
            <nav :class="[
                'w-full flex min-[476px]:justify-center py-6 text-nowrap',
                isScrolled ? 'fixed top-0 left-0 bg-stone-50 font-bold z-20' : ''
            ]">
                <div class="2xl:block flex">
                    <p
                        class="font-noto-jp text-[#F0BD22] 2xl:text-[30px] md:text-[20px] min-[476px]:text-[14px] min-[374px]:text-[12px] sm:tracking-[0.06em] mb-2 min-[476px]:pl-0 pl-3">
                        itsshowtime．無敵の特攻服オーダーメイドブランド
                    </p>

                    <!-- NavBar 1600px以下 -->
                    <nav class="min-[1680px]:hidden fixed top-0 left-0 w-full z-20 font-noto-jp">
                        <!-- Ham Btn -->
                        <button type="button"
                            class="w-9 h-9 flex justify-center items-center cursor-pointer p-6 fixed min-[476px]:top-4 top-2 right-4 z-20"
                            @click="toggleMenu">
                            <i class="fa-solid fa-bars text-3xl" style="color:#F0BD22"></i>
                        </button>

                        <div :class="[
                            'fixed left-0 top-0 w-full h-[380px] bg-slate-100 z-10',
                            'flex flex-col justify-center gap-6 p-8 overflow-y-auto',
                            isOpen ? 'flex' : 'hidden'
                        ]">
                            <Link :href="route(item.href)" v-for="item in menuItems" :key="item.id" @click="toggleMenu"
                                class="flex items-center gap-[9px] text-xl ">
                            <img src="/image/svg/Arrow 2.svg" alt="" />
                            <p class="font-normal leading-[1.2] text-[#1f1b1b]">{{ item.name }}</p>
                            </Link>
                        </div>
                    </nav>
                </div>
            </nav>


            <!-- NavBar 1680px以上 -->
            <nav class="hidden min-[1680px]:flex flex-col fixed top-64 2xl:left-16 z-10 font-noto-cjk text-white">
                <div class="w-[80px] mb-4">
                    <img src="/image/LOGO-底部有字.webp" class="w-full h-full object-cover">
                </div>
                <img src="/image/svg/Menu.svg" class="w-full h-full object-cover mb-4">
                <div class="gap-6">
                    <Link :href="route('home')" v-for="item in menuItems" :key="item.id"
                        class="flex items-center gap-[9px]" @click="goHome">
                    <p class="font-normal leading-[1.8]">{{ item.name }}</p>
                    <img src="/image/svg/Arrow.svg" alt="">
                    </Link>
                </div>
            </nav>


            <!-- Banner -->
            <div class="2xl:w-[821.46px] md:w-[45%] w-[80%] mb-12">
                <img src="/image/ITS SHOW TIME.webp" class="w-full h-full object-cover">
            </div>
            <p
                class="2xl:w-[493px] font-noto-jp font-bold 2xl:text-[32px] sm:text-[20px] text-center text-[#F0BD22] border-[#F0BD22] border-[3px] rounded-[4px] py-3 px-5 tracking-[-0.08em] text-nowrap">
                天下無敵、台湾特攻服の第一品牌</p>
            <p class="text-white font-noto-jp 2xl:text-[36px] sm:text-[20px] tracking-[-0.08em] py-4 mb-28">詢價清單列表</p>



            <!-- 詢價清單列表 -->
            <div class="2xl:w-[1320px] w-[70%] flex items-end mb-6 2xl:px-0 xl:px-1">
                <p
                    class="2xl:flex-1 2xl:w-0 w-[400px] font-noto-jp font-bold sm:text-[24px] text-[18px] text-[#F0BD22] 2xl:mr-0 xl:mr-4">
                    商品名稱
                </p>
                <p
                    class="xl:w-[240px] w-[180px] font-noto-jp font-bold min-[956px]:text-[24px] text-[0px] text-[#F0BD22]">
                    規格
                </p>
                <p
                    class="xl:w-[160px] w-[100px] font-noto-jp font-bold min-[956px]:text-[24px] text-[0px] text-[#F0BD22]">
                    金額
                </p>
                <button type="button"
                    class="xl:w-[141px] font-noto-jp font-bold xl:text-[24px] text-center text-[#F0BD22] border-[#F0BD22] border-[3px] rounded-[2px] py-4 px-4 cursor-pointer text-nowrap"
                    @click="clearAllBtn">
                    全部刪除
                </button>
            </div>


            <!-- min-[956px]以上的選擇規格商品圖 -->
            <div
                class="flex-col 2xl:w-[1399px] w-[70%] border-y-2 border-[#F0BD22] text-center 2xl:font-bold font-noto-jp mb-12">
                <div v-for="(product, index) in selectProducts" :key="index"
                    v-if="selectProducts && selectProducts.length > 0"
                    class="min-[956px]:w-full min-[956px]:flex hidden items-center my-10">
                    <button v-if="isLastProductName(product, index)" type="button" class="text-white rounded-full" @click="addProductItem(product.id, index)">
                        <img class="size-8 rounded-full hover:bg-slate-300" src="/image/svg/plus.svg" alt="">
                    </button>
                    <div v-else class="size-8"></div>
                    <div class="flex 2xl:flex-1 items-center ml-4">
                        <div class="2xl:w-[125.07px] w-[65px] 2xl:mr-8 mr-4">
                            <img class="rounded-tl-md rounded-tr-md" :src="product.first_img.img_path"
                                alt="Product Image">
                        </div>
                        <p class="2xl:w-[394px] lg:w-[200px] md:w-[160px] 2xl:text-[20px] text-white text-left">
                            {{ product.name }}
                        </p>
                    </div>

                    <div v-if="!selectedSpecs[product.uid]" class="xl:w-[300px] w-[240px] flex justify-center">
                        <button type="button"
                            class="xl:w-[146px] w-[86px] xl:text-[24px] text-white border-white border-[3px] rounded-[5px] p-2 cursor-pointer"
                            @click="openModal(product.uid)">
                            規格選擇
                        </button>
                    </div>

                    <!-- 顯示選好的規格 -->
                    <div v-else
                        class="xl:w-[300px] w-[240px] flex justify-center items-center text-white xl:text-[20px] gap-6">
                        {{ formatSpecs(product.uid) }}
                        <button v-show="selectedSpecs[product.uid]" type="button"
                            class="flex justify-end cursor-pointer z-10" @click="openModal(product.uid)">
                            <img class="xl:w-[28px] w-[20px]" src="/image/svg/edit.svg" alt="">
                        </button>
                    </div>


                    <p class="xl:w-[200px] w-[140px] flex justify-center xl:text-[24px] text-white">
                        金額待確認
                    </p>

                    <!-- 編輯和刪除按鈕 -->
                    <div class="flex justify-around xl:w-[200px] w-[120px]">
                        <button type="button" class="flex justify-center xl:mr-2 cursor-pointer"
                            @click="deleteProduct(product.uid)">
                            <img class="xl:w-[33px] w-[25px]" src="/image/svg/trash.svg" alt="">
                        </button>
                    </div>
                </div>


                <!-- min-[956px]以下才出現的選擇規格商品圖 -->
                <div class="flex flex-wrap">
                    <div v-for="(product, index) in selectProducts" :key="product.uid"
                        class="min-[956px]:hidden md:w-[30%] flex flex-col gap-2 rounded-tl-2xl rounded-tr-2xl my-8 p-1 group relative overflow-hidden ml-4">
                        <img class="rounded-tl-2xl rounded-tr-2xl w-full" :src="product.first_img.img_path"
                            alt="Product Image">

                        <div class="flex flex-col gap-2 px-2 pb-4 md:h-[100px] text-white ">
                            <p class="text-left font-noto-jp leading-[1.2]">
                                {{ product.name }}
                            </p>
                            <p v-show="selectedSpecs[product.uid]">
                                {{ formatSpecs(product.uid) }}
                            </p>
                        </div>
                        <div
                            class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center z-10 pb-16">
                            <button v-show="!selectedSpecs[product.uid]"
                                class="border-[#F0BD22] border-2 text-[#F0BD22] px-6 py-2 rounded-md"
                                @click="openModal(product.uid)">
                                規格
                            </button>
                        </div>
                        <div class="flex justify-center gap-4">
                            <button v-if="isLastProductName(product, index)" type="button" class="text-white rounded-full z-10"
                                @click="addProductItem(product.id, index)">
                                <img class="size-8 rounded-full hover:bg-slate-300" src="/image/svg/plus.svg" alt="">
                            </button>
                            <button v-show="selectedSpecs[product.uid]" type="button"
                                class="flex justify-end cursor-pointer z-10" @click="openModal(product.uid)">
                                <img class="xl:w-[33px] w-[25px]" src="/image/svg/edit.svg" alt="">
                            </button>
                            <button type="button" class="flex justify-end cursor-pointer z-10"
                                @click="deleteProduct(product.uid)">
                                <img class="xl:w-[33px] w-[25px]" src="/image/svg/trash.svg" alt="">
                            </button>
                        </div>
                    </div>
                </div>

            </div>


            <!-- 商品項目計數 -->
            <div class="2xl:w-[1399px] w-[70%] flex-col flex items-end mb-60">
                <p class="2xl:text-[24px] text-white mb-2">總計 {{ productCount }} 款商品</p>
                <p class="2xl:text-[24px] text-white">總金額待訂單確認後提供</p>
            </div>

            <!-- 選擇商品規格 -->
            <div v-if="isFormatOpen && currentItem"
                class="w-full h-dvh fixed bg-black/50 inset-0 z-50  py-12 flex justify-center items-center"
                @click="hideModal">
                <ShoppingCart :hideModal='hideModal' :item="currentItem"
                    :selectedSpec="selectedSpecs[currentProductUid]" @updateColor="handleColorUpdate"
                    @updateStyle="handleStyleUpdate" @updateSize="handleSizeUpdate"
                    @updateQuantity="handleQuantityUpdate" @addToCart="addToCart" />
            </div>


            <!-- 詢價資料表 -->
            <div class="2xl:w-[991px] sm:w-[60%] min-[376px]:w-[80%] w-[90%] flex justify-start 2xl:mb-10 mb-4">
                <p class="text-white font-noto-jp 2xl:text-[36px] text-[20px] tracking-[-0.08em] 2xl:ml-10">詢價資料填寫</p>
            </div>

            <div
                class="2xl:w-[991px] sm:w-[60%] min-[376px]:w-[80%] w-[90%] flex flex-col 2xl:items-center border-t-2 border-white font-noto-jp mb-20 py-8 text-white">
                <div class="md:flex">

                    <div class="2xl:w-[410px] flex flex-1 flex-col 2xl:mr-6 md:mr-4 mb-10">
                        <label for="username" class="text-white font-noto-jp 2xl:text-[28px] tracking-[0.02em] mb-4">
                            姓名 | Name
                        </label>
                        <input id="username" v-model="username" type="text" required
                            class="bg-transparent border-[1px] border-white rounded-[8px] px-4 py-3 placeholder:text-[20px] placeholder:text-white/50"
                            placeholder="廖小笙" />
                    </div>

                    <div class="2xl:w-[456px] md:w-[50%] flex flex-col mb-10">
                        <label for="birthday" class="text-white font-noto-jp 2xl:text-[28px] tracking-[0.02em] mb-4">
                            出生年月日 | Birthday
                        </label>

                        <div class="relative">
                            <input id="birthday" type="date" required
                                class="w-full h-[50px] bg-transparent border border-white rounded-[8px] px-3 py-3 pr-12 text-[20px] text-white/50 custom-date"
                                placeholder="年/月/日" />

                            <div class="absolute right-4 top-1/2 transform -translate-y-1/2 cursor-pointer">
                                <img src="/image/svg/calendar.svg" alt="calendar icon" class="w-[24px] h-[24px]"
                                    @click="triggerDatePicker" />
                            </div>
                        </div>
                    </div>
                </div>


                <div class="flex flex-col mb-10">
                    <label for="phone" class="text-white font-noto-jp 2xl:text-[28px] tracking-[0.02em] mb-4">
                        聯絡電話 | Phone
                    </label>
                    <input id="phone" v-model="phone" type="text" required
                        class="2xl:w-[895px] bg-transparent border border-white rounded-[8px] px-4 py-3 placeholder:text-[20px] placeholder:text-white/50"
                        placeholder="0912345678" />
                </div>

                <div class="flex flex-col mb-10">
                    <label for="email" class="text-white font-noto-jp 2xl:text-[28px] tracking-[0.02em] mb-4">
                        電子信箱｜Email
                    </label>
                    <input id="email" v-model="email" type="text" required
                        class="2xl:w-[895px] bg-transparent border border-white rounded-[8px] px-4 py-3 placeholder:text-[20px] placeholder:text-white/50"
                        placeholder="Las123@gmail.com" />
                </div>

                <div class="flex flex-col mb-10">
                    <label for="address" class="text-white font-noto-jp 2xl:text-[28px] tracking-[0.02em] mb-4">
                        聯絡地址 | Address ( 選填 )
                    </label>
                    <input v-model="address" id="address" type="text"
                        class="2xl:w-[895px] bg-transparent border border-white rounded-[8px] px-4 py-3 placeholder:text-[20px] placeholder:text-white/50"
                        placeholder="南投市環山路112號">
                </div>

                <div class="flex flex-col mb-10">
                    <label for="remark" class="text-white font-noto-jp 2xl:text-[28px] tracking-[0.02em] mb-4">
                        備註 | Remark ( 選填 )
                    </label>
                    <textarea v-model="remark" id="remark"
                        class="resize-none 2xl:w-[895px] w-full h-[220px] bg-transparent border border-white rounded-[8px] px-4 py-3 placeholder:text-[20px] "></textarea>
                </div>

            </div>

            <button @click="handleSubmit"
                class="font-noto-jp font-bold md:text-[24px] text-[18px] text-center text-[#F0BD22] border-[#F0BD22] border-[3px] rounded-[5px] px-12 py-4 cursor-pointer mb-36">
                送出詢價單
            </button>
        </div>
        <FrontendFooter />
    </section>
</template>

<style>
html,
body {
    font-size: 16px;
}

::-webkit-scrollbar {
    width: 17px;
    height: 14px;
    background-color: #000;
}

/* 滾動條軌道 */
::-webkit-scrollbar-track {
    background: #111;
    border: 2px solid #333;
    box-shadow: inset 0 0 5px rgba(255, 0, 0, 0.2);
}

/* 自訂 scrollbar 方塊樣式 */
::-webkit-scrollbar-thumb {
    background: #fff7e0;
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
    background-color: #000;
}


/* 確保垂直輪播正常工作 */
.swiper-slide {
    height: auto;
}

.swiper-slide img {
    height: 100%;
    object-fit: cover;
}


/* 日曆顯示 */
.custom-date::-webkit-calendar-picker-indicator {
    opacity: 0;
    position: absolute;
    right: 0;
    width: 100%;
    height: 100%;
    cursor: pointer;
}
</style>
