<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class Pilihan extends AbstractSeed
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
            ['pilihan' => 'Tidak baik'],
            ['pilihan' => 'Kurang baik'],
            ['pilihan' => 'Cukup baik'],
            ['pilihan' => 'Baik'],
            ['pilihan' => 'Sangat baik'],
        ];

        $this->table('pilihan')->insert($data)->save();
    }
}
