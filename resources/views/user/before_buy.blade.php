<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            購入前確認
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    

                <section class="text-gray-600 body-font relative">
                    <div class="container px-5 mx-auto">
                      <div class="flex flex-col text-center w-full mb-12">
                        <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">購入前確認</h1>
                      </div>
                      
                      @foreach($products as $product)
                    <div class="md:flex md:items-center mb-2">
                        <div class="md:w-3/12">
                            @if ($product->imageFirst->filename !== null)
                            <img src="{{ asset('storage/products/' . $product->imageFirst->filename )}}">
                            @else
                            <img src="">
                            @endif
                        </div>
                        <div class="md:w-4/12 md:ml-2">{{ $product->name }}</div>
                        <div class="md:w-3/12 flex justify-around">
                            <div>{{ $product->pivot->quantity }}個</div>
                            <div>{{ number_format($product->pivot->quantity * $product->price) }}<span class="text-sm text-gray-700">円(税込)</span></div>
                        </div>
                    </div>
                    @endforeach

                    <div class="my-2">
                        小計：{{ number_format($totalPrice) }}<span class="text-sm text-gray-700">円（税込）</span>
                    </div>


                      <div class="lg:w-1/2 md:w-2/3 mx-auto">
                        <div class="-m-2">
                          <div class="p-2 w-1/2 mx-auto">
                            <div class="relative">
                                <div class="leading-7 text-sm text-gray-600">名前</div>
                                <div class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ $user->name }}</div>
                            </div>
                          </div>
                          <div class="p-2 w-1/2 mx-auto">
                            <div class="relative">
                                <div class="leading-7 text-sm text-gray-600">メールアドレス</div>
                                <div class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ $user->email }}</div>
                            </div>
                          </div>
                          <div class="p-2 w-1/2 mx-auto">
                            <div class="relative">
                                <div class="leading-7 text-sm text-gray-600">郵便番号</div>
                                <div class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ $user->postal_code }}</div>
                            </div>
                          </div>
                          <div class="p-2 w-1/2 mx-auto">
                            <div class="leading-7 text-sm text-gray-600">都道府県</div>
                            @foreach ($prefs as $key => $pref)
                            @if($user->pref_id == $key)
                            <div class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                                {{ $pref }}
                            </div>
                            @endif  
                            @endforeach
                          </div>
                          <div class="p-2 w-1/2 mx-auto">
                            <div class="relative">
                                <div class="leading-7 text-sm text-gray-600">市区町村</div>
                                <div class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ $user->city }}</div>
                            </div>
                          </div>
                          <div class="p-2 w-1/2 mx-auto">
                            <div class="relative">
                                <div class="leading-7 text-sm text-gray-600">町名番地</div>
                                <div class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ $user->town }}</div>
                            </div>
                          </div>
                          <div class="p-2 w-1/2 mx-auto">
                            <div class="relative">
                                <div class="leading-7 text-sm text-gray-600">建物名</div>
                                <div class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ $user->building }}</div>
                            </div>
                          </div>
                          <div class="p-2 w-1/2 mx-auto">
                            <div class="relative">
                                <div class="leading-7 text-sm text-gray-600">電話番号</div>
                                <div class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">{{ $user->phone_number }}</div>
                            </div>
                          </div>
                          <div class="p-2 w-full flex justify-around mt-4">
                            <button type="button" onclick="location.href='{{ route('user.cart.address_confirm') }}'" class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</button>
                            {{-- <button type="submit" class="text-white bg-red-500 border-0 py-2 px-8 focus:outline-none hover:bg-red-600 rounded text-lg">情報変更をする</button> --}}
                            <div>
                            <button type="button" class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded" onclick="location.href='{{ route('user.cart.checkout')}}'">
                                購入する
                            </button>
                            </div>
                          </div>
                        </div>
                      </form>
                      </div>
                  </div>
                </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>