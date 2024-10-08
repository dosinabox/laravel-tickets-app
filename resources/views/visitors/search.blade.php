<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Поиск</title>
    @vite(['resources/css/visitors/search.css'])
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="search-container">
        <form method="GET" action="{{ route('visitors.ui.search') }}">
            <div class="search-input-container">
             <label for="search-name">Поиск по имени, фамилии или коду</label>
                <input type="text" id="query" name="query" value="{{ $query ?? '' }}">
            </div>
            <button type="submit">Найти</button>
        </form>
    </div>
    @if(count($visitors) > 0)
        <br>
        @foreach ($visitors as $visitor)
            <a href="{{ route('visitors.ui.show', $visitor->getCode()) }}" style="color: white; text-decoration: none">
                <p style="font-size: 24px; color: {{ $visitor->isRejected() ? 'red' : 'white' }};">
                    {{ $visitor->getName() }} {{ $visitor->getLastName() }} ({{ $visitor->getCategory() }})
                </p>
            </a>
        @endforeach
    @elseif($query)
        <br>
        <p style="font-size: 24px">{{ $query }} - не найдено!</p>
    @endif
</div>
</body>
</html>
