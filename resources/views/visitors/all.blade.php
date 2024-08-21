<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Список</title>
    @vite(['resources/css/search.css'])
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="container">
    @if(count($visitors) > 0)
        <br>
        @foreach ($visitors as $visitor)
            <a href="/ui/visitors/{{ $visitor->getCode() }}" style="color: white; text-decoration: none">
                <p style="font-size: 24px; color: {{ $visitor->getIsRejected() ? 'red' : 'white' }};">
                    {{ $visitor->getName() }} {{ $visitor->getLastName() }} ({{ $visitor->getCategory() }})
                </p>
            </a>
        @endforeach
    @else
        <br>
        <p style="font-size: 24px">Нет посетителей</p>
    @endif
</div>
</body>
</html>
