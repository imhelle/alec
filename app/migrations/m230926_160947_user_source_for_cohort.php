<?php

use yii\db\Migration;

/**
 * Class m230926_160947_user_source_for_cohort
 */
class m230926_160947_user_source_for_cohort extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%cohort}}', 'user_id', $this->integer());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%cohort}}', 'user_id');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230926_160947_user_source_for_cohort cannot be reverted.\n";

        return false;
    }
    */
}
