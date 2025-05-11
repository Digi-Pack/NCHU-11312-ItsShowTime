{{-- <x-mail::message>
# Introduction

The body of your message.

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message> --}}
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>詢價確認自動通知</title>
</head>
<body>
  <p>親愛的顧客您好，</p>
  <p>我們已收到您的詢價單，將在 24 小時內與您聯繫。</p>
  <p>感謝您的詢問！</p>

  <p>※ 此信件為系統自動發送，請勿直接回覆。</p>
  {{-- <p>{{ config('app.name') }}</p> --}}
</body>
</html>