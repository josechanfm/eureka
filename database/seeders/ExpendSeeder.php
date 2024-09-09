<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Fund;
use App\Models\Expend;

class ExpendSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fund=Fund::find(1);
        $expendItems=$fund->items;
        $expend=$fund->expends->create([
            'title'=>'項目啓動經費'
        ]);
        foreach($expendItems as $expendItem){
            foreach($expendItem->accounts as $expendAccount){
                $expend->item()->create([
                    'fund_item_account_id'=>$expendAccount->id,
                    'description'=>'輸入'.$expendAccount->description,
                ]);
            }
        }
        
    }
}
