<?php

namespace app\controllers;

use app\models\Tickit;
use app\models\User;
use Yii;
use app\models\Login;
use yii\helpers\Url;
use yii\web\Controller;
use app\models\Website;

class LoginController extends Controller
{
    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    public function actionDefault()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if (!Yii::$app->session->has('from')) {
            $from = Yii::$app->request->get('from');
            Yii::$app->session->set('from', $from);
        }

        $model = new Login();
        $model->setScenario('default');

        if ($model->load(Yii::$app->request->post()) && $model->Login()) {
            $this->layout = 'SsoApi';
            $website = Website::find()->all();

            $user = User::getUser($model->account);

            $timestamp = microtime(true) * 10000;
            $AuthenTickitRequestParamName = md5($user->id . $timestamp);
            $AuthenTickitRequestParamName = bin2hex($AuthenTickitRequestParamName);
            $AuthenTickitRequestParamName = strtoupper($AuthenTickitRequestParamName);

            $insertData = [];
            foreach ($website as $val) {
                $insertData[] = [$user->id, $val->id, 'login', $AuthenTickitRequestParamName, $timestamp];
            }

            $insertData = array_values($insertData);

            // INSERT 一次插入多行
            Yii::$app->db->createCommand()->batchInsert('tickit', ['user_id', 'webid', 'action', 'value', 'creation_time'], $insertData)->execute();

            Yii::$app->user->login(User::getUserByUserid($user->id), 0);
            return $this->render('/sso-api/login', [
                'website' => $website,
                'AuthenTickitRequestParamName' => $AuthenTickitRequestParamName,
            ]);

        } else {
            return $this->render('default', [
                'model' => $model
            ]);
        }
    }

    public function actionMobile()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if (!Yii::$app->session->has('from')) {
            $from = Yii::$app->request->get('from');
            Yii::$app->session->set('from', $from);
        }

        $model = new Login();
        $model->setScenario('mobile');

        if ($model->load(Yii::$app->request->post()) && $model->MobileLogin()) {
            $this->layout = 'SsoApi';
            $website = Website::find()->all();
            $user = User::getUserByMobile($model->mobile);

            $timestamp = microtime(true) * 10000;
            $AuthenTickitRequestParamName = md5($user->id . $timestamp);
            $AuthenTickitRequestParamName = bin2hex($AuthenTickitRequestParamName);
            $AuthenTickitRequestParamName = strtoupper($AuthenTickitRequestParamName);

            $insertData = [];
            foreach ($website as $val) {
                $insertData[] = [$user->id, $val->id, 'login', $AuthenTickitRequestParamName, $timestamp];
            }

            $insertData = array_values($insertData);

            // INSERT 一次插入多行
            Yii::$app->db->createCommand()->batchInsert('tickit', ['user_id', 'webid', 'action', 'value', 'creation_time'], $insertData)->execute();

            Yii::$app->user->login(User::getUserByUserid($user->id), 0);
            return $this->render('/sso-api/login', [
                'website' => $website,
                'AuthenTickitRequestParamName' => $AuthenTickitRequestParamName,
            ]);
        } else {

            return $this->render('mobile', [
                'model' => $model
            ]);
        }
    }

}
