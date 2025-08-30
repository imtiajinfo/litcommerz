<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $datas =  [
            // Email Configuration
            [
                'menu_show' => 1,
                'menu_name' => 'Mail Setting',
                'level' => 2,
                'parent_menu' => 0,
                'parent_menu_id' => 25,
                'module' => 1,
                'base_url' => 'mailSetting',
                'route' => 'admin.mailSetting.index',
                'active' => 1,
                'serial' => 12,
                'icon' => '',
            ],
            [
                'menu_show' => 0,
                'menu_name' => 'Mail Setting Update',
                'level' => 0,
                'parent_menu' => 0,
                'parent_menu_id' => 0,
                'module' => 1,
                'base_url' => 'mailSetting/store',
                'route' => 'admin.mailSetting.store',
                'active' => 1,
                'serial' => 0,
                'icon' => null,
            ],
        ];
        // \App\Models\Product::where('id', '>', 0)->update([
        //     'offer_amount' => 0,
        // ]);
        foreach($datas as $data){
           $a = \App\Models\Menu::create($data);
        }
    }
}
