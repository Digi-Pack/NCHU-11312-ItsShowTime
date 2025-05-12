// 正則表達式 regex
const phoneRegex = /^[0-9]{10}$/; // 10位數的電話號碼
const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/; // email 格式
const dateRegex = /^\d{4}-\d{2}-\d{2}$/; // 日期格式 (YYYY-MM-DD)

export {
  phoneRegex,
  emailRegex,
  dateRegex,
};