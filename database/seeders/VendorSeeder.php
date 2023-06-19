<?php

namespace Database\Seeders;

use App\Models\Vendor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Vendor::truncate();

        $data = [
            [
                'name'      => 'PT ABC',
                'code'      => 'PT ABC',
                'address'   => 'Surabaya',
                'type'      => 'customer'
            ],
            [
                'name'      => 'PT Contractor A',
                'code'      => 'PT Contractor A',
                'address'   => 'Sidoarjo',
                'type'      => 'customer'
            ],
            [
                'name'      => 'PT Kapal Api',
                'code'      => 'PT Kapal Api',
                'address'   => 'Kalimantan',
                'type'      => 'customer'
            ],
            [
                'name'      => 'PT Berkah',
                'code'      => 'PT Berkah',
                'address'   => 'Jakarta',
                'type'      => 'supplier'
            ],
            [
                'name'      => 'PT Abadi',
                'code'      => 'PT Abadi',
                'address'   => 'Bali',
                'type'      => 'supplier'
            ],
            [
                'name'      => 'PT Sentosa',
                'code'      => 'PT Sentosa',
                'address'   => 'Malang',
                'type'      => 'supplier'
            ],
        ];

        DB::table('vendors')->insert($data);
    }
}
