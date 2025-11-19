<?php

use Phinx\Migration\AbstractMigration;

class CreateEstoqueTable extends AbstractMigration
{
    public function change()
    {
        $table = $this->table('estoque', [
            'id' => false,
            'primary_key' => 'produto_id'
        ]);

        $table->addColumn('produto_id', 'biginteger', ['signed' => false])
            ->addColumn('quantidade', 'integer', ['default' => 0])
            ->addColumn('estoque_minimo', 'integer', ['default' => 5])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('updated_at', 'timestamp', ['null' => true])

            ->addForeignKey('produto_id', 'produtos', 'id', [
                'delete' => 'CASCADE',
                'update' => 'NO_ACTION'
            ])

            ->addIndex('produto_id', ['unique' => true])

            ->create();
    }
}
