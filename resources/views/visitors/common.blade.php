<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Посетитель</title>
    @vite(['resources/css/common.css'])
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1 class="title">{{ $visitor->getCategory() }}</h1>
    <p class="name">{{ $visitor->getName() }}<br>{{ $visitor->getLastName() }}</p>
    <a href="/ui/search"><button class="back-button">Назад к поиску</button></a>
</div>
</body>
</html>
