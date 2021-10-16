<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%task}}`.
 */
class m211016_074342_create_task_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%task}}', [
            'id' => $this->primaryKey(),
            'title' => $this->text()->notNull(),
            'priority' => $this->integer()->defaultValue(0),
            'done' => $this->boolean()->defaultValue(false),
            'version' => $this->bigInteger(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%task}}');
    }
}
