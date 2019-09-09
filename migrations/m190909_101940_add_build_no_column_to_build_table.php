<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%build}}`.
 */
class m190909_101940_add_build_no_column_to_build_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%build}}', 'build_no', $this->integer()->after('project_id'));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('{{%build}}', 'build_no');
    }
}
