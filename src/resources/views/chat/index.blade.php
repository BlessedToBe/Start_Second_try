<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Список чатов</title>
</head>
<body>

<h2>Чаты</h2>

@foreach($chats as $chat)
    <div style="margin-bottom: 15px;" >
        <a href="/chats/{{$chat->id}}">
            <strong>{{$chat->name ?? 'Без названия'}}</strong>
        </a>
        <br>

        @if ($chat->messages->first())
            <small>
                Последнее сообщение:
                {{$chat->messages->first()->text}}
            </small>
        @else
            <small>
                Сообщений нет
            </small>
        @endif
    </div>
@endforeach

</body>
</html>
