<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category=Category::create(
            [
                'title_zh'=>'校內項目',
            ]
        );
        $data=[
            ["name_zh"=>"本地研究人員津貼費用","account"=>[
                [
                    "name_zh"=>"校內教職人員",
                    "account_code"=>"ABC-01-1234-5"
                ],[
                    "name_zh"=>"校內在讀本科生及研究生",
                    "account_code"=>"ABC-01-1234-5"
                ],[
                    "name_zh"=>"本地研究員/專家/專業人士",
                    "account_code"=>"ABC-01-1234-5"
                ],
            ]],
            ["name_zh"=>"外聘專家顧問費","account"=>[
                [
                    "name_zh"=>"顧問費",
                    "account_code"=>"ABC-02-1234-5"
                ]
            ]],
            ["name_zh"=>"儀器設備費","account"=>[
                [
                    "name_zh"=>"儀器",
                    "account_code"=>"ABC-02-1234-5"
                ]
            ]],
            ["name_zh"=>"可消耗性才料、試劑及維修設備費","account"=>[
                [
                    "name_zh"=>"設備費",
                    "account_code"=>"ABC-02-1234-5"
                ]
            ]],
            ["name_zh"=>"協作/合作費","account"=>[
                [
                    "name_zh"=>"協作/合作費",
                    "account_code"=>"ABC-02-1234-5"
                ]
            ]],
            ["name_zh"=>"因執行項目而衍生之其他開支","account"=>[
                [
                    "name_zh"=>"其他開支",
                    "account_code"=>"ABC-02-1234-5"
                ]
            ]]
        ];
        foreach($data as $d){
            $account=$d['account'];
            unset($d['account']);
            $categoryItem=$category->items()->create($d);
            foreach($account as $a){
                $categoryItem->accounts()->create($a);
            }
            
        }
        
    }
}
