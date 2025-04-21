<script setup>
// import logo from "p/image/LOGO-方.png";
</script>

<template>
  <nav class="max-w-[1903px] mx-auto">
    <!-- 紅色品牌名稱 -->
    <div class="fixed top-0 left-0 w-full z-10">
      <div class="max-w-[1903px] h-[40px] bg-[#B41900] mx-auto flex justify-center items-center text-white">
        <p class="font-noto-cjk text-sm font-normal leading-[1.2]">
          台湾無敵の特工服オーダーメイドブランド
        </p>
      </div>
    </div>
    <div class="w-full mt-[40px] h-[230px] bg-white relative min-[577px]:h-[300px]">
      <!-- h-[334px] top-[69px] -->
      <div class="w-full absolute flex flex-col justify-center min-[577px]:flex-row min-[577px]:top-[40px]">
        <!-- 左：logo absolute top-[-29px] -->
        <div class="w-full min-[577px]:w-[50%] relative mb-[10px] lg:pl-[100px] xl:pl-[100px]">
          <div class="relative w-full h-[93px] px-[21px] pt-7 xl:w-[724px] xl:h-[132.84px] 2xl:w-[1041px] 2xl:h-[191px]">
            <img class="absolute top-[32px] left-[20px] 2xl:top-[0.5px] 2xl:left-[82px] w-[52.71px] lg:w-[70px] xl:w-[107.81px] 2xl:w-[155.01px] " src="/image/LOGO-方.png" alt="logo">
            <p
              class="w-[152px] h-[8px] text-[11px] lg:w-[309px] lg:h-[16px] lg:text-[22.26px] 2xl:w-[445px] 2xl:h-[23px] 2xl:text-[32px] font-noto-jp text-[#444444] font-black leading-[1.2] tracking-[-0.08em] absolute top-[30px] left-[80px] lg:left-[100px] xl:left-[140px] xl:top-[40px] 2xl:left-[240px] 2xl:top-[10px]">
              天下無敵、台湾特工服の第一品牌
            </p>
            <p
              class="w-[264px] h-[36px] text-[47.61px] lg:w-[540px] lg:text-[97.37px] 2xl:w-[776px] 2xl:h-[107px] 2xl:text-[140px] font-freckle text-[#444444] font-normal leading-[1] tracking-[-0.08em] absolute bottom-[10px] left-[80px] lg:left-[100px] xl:left-[140px] xl:bottom-[30px] 2xl:left-[240px] 2xl:bottom-[50px]">
              ITS SHOW TIME
            </p>
          </div>
        </div>
        <!-- 右：menu absolute top-[-29px] -->
        <div class="w-full h-auto pl-4 relative font-noto-cjk justify-center text-[#000000] min-[577px]:flex min-[577px]:w-[50%]">
          <div class=" flex flex-col gap-3">
            <div class="flex items-center gap-[5px]">
              <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 0V12H0L12 0Z" fill="#4B402A" />
              </svg>
              <p class="font-noto font-normal leading-[1.2]">Menu</p>
            </div>
            <div class="flex flex-wrap gap-3 pl-4 min-[577px]:flex-col">
              <div class="flex items-center gap-[9px]">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M1.18841e-05 12.657C1.2137e-05 13.2093 0.447727 13.657 1.00001 13.657L10 13.657C10.5523 13.657 11 13.2093 11 12.657C11 12.1047 10.5523 11.657 10 11.657L2.00001 11.657L2.00001 3.65697C2.00001 3.10469 1.5523 2.65697 1.00001 2.65697C0.447728 2.65697 1.23477e-05 3.10469 1.26849e-05 3.65697L1.18841e-05 12.657ZM11.6066 0.636155L0.292906 11.9499L1.70712 13.3641L13.0208 2.05037L11.6066 0.636155Z"
                    fill="#4B402A" />
                </svg>
                <p class="font-normal leading-[1.2]">作品集</p>
              </div>
              <div class="flex items-center gap-[9px]">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M1.18841e-05 12.657C1.2137e-05 13.2093 0.447727 13.657 1.00001 13.657L10 13.657C10.5523 13.657 11 13.2093 11 12.657C11 12.1047 10.5523 11.657 10 11.657L2.00001 11.657L2.00001 3.65697C2.00001 3.10469 1.5523 2.65697 1.00001 2.65697C0.447728 2.65697 1.23477e-05 3.10469 1.26849e-05 3.65697L1.18841e-05 12.657ZM11.6066 0.636155L0.292906 11.9499L1.70712 13.3641L13.0208 2.05037L11.6066 0.636155Z"
                    fill="#4B402A" />
                </svg>
                <p class="font-normal leading-[1.2]">品牌理念</p>
              </div>
              <div class="flex items-center gap-[9px]">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M1.18841e-05 12.657C1.2137e-05 13.2093 0.447727 13.657 1.00001 13.657L10 13.657C10.5523 13.657 11 13.2093 11 12.657C11 12.1047 10.5523 11.657 10 11.657L2.00001 11.657L2.00001 3.65697C2.00001 3.10469 1.5523 2.65697 1.00001 2.65697C0.447728 2.65697 1.23477e-05 3.10469 1.26849e-05 3.65697L1.18841e-05 12.657ZM11.6066 0.636155L0.292906 11.9499L1.70712 13.3641L13.0208 2.05037L11.6066 0.636155Z"
                    fill="#4B402A" />
                </svg>
                <p class="font-normal leading-[1.2]">製作方式</p>
              </div>
              <div class="flex items-center gap-[9px]">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M1.18841e-05 12.657C1.2137e-05 13.2093 0.447727 13.657 1.00001 13.657L10 13.657C10.5523 13.657 11 13.2093 11 12.657C11 12.1047 10.5523 11.657 10 11.657L2.00001 11.657L2.00001 3.65697C2.00001 3.10469 1.5523 2.65697 1.00001 2.65697C0.447728 2.65697 1.23477e-05 3.10469 1.26849e-05 3.65697L1.18841e-05 12.657ZM11.6066 0.636155L0.292906 11.9499L1.70712 13.3641L13.0208 2.05037L11.6066 0.636155Z"
                    fill="#4B402A" />
                </svg>
                <p class="font-normal leading-[1.2]">商品列表</p>
              </div>
              <div class="flex items-center gap-[9px]">
                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M1.18841e-05 12.657C1.2137e-05 13.2093 0.447727 13.657 1.00001 13.657L10 13.657C10.5523 13.657 11 13.2093 11 12.657C11 12.1047 10.5523 11.657 10 11.657L2.00001 11.657L2.00001 3.65697C2.00001 3.10469 1.5523 2.65697 1.00001 2.65697C0.447728 2.65697 1.23477e-05 3.10469 1.26849e-05 3.65697L1.18841e-05 12.657ZM11.6066 0.636155L0.292906 11.9499L1.70712 13.3641L13.0208 2.05037L11.6066 0.636155Z"
                    fill="#4B402A" />
                </svg>
                <p class="font-normal leading-[1.2]">聯絡方式</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>
  <main class="max-w-[1903px] mx-auto">
    <!-- 第一張大圖 -->
    <section class="w-full flex justify-center items-center">
      <img src="/image/1-1.png" alt="">
      <img src="/image/1-2.png" alt="">
    </section>
    <!-- 網站功能簡介 -->
    <section class="w-full bg-white flex flex-col gap-6 border-b px-[200px] py-20">
      <p class="font-noto-cjk text-[#7A7A7A] font-normal leading-[1.2]">網站功能簡介</p>
      <div class="flex gap-6">
        <div class="w-1/3 flex flex-col gap-4">
          <div class="flex items-end gap-[15px] text-[#444444]">
            <p class="font-jockey text-[96px] font-normal leading-[96px] uppercase">10+</p>
            <p class="font-pingfang text-[30px] font-medium leading-[1.14] tracking-[2.25px]">年電繡經驗</p>
          </div>
          <p class="h-[54px] font-pingfang text-[#444444] text-lg font-normal leading-[1.5] tracking-[1.35px]">
            保證刺出不羈的靈魂，讓每一位顧客擁有最優質的服務。
          </p>
        </div>
        <div class="w-1/3 flex flex-col gap-4">
          <div class="flex items-end gap-[15px] text-[#444444]">
            <p class="font-jockey text-[96px] font-normal leading-[96px] uppercase">2,000+</p>
            <p class="font-pingfang text-[30px] font-medium leading-[1.14] tracking-[2.25px]">番長指定</p>
          </div>
          <p class="font-pingfang text-[#444444] text-lg font-normal leading-[1.5] tracking-[1.35px]">
            治霸全國指定品牌，日常暴走穿搭首選。
          </p>
        </div>
        <div class="w-1/3 flex flex-col gap-4">
          <div class="flex items-end gap-[15px] text-[#444444]">
            <svg width="151" height="96" viewBox="0 0 151 96" fill="none" xmlns="http://www.w3.org/2000/svg">
              <g clip-path="url(#clip0_148_2135)">
                <path
                  d="M36.2819 86C29.5708 86 23.419 84.4814 17.8264 81.4441C12.3736 78.2689 8.03935 73.851 4.82361 68.1907C1.60787 62.5304 0 55.8347 0 48.1035C0 40.3724 1.60787 33.6767 4.82361 28.0163C8.03935 22.218 12.3736 17.8002 17.8264 14.7629C23.419 11.5876 29.5708 10 36.2819 10C41.1755 10 45.6495 10.7593 49.7042 12.2779C53.7588 13.7965 57.8134 16.3506 61.868 19.9401C66.0625 23.5295 70.6065 28.4995 75.5 34.8501C80.3935 28.4995 84.8676 23.5295 88.9222 19.9401C92.9768 16.3506 97.0315 13.7965 101.086 12.2779C105.281 10.7593 109.825 10 114.718 10C121.569 10 127.721 11.5876 133.174 14.7629C138.626 17.8002 142.961 22.218 146.176 28.0163C149.392 33.6767 151 40.3724 151 48.1035C151 55.8347 149.392 62.5304 146.176 68.1907C142.961 73.851 138.626 78.2689 133.174 81.4441C127.721 84.4814 121.569 86 114.718 86C107.448 86 100.876 84.2053 95.0042 80.6158C89.1319 76.8883 82.6306 70.3306 75.5 60.9428C68.3694 70.3306 61.868 76.8883 55.9958 80.6158C50.2634 84.2053 43.6921 86 36.2819 86ZM36.2819 71.7112C40.3366 71.7112 44.1116 70.6067 47.6069 68.3978C51.1023 66.0509 54.388 63.0826 57.4639 59.4932C60.6796 55.7657 63.6157 51.9691 66.2722 48.1035C63.8954 44.376 61.169 40.6485 58.0931 36.921C55.1569 33.1935 51.8713 30.0872 48.2361 27.6022C44.7407 25.1172 40.756 23.8747 36.2819 23.8747C29.5708 23.8747 24.3278 26.0836 20.5528 30.5014C16.9176 34.7811 15.1 40.6485 15.1 48.1035C15.1 55.4205 17.1972 61.2189 21.3917 65.4986C25.5861 69.6403 30.5495 71.7112 36.2819 71.7112ZM114.718 71.7112C120.45 71.7112 125.414 69.6403 129.608 65.4986C133.803 61.2189 135.9 55.4205 135.9 48.1035C135.9 40.6485 134.012 34.7811 130.237 30.5014C126.602 26.0836 121.429 23.8747 114.718 23.8747C110.244 23.8747 106.189 25.1172 102.554 27.6022C99.0588 30.0872 95.843 33.1935 92.9069 36.921C89.9708 40.6485 87.2444 44.376 84.7278 48.1035C87.5241 52.1072 90.4602 55.9037 93.5361 59.4932C96.612 63.0826 99.8977 66.0509 103.393 68.3978C106.888 70.6067 110.663 71.7112 114.718 71.7112Z"
                  fill="#444444" />
              </g>
              <defs>
                <clipPath id="clip0_148_2135">
                  <rect width="151" height="74" fill="white" transform="translate(0 11)" />
                </clipPath>
              </defs>
            </svg>
            <p class="font-pingfang text-[30px] font-medium leading-[1.14] tracking-[2.25px]">無極限客製</p>
          </div>
          <p class="h-[54px] font-pingfang text-[#444444] text-lg font-normal leading-[1.5] tracking-[1.35px]">
            多種版型可供下載，客製化屬於你自己的自由靈魂。
          </p>
        </div>
      </div>
    </section>
    <!-- 第二張大圖 -->
    <section class="w-full bg-[#333333] flex justify-center items-center gap-10 pl-50">
      <div class="w-[639px] flex flex-col gap-6 border-l border-[#333333] py-20">
        <p class="w-[417px] font-bakudai-r text-white text-[64px] font-normal leading-[1.2]">
          繡上自由想法, 秀出自信態度
        </p>
        <p class="font-noto-cjk text-[#D9D9D9] font-normal leading-[1.6]">
          桀驁不馴，既是對社會規範的挑戰，也是對自身風格的堅持。<br><br>
          我們堅信透過刺繡，繡上的每一針一線都能傳遞情感與故事。​​無論是個人訂製還是團體需求，我們都以專業態度滿足，期望每件作品都能成為您生活中的亮點。
        </p>
      </div>
      <img src="/image/2.png" alt="">
    </section>
    <!-- 設計 -->
    <section class="w-full bg-white">
      <!-- 設計自己的暴走魂 -->
      <div class="w-full flex justify-center items-center gap-6 px-[200px] py-20">
        <div class="w-full flex justify-center items-center min-[1201px]:gap-10 gap-6">
          <div class="w-full flex-1 flex flex-col justify-center gap-6">
            <!-- 訂製方式 -->
            <div class="flex flex-col justify-center gap-6 py-6">
              <p class="font-noto-cjk text-[#7A7A7A] font-normal leading-[1.2]">訂製方式</p>
              <div class="flex items-center gap-6">
                <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M24 0.5V24.5H0L24 0.5Z" fill="#4B402A" />
                </svg>
                <p
                  class="font-noto-cjk text-[#444444] min-[1314px]:text-[64px] min-[1201px]:text-[56px] text-[48px] font-bold leading-[1.2]">
                  設計自己的暴走魂</p>
              </div>
              <p class="font-Noto-serif-jp text-[#444444] text-lg font-normal leading-[1.5]">
                完全客製化，透過連結下載模板自行設計，有長版/短版/特工褲各4色可做挑選。</p>
            </div>
            <!-- 進度條 -->
            <div
              class="min-[1441px]:w-[731px] min-[1314px]:w-[600px] min-[1276px]:w-[560px] min-[1201px]:w-[535px] w-[469px] min-[1201px]:h-[123px] h-[105px] relative">
              <div class="w-full flex min-[1314px]:gap-20 min-[1201px]:gap-10 gap-2">
                <div class="w-1/3 flex flex-col items-center gap-2">
                  <p
                    class="font-noto text-[#444444] text-lg min-[1314px]:font-normal font-bold leading-[1.5] tracking-[1.35px]">
                    Step1.</p>
                  <button
                    class="w-full bg-[#444444] font-noto-cjk text-white text-lg min-[1201px]:font-normal font-bold leading-[100%] rounded-[8px] min-[1441px]:whitespace-nowrap min-[1441px]:py-3 py-[22px] min-[1441px]:px-0 px-6"
                    type="button">
                    特攻服初稿
                  </button>
                </div>
                <div class="w-1/3 flex flex-col items-center gap-2">
                  <p
                    class="font-noto text-[#444444] text-lg min-[1314px]:font-normal font-bold leading-[1.5] tracking-[1.35px]">
                    Step2.</p>
                  <button
                    class="w-full font-noto-cjk text-[#444444] text-lg min-[1314px]:font-normal font-bold leading-[100%] rounded-[8px] min-[1441px]:whitespace-nowrap border border-[#444444] py-3 min-[1441px]:px-0 px-6"
                    type="button">
                    回傳給小編排稿+估價
                  </button>
                </div>
                <div class="w-1/3 flex flex-col items-center gap-2">
                  <p
                    class="font-noto text-[#444444] text-lg min-[1314px]:font-normal font-bold leading-[1.5] tracking-[1.35px]">
                    Step3.</p>
                  <button
                    class="w-full font-noto-cjk text-[#444444] text-lg min-[1314px]:font-normal font-bold leading-[100%] rounded-[8px] min-[1441px]:whitespace-nowrap border border-[#444444] py-3 min-[1441px]:px-0 px-6"
                    type="button">
                    完成訂製、付訂金
                  </button>
                </div>
              </div>
              <div
                class="flex gap-[102px] absolute top-[16px] min-[1441px]:left-[192px] min-[1314px]:left-[165px] min-[1201px]:left-[142px] left-[150px]">
                <div class="min-[1441px]:w-[122px] min-[1201px]:w-[80px] w-[32px] border border-[#444444]"></div>
                <div class="min-[1441px]:w-[122px] min-[1201px]:w-[80px] w-[32px] border border-[#444444]"></div>
              </div>
            </div>
            <!-- 價目樣式參考表 -->
            <div class="flex flex-col gap-6 py-6">
              <div class="flex gap-6">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M24 0V24H0L24 0Z" fill="#4B402A" />
                </svg>
                <p class="font-noto-cjk text-[#7A7A7A] font-normal leading-[1.2]">價目樣式參考表</p>
              </div>
              <p class="font-Noto-serif-jp text-[#444444] text-lg font-normal leading-[1.5]">完全客製化，透過連結下載模板自行設計</p>
              <div class="w-full min-[1441px]:flex grid grid-cols-2 gap-4">
                <button type="button"
                  class="bg-[#444444] font-noto-cjk text-lg text-white font-normal leading-[100%] rounded-[8px] px-8 py-3">
                  中文字體樣式
                </button>
                <button type="button"
                  class="bg-[#444444] font-noto-cjk text-lg text-white font-normal leading-[100%] rounded-[8px] px-8 py-3">
                  英文字體樣式
                </button>
                <button type="button"
                  class="bg-[#444444] font-noto-cjk text-lg text-white font-normal leading-[100%] rounded-[8px] px-8 py-3">
                  繡字價目表
                </button>
                <button type="button"
                  class="bg-[#FFC051] flex items-center justify-center gap-1 rounded-[8px] px-11 py-3">
                  <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M8 12L3 7L4.4 5.55L7 8.15V0H9V8.15L11.6 5.55L13 7L8 12ZM2 16C1.45 16 0.979333 15.8043 0.588 15.413C0.196666 15.0217 0.000666667 14.5507 0 14V11H2V14H14V11H16V14C16 14.55 15.8043 15.021 15.413 15.413C15.0217 15.805 14.5507 16.0007 14 16H2Z"
                      fill="#4D4D4D" />
                  </svg>
                  <p class="font-Microsoft text-lg text-[#4D4D4D] font-bold leading-[100%] tracking-[1.35px]">下載模板</p>
                </button>
              </div>
            </div>
          </div>
          <img src="/image/3-1.png" alt="">
        </div>
      </div>
      <!-- 下單購買 -->
      <div class="w-full bg-[#333333] flex flex-col gap-4 min-[1904px]:px-[200px] min-[1201px]:px-[120px] px-10 py-8">
        <div class="flex items-center gap-6">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M24 0V24H0L24 0Z" fill="white" />
          </svg>
          <p class="font-noto-cjk min-[1201px]:text-[80px] text-[48px] text-white font-bold leading-[1.2]">下單購買</p>
        </div>
        <div class="min-[1201px]:flex grid grid-cols-1 gap-4">
          <div
            class="min-[1201px]:w-1/3 w-full flex flex-col gap-2 shadow-[0px_0px_4px_0px_rgba(0, 0, 0, 0.1)] rounded-tl-2xl rounded-tr-2xl">
            <img class="rounded-tl-2xl rounded-tr-2xl" src="/image/4-1.png" alt="">
            <div class="flex flex-col gap-2 px-2">
              <p class="font-noto-cjk text-[24px] text-white font-bold leading-[1.2]">
                日式特攻服 暴走族 🎌 [白色] 素色特攻服 客製化 團體服
              </p>
              <p
                class="font-pingfang-r text-[32px] text-[#C89E51] font-normal leading-[100%] tracking-[0.08em] opacity-80 [text-shadow:1px_1px_0_#B41900,-1px_1px_0_#B41900,1px_-1px_0_#B41900,-1px_-1px_0_#B41900,0px_1px_0_#B41900,0px_-1px_0_#B41900,1px_0px_0_#B41900,-1px_0px_0_#B41900]">
                $50
              </p>
            </div>
          </div>
          <div
            class="min-[1201px]:w-1/3 w-full flex flex-col gap-2 shadow-[0px_0px_4px_0px_rgba(0, 0, 0, 0.1)] rounded-tl-2xl rounded-tr-2xl">
            <img class="rounded-tl-2xl rounded-tr-2xl" src="/image/4-2.png" alt="">
            <div class="flex flex-col gap-2 px-2">
              <p class="font-noto-cjk text-[24px] text-white font-bold leading-[1.2]">
                日式中版特攻服 暴走族 🎌 素色特攻服 客製化 團體服
              </p>
              <p
                class="font-pingfang-r text-[32px] text-[#C89E51] font-normal leading-[100%] tracking-[0.08em] opacity-80 [text-shadow:1px_1px_0_#B41900,-1px_1px_0_#B41900,1px_-1px_0_#B41900,-1px_-1px_0_#B41900,0px_1px_0_#B41900,0px_-1px_0_#B41900,1px_0px_0_#B41900,-1px_0px_0_#B41900]">
                $50
              </p>
            </div>
          </div>
          <div
            class="min-[1201px]:w-1/3 w-full flex flex-col gap-2 shadow-[0px_0px_4px_0px_rgba(0, 0, 0, 0.1)] rounded-tl-2xl rounded-tr-2xl">
            <img class="rounded-tl-2xl rounded-tr-2xl" src="/image/4-3.png" alt="">
            <div class="flex flex-col gap-2 px-2">
              <p class="font-noto-cjk text-[24px] text-white font-bold leading-[1.2]">
                刺繡 電腦刺繡 客製化 刺繡範例 請看商品描述 歡迎聊聊詢問
              </p>
              <p
                class="font-pingfang-r text-[32px] text-[#C89E51] font-normal leading-[100%] tracking-[0.08em] opacity-80 [text-shadow:1px_1px_0_#B41900,-1px_1px_0_#B41900,1px_-1px_0_#B41900,-1px_-1px_0_#B41900,0px_1px_0_#B41900,0px_-1px_0_#B41900,1px_0px_0_#B41900,-1px_0px_0_#B41900]">
                $50
              </p>
            </div>
          </div>
        </div>
        <div class="w-full flex justify-center">
          <button
            class="bg-white flex items-center gap-[10px] px-10 py-4 rounded-2xl shadow-[0px_4px_4px_0px_rgba(0, 0, 0, 0.25)]"
            type="button">
            <img src="/image/svg/Shopee_logo.svg" alt="">
            <p class="font-noto-cjk text-[#444444] text-lg font-normal leading-[1.5]">蝦皮賣場</p>
            <svg width="26" height="25" viewBox="0 0 26 25" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path
                d="M25.2071 13.1788C25.5976 12.7883 25.5976 12.1551 25.2071 11.7646L18.8431 5.40061C18.4526 5.01009 17.8195 5.01009 17.4289 5.40061C17.0384 5.79114 17.0384 6.4243 17.4289 6.81483L23.0858 12.4717L17.4289 18.1285C17.0384 18.5191 17.0384 19.1522 17.4289 19.5427C17.8195 19.9333 18.4526 19.9333 18.8431 19.5427L25.2071 13.1788ZM0.5 13.4717H24.5V11.4717H0.5V13.4717Z"
                fill="#444444" />
            </svg>
          </button>
        </div>
      </div>
    </section>
  </main>
  <!-- footer -->

  <footer class="max-w-[1903px] bg-[#272727] flex flex-col min-[522px]:justify-center min-[522px]:items-center gap-10 mx-auto min-[769px]:py-10 relative min-[476px]:px-4 px-3 pt-[110px] pb-10">

    <!-- 回到頂部 -->
    <button type="button"
      class="bg-[#444444] border-2 border-[#4D4D4D] font-noto-cjk text-white font-bold text-lg leading-[125%] tracking-[1.5px] min-[522px]:p-5 min-[522px]:w-[103px] w-[95px] min-[522px]:h-[65px] h-[41px] absolute top-7 right-4">
      回頂部
    </button>

    <!-- logo -->
    <div class="flex items-start min-[476px]:gap-2 gap-[6px]">
      <img src="/image/LOGO-中.png" alt="" class="min-[522px]:w-[73.85px] w-[57.36px]">
      <div class="flex-col gap-[5.76px]">
        <p class="font-noto-jp text-white min-[522px]:text-[14.8px] text-[11.5px] font-black leading-[1.2] tracking-[-0.08em]">
          天下無敵、台湾特工服の第一品牌
        </p>
        <p class="font-freckle text-white min-[522px]:text-[64.77px] text-[50.31px] font-normal leading-[1.2] tracking-[-0.08em]">
          ITS SHOW TIME
        </p>
      </div>
    </div>


    <!-- 聯絡 -->
    <div class="min-[769px]:flex items-center gap-10">
      <!-- 字體 Taipei Sans TC Beta -->
      <span class="font-taipei-sans-tc-r text-white leading-[192%] tracking-[1.2px]">
        <span class="font-taipei-sans-tc-bold">聯絡我們</span><br>
        聯絡地址：台中市東區精武路173號<br>
        客服電話：0984 090 320
      </span>
      <div class="min-[1201px]:flex grid min-[522px]:grid-cols-2 grid-cols-1 gap-4 py-8">
        <button type="button" class="w-[198px] bg-[#333333] flex items-center gap-1 px-2 py-1 rounded-[26px]">
          <img src="/image/svg/facebook.svg" alt="">
          <p class="font-taipei-sans-tc-r text-white font-normal text-lg leading-[1.25] tracking-[1.35px]">Itsshowtime
          </p>
        </button>
        <button type="button" class="w-[198px] bg-[#333333] flex items-center gap-1 px-2 py-1 rounded-[26px]">
          <img src="/image/svg/instagram.svg" alt="">
          <p class="font-taipei-sans-tc-r text-white font-normal text-lg leading-[1.25] tracking-[1.35px]">
            itsshowtime_tw</p>
        </button>
        <button type="button" class="w-[198px] bg-[#333333] flex items-center gap-1 px-2 py-1 rounded-[26px]">
          <img src="/image/svg/shopee.svg" alt="">
          <p class="font-taipei-sans-tc-r text-white font-normal text-lg leading-[1.25] tracking-[1.35px]">蝦皮賣場</p>
        </button>
        <button type="button" class="w-[198px] bg-[#333333] flex items-center gap-1 px-2 py-1 rounded-[26px]">
          <img src="/image/svg/maps.svg" alt="">
          <p class="font-taipei-sans-tc-r text-white  text-lg leading-[1.25] tracking-[1.35px]">Google地圖</p>
        </button>

      </div>

    </div>
    <div class="border-t border-[#BBBDBD] pt-10 pb-5">
      <p class="font-noto text-white font-normal leading-[1.6] tracking-[1.2px]">
        Copyright © 2025 衣織繡態企業社 ． Web Design → Digi-pack
      </p>
    </div>
  </footer>

</template>

<style>
html,
body {
  font-size: 16px;
  background-color: #0A1109;
  margin: 0;
  padding: 0;
}

.font-noto-cjk {
  font-family: 'Noto Sans CJK TC';
}

.font-noto {
  font-family: 'Noto Sans TC';
}

.font-noto-jp {
  font-family: 'Noto Sans JP';
}

.font-freckle {
  font-family: 'Freckle Face';
}

.font-jockey {
  font-family: 'Jockey One';
}

.font-pingfang {
  font-family: 'PingFang SC';
}

.font-pingfang-r {
  font-family: 'PingFang SC Regular';
}

.font-bakudai-r {
  font-family: Bakudai-Regular;
}

.font-Noto-serif-jp {
  font-family: 'Noto Serif JP';
}

.font-Microsoft {
  font-family: 'Microsoft JhengHei';
}

.font-taipei-sans-tc-bold {
  font-family: 'Taipei Sans TC Beta Bold';
}

.font-taipei-sans-tc-r {
  font-family: 'Taipei Sans TC Beta Regular';
}

button {
  cursor: pointer;
}
</style>