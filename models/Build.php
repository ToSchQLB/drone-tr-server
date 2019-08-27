<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "build".
 *
 * @property int $id
 * @property int $project_id
 * @property int $success
 * @property int $assertion
 * @property int $positiv
 * @property int $negativ
 * @property string $date
 *
 * @property Project $project
 */
class Build extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'build';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['project_id', 'success', 'assertion', 'positiv', 'negativ'], 'integer'],
            [['date'], 'safe'],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('build', 'ID'),
            'project_id' => Yii::t('build', 'Project ID'),
            'success' => Yii::t('build', 'Success'),
            'assertion' => Yii::t('build', 'Assertion'),
            'positiv' => Yii::t('build', 'Positiv'),
            'negativ' => Yii::t('build', 'Negativ'),
            'date' => Yii::t('build', 'Date'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['id' => 'project_id']);
    }
}