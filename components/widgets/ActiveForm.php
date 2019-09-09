<?php


namespace app\components\widgets;


use yii\db\ActiveRecord;

class ActiveForm extends \yii\widgets\ActiveForm
{
    /** @var ActiveRecord */
    public $model;

    public function init()
    {
        if (empty($this->id) && is_subclass_of($this->model, ActiveRecord::className())) {
            $this->id = !empty($this->id) ? $this->id : $this->model->formName();
        }
        parent::init();
    }


}