<?php

declare(strict_types=1);

use Phinx\Seed\AbstractSeed;

class Jawaban extends AbstractSeed
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
        for ($i = 2; $i <= 5; $i++) {
            for ($j = 1; $j <= 4; $j++) {
                for ($k = 1; $k <= 6; $k++) {
                    $data = [
                        [
                            'user_id' => $i,
                            'indikator_id' => $j,
                            'pertanyaan_id' => $k,
                            'pilihan_id' => mt_rand(1, 5),
                        ],
                    ];
                    $this->table('jawaban')->insert($data)->save();
                }
            }
        }
    }
}
