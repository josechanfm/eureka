<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FundCategory;

class FundCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $funCategory=FundCategory::create(
            [
                'title_zh'=>'校內項目',
            ]
        );
        $data=[
            ["fund_category_id"=>$funCategory->id,"name_zh"=>"本地研究人員津貼費用"],
            ["fund_category_id"=>$funCategory->id,"name_zh"=>"外聘專家顧問費"],
            ["fund_category_id"=>$funCategory->id,"name_zh"=>"儀器設備費"],
            ["fund_category_id"=>$funCategory->id,"name_zh"=>"可消耗性才料、試劑及維修設備費"],
            ["fund_category_id"=>$funCategory->id,"name_zh"=>"協作/合作費"],
            ["fund_category_id"=>$funCategory->id,"name_zh"=>"因執行項目而衍生之其他開支"]
    
        ];
        $funCategory->items->upsert($data);
    }
}
