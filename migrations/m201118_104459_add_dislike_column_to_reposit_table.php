<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%reposit}}`.
 */
class m201118_104459_add_dislike_column_to_reposit_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%reposit}}', 'dislike', $this->integer(7));
        $this->addColumn('{{%reposit}}', 'id_list', $this->integer(9));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%reposit}}', 'dislike');
        $this->dropColumn('{{%reposit}}', 'id_list');
    }
}
