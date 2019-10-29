<?php
use Illuminate\Database\Seeder;
use App\Store\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => 'admin@test.com',
            'name' => 'admin',
            'role' => 'admin',
            'password' => bcrypt('admin@123')
        ]);

        User::create([
            'email' => 'shane@test.com',
            'name' => 'Shane White',
            'role' => 'user',
            'password' => bcrypt('hank@123')
        ]);

        User::create([
            'email' => 'adam@test.com',
            'name' => 'Adam David',
            'role' => 'user',
            'password' => bcrypt('jesse@123')
        ]);
    }
}
