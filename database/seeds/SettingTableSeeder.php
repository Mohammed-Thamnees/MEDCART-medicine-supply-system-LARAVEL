<?php

use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=array(
            'description'=>"Kottakkal arya vaidya sala medicine supply center",
            'short_des'=>"Tirur branch",
            //'photo'=>"image.jpg",
            'logo'=>'logo.jpg',
            'address'=>"kottakkal avs",
            'email'=>"avs@gmail.com",
            'phone'=>"9895157065",
        );
        DB::table('settings')->insert($data);
    }
}
