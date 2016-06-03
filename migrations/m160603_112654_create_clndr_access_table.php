<?php

use yii\db\Migration;

/**
 * Handles the creation for table `clndr_access_table`.
 */
class m160603_112654_create_clndr_access_table extends Migration
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

         $this->createTable('{{%clndr_access}}', [
            'id' => $this->primaryKey(),
            'user_owner' => $this->integer()->notNull(),
            'user_guest' => $this->integer()->notNull(),
            'create_at_date' => $this->datetime()->notNull(),
        ], $tableOptions);

         $this->addForeignKey('FK_user_owner','{{%clndr_access}}','user_owner','{{%clndr_user}}','id','CASCADE','CASCADE');
         $this->addForeignKey('FK_user_guest','{{%clndr_access}}','user_guest','{{%clndr_user}}','id','CASCADE','CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%clndr_access}}');
    }
}
