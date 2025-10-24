<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'teacher_id' => 3, // Jim Jamero (teacher)
                'course' => 'Introduction to Programming',
                'description' => 'Learn the basics of programming with hands-on exercises and projects.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'teacher_id' => 3, // Jim Jamero (teacher)
                'course' => 'Web Development Fundamentals',
                'description' => 'Build modern websites using HTML, CSS, and JavaScript.',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'teacher_id' => 3, // Jim Jamero (teacher)
                'course' => 'Database Design',
                'description' => 'Learn how to design and implement relational databases.',
                'created_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Insert all data in one go
        $this->db->table('courses')->insertBatch($data);
    }
}
