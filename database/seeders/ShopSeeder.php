<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ShopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shops')->insert([
            [
                'owner_id' => 1,
                'name' => 'スーパー古着',
                'information' => 'ヨーロッパ古着を取り扱っています。',
                'filename' => 'sample2.jpg',
                'is_selling' => true
            ],
            [
                'owner_id' => 2,
                'name' => 'ファッション・ララ',
                'information' => '1950年代~1970年代の古着を取り扱っています。',
                'filename' => 'sample2.jpg',
                'is_selling' => true
            ],
            [
                'owner_id' => 3,
                'name' => 'ファッション・ララ',
                'information' => '1950年代~1970年代の古着を取り扱っています。',
                'filename' => 'sample2.jpg',
                'is_selling' => true
            ],
            [
                'owner_id' => 4,
                'name' => 'ファッション・ララ',
                'information' => '1950年代~1970年代の古着を取り扱っています。',
                'filename' => 'sample2.jpg',
                'is_selling' => true
            ],
            [
                'owner_id' => 5,
                'name' => 'ファッション・ララ',
                'information' => '1950年代~1970年代の古着を取り扱っています。',
                'filename' => 'sample2.jpg',
                'is_selling' => true
            ],
            [
                'owner_id' => 6,
                'name' => 'ファッション・ララ',
                'information' => '1950年代~1970年代の古着を取り扱っています。',
                'filename' => 'sample2.jpg',
                'is_selling' => true
            ],
        ]);
    }
}
