<x-app-layout>
    <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                購入履歴
            </h2>  
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex">
                        <div class ="w-1/2 md:items-center">
                            @foreach ($items as $item => $a_item)
                                @foreach($a_item as $A_item)
                                {{-- @foreach($products as $product) --}}
                                <div class="md:flex md:items-center mb-12">
                                    <div class="md:w-1/2">
                                        @if ($A_item->imageFirst->filename !== null)
                                        <img src="{{ asset('storage/products/' . $A_item->imageFirst->filename )}}">
                                        @else
                                        <img src="">
                                        @endif
                                    </div>
                                    <div class="md:w-4/12 md:ml-2">{{ $A_item->name }}</div>
                                </div>
                                {{-- @endforeach --}}
                                @endforeach
                            @endforeach
                        </div>
                        <div width="w-1/2 md:items-center">
                            @foreach($BoughtHistories as $BoughtHistory)
                            <div class="mb-12 py-16">
                                <div class="md:flex">
                                <div class="px-20">{{ $BoughtHistory->quantity }}個</div>
                                <div class="">{{ number_format($BoughtHistory->price)}}円<span class="text-sm text-gray-700">(税込)</span></div>
                                </div>
                            </div>
                            @endforeach  
                        </div> 
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
