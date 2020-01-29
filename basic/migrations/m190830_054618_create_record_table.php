<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%record}}`.
 */
class m190830_054618_create_record_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%record}}', [
            'id' => $this->primaryKey(),
            'type' => $this->string(),
            'date_time' => $this->dateTime(),
            'seconds' => $this->integer(),
            'samples' => $this->integer(),
            'info' => 'blob',
            'data' => 'blob'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%record}}');
    }
}
