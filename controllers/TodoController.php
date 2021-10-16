<?php

namespace app\controllers;

use app\models\Task;
use Yii;
use yii\filters\ContentNegotiator;
use yii\filters\VerbFilter;
use yii\web\Response;

class TodoController extends \yii\web\Controller
{
    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    public function init()
    {
        parent::init();
        \Yii::$app->user->enableSession = false;
        \Yii::$app->user->loginUrl = null;
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => Response::FORMAT_JSON,
                'application/xml' => Response::FORMAT_XML,
                //'application/html' => Response::FORMAT_HTML,
            ],
        ];

        $behaviors['verbFilter'] = [
            'class' => VerbFilter::className(),
            'actions' => [
                'view' => ['GET', 'HEAD'],
                'create' => ['POST'],
                'update' => ['PUT', 'PATCH'],
                'delete' => ['DELETE'],
            ],
        ];
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        return $actions;
    }

    public function actionView()
    {
        $model = Task::find()->asArray()->orderBy(['id'=>SORT_DESC])->all();
        return $model;
    }

    public function actionCreate()
    {
        $post = Yii::$app->request->post();
        $task = new Task();
        if ($task->load($post,'')) {
            try {
                if ($task->save()) {
                    return ['status' => 200, 'message' => 'data saved successfully!'];
                }
                return ['status' => 600, 'message' => $task->getErrors()];
            } catch (\Exception $e) {
                return ['status' => 700, 'message' => $e->getMessage()];
            }
        }
    }

    public function actionUpdate()
    {
        $post = Yii::$app->request->post();
        $task = Task::findOne($post['id']);
            if ($task->load($post, '')) {
                try {
                    if ($task->save()) {
                        return ['status' => 200, 'message' => 'data updated successfully!'];
                    }
                    return ['status' => 600, 'message' => $task->getErrors()];
                } catch (\Exception $e) {
                    return ['status' => 700, 'message' => $e->getMessage()];
                }
            }
        return $task->getErrors();
    }

    public function actionDelete()
    {
        $param = Yii::$app->request->get();
        $param['id'] = intval($param['id']);
        try
        {
            $task = Task::findOne($param['id']);
                if($task->delete()){
                    return ['status'  => 200, 'message'=> 'Record successfully removed!'];
                }
                return ['status'  => 600, 'message'=> $task->getErrors()];
        }catch (\Exception $e)
        {
            return ['status'  => 700, 'message'=> $e->getMessage()];
        }
    }
}
