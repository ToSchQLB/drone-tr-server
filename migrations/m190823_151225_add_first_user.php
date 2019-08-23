<?php

use yii\db\Migration;

/**
 * Class m190823_151225_add_first_user
 */
class m190823_151225_add_first_user extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;
        $admin = $auth->createRole('Admin');
        $auth->add($admin);

        $cc = new \Da\User\Command\CreateController('create','user');
        $cc->actionIndex('admin@admin.de','admin','admin123', 'Admin');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190823_151225_add_first_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190823_151225_add_first_user cannot be reverted.\n";

        return false;
    }
    */
}
