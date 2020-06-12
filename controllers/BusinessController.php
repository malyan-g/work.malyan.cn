<?php
/**
 * Created by PhpStorm.
 * User: M
 * Date: 2020/6/11
 * Time: 17:44
 */

namespace app\controllers;

use Yii;
use app\models\Business;
use app\models\search\BusinessSearch;

/**
 * Class BusinessController
 * @package app\controllers
 */
class BusinessController extends Controller
{
    public $keywords;

    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
                'config' => [
                    "imageUrlPrefix"  => "https://work.malyan.cn",//图片访问路径前缀
                    "imagePathFormat" => "/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}", //上传保存路径
                    "imageMaxSize"            => 8184000,
                    "imageCompressEnable"     => false,
                    "imageCompressBorder"     => 3200,
                ]
            ]
        ];
    }

    /**
     * 问题列表
     * @return string
     */
    public function actionList()
    {
        $searchModel = new BusinessSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $this->keywords = $searchModel->title;
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
        $model = $this->findModel();
        if($model->user_id == $this->userId){
            $model->status = 0;
            if($model->save(false)){
                $this->alert('Business Delete Successfully', self::ALERT_SUCCESS);
            }else{
                $this->alert('Business Delete Failure');
            }
            return $this->redirect(Yii::$app->request->referrer);
        }else{
            $this->exception('Illegal Request');
        }
    }

    /**
     * 问题详情
     * @return string
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionView()
    {
        $model = $this->findModel();

        return $this->render('view', [
            'model' => $model
        ]);
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
        $model = $isNewRecord ? new Business() : $this->findModel();
        if($isNewRecord === false){
            if($model->user_id != $this->userId){
                $this->exception('Illegal Request');
            }
        }
        $request = Yii::$app->request;
        if($request->isPost){
            if($model->load($request->post()) && $model->validate()){
               if($model->save(false)){
                    $this->alert($isNewRecord ? 'Business Create Successfully' : 'Business Update Successfully', self::ALERT_SUCCESS);
                    if($isNewRecord){
                        return $this->redirect(['business/create']);
                    }
            }else{
                $this->alert($isNewRecord ? 'Business Create Failure' : 'Business Update Failure');
            }
            }else{
                $this->exception('Illegal Operation');
            }
        }

        return $this->render('form',[
            'model' => $model
        ]);
    }

    /**
     * 问题查询
     * @return  Business the loaded model
     * @throws \yii\web\NotFoundHttpException
     */
    public function findModel()
    {
        $id = (int) Yii::$app->request->get('id', 0);
        if($id){
            if(($model = Business::findOne(['id' => $id])) !== null){
                return $model;
            }
        }
        $this->exception('Illegal Request');
    }
}