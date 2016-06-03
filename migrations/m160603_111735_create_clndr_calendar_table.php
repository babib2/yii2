<?php

use yii\db\Migration;

/**
 * Handles the creation for table `clndr_calendar_table`.
 */
class m160603_111735_create_clndr_calendar_table extends Migration
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

         $this->createTable('{{%clndr_calendar}}', [
            'id' => $this->primaryKey(),
            'text' => $this->string()->notNull(),
            'creator' => $this->integer()->notNull(),
            'create_at_date' => $this->datetime()->notNull(),
        ], $tableOptions);

         $this->addForeignKey('FK_creator','{{%clndr_calendar}}','creator','{{%clndr_user}}','id','CASCADE','CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('{{%clndr_calendar}}');
    }
}
