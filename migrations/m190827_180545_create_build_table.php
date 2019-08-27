<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%build}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%project}}`
 */
class m190827_180545_create_build_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%build}}', [
            'id' => $this->primaryKey(),
            'project_id' => $this->integer(),
            'success' => $this->smallInteger(),
            'assertion' => $this->integer(),
            'positiv' => $this->integer(),
            'negativ' => $this->integer(),
            'date' => $this->datetime(),
        ]);

        // creates index for column `project_id`
        $this->createIndex(
            '{{%idx-build-project_id}}',
            '{{%build}}',
            'project_id'
        );

        // add foreign key for table `{{%project}}`
        $this->addForeignKey(
            '{{%fk-build-project_id}}',
            '{{%build}}',
            'project_id',
            '{{%project}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%project}}`
        $this->dropForeignKey(
            '{{%fk-build-project_id}}',
            '{{%build}}'
        );

        // drops index for column `project_id`
        $this->dropIndex(
            '{{%idx-build-project_id}}',
            '{{%build}}'
        );

        $this->dropTable('{{%build}}');
    }
}
