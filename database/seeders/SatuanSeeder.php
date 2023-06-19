<?php

namespace Database\Seeders;

use App\Models\Satuan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SatuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Satuan::truncate();

        $data = [
            [
                'name'      => 'M3',
                'code'      => 'M3',
            ],
            [
                'name'      => 'KG',
                'code'      => 'KG',
            ],
            [
                'name'      => 'Ton',
                'code'      => 'Ton',
            ],
            [
                'name'      => 'Meter',
                'code'      => 'Meter',
            ],
            [
                'name'      => 'Piece',
                'code'      => 'Piece',
            ],
            [
                'name'      => 'Lusin',
                'code'      => 'Lusin',
            ],
        ];

        DB::table('satuans')->insert($data);
    }
}
