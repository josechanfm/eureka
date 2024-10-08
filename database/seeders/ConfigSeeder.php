<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Config;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Config::create(
            ['key'=>'fund_categories','content'=>
                [
                    [
                        "value"=> "INTERNAL",
                        "label"=> "校內項目",
                        "initial"=>'I'
                    ],[
                        "value"=> "FDCT",
                        "label"=> "科技發展基金項目",
                        "initial"=>'F'
                    ],[
                        "value"=> "DELEGATE",
                        "label"=> "校外委託項目",
                        "initial"=>'E'
                    ]
                ]
            ]
        );
    }
}
