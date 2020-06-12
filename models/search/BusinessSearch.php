<?php
/**
 * Created by PhpStorm.
 * User: M
 * Date: 2020/5/26
 * Time: 09:56
 */

namespace app\models\search;

use yii\base\Model;
use app\models\Business;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;

/**
 * Class BusinessSearch
 * @package app\models\search
 */
class BusinessSearch extends Business
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
        $query = self::find()->where(['status' => 1]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => ArrayHelper::getValue($params, 'per-page', 10)
            ],
        ]);

        $query->andFilterWhere(['like', 'title', $this->title]);

        $query->orderBy(['created_at' => SORT_DESC]);

        return $dataProvider;
    }
}
