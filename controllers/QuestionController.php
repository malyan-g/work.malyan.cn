<?php

namespace app\controllers;

use Yii;
use app\models\Question;
use app\models\QuestionAttr;
use app\models\QuestionCate;
use yii\data\ActiveDataProvider;
use app\models\search\QuestionSearch;
use app\models\search\QuestionCateSearch;

/**
 * 问题相关操作
 * Class QuestionController
 * @package app\controllers
 */
class QuestionController extends Controller
{
    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
                'config' => [
                    "imageUrlPrefix"  => "http://work.malyan.cn",//图片访问路径前缀
                    "imagePathFormat" => "/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}", //上传保存路径
                    "imageMaxSize"            => 4096000,
                ]
            ]
        ];
    }

    /**
     * 问题主页
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new QuestionSearch();
        $dataProvider = $searchModel->indexSearch(Yii::$app->request->queryParams);
        var_dump(Yii::$app->request->queryParams);
        $data = $dataProvider->query->limit(10)->offset(0)->asArray()->all();
        return $this->render('index', [
            'searchModel' => $searchModel,
            'data' => $data
        ]);
    }

    /**
     * 问题主页
     * @return string
     */
    public function actionCateIndex()
    {
        $searchModel = new QuestionSearch();
        $dataProvider = $searchModel->cateSearch(Yii::$app->request->queryParams);
        return $this->render('cate-index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * 问题列表
     * @return string
     */
    public function actionList()
    {
        $searchModel = new QuestionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('list', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * 问题创建
     * @return string|\yii\web\Response
     * @throws \yii\db\Exception
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionCreate()
    {
        return $this->save();
    }

    /**
     * 问题修改
     * @return string|\yii\web\Response
     * @throws \yii\db\Exception
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionUpdate()
    {
        return $this->save(false);
    }

    /**
     * 问题删除
     * @return \yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionDelete()
    {
        $model = $this->findQuestion();
        $model->status = 0;
        if($model->save(false)){
            $this->alert('Question Delete Successfully', self::ALERT_SUCCESS);
        }else{
            $this->alert('Question Delete Failure');
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * 问题详情
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView()
    {
        $this->layout = false;
        $id = (int) Yii::$app->request->get('id', 0);
        $questionAttr = $this->findQuestionAttr($id);

        return $this->render('view', [
            'questionAttr' => $questionAttr
        ]);
    }

    /**
     * 问题分类列表
     * @return string
     */
    public function actionCateList()
    {
        $searchModel = new QuestionCateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('cate-list', [
            'searchModel'=>$searchModel,
            'dataProvider'=>$dataProvider
        ]);
    }

    /**
     * 问题分类创建
     * @return string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionCateCreate()
    {
        return $this->cateSave();
    }

    /**
     * 问题分类修改
     * @return string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionCateUpdate()
    {
        return $this->cateSave(false);
    }

    /**
     * 问题分类删除
     * @return \yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionCateDelete()
    {
        $model = $this->findQuestionCate();
        $model->status = 0;
        if($model->save(false)){
            $this->alert('Cate Delete Successfully', self::ALERT_SUCCESS);
        }else{
            $this->alert('Cate Delete Failure');
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * 问题保存
     * @param bool $isNewRecord
     * @return string|\yii\web\Response
     * @throws \yii\db\Exception
     * @throws \yii\web\NotFoundHttpException
     */
    private function save($isNewRecord = true)
    {
        $question = $isNewRecord ? new Question() : $this->findQuestion();
        $questionAttr = $isNewRecord ? new QuestionAttr() : $this->findQuestionAttr($question->id);
        $request = Yii::$app->request;
        if($request->isPost){
            if($question->load($request->post()) && $question->validate() && $questionAttr->load($request->post()) && $questionAttr->validate()){
                $trans = Yii::$app->db->beginTransaction();
                try{
                    $question->save(false);
                    $questionAttr->question_id = $question->id;
                    $questionAttr->save(false);
                    $trans->commit();
                    $this->alert($isNewRecord ? 'Question Create Successfully' : 'Question Update Successfully', self::ALERT_SUCCESS);
                    if($isNewRecord){
                        return $this->redirect(['question/create']);
                    }
                }catch (\Exception $e){
                    $trans->rollBack();
                    $this->alert($isNewRecord ? 'Question Create Failure' : 'Question Update Failure');
                }
            }else{
                $this->exception('Illegal Operation');
            }
        }

        return $this->render('form',[
            'question' => $question,
            'questionAttr' => $questionAttr
        ]);
    }

    /**
     * 问题分类保存
     * @param bool $isNewRecord
     * @return string|\yii\web\Response
     * @throws \yii\web\NotFoundHttpException
     */
    private function cateSave($isNewRecord = true)
    {
        $model = $isNewRecord ? new QuestionCate() : $this->findQuestionCate();
        $request = Yii::$app->request;
        if($request->isPost){
            if($model->load($request->post()) && $model->validate()){
               if($model->save(false)){
                    if($isNewRecord){
                        return $this->redirect(['question/cate-create']);
                    }
                    $this->alert($isNewRecord ? 'Cate Create Successfully' : 'Cate Update Successfully', self::ALERT_SUCCESS);
               }else{
                   $this->alert($isNewRecord ? 'Cate Create Failure' : ' Cate Update Failure');
               }
            }else{
                $this->exception('Illegal Operation');
            }
        }

        return $this->render('cate-form',[
            'model' => $model
        ]);
    }

    /**
     * 问题查询
     * @return  Question the loaded model
     * @throws \yii\web\NotFoundHttpException
     */
    public function findQuestion()
    {
        $id = (int) Yii::$app->request->get('id', 0);
        if($id){
            if(($model = Question::findOne(['id' => $id, 'user_id' => $this->userId])) !== null){
                return $model;
            }
        }
        $this->exception('Illegal Request');
    }

    /**
     * 问题附属查询
     * @param $id
     * @return QuestionAttr the loaded model
     * @throws \yii\web\NotFoundHttpException
     */
    public function findQuestionAttr($id)
    {
        if(($model = QuestionAttr::findOne(['question_id' => $id])) !== null){
            return $model;
        }
        $this->exception('Illegal Request');
    }

    /**
     * 问题分类查询
     * @return  QuestionCate the loaded model
     * @throws \yii\web\NotFoundHttpException
     */
    public function findQuestionCate()
    {
        $id = (int) Yii::$app->request->get('id', 0);
        if($id){
            if(($model = QuestionCate::findOne(['id' => $id, 'user_id' => $this->userId])) !== null){
                return $model;
            }
        }
        $this->exception('Illegal Request');
    }
}
