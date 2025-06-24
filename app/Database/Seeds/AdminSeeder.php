<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\Shield\Models\UserModel;

class AdminSeeder extends Seeder
{
    public function run()
    {
        $users = new UserModel();

        $userId = $users->insert([
            'username' => 'admin',
            'email'    => 'admin@example.com',
            'password' => 'admin123', // Shield akan hash otomatis
        ]);

        // Beri peran admin biasa
        $users->assignGroup($userId, 'admin');
    }
}
