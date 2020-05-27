<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%question_attr}}".
 *
 * @property int $question_id 问题主键
 * @property string $describe 问题描述
 */
class QuestionAttr extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%question_attr}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['describe'], 'required'],
            [['question_id'], 'integer'],
            [['describe'], 'required'],
            [['describe'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'question_id' => '问题主键',
            'describe' => '问题描述',
        ];
    }
}
