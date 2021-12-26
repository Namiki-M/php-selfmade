<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                <section class="text-gray-600 body-font relative">
                    <div class="container px-5 mx-auto">
                      <div class="flex flex-col text-center w-full mb-12">
                        <h1 class="sm:text-3xl text-2xl font-medium title-font mb-4 text-gray-900">ユーザー登録</h1>
                        <!-- <p class="lg:w-2/3 mx-auto leading-relaxed text-base">Whatever cardigan tote bag tumblr hexagon brooklyn asymmetrical gentrify.</p> -->
                      </div>
                      <div class="lg:w-1/2 md:w-2/3 mx-auto">
                        <x-auth-validation-errors class="mb-4" :errors="$errors" />
                        <form method="post" action="{{ route('admin.users.store') }}">
                          @csrf
                        <div class="-m-2">
                          <div class="p-2 w-1/2 mx-auto">
                            <div class="relative">
                              <label for="name" class="leading-7 text-sm text-gray-600">ユーザー名</label>
                              <input type="text" id="name" name="name" value="{{ old('name') }}" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                            </div>
                          </div>
                          <div class="p-2 w-1/2 mx-auto">
                            <div class="relative">
                              <label for="email" class="leading-7 text-sm text-gray-600">メールアドレス</label>
                              <input type="email" id="email" name="email" value="{{ old('email') }}" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                            </div>
                          </div>
                          <div class="p-2 w-1/2 mx-auto">
                            <div class="relative">
                              <label for="password" class="leading-7 text-sm text-gray-600">パスワード</label>
                              <input type="password" id="password" name="password" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                            </div>
                          </div>
                          <!-- パスワードの確認 -->
                          <div class="p-2 w-1/2 mx-auto">
                            <div class="relative">
                              <label for="password_confirmation" class="leading-7 text-sm text-gray-600">パスワード確認</label>
                              <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                            </div>
                          </div>
                          <div class="p-2 w-1/2 mx-auto">
                            <div class="relative">
                              <label for="postal_code" class="leading-7 text-sm text-gray-600">郵便番号</label>
                              <span>〒(例)101-0001</span><input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code') }}" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                            </div>
                          </div>
                          <div class="p-2 w-1/2 mx-auto">
                            <label for="pref_id" class="leading-7 text-sm text-gray-600">都道府県</label>
                            <select name="pref_id" id="pref_id" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                              @foreach ($prefs as $key => $pref)
                                    <option value="{{ $key }}" @if (old('pref_id') == $key) selected @endif>
                                        {{ $pref }}
                                    </option>
                              @endforeach
                            </select>
                          </div>
                          <div class="p-2 w-1/2 mx-auto">
                            <div class="relative">
                              <label for="city" class="leading-7 text-sm text-gray-600">市区町村</label>
                              <input type="text" id="city" name="city" value="{{ old('city') }}" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                            </div>
                          </div>
                          <div class="p-2 w-1/2 mx-auto">
                            <div class="relative">
                              <label for="town" class="leading-7 text-sm text-gray-600">町名番地</label>
                              <input type="text" id="town" name="town" value="{{ old('town') }}" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                            </div>
                          </div>
                          <div class="p-2 w-1/2 mx-auto">
                            <div class="relative">
                              <label for="building" class="leading-7 text-sm text-gray-600">建物名</label>
                              <input type="text" id="building" name="building" value="{{ old('building') }}" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                            </div>
                          </div>
                          <div class="p-2 w-1/2 mx-auto">
                            <div class="relative">
                              <label for="phone_number" class="leading-7 text-sm text-gray-600">電話番号</label>
                              <span>(例)070-0000-0000</span><input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                            </div>
                          </div>


                          <div class="p-2 w-full flex justify-around mt-4">
                            <button type="button" onclick="location.href='{{ route('admin.owners.index') }}'" class="bg-gray-200 border-0 py-2 px-8 focus:outline-none hover:bg-gray-400 rounded text-lg">戻る</button>
                            <button type="submit" class="text-white bg-indigo-500 border-0 py-2 px-8 focus:outline-none hover:bg-indigo-600 rounded text-lg">登録する</button>
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
