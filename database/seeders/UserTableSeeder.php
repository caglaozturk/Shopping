<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Faker\Generator as Faker;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        $user_admin = User::create([
            'fullname' => 'Çağla Öztürk',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123'),
            'activation_key' => Str::random(60),
            'is_active' => 1,
            'is_admin' => 1
        ]);

        $user_admin->detail()->create([
            'address' => 'Avcılar',
            'phone_number' => '5324121122',
            'mobile_number' => '5459635241'
        ]);

        for($i=0; $i<30; $i++){
            $user_customer = User::create([
                'fullname' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('123'),
                'is_active' => 1,
                'is_admin' => 0
            ]);
    
            $user_customer->detail()->create([
                'address' => $faker->address,
                'phone_number' => $faker->e164PhoneNumber,
                'mobile_number' => $faker->e164PhoneNumber
            ]);
        }

        Schema::enableForeignKeyConstraints();
    }
}
