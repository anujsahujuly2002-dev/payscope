<?php

namespace Database\Seeders;

use App\Models\PaymentMode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        /* State::create([
            'name'=>strtolower('ASSAM')
        ]);
        State::create([
            'name'=>strtolower('BIHAR')
        ]);
        State::create([
            'name'=>strtolower('CHENNAI')
        ]);
        State::create([
            'name'=>strtolower('GUJARAT')
        ]);
        State::create([
            'name'=>strtolower('HARYANA')
        ]);
        State::create([
            'name'=>strtolower('HIMACHAL PRADESH')
        ]);
        State::create([
            'name'=>strtolower('JAMMU KASHMIR')
        ]);
        State::create([
            'name'=>strtolower('KARNATAKA')
        ]);
        State::create([
            'name'=>strtolower('KERALA')
        ]);
        State::create([
            'name'=>strtolower('KOLKATA')
        ]);
        State::create([
            'name'=>strtolower('MAHARASHTRA')
        ]);
        State::create([
            'name'=>strtolower('MADHYA PRADESH')
        ]);
        State::create([
            'name'=>strtolower('CHHATTISGARH')
        ]);
        State::create([
            'name'=>strtolower('MUMBAI')
        ]);
        State::create([
            'name'=>strtolower('NORTH EAST')
        ]);
        State::create([
            'name'=>strtolower('ORISSA')
        ]);
        State::create([
            'name'=>strtolower('PUNJAB')
        ]);
        State::create([
            'name'=>strtolower('RAJASTHAN')
        ]);
        State::create([
            'name'=>strtolower('TAMIL NADU')
        ]);
        State::create([
            'name'=>strtolower('UP EAST')
        ]);
        State::create([
            'name'=>strtolower('UP WEST')
        ]);
        State::create([
            'name'=>strtolower('WEST BENGAL')
        ]);
        State::create([
            'name'=>strtolower('DELHI NCR')
        ]);
        State::create([
            'name'=>strtolower('ANDHRA PRADESH')
        ]);
        State::create([
            'name'=>strtolower('Delhi/NCR')
        ]);
        State::create([
            'name'=>strtolower('UTTARAKHAND')
        ]);
        State::create([
            'name'=>strtolower('JHARKHAND')
        ]); */

        PaymentMode::create([
            'name'=>strtolower('IMPS')
        ]);
        PaymentMode::create([
            'name'=>strtolower('NEFT')
        ]);
        PaymentMode::create([
            'name'=>strtolower('NET BANKING')
        ]);
        PaymentMode::create([
            'name'=>strtolower('CASH')
        ]);
        PaymentMode::create([
            'name'=>strtolower('OTHER')
        ]);
       
    }
}
