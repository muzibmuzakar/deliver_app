<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SeksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('seksis')->insert([
            ['nama' => 'Seksi Pengiriman'],
            ['nama' => 'Seksi Gudang'],
            ['nama' => 'Seksi Penerimaan'],
            ['nama' => 'Seksi Operasional'],
        ]);
    }
}
