<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%result}}`.
 */
class m191118_075730_create_result_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%result}}', [
            'id' => $this->primaryKey(),
            'record_id' => $this->integer(),
            'front' => $this->integer(),
            'distance' => $this->integer(),
            'error' => $this->integer(),
            'confirmed' => $this->boolean()
        ]);
        
        $this->addForeignKey(
            'record_id',  // это "условное имя" ключа
            'result', // это название текущей таблицы
            'record_id', // это имя поля в текущей таблице, которое будет ключом
            'record', // это имя таблицы, с которой хотим связаться
            'id', // это поле таблицы, с которым хотим связаться
            'CASCADE',
            'CASCADE'
        );
    }
    

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'record_id',
            'result'
        );
        $this->dropTable('{{%result}}');
    }
}
