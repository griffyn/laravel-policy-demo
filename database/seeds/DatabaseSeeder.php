<?php
use App\Models\User;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            [
                'username' => 'admin',
                'password' => Hash::make('123123'),
                'type' => 'admin',
            ]
        );
    }
}
