<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%business}}".
 *
 * @property int $id 主键
 * @property string $title 标题
 * @property string $content 内容
 * @property int $user_id 创建人
 * @property int $status 状态
 * @property int $created_at 创建时间
 */
class Business extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%business}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'required'],
            [['content'], 'string'],
            [['created_at'], 'integer'],
            [['title'], 'string', 'max' => 200],
            [['user_id'], 'integer', 'max' => 9999],
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
            'title' => '标题',
            'content' => '内容',
            'user_id' => '创建人',
            'status' => '状态',
            'created_at' => '创建时间',
        ];
    }
}
