{{--@if($order->chats->count() > 0)--}}
@if($chats->count() > 0)
    @foreach($chats as $chat)
        <div class="@if($chat->user_id == Auth::user()->id) me @else you @endif">
            <span class="username">{{ $chat->user->username }}</span>
            <p class="user_text">{{ $chat->text }}
                <br>
                <span class="timestemp"> {{ dateTimeHuman($chat->created_at) }}</span>
            </p>

        </div>
    @endforeach
@endif
