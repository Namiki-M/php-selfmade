


##インストール後の実施
画像のダミーデータは
public/imagesフォルダ内に
sample1.jpg
sample2.jpg
sample3.png
sample4.jpg
sample5.jpg
sample6.jpg
として保存している。

php artisan storage:linkで
storageフォルダにリンク後、

storage/app/public/productsフォルダ内に保存する
と表示されます。
（productフォルダがない場合は作成する必要がある。）

.envファイルはgit上にアップされない

php artisan queue:work でメールの非同期処理を実行。