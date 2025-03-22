<?php

namespace Database\Seeders;

use App\Models\MobileOpertor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MobileOperatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MobileOpertor::create([
            'sp_key'=>'3',
            'operator_name'=>'Airtel',
        ]);
        MobileOpertor::create([
            'sp_key'=>'5',
            'operator_name'=>'BSNL - Special Tariff',
        ]);
        MobileOpertor::create([
            'sp_key'=>'4',
            'operator_name'=>'BSNL Talktime',
        ]);
        MobileOpertor::create([
            'sp_key'=>'GPAY',
            'operator_name'=>'GOOGLE PLAY RECHARGE',
        ]);
        MobileOpertor::create([
            'sp_key'=>'33',
            'operator_name'=>'NOT APPLICABLE',
        ]);
        MobileOpertor::create([
            'sp_key'=>'116',
            'operator_name'=>'Reliance Jio',
        ]);
        MobileOpertor::create([
            'sp_key'=>'37',
            'operator_name'=>'VI',
        ]);
        MobileOpertor::create([
            'sp_key'=>'51',
            'operator_name'=>'Airtel Digital Tv',
        ]);
        MobileOpertor::create([
            'sp_key'=>'53',
            'operator_name'=>'Dish Tv',
        ]);
        MobileOpertor::create([
            'sp_key'=>'54',
            'operator_name'=>'Sun Direct',
        ]);
        MobileOpertor::create([
            'sp_key'=>'55',
            'operator_name'=>'Tata Sky',
        ]);
        MobileOpertor::create([
            'sp_key'=>'56',
            'operator_name'=>'Videocon D2h',
        ]);
    }
}
