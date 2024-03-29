<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            チャット
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div id="room">
                        @foreach($messages as $key => $message)
                            {{--   送信したメッセージ  --}}
                            @if($message->send == \Illuminate\Support\Facades\Auth::id())
                                <div class="send" style="text-align: right">
                                    <p>{{$message->message}}</p>
                                </div>
                 
                            @endif
                 
                            {{--   受信したメッセージ  --}}
                            @if($message->recieve == \Illuminate\Support\Facades\Auth::id())
                                <div class="recieve" style="text-align: left">
                                    <p>{{$message->message}}</p>
                                </div>
                            @endif
                        @endforeach
                    </div>
                 
                    <form>
                        <textarea name="message" style="width:100%"></textarea>
                        <button type="button" id="btn_send">送信</button>
                    </form>

                    <input type="hidden" name="send" value="{{$param['send']}}">
                    <input type="hidden" name="recieve" value="{{$param['recieve']}}">
                    <input type="hidden" name="login" value="{{\Illuminate\Support\Facades\Auth::id()}}">
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
 
        //ログを有効にする
        Pusher.logToConsole = true;
  
        var pusher = new Pusher('[YOUR-APP-KEY]', {
            cluster  : '[YOUR-CLUSTER]',
            encrypted: true
        });
  
        //購読するチャンネルを指定
        var pusherChannel = pusher.subscribe('chat');
  
        //イベントを受信したら、下記処理
        pusherChannel.bind('chat_event', function(data) {
  
            let appendText;
            let login = $('input[name="login"]').val();
  
            if(data.send === login){
                appendText = '<div class="send" style="text-align:right"><p>' + data.message + '</p></div> ';
            }else if(data.recieve === login){
                appendText = '<div class="recieve" style="text-align:left"><p>' + data.message + '</p></div> ';
            }else{
                return false;
            }
  
            // メッセージを表示
            $("#room").append(appendText);
  
            if(data.recieve === login){
                // ブラウザへプッシュ通知
                Push.create("新着メッセージ",
                    {
                        body: data.message,
                        timeout: 8000,
                        onClick: function () {
                            window.focus();
                            this.close();
                        }
                    })
  
            }
  
  
        });
  
  
         $.ajaxSetup({
             headers : {
                 'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content'),
             }});
  
  
         // メッセージ送信
         $('#btn_send').on('click' , function(){
             $.ajax({
                 type : 'POST',
                 url : '/chat/send',
                 data : {
                     message : $('textarea[name="message"]').val(),
                     send : $('input[name="send"]').val(),
                     recieve : $('input[name="recieve"]').val(),
                 }
             }).done(function(result){
                 $('textarea[name="message"]').val('');
             }).fail(function(result){
  
             });
         });
     </script>
</x-app-layout>