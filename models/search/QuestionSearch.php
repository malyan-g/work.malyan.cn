<?php
/**
 * Created by PhpStorm.
 * User: M
 * Date: 2020/5/26
 * Time: 09:56
 */

namespace app\models\search;

use yii\base\Model;
use app\models\Question;
use yii\helpers\ArrayHelper;
use app\models\QuestionCate;
use yii\data\ActiveDataProvider;

/**
 * Class QuestionSearch
 * @package app\models\search
 */
class QuestionSearch extends Question
{
    public $startDate;
    public $endDate;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cate_id'], 'integer'],
            [['startDate', 'endDate'], 'date', 'format' => 'php:Y-m-d', 'message'=>'{attribute}不符合格式。']
        ];
    }

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
        $query = self::find()->joinWith(['user','cate'])->where([self::tableName() . '.status' => 1]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => ArrayHelper::getValue($params, 'per-page', 10)
            ],
        ]);

        $query->orderBy([self::tableName() . '.created_at' => SORT_DESC]);

        $this->load($params);

        if(!$this->validate()) {
            return $dataProvider;
        }

        if(count($params) === 0){
            $this->startDate = date('Y-m-01', strtotime(date("Y-m-d")));
            $this->endDate = date('Y-m-d', time());
        }

        // 创建时间
        if($this->startDate){
            $query->andFilterWhere(['>=', self::tableName() . '.created_at', strtotime($this->startDate)]);
        }

        if($this->endDate){
            $query->andFilterWhere(['<=', self::tableName() . '.created_at', strtotime($this->endDate) + 86400]);
        }

        return $dataProvider;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function indexSearch(Array $params)
    {
        $query = self::find()->joinWith(['cate'])->select(['cate_id', 'count(1) as total']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);

        $query->where([self::tableName() . '.status' => 1, QuestionCate::tableName() . '.status' => 1]);
        $query->groupBy('cate_id')->orderBy(['total' => SORT_DESC]);
        $this->load($params);

        if(!$this->validate()) {
            return $dataProvider;
        }

        if(count($params) === 0){
            $this->startDate = date('Y-m-01', strtotime(date("Y-m-d")));
            $this->endDate = date('Y-m-d', time());
        }

        // 创建时间
        if($this->startDate){
            $query->andFilterWhere(['>=', self::tableName() . '.created_at', strtotime($this->startDate)]);
        }

        if($this->endDate){
            $query->andFilterWhere(['<=', self::tableName() . '.created_at', strtotime($this->endDate) + 86400]);
        }

        $query->andFilterWhere([
            'cate_id' => $this->cate_id
        ]);

        return $dataProvider;
    }

    /**
     * @param array $params
     * @return ActiveDataProvider
     */
    public function cateSearch(Array $params)
    {
        $query = self::find()->joinWith(['cate','user','attr']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => ArrayHelper::getValue($params, 'per-page', 10)
            ],
        ]);

        $query->where([self::tableName() . '.status' => 1, QuestionCate::tableName() . '.status' => 1]);
        $query->orderBy([self::tableName() . '.created_at' => SORT_DESC]);
        $this->load($params);

        if(!$this->validate()) {
            return $dataProvider;
        }

        // 创建时间
        if($this->startDate){
            $query->andFilterWhere(['>=', self::tableName() . '.created_at', strtotime($this->startDate)]);
        }

        if($this->endDate){
            $query->andFilterWhere(['<=', self::tableName() . '.created_at', strtotime($this->endDate) + 86400]);
        }

        $query->andFilterWhere(['cate_id' => $this->cate_id]);

        return $dataProvider;
    }
}
