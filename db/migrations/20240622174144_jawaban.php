<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Jawaban extends AbstractMigration
{
    public function change(): void
    {
        $jawaban = $this->table('jawaban');
        $jawaban
            ->addColumn('user_id', 'integer', ['null' => false])
            ->addColumn('indikator_id', 'integer', ['null' => false, 'signed' => false])
            ->addColumn('pertanyaan_id', 'integer', ['null' => false, 'signed' => false])
            ->addColumn('pilihan_id', 'integer', ['null' => false, 'signed' => false])
            ->addForeignKey('user_id', 'users', 'user_id', ['delete' => 'CASCADE', 'update' => 'NO_ACTION'])
            ->addForeignKey('indikator_id', 'indikator', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->addForeignKey('pertanyaan_id', 'pertanyaan', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->addForeignKey('pilihan_id', 'pilihan', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->create();
    }
}
