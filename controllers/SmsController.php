<?php

namespace app\controllers;

use app\models\User;
use Yii;
use app\models\Sms;
use app\models\SmsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * SmsController implements the CRUD actions for Sms model.
 */
class SmsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionSend($mobile = null, $actionid)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if($actionid == 'passwordreset'){
            $mobile = Yii::$app->session->get('mobile');
        }

        if (Yii::$app->request->isAjax) {
            //判断手机号
            if (!$mobile && $actionid != 'passwordreset') {
                $return = [
                    'code' => 0,
                    'attribute' => 'mobile',
                    'message' => '手机号不能为空。',
                ];
            } elseif (!preg_match('/^1[34578]{1}\d{9}$/', $mobile) && $actionid != 'passwordreset') {
                $return = [
                    'code' => 0,
                    'attribute' => 'mobile',
                    'message' => '手机号格式不正确。',
                ];
            } elseif (User::find()->where(['mobile' => $mobile])->count() > 0 && $actionid == 'register') {
                $return = [
                    'code' => 0,
                    'attribute' => 'mobile',
                    'message' => '手机号已被注册。',
                ];
            } elseif (!User::find()->where(['mobile' => $mobile])->count() > 0 && $actionid == 'login') {
                $return = [
                    'code' => 0,
                    'attribute' => 'mobile',
                    'message' => '手机号未注册,请注册后登录。',
                ];
            } elseif (!User::find()->where(['mobile' => $mobile])->count() > 0 && $actionid == 'passwordreset') {
                $return = [
                    'code' => 0,
                    'attribute' => 'mobile',
                    'message' => '手机号未注册。',
                ];
            } else {

                //判断发送间隔
                $data = Sms::find()->where(['mobile' => $mobile, 'action' => $actionid])->orderBy('send_time Desc')->one();
                $wait_time = isset($data) ? (time() - $data->send_time) : time();
                if ($wait_time < 60) {
                    $return = [
                        'code' => 0,
                        'attribute' => 'mobile',
                        'message' => '请在' . (60 - $wait_time) . '秒后重新获取。',
                    ];
                } else {

                    $model = new Sms();
                    $model->mobile = $mobile;
                    $model->sms = '1111';
                    $model->send_time = time();
                    $model->action = $actionid;
                    $model->save();

                    $return = [
                        'code' => 200,
                        'message' => $model->id,
                    ];
                }
            }
            return $return;
        } else {
            return [
                'code' => 0,
                'attribute' => 'mobile',
                'message' => '请求来路不正确',
            ];
        }
    }

    /**
     * Lists all Sms models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SmsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Sms model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Sms model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Sms();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Sms model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Sms model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Sms model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Sms the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Sms::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
