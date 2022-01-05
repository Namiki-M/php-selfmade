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
                            @if($message->receive == \Illuminate\Support\Facades\Auth::id())
                                <div class="receive" style="text-align: left">
                                    <p>{{$message->message}}</p>
                                </div>
                            @endif
                        @endforeach
                    </div>
                 
                    <form>
                        <textarea name="message" style="width:100%"></textarea>
                        <button type="button" id="btn_send" class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">送信</button>
                        <button type="button" onclick="location.href='{{ route('user.chat_user_select.index') }}'" class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</button>
                    </form>

                    <input type="hidden" name="send" value="{{$param['send']}}">
                    <input type="hidden" name="receive" value="{{$param['receive']}}">
                    <input type="hidden" name="login" value="{{\Illuminate\Support\Facades\Auth::id()}}">
                </div>
            </div>
        </div>
    </div>
 
    <script type="text/javascript">
    // document.getElementById("btn_send").onclick = function() {
    //     alert('aaaa');
    // };
    
 
        //ログを有効にする
        Pusher.logToConsole = true;
        
  
        let pusher = new Pusher('8b488c5a3ae513661938', {
            cluster  : 'ap3',
            // encrypted: true
        });
  
        //購読するチャンネルを指定
        let pusherChannel = pusher.subscribe('chat');

  
        //イベントを受信したら、下記処理
        pusherChannel.bind('chat_event', function(data) {
  
            let appendText;
            let login = $('input[name="login"]').val();

  
            if(data.send === login){
                appendText = '<div class="send" style="text-align:right"><p>' + data.message + '</p></div> ';
            }else if(data.receive === login){
                appendText = '<div class="receive" style="text-align:left"><p>' + data.message + '</p></div> ';
            }else{
                return false;
            }
  
            // メッセージを表示
            $("#room").append(appendText);
  
            if(data.receive === login){
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
         $("#btn_send").on('click' , function(){
             $.ajax({
                 type : 'POST',
                 url : '/chat/send',
                 data : {
                     message : $('textarea[name="message"]').val(),
                     send : $('input[name="send"]').val(),
                     receive : $('input[name="receive"]').val(),
                 }
             }).done(function(result){
                 $('textarea[name="message"]').val('');
             }).fail(function(result){
  
             });
         });




     </script>
</x-app-layout>