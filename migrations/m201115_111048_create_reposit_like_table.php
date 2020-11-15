<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%reposit_like}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%reposit}}`
 * - `{{%user}}`
 */
class m201115_111048_create_reposit_like_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%reposit_like}}', [
            'id' => $this->primaryKey(),
            'reposit_id' => $this->integer(7),
            'user_id' => $this->integer(9),
            'like' => $this->integer(1)->NULL(),
            'dislike' => $this->integer(1)->NULL(),
        ]);

        // creates index for column `reposit_id`
        $this->createIndex(
            '{{%idx-reposit_like-reposit_id}}',
            '{{%reposit_like}}',
            'reposit_id'
        );

        // add foreign key for table `{{%reposit}}`
        $this->addForeignKey(
            '{{%fk-reposit_like-reposit_id}}',
            '{{%reposit_like}}',
            'reposit_id',
            '{{%reposit}}',
            'id',
            'CASCADE'
        );

        // creates index for column `user_id`
        $this->createIndex(
            '{{%idx-reposit_like-user_id}}',
            '{{%reposit_like}}',
            'user_id'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-reposit_like-user_id}}',
            '{{%reposit_like}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%reposit}}`
        $this->dropForeignKey(
            '{{%fk-reposit_like-reposit_id}}',
            '{{%reposit_like}}'
        );

        // drops index for column `reposit_id`
        $this->dropIndex(
            '{{%idx-reposit_like-reposit_id}}',
            '{{%reposit_like}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-reposit_like-user_id}}',
            '{{%reposit_like}}'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            '{{%idx-reposit_like-user_id}}',
            '{{%reposit_like}}'
        );

        $this->dropTable('{{%reposit_like}}');
    }
}
