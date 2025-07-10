<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::insert([
            ['content' => '商品について'],
            ['content' => 'サービスについて'],
            ['content' => '支払いについて'],
            ['content' => '配送について'],
            ['content' => 'その他'],
        ]);
    }
}
