<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;


class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Crisandy Gomez',
                'email' => 'GomezCrisandy@gmail.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Jerald Maca',
                'email' => 'JeraldMaca@gmail.com',
                'password' => password_hash('2311600073', PASSWORD_DEFAULT),
                'role' => 'student',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Jim Jamero',
                'email' => 'Jamero@gail.com',
                'password' => password_hash('prof123', PASSWORD_DEFAULT),
                'role' => 'teacher',
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];
        // Insert all data in one go
        $this->db->table('users')->insertBatch($data);
    }
}
