@props([
    'title',
    'message' => 'メッセージ初期値です',
    'message1' => 'メーっせーじ',
    'content' => '本文の初期値です'
    ])

<div class="border-2 shadow w-1/2 p-2">
 <div>{{ $title }}</div>
 <div>画像</div>
 <div> {{ $content }} </div>
 <div> {{ $message }} </div>
 <div> {{ $message1 }} </div>
</div>