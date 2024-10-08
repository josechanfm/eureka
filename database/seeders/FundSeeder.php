<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Fund;
use App\Models\FundItem;
use App\Models\Category;
use App\Models\CategoryItemAccount;
use App\Models\User;

class FundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category=Category::where('type','FDCT')->first();
        $fund=Fund::create([
            'category_id'=>$category->id,
            // 'entity'=>'MPU',
            // 'declarant'=>'Jose',
            // 'birm'=>'12345678',
            'project_code'=>'P04-1234-5',
            'title'=>'Research funding budget management system',
            'responsible'=>'Simon',
            'amount'=>'123,456.00',
            'type'=>'P',
            'duration'=>'36',
            'grant'=>'6',
            'grants'=>["10,000","20,000","30,000","40,000","50,000","60,000"],
            'is_submitted'=>false,
            'is_closed'=>false,
            'owner_id'=>1,
            'repayments'=>[]
        ]);
        $fund->users()->attach(User::where('username','LIKE',"%member%")->get());

        $categoryItems=$category->items;
        foreach($categoryItems as $i=>$item){
            $splits=$item->accounts;
            foreach($splits as $i=>$a){
                $fundItem=$fund->items()->create([
                    'category_item_id'=>$item->id,
                    'sequence'=>$i,
                    'description'=>$item->name_zh,
                    'amount'=>100000+($i*10000)
                ]);
    
                $fundItem->splits()->create([
                    'sequence'=>1,
                    'description'=>$a->name_zh,
                    'amount'=>null
                ]);
            }
        }
        $fundItem=FundItem::find(5);
        //$categoryItemAccount=CategoryItemAccount::find(1);
        $fundItem->splits()->create([
            'sequence'=>2,
            'description'=>'Additional item',
            'amount'=>'1000',
           //'description'=>$categoryItemAccount->name_zh.' B',
        ]);
        $fundItem=FundItem::find(7);
        $categoryItemAccount=CategoryItemAccount::find(7);
        $fundItem->splits()->create([
            'sequence'=>2,
            'description'=>'Additional item',
            'amount'=>'2000',
           //'description'=>$categoryItemAccount->name_zh.' B',
        ]);
    }
}


