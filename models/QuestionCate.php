<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%question_cate}}".
 *
 * @property int $id 主键
 * @property string $question_name 问题分类描述
 * @property int $status 状态
 * @property int $user_id 创建人
 * @property int $created_at 创建时间
 */
class QuestionCate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%question_cate}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question_name'], 'required'],
            [['created_at'], 'integer'],
            [['question_name'], 'string', 'max' => 64],
            [['status'], 'integer', 'max' => 1],
            [['user_id'], 'integer', 'max' => 9999],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'question_name' => '问题分类',
            'status' => '状态',
            'user_id' => '创建人',
            'created_at' => '创建时间',
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if($this->isNewRecord){
            $this->status = 1;
            $this->user_id = Yii::$app->user->id;
            $this->created_at = time();
        }

        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    /**
     * @return array
     */
    public static function cateArray()
    {
        return self::find()->select('question_name')->where(['status' => 1])->indexBy('id')->asArray()->column();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
