<?php

namespace app\controllers;

use app\models\Tickit;
use app\models\User;
use app\models\Website;
use Yii;
use app\models\Register;
use yii\helpers\Url;
use yii\web\Controller;

class RegisterController extends Controller
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

    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if (!Yii::$app->session->has('from')){
            $from = Yii::$app->request->get('from');
            Yii::$app->session->set('from', $from);
        }

        $model = new Register();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            $this->layout = 'SsoApi';
            $website = Website::find()->all();

            $user = User::getUserByMobile($model->mobile);

            $timestamp = microtime(true) * 10000;
            $AuthenTickitRequestParamName = md5($user->id.$timestamp);
            $AuthenTickitRequestParamName = bin2hex($AuthenTickitRequestParamName);
            $AuthenTickitRequestParamName = strtoupper($AuthenTickitRequestParamName);

            $tickit = new Tickit();
            $tickit->user_id = $user->id;
            $tickit->action = 'login';
            $tickit->value = $AuthenTickitRequestParamName;
            $tickit->creation_time = $timestamp;
            if($tickit->save()){
                return $this->render('/sso-api/login', [
                    'website' => $website,
                    'AuthenTickitRequestParamName' => $AuthenTickitRequestParamName,
                ]);
            }else{
                print_r($tickit->errors);
            }
        }else{
            return $this->render('index',[
                'model' => $model
            ]);
        }
    }
}
