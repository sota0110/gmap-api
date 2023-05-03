<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class CreateNotes extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('notes');
        $table->addColumn('name', 'string', [
            'default' => null,
            'limit' => 255,
            'null' => false,
        ]);
        $table->addColumn('address', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('latitude', 'float', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('longitude', 'float', [
            'default' => null,
            'null' => true,
        ]);
        $table->addColumn('memo', 'text', [
            'default' => null,
            'null' => true,
        ]);
        $table->create();
    }
}
