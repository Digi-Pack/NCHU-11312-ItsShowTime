const useAlert = (title, doSomething) => {
  Swal.fire({
    title: title,
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "確定",
    cancelButtonText: "取消",
  }).then((result) => {
    if (result.isConfirmed) {
      if (typeof doSomething === 'function') {
        doSomething();
      };
    };
  });
};

export {
  useAlert,
}