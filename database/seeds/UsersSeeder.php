<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        DB::table('users')->insert(array (
            0 =>
                array (
                    'id' => 1,
                    'email' => 'izakruta@gmail.com',
                    'avatar' => null,
                    'name' => 'Ilya Zakruta',
                    'created_at' => '2019-02-01 16:20:34',
                    'updated_at' => '2019-02-01 19:26:28',
                    'phone' => null,
                    'password' => '$2y$10$qmxakkJHYHK5MmJ5bhkFOuYf/JOgUrGqAEtjm7Hitwt2aUQ0Xz.9K'
                ),
        ));
    }
}
