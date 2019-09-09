<?php

namespace app\models;

use Symfony\Component\Yaml\Tests\B;
use Yii;
use yii\db\Expression;
use yii\helpers\FileHelper;

/**
 * This is the model class for table "project".
 *
 * @property int $id
 * @property string $name
 * @property string $token
 * @property int $build_cnt
 *
 * @property Build[] builds
 * @property Build lastBuild                        
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
            [['build_cnt'], 'integer'],
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
            'build_cnt' => Yii::t('project', 'Build Count'),
            'lastBuild.date' => Yii::t('project', 'last Build'),
        ];
    }

    public function beforeSave($insert)
    {
        if($insert){
            $this->token = uniqid('') . uniqid('');
        }
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if($insert){
            FileHelper::createDirectory('./import/'.$this->token);
            FileHelper::createDirectory('./pd/'.$this->token);

        }
        parent::afterSave($insert, $changedAttributes);
    }


    public function beforeDelete()
    {
        FileHelper::removeDirectory('./import/'.$this->token);
        return parent::beforeDelete();
    }

    public function createNewBuild()
    {
        $build = new Build();
        $build->project_id = $this->id;
        $build->date = new Expression('now()');
        $build->build_no = $this->build_cnt +1;
        $build->save(false);

        $this->build_cnt = $build->build_no;
        $this->save(false);

        return $build;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBuilds(){
        return $this->hasMany(Build::className(), ['project_id' => 'id']);
    }
    
    public function getLastBuild(){
        return $this->hasOne(Build::className(), ['project_id' => 'id'])
            ->onCondition(['id'=>Build::find()->where(['project_id' => $this->id])->max('id')]);
    }


}
