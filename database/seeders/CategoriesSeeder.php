<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::truncate();

        $data = [
            [
                'name'      => 'Listrik',
                'code'      => 'Listrik',
            ],
            [
                'name'      => 'Elektronik',
                'code'      => 'Elektronik',
            ],
            [
                'name'      => 'Plastik',
                'code'      => 'Plastik',
            ],
            [
                'name'      => 'Aluminium',
                'code'      => 'Aluminium',
            ],
            [
                'name'      => 'Besi',
                'code'      => 'Besi',
            ],
            [
                'name'      => 'Kaca',
                'code'      => 'Kaca',
            ],
        ];

        DB::table('categories')->insert($data);
    }
}
