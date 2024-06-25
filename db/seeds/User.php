<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class User extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     */
    public function run(): void
    {
        $data = [
            [
                'nama' => 'John Doe',
                'npm' => 'admin',
                'email' => 'johndoe@example.com',
                'username' => 'admin',
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'role' => 'admin',
            ],
            [
                'nama' => 'Jane Doe',
                'npm' => '987654321',
                'fakultas' => 'Ekonomi',
                'prodi' => 'Komputerisasi Akutansi',
                'email' => 'janedoe@example.com',
                'username' => 'janedoe',
                'password' => password_hash('password', PASSWORD_DEFAULT),
            ],
            [
                'nama' => 'Jane Doe',
                'npm' => '98765432',
                'fakultas' => 'Ekonomi',
                'prodi' => 'Manajemen Informatika',
                'email' => 'janedoe1@example.com',
                'username' => 'janedoe1',
                'password' => password_hash('password', PASSWORD_DEFAULT),
            ],
            [
                'nama' => 'Jane Doe',
                'npm' => '9876543',
                'fakultas' => 'Ekonomi',
                'prodi' => 'Komputerisasi Akutansi',
                'email' => 'janedoe2@example.com',
                'username' => 'janedoe2',
                'password' => password_hash('password', PASSWORD_DEFAULT),
            ],
            [
                'nama' => 'Jane Doe',
                'npm' => '987654',
                'fakultas' => 'Ekonomi',
                'prodi' => 'Komputerisasi Akutansi',
                'email' => 'janedoe3@example.com',
                'username' => 'janedoe3',
                'password' => password_hash('password', PASSWORD_DEFAULT),
            ],

        ];

        $users = $this->table('users');
        $users->insert($data)->save();
    }
}