<?php
/**
 * Created by PhpStorm.
 * User: M
 * Date: 2020/5/26
 * Time: 09:56
 */

namespace app\models\search;

use yii\base\Model;
use yii\helpers\ArrayHelper;
use app\models\QuestionCate;
use yii\data\ActiveDataProvider;

/**
 * Class QuestionCateSearch
 * @package app\models\search
 */
class QuestionCateSearch extends QuestionCate
{

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        return Model::scenarios();
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(Array $params)
    {
        $query = self::find()->joinWith('user')->where([self::tableName() . '.status' => 1]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => ArrayHelper::getValue($params, 'per-page', 10)
            ],
        ]);

        $query->orderBy(['created_at' => SORT_DESC]);

        return $dataProvider;
    }
}
