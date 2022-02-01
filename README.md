# アプリケーション情報

## 概要
 - 制作物 : 古着専門のモール型ECサイト
 - お店ユーザーと一般ユーザーで商品の購買が可能です
 - お店ユーザーと一般ユーザーとアドミン側でWebページの表示が異なっています
 - Stripeというクレジットカード決済機能を導入しています

## テストアカウント
1. アドミン用
 - 名前 : test
 - メールアドレス : test@test.com
 - パスワード : password123

2. お店ユーザー
 - 名前 : test1
 - メールアドレス : test1@test.com
 - パスワード : password123
 

 3.一般ユーザー
 - 名前 : test1
 - メールアドレス : test1@test.com
 -パスワード : password123
 - カード情報 https://stripe.com/docs/testingを参照してください　※CVCや有効期限は任意です

## 環境
 MAMP/MySQL/Laravel/Visual Studio Code/Tailwindcss

## 開発日数
 - 開発日数　40日間
 - １日あたりの作業時間 平均4時間

## データベース
- DB_CONNECTION=mysql
- DB_HOST=127.0.0.1
- DB_PORT=8889
- DB_DATABASE=selfmade
- DB_USERNAME=Mutsuki
- DB_PASSWORD=password123
(.envファイルの上記をご利用の環境に合わせて変更してください)

##ダウンロード後の実施事項

- cd fashionec
- composer install
- npm install
- npm run dev


.env.exampleをコピーして.envファイルを作成

XAMPP/MAMPまたは他の開発環境でDBを起動後
- php artisan migrate:fresh --seed
と実行してください。(データベースにテーブルとダミーデータが追加されればOK)

最後に
php artisan key:generate
と入力してキーを生成後、
php artisan serve
で簡易サーバーを立ち上げ、表示確認時てください。

##インストール後の実施

画像のダミーデータは
public/imagesフォルダ内に
sample1.jpg
sample2.jpg
sample3.png
sample4.jpg
sample5.jpg
sample6.jpg
として保存しています。

php artisan storage:linkで
storageフォルダにリンク後、

storage/app/public/productsフォルダ内に
保存すると表示されます。
（productsフォルダがない場合は作成する必要がある。）

ショップの画像も表示する場合は、
storage/app/public/shopsフォルダを作成し
画像を保存してください。

## 決済機能について
決済機能はstripeというAPIを使って実装しています。
必要な場合は.envにstripeの情報を追記してください。

## メールの送信機能(購入時と販売時)
メールのテストとしてmailtrapを利用しています。
必要な場合は.envにmailtrapの情報を追記してください。

また、メールの送信処理には時間がかかるので、キューを使用しています。(非同期処理)

php artisan queue:work でメールの非同期処理を実行することが可能です。


