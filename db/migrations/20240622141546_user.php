<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class User extends AbstractMigration
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
        $users = $this->table('users', ['id' => false, 'primary_key' => 'user_id']);
        $users->addColumn('user_id', 'integer', ['identity' => true])
            ->addColumn('nama', 'string', ['limit' => 100])
            ->addColumn('npm', 'string', ['limit' => 9])
            ->addColumn('fakultas', 'string', ['limit' => 50])
            ->addColumn('prodi', 'enum', ['values' => ['Manajemen Informatika', 'Komputerisasi Akutansi']])
            ->addColumn('email', 'string', ['limit' => 64])
            ->addColumn('username', 'string', ['limit' => 64])
            ->addColumn('password', 'string', ['limit' => 255])
            ->addColumn('role', 'enum', ['values' => ['admin', 'user'], 'default' => 'user'])
            ->create();

        $users->addIndex(['username'], ['unique' => true])
            ->addIndex(['email'], ['unique' => true])
            ->addIndex(['npm'], ['unique' => true])
            ->update();
    }
}