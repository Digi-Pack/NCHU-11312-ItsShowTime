import { router } from '@inertiajs/vue3';

const flashMessage = (result, title, redirect) => {
  if (result.res === 'success') {
    Swal.fire({
      icon: "success",
      title: result.msg || `${title}成功`,
      showConfirmButton: false,
      timer: 1000,
    }).then(() => {
      router.get(redirect);
    });
  } else {
    Swal.fire({
      icon: "error",
      title: result.msg || `${title}失敗`,
    });
  };
};

export {
  flashMessage,
}