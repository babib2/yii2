<?php

use yii\db\Migration;

/**
 * Handles the creation for table `clndr_user`.
 */
class m160603_110040_create_clndr_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%clndr_user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull(),
            'name' => $this->string()->notNull(),
            'surname' => $this->string()->notNull(),
            'password' => $this->string()->notNull(),
            'salt' => $this->string()->notNull(),
            'access_token' => $this->string()->notNull(),
            'create_at_date' => $this->datetime()->notNull(),
        ], $tableOptions);

    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%clndr_user}}');
    }
}
