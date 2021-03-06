<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data=array(
            array(
                'name'=>'Admin',
                'owner_name'=>'Admin',
                'place'=>'Tirur',
                'email'=>'admin@gmail.com',
                'number'=>'9895157065',
                'post'=>'Tirur',
                'pin'=>'676551',
                'mark'=>'Tirur',
                //'file'=>'Null',
                'password'=>Hash::make('1111'),
                'role'=>'admin',
                'status'=>'active'
            ),
            array(
                'name'=>'User',
                'owner_name'=>'User',
                'place'=>'Tirur',
                'email'=>'user@gmail.com',
                'number'=>'9895157066',
                'post'=>'Tirur',
                'pin'=>'676552',
                'mark'=>'Tirur',
                //'file'=>'Null',
                'password'=>Hash::make('1111'),
                'role'=>'user',
                'status'=>'active'
            ),
        );

        DB::table('users')->insert($data);
    }
}
