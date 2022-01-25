<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            チャット一覧
        </h2>
    </x-slot>

    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
    
            </div>
        </div>
        
    
        {{--  チャット可能ユーザ一覧  --}}
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            {{-- @foreach($owners as $key => $owner)
            <tr>
                <th>{{$loop->iteration}}</th>
                <td>{{$owner->name}}</td>
                <td><a href="{{ route('user.chat.chat', ['message' => $owner->id])}}"><button type="button" class="btn btn-primary">Chat</button></a></td>
            </tr>
            @endforeach --}}
            @foreach($shops as $key => $shop)
            <tr>
                <th>{{$loop->iteration}}</th>
                <td>{{$shop->name}}</td>
                <td><a href="{{ route('user.chat.contact', ['user' => $shop->owner_id])}}"><button type="button" class="btn btn-primary">Chat</button></a></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    
    </div>
</x-app-layout>