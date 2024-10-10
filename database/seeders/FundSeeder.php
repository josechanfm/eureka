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
            'title'=>'基於人工智能的多肽藥物設計大模型',
            'responsible'=>'魏樂義',
            'amount'=>'2095000',
            'type'=>'U',
            'duration'=>'36',
            'grant'=>'6',
            'grants'=>["835,000","630,000","63,000"],
            'is_submitted'=>true,
            'is_closed'=>false,
            'owner_id'=>1,
            'repayments'=>[]
        ]);
        $fund->users()->attach(User::where('username','LIKE',"%member%")->get());

        $items=[
            ['category_item_id'=>'1','sequence'=>'1','description'=>' 本地研究人員津貼費','amount'=>'950000','splits'=>[
                ['sequence'=>'1','description'=>'魏樂義','amount'=>'150000'],
                ['sequence'=>'2','description'=>'姚小軍','amount'=>'100000'],
                ['sequence'=>'3','description'=>'郭晶晶','amount'=>'100000'],
                ['sequence'=>'4','description'=>'段宏亮','amount'=>'150000'],
                ['sequence'=>'5','description'=>'博士研究助理','amount'=>null]
            ]],
            ['category_item_id'=>'2','sequence'=>'1','description'=>'外聘專家顧問費 ','amount'=>'180000','splits'=>[
                ['sequence'=>'1','description'=>'外聘專家(待定)','amount'=>'180000'],
            ]],
            ['category_item_id'=>'3','sequence'=>'1','description'=>'儀器設備費 ','amount'=>'150000','splits'=>[
                ['sequence'=>'1','description'=>'計算用伺服器','amount'=>'150000'],
            ]],
            ['category_item_id'=>'4','sequence'=>'1','description'=>'可消耗性材料、試劑及維修設備費 ','amount'=>'52000','splits'=>[
                ['sequence'=>'1','description'=>'計算用顯卡','amount'=>'52000'],
            ]],
            ['category_item_id'=>'4','sequence'=>'2','description'=>'可消耗性材料、試劑及維修設備費 ','amount'=>'5000','splits'=>[
                ['sequence'=>'1','description'=>'伺服器固態硬碟','amount'=>'5000']
            ]],
            ['category_item_id'=>'6','sequence'=>'1','description'=>'出席會議費 ','amount'=>'120000','splits'=>[
                ['sequence'=>'1','description'=>'國內會議','amount'=>null],
                ['sequence'=>'2','description'=>'國內差旅費','amount'=>null]
            ]],
            ['category_item_id'=>'7','sequence'=>'1','description'=>'研究差旅費','amount'=>'90000','splits'=>[
                ['sequence'=>'1','description'=>'國內差旅費','amount'=>null],
                ['sequence'=>'2','description'=>'國際差旅費','amount'=>null]

            ]],
            ['category_item_id'=>'8','sequence'=>'1','description'=>' 出版/文獻費 ','amount'=>'70000','splits'=>[
                ['sequence'=>'1','description'=>'出版費','amount'=>'70000']
            ]],
            ['category_item_id'=>'9','sequence'=>'1','description'=>'第三方財務審計費用 ','amount'=>'10000','splits'=>[
                ['sequence'=>'1','description'=>'第三方財務審計費用','amount'=>'10000']
            ]],
        ];
        foreach($items as $item){
            $splits=$item['splits'];
            unset($item['splits']);
            $fundItem=$fund->items()->create($item);
            foreach($splits as $split){
                $fundItem->splits()->create($split);
            }
        }
    }
}


