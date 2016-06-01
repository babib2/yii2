<?php

use yii\db\Migration;

/**
 * Handles the creation for table `zayavka`.
 */
class m160526_094434_create_zayavka extends Migration
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

          $this->createTable('{{%zayavka}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->datetime(),
            'updated_at' => $this->datetime(),
            'name' => $this->string(255),
            'address' => $this->string(255),
            'email' => $this->string(255),
            'phone' => $this->string(10),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%zayavka}}');
    }
}
