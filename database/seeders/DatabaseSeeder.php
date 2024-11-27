<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        DB::table('users')->insert([
            'email' => 'abu22'.'@gmail.com',//
            'password' => Hash::make('123456'),
            'name' => 'abu bakar',//
            'phone' => '0148254347',//
            'ic' => '962311115669',//
            'role' => 1,
            'date_register' => '2024-10-19 00:44:09',
            'toyyip_key' => Crypt::encryptString('da7oi8t1-1ifp-oa5q-crgp-kbfjwradgutt'),
            'toyyip_category' => Crypt::encryptString('ndp79143'),
            'email_verified_at' => '2024-10-20 00:10:50',
        ]);

        DB::table('companies')->insert([
            'user_email' => 'abu22'.'@gmail.com',//
            'logo' => 'logo.jpg',//

        ]);

        DB::table('users')->insert([
            'email' => 'ali22'.'@gmail.com',//
            'password' => Hash::make('123456'),
            'name' => 'ali bakar',//
            'phone' => '0148254357',//
            'ic' => '962311115670',//
            'role' => 2,
            'date_register' => '2024-10-19 00:44:09',
            'toyyip_key' => Crypt::encryptString(''),
            'toyyip_category' => Crypt::encryptString(''),
            'email_verified_at' => '2024-10-20 00:10:50',
        ]);

        DB::table('companies')->insert([
            'user_email' => 'ali22'.'@gmail.com',//
            'logo' => 'logo.jpg',//

        ]);

        DB::table('employees')->insert([
            'email' => 'ali22'.'@gmail.com',//
            'name' => 'ali bakar',//
            'gender' => 'male',
            'work_id' => 'w2335',//
            'phone' => '0148254347',//
            'address' => '358 kg losong panglima perang, 21000, kuala terengganu, terengganu.',//
            'address2' => '358 ',//
            'ic' => '962311115670',//
            'birthday' => '2023-10-10',//
            'position' => 'staff',//
            'user_email' => 'abu22'.'@gmail.com',//
            'date_register' => '2024-10-19 00:44:09',
        ]);

        DB::table('employees')->insert([
            'email' => 'atan22'.'@gmail.com',//
            'name' => 'atan bakar',//
            'gender' => 'male',
            'work_id' => 'w2336',//
            'phone' => '0148254347',//
            'address' => '358 kg losong panglima perang, 21000, kuala terengganu, terengganu.',//
            'address2' => '358 ',//
            'ic' => '962311115668',//
            'birthday' => '2023-10-10',//
            'position' => 'staff',//
            'user_email' => 'abu22'.'@gmail.com',//
            'date_register' => '2024-10-19 00:44:09',
    
        ]);

        DB::table('customers')->insert([
            'email' => 'atan22'.'@gmail.com',//
            'name' => 'atan bakar',//
            'phone' => '0148254347',//
            'address' => '358 kg losong panglima perang, 21000, kuala terengganu, terengganu.',//
            'ic' => '962311115668',//
            'point' => 0,//
            'user_email' => 'abu22'.'@gmail.com',//
        ]);

        DB::table('items')->insert([

            'name' => 'atan bakar',//
            'shortcode' => 'mee segere',//
            'picture' => 'empty.png',//
            'category' => 'retail',//
            'cost' => 5,//
            'price' => 6,//
            'quantity' => 0,//
            'user_email' => 'abu22'.'@gmail.com',//
        ]);

    }
}
