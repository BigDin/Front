<?php

use yii\db\Migration;
//use yii\db\QueryBuilder;

/**
 * Handles the creation of table `{{%user}}`.
 */
class m190829_094949_create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(),
            'firstname' => $this->string(),
            'lastname' => $this->string(),
            'password' => $this->string(60),
            'email' => $this->string(),
            'status' => $this->integer(2),
            'auth_key' => $this->string(32),
            'access_token' => $this->string(32)
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
