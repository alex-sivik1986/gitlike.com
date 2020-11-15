<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%reposit}}`.
 */
class m201115_110457_create_reposit_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%reposit}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(64),
            'like' => $this->integer(9),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%reposit}}');
    }
}
