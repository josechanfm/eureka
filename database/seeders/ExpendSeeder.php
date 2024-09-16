<?php

namespace Database\Seeders;

use App\Models\CategoryItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Fund;
use App\Models\Expend;
use App\Models\CategoryItemAccount;

class ExpendSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fund=Fund::find(1);
        $expendItems=$fund->items;
        $expend=$fund->expends()->create([
            'year'=>'2024',
            'title'=>'項目啓動經費',
            'owner_id'=>1,
        ]);

        $expend->items()->create([
            'description'=>'張三李四黃五',
            'fund_item_split_id'=>1,
            'amount'=>'100',
            'account_code'=>CategoryItemAccount::find(1)->account_code,
        ]);
        $expend->items()->create([
            'description'=>'李四',
            'fund_item_split_id'=>5,
            'amount'=>'200',
            'account_code'=>CategoryItemAccount::find(5)->account_code,
        ]);
        $expend->items()->create([
            'description'=>'黃五',
            'fund_item_split_id'=>6,
            'amount'=>'300',
            'account_code'=>CategoryItemAccount::find(6)->account_code,
        ]);
        // foreach($expendItems as $expendItem){
        //     foreach($expendItem->accounts as $expendAccount){
        //         $expend->item()->create([
        //             'fund_item_account_id'=>$expendAccount->id,
        //             'description'=>'輸入'.$expendAccount->description,
        //         ]);
        //     }
        // }
        
    }
}
