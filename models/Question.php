<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%question}}".
 *
 * @property int $id 主键
 * @property int $cate_id 问题分类
 * @property int $status 状态
 * @property int $user_id 创建人
 * @property int $created_at 创建时间
 */
class Question extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%question}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cate_id'], 'required'],
            [['created_at'], 'integer'],
            [['cate_id', 'user_id'], 'integer', 'max' => 9999],
            [['status'], 'integer', 'max' => 1],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '主键',
            'cate_id' => '问题分类',
            'status' => '状态',
            'user_id' => '创建人',
            'created_at' => '创建时间',
            'startDate' => '开始日期',
            'endDate' => '结束日期'
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
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCate()
    {
        return $this->hasOne(QuestionCate::className(), ['id' => 'cate_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAttr()
    {
        return $this->hasOne(QuestionAttr::className(), ['question_id' => 'id']);
    }
}
