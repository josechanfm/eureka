<?php

namespace Database\Seeders;

use App\Models\CategoryItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Fund;
use App\Models\Category;
use App\Models\CategoryItemAccount;

class BudgetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fund=Fund::find(1);
        $budgetItems=$fund->items;
        $category=Category::where('type','FDCT')->first();
        $budget=$fund->budgets()->create([
            'category_id'=>$category->id,
            'year'=>'2024',
            'title'=>'項目啓動經費',
            'owner_id'=>1,
            'status'=>'S0'
        ]);
        $budget->items()->create([
            'description'=>'張三李四黃五',
            'fund_item_split_id'=>1,
            'amount'=>'100',
            'category_item_account_id'=>CategoryItemAccount::find(1)->id,
            'account_code'=>null,
        ]);
        $budget->items()->create([
            'description'=>'李四',
            'fund_item_split_id'=>5,
            'amount'=>'200',
            'category_item_account_id'=>CategoryItemAccount::find(5)->id,
            'account_code'=>null,
        ]);
        $budget->items()->create([
            'description'=>'黃五',
            'fund_item_split_id'=>6,
            'amount'=>'300',
            'category_item_account_id'=>CategoryItemAccount::find(6)->id,
            'account_code'=>null,
        ]);
        // foreach($budgetItems as $budgetItem){
        //     foreach($budgetItem->accounts as $budgetAccount){
        //         $budget->item()->create([
        //             'fund_item_account_id'=>$budgetAccount->id,
        //             'description'=>'輸入'.$budgetAccount->description,
        //         ]);
        //     }
        // }
        
    }
}
