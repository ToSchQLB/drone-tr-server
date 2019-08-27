<?php

namespace app\models;

use Yii;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "project".
 *
 * @property int $id
 * @property string $name
 * @property string $token
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['token'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('project', 'ID'),
            'name' => Yii::t('project', 'Name'),
            'token' => Yii::t('project', 'Token'),
        ];
    }

    public function beforeSave($insert)
    {
        if($insert){
            $this->token = uniqid('') . uniqid('');
            FileHelper::createDirectory(Yii::getAlias('@web/import/'.$this->token));

        }
        return parent::beforeSave($insert);
    }

    public function beforeDelete()
    {
        FileHelper::removeDirectory(Yii::getAlias('@web/import/'.$this->token));
        return parent::beforeDelete();
    }


}
