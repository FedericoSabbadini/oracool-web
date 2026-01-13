<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;  
use Illuminate\Support\Facades\Hash;
use Illuminate\Suwpport\Str; 
use Illuminate\Support\Facades\DB; 

/**
 * Class UserSeeder
 *
 * Seeder for populating the users table with a default user and additional users.
 */
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'federico',
            'email' => 'federicosabbadini@icloud.com',
            'password' => Hash::make('sabbadini'),
            'remember_token' => Str::random(10),
            'admin' => true,
            'adminKey' => Hash::make('SBBFRC02A04B157M')
        ]);

        DB::table('sessions')->insert([
            'id' => Str::uuid(),
            'user_id' => $user->id,
            'payload' => '',
            'last_activity' => now()->timestamp,
        ]);

        User::factory()->count(9)->create();
    }
}
