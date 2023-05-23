<?php

use yii\db\Migration;

/**
 * Class m230508_152527_savedLinkTable
 */
class m230508_152527_savedLinkTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%saved_link}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'link' => $this->string()->unique(),
            'url' => $this->string(),
            'chart' => 'LONGTEXT',
            'timestamp' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%saved_link}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230508_152527_savedLinkTable cannot be reverted.\n";

        return false;
    }
    */
}
