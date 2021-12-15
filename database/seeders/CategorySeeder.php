<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('primary_categories')->insert([
            [
                'name' => 'メンズ',
                'sort_order' => 1,
            ],
            [
                'name' => 'レディース',
                'sort_order' => 2,
            ],
            ]);

            DB::table('secondary_categories')->insert([
                [
                    'name' => 'トップス',
                    'sort_order' => 1,
                    'primary_category_id' => 1,
                ],
                [
                    'name' => 'ボトムス',
                    'sort_order' => 2,
                    'primary_category_id' => 1,
                ],
                [
                    'name' => 'その他',
                    'sort_order' => 3,
                    'primary_category_id' => 1,
                ],
                [
                    'name' => 'トップス',
                    'sort_order' => 1,
                    'primary_category_id' => 2,
                ],
                [
                    'name' => 'ボトムス',
                    'sort_order' => 2,
                    'primary_category_id' => 2,
                ],
                [
                    'name' => 'その他',
                    'sort_order' => 3,
                    'primary_category_id' => 2,
                ],
                ]);
    }
}
