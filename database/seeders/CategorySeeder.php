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
                    "account_code"=>"ABC-01-0001-1"
                ],[
                    "name_zh"=>"校內在讀本科生及研究生",
                    "account_code"=>"ABC-01-0001-2"
                ],[
                    "name_zh"=>"本地研究員/專家/專業人士",
                    "account_code"=>"ABC-01-0001-3"
                ],
            ]],
            ["name_zh"=>"外聘專家顧問費","account"=>[
                [
                    "name_zh"=>"外聘專家顧問費---1",
                    "account_code"=>"ABC-02-0002-1"
                ],
                [
                    "name_zh"=>"外聘專家顧問費---2",
                    "account_code"=>"ABC-02-0002-2"
                ],
                [
                    "name_zh"=>"外聘專家顧問費---3",
                    "account_code"=>"ABC-02-0002-3"
                ]
            ]],
            ["name_zh"=>"儀器設備費","account"=>[
                [
                    "name_zh"=>"儀器設備費---1",
                    "account_code"=>"ABC-02-0003-1"
                ],[
                    "name_zh"=>"儀器設備費---2",
                    "account_code"=>"ABC-02-0003-2"
                ],[
                    "name_zh"=>"儀器設備費---3",
                    "account_code"=>"ABC-02-0003-3"
                ]
            ]],
            ["name_zh"=>"可消耗性才料、試劑及維修設備費","account"=>[
                [
                    "name_zh"=>"消耗性才料---1",
                    "account_code"=>"ABC-02-0004-1"
                ],[
                    "name_zh"=>"消耗性才料---2",
                    "account_code"=>"ABC-02-0004-2"
                ],[
                    "name_zh"=>"消耗性才料---3",
                    "account_code"=>"ABC-02-0004-3"
                ]
            ]],
            ["name_zh"=>"協作/合作費","account"=>[
                [
                    "name_zh"=>"協作/合作費---1",
                    "account_code"=>"ABC-02-0005-1"
                ],[
                    "name_zh"=>"協作/合作費---2",
                    "account_code"=>"ABC-02-0005-2"
                ],[
                    "name_zh"=>"協作/合作費---3",
                    "account_code"=>"ABC-02-0005-3"
                ]
            ]],
            ["name_zh"=>"因執行項目而衍生之其他開支","account"=>[
                [
                    "name_zh"=>"其他開支---1",
                    "account_code"=>"ABC-02-0006-1"
                ],[
                    "name_zh"=>"其他開支---2",
                    "account_code"=>"ABC-02-0006-2"
                ],[
                    "name_zh"=>"其他開支---3",
                    "account_code"=>"ABC-02-0006-3"
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
