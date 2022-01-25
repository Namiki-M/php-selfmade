<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <div class="w-28">
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('user.register') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                name="password_confirmation" required />
            </div>
            {{-- 追加分　登録情報 --}}
            
                <div class="relative">
                  <label for="postal_code" class="leading-7 text-sm text-gray-600">郵便番号</label>
                  <span>〒(例)101-0001</span><input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code') }}" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                </div>
            
              
                <label for="pref_id" class="leading-7 text-sm text-gray-600">都道府県</label>
                <select name="pref_id" id="pref_id" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                  @foreach ($prefs as $key => $pref)
                        <option value="{{ $key }}" @if (old('pref_id') == $key) selected @endif>
                            {{ $pref }}
                        </option>
                  @endforeach
                </select>
            
              
                <div class="relative">
                  <label for="city" class="leading-7 text-sm text-gray-600">市区町村</label>
                  <input type="text" id="city" name="city" value="{{ old('city') }}" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                </div>
            
              
                <div class="relative">
                  <label for="town" class="leading-7 text-sm text-gray-600">町名番地</label>
                  <input type="text" id="town" name="town" value="{{ old('town') }}" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                </div>
            
              
                <div class="relative">
                  <label for="building" class="leading-7 text-sm text-gray-600">建物名</label>
                  <input type="text" id="building" name="building" value="{{ old('building') }}" class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                </div>
            
              
                <div class="relative">
                  <label for="phone_number" class="leading-7 text-sm text-gray-600">電話番号</label>
                  <span>(例)070-0000-0000</span><input type="text" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" required class="w-full bg-gray-100 bg-opacity-50 rounded border border-gray-300 focus:border-indigo-500 focus:bg-white focus:ring-2 focus:ring-indigo-200 text-base outline-none text-gray-700 py-1 px-3 leading-8 transition-colors duration-200 ease-in-out">
                </div>
            


            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('user.login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
