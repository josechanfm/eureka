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
                'type'=>'FDCT',
                'version'=>'2024',
                'title_zh'=>'校內項目',
                'active'=>true
            ]
        );
        $data=[
            ["name_zh"=>"本地研究人員津貼費","account"=>[
                ["name_zh"=>"個人津貼(公職校內人員)","user_define"=>false,"account_code"=>"1-31-02-99-00-00-01.280.Z01"],
                ["name_zh"=>"個人津貼(公職校外人員)","user_define"=>false,"account_code"=>"1-31-02-99-00-00-99.280.Z01"],
                ["name_zh"=>"個人津貼(非公職校外人員)","user_define"=>false,"account_code"=>"1-32-02-23-00-00-99.280.Z01"],
                ["name_zh"=>"本校全日制學士學生津貼","user_define"=>false,"account_code"=>"1-32-02-15-00-00-01.280.Z01"],
                ["name_zh"=>"本校全日制研究生津貼","user_define"=>false,"account_code"=>"1-32-02-15-00-00-02.280.Z01"],
                ["name_zh"=>"(用家自定)","user_define"=>true,"account_code"=>"GF手動輸入"]
            ]],
            ["name_zh"=>"外聘專家顧問費","account"=>[
                ["name_zh"=>"(用家自定)","user_define"=>false,"account_code"=>"1-32-02-23-00-00-99.280.Z01"]
            ]],
            ["name_zh"=>"儀器設備費","account"=>[
                ["name_zh"=>"實驗室/工場/工作室設備","user_define"=>false,"account_code"=>"1-41-02-08-00-00-01.280.Z01"],
                ["name_zh"=>"資訊及系統設備","user_define"=>false,"account_code"=>"1-41-02-10-00-00-01.280.Z01"],
                ["name_zh"=>"軟件及版權","user_define"=>false,"account_code"=>"1-41-03-01-00-00-01.280.Z01"],
                ["name_zh"=>"辦公設備","user_define"=>false,"account_code"=>"1-41-02-13-00-00-01.280.Z01"],
                ["name_zh"=>"(用家自定)","user_define"=>true,"account_code"=>"GF手動輸入"],
            ]],
            ["name_zh"=>"可消耗性材料、試劑及維修設備費","account"=>[
                ["name_zh"=>"參考書籍","user_define"=>false,"account_code"=>"1-41-02-12-00-00-01.280.Z01"],
                ["name_zh"=>"數據","user_define"=>false,"account_code"=>"1-32-02-01-02-00-99.280.Z01"],
                ["name_zh"=>"圖像資料 (版權類)","user_define"=>false,"account_code"=>"1-41-03-01-00-00-01.280.Z01"],
                ["name_zh"=>"音像產品 (CD類)","user_define"=>false,"account_code"=>"1-32-01-99-00-00-01.280.Z01"],
                ["name_zh"=>"音像產品 (版權類)","user_define"=>false,"account_code"=>"1-41-03-01-00-00-01.280.Z01"],
                ["name_zh"=>"資料檢索","user_define"=>false,"account_code"=>"1-32-02-01-02-00-99.280.Z01"],
                ["name_zh"=>"量表","user_define"=>false,"account_code"=>"1-23-567"],
                ["name_zh"=>"實驗室試劑","user_define"=>false,"account_code"=>"1-32-01-01-00-00-01.280.Z01"],
                ["name_zh"=>"維護費及維修費","user_define"=>false,"account_code"=>"1-32-02-01-01-00-99.280.Z01"],
                ["name_zh"=>"(用家自定)","user_define"=>true,"account_code"=>"GF手動輸入"],
            ]],
            ["name_zh"=>"協作/合作費","account"=>[
                ["name_zh"=>"(用家自定)","user_define"=>false,"account_code"=>"1-32-02-23-00-00-99.280.Z01"],
            ]],
            ["name_zh"=>"出席會議費","account"=>[
                ["name_zh"=>"國內會議-註冊費","user_define"=>false,"account_code"=>"1-32-02-14-00-00-02.280.Z01"],
                ["name_zh"=>"國內會議-非本地交通費","user_define"=>false,"account_code"=>"1-32-02-09-01-00-01.280.Z01"],
                ["name_zh"=>"國內會議-住宿費","user_define"=>false,"account_code"=>"1-32-02-08-01-00-02.280.Z01"],
                ["name_zh"=>"國內會議-餐費","user_define"=>false,"account_code"=>"1-32-02-99-00-00-99.280.Z01"],
                ["name_zh"=>"國際會議-註冊費","user_define"=>false,"account_code"=>"1-32-02-14-00-00-02.280.Z01"],
                ["name_zh"=>"國際會議-非本地交通費","user_define"=>false,"account_code"=>"1-32-02-09-01-00-01.280.Z01"],
                ["name_zh"=>"國際會議-住宿費","user_define"=>false,"account_code"=>"1-32-02-08-01-00-02.280.Z01"],
                ["name_zh"=>"國際會議-餐費","user_define"=>false,"account_code"=>"1-32-02-99-00-00-99.280.Z01"],
                ["name_zh"=>"(用家自定)","user_define"=>true,"account_code"=>"GF手動輸入"],
            ]],
            ["name_zh"=>"研究差旅費","account"=>[
                ["name_zh"=>"差旅-非本地交通費","user_define"=>false,"account_code"=>"1-32-02-09-01-00-01.280.Z01"],
                ["name_zh"=>"差旅-住宿費","user_define"=>false,"account_code"=>"1-32-02-08-01-00-02.280.Z01"],
                ["name_zh"=>"差旅-餐費","user_define"=>false,"account_code"=>"1-32-02-99-00-00-99.280.Z01"],
                ["name_zh"=>"(用家自定)","user_define"=>true,"account_code"=>"GF手動輸入"],
            ]],
            ["name_zh"=>"出版/文獻費","account"=>[
                ["name_zh"=>"線上出版費","user_define"=>false,"account_code"=>"1-32-02-01-02-00-99.280.Z01"],
                ["name_zh"=>"線下出版費","user_define"=>false,"account_code"=>"1-32-02-13-00-00-01.280.Z01"],
                ["name_zh"=>"購買文獻費","user_define"=>false,"account_code"=>"1-23-456"],
                ["name_zh"=>"(用家自定)","user_define"=>true,"account_code"=>"GF手動輸入"],
            ]],
            ["name_zh"=>"第三方財務審計費用","account"=>[
                ["name_zh"=>"財務審計費用","user_define"=>false,"account_code"=>"1-32-02-19-00-00-02.280.Z01"],
                ["name_zh"=>"(用家自定)","user_define"=>true,"account_code"=>"GF手動輸入"],
            ]],
            ["name_zh"=>"其它","account"=>[
                ["name_zh"=>"紀念品","user_define"=>false,"account_code"=>"1-32-01-10-00-00-01.280.Z01"],
                ["name_zh"=>"郵寄/包裹費","user_define"=>false,"account_code"=>"1-32-02-06-00-00-99.280.Z01"],
                ["name_zh"=>"通訊費","user_define"=>false,"account_code"=>"1-32-02-06-00-00-99.280.Z01"],
                ["name_zh"=>"文具","user_define"=>false,"account_code"=>"1-32-01-04-00-00-01.280.Z01"],
                ["name_zh"=>"掃瞄費","user_define"=>false,"account_code"=>"1-32-01-04-00-00-01.280.Z01"],
                ["name_zh"=>"複印費/打印費/印刷費","user_define"=>false,"account_code"=>"1-32-01-04-00-00-01.280.Z01"],
                ["name_zh"=>"非本地人員的本地交通費","user_define"=>false,"account_code"=>"1-32-02-09-01-00-02.280.Z01"],
                ["name_zh"=>"非本地人員的本地住宿費","user_define"=>false,"account_code"=>"1-32-02-08-01-00-99.280.Z01"],
                ["name_zh"=>"非本地人員的本地餐費","user_define"=>false,"account_code"=>"1-32-02-99-00-00-99.280.Z01"],
                ["name_zh"=>"測試/檢測費","user_define"=>false,"account_code"=>"1-32-02-23-00-00-99.280.Z01"],
                ["name_zh"=>"專利申請費","user_define"=>false,"account_code"=>"1-32-02-99-00-00-99.280.Z01"],
                ["name_zh"=>"醫療器械註冊證書","user_define"=>false,"account_code"=>"1-32-02-99-00-00-99.280.Z01"],
                ["name_zh"=>"結題鑑定費","user_define"=>false,"account_code"=>"1-32-02-99-00-00-99.280.Z01"],
                ["name_zh"=>"(用家自定)","user_define"=>true,"account_code"=>"GF手動輸入"],
                                
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
