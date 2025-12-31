<!DOCTYPE html>
<html>
<head>
    <meta charset = "UTF-8">
    <title>Chat</title>
</head>
<body>

<h2>Chat: {{ $chat -> name ?? "Без названия" }}</h2>

<hr>

@foreach ($chat->messages as $message)
    <p>
        <strong>
            {{$message->direction === 'incoming' ? 'Пользователь' : 'Оператор'}}:
        </strong>
        {{$message->text}}
    </p>
@endforeach

<hr>

<form method='POST' action="/chats/{{ $chat->id }}/send">
    @csrf

    <input
        type="text"
        name="text"
        placeholder="Введите сообщение"
        required
    >

    <button type="submit">Отправить</button>

</form>

</body>
</html>
