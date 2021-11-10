<x-tests.app>
    <x-slot name="header">ヘッダー１</x-slot>
コンポーネントテスト１

    <x-tests.card title="タイトル" content="コンテンツ" :message="$message" :message1="$message1"></x-tests.card>
    <x-tests.card title="タイトル２"></x-tests.card>
    <x-tests.card title="クラスを変えたい" class="bg-red-300"></x-tests.card>
</x-tests.app>