<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class Indikator extends AbstractSeed
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
                'indikator' => 'Proses Pembelajaran',
            ],
            [
                'indikator' => 'Layanan Akademik',
            ],
            [
                'indikator' => 'Layanan Kemahasiswaan',
            ],
            [
                'indikator' => 'Sarana dan Prasarana',
            ]
        ];

        $this->table('indikator')->insert($data)->save();
    }
}
