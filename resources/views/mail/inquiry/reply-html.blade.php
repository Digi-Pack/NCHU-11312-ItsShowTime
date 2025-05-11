<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>詢價回覆通知</title>
</head>
<body>
  <p>親愛的顧客您好，</p>
  <p>我們已收到您的詢價內容，以下是回覆訊息：</p>

  <blockquote style="border-left: 4px solid #ccc; margin: 1em 0; padding-left: 1em;">
    {!! nl2br(e($messageContent)) !!}
  </blockquote>

  <p>若您有任何問題，歡迎再次聯繫我們。</p>
  <p>此為系統發送信件，請勿直接回覆。</p>
  <p>ItS SHOW TIME 團隊 敬上</p>
</body>
</html>
