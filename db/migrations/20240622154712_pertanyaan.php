<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Pertanyaan extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change(): void
    {
        $pertanyaan = $this->table('pertanyaan');
        $pertanyaan->addColumn('indikator_id', 'integer', ['null' => false, 'signed' => false])
            ->addColumn('pertanyaan', 'string', ['limit' => 255, 'null' => false])
            ->addForeignKey('indikator_id', 'indikator', 'id', ['delete' => 'NO_ACTION', 'update' => 'NO_ACTION'])
            ->create();
    }
}
