<?php

namespace app\controllers;

use Yii;
use app\models\Tickit;
use yii\web\Controller;
use app\models\Website;
use yii\web\Response;
use app\models\User;

class SsoApiController extends Controller
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

    public function actionLogin()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $sso_website_id = Yii::$app->request->get('sso_website_id');
        $website = Website::findOne($sso_website_id);
        if(!isset($website->secret)){
            return [
                'code' => 0,
                'message' => 'sso_website_id error',
            ];
        }
        $sso_website_secret = $website->secret;
        $sign = Yii::$app->request->get('sign');
        $timestamp = Yii::$app->request->get('timestamp');
        if(md5($sso_website_id.$sso_website_secret.$timestamp) != $sign){
            return [
                'code' => 0,
                'message' => 'sign error',
            ];
        }
        $AuthenTickitRequestParamName = Yii::$app->request->get('AuthenTickitRequestParamName');
        $tickit = Tickit::find()->where(['value' => $AuthenTickitRequestParamName])->one();
        if(!isset($tickit->user_id)){
            return [
                'code' => 0,
                'message' => 'AuthenTickitRequestParamName error',
            ];
        }
        //Tickit::deleteAll(['value' => $AuthenTickitRequestParamName]);
        //Yii::$app->user->login(User::getUserByUserid($tickit->user_id), 0);
        return [
            'code' => 200,
            'message' => $tickit->user_id,
        ];
    }

    public function actionRegister()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $sso_website_id = Yii::$app->request->get('sso_website_id');
        $website = Website::findOne($sso_website_id);
        if(!isset($website->secret)){
            return [
                'code' => 0,
                'message' => 'sso_website_id error',
            ];
        }
        $sso_website_secret = $website->secret;
        $sign = Yii::$app->request->get('sign');
        $timestamp = Yii::$app->request->get('timestamp');
        if(md5($sso_website_id.$sso_website_secret.$timestamp) != $sign){
            return [
                'code' => 0,
                'message' => 'sign error',
            ];
        }
        $AuthenTickitRequestParamName = Yii::$app->request->get('AuthenTickitRequestParamName');
        $tickit = Tickit::find()->where(['value' => $AuthenTickitRequestParamName])->one();
        if(!isset($tickit->user_id)){
            return [
                'code' => 0,
                'message' => 'AuthenTickitRequestParamName error',
            ];
        }
        //Tickit::deleteAll(['value' => $AuthenTickitRequestParamName]);
        $user = User::getUserByUserid($tickit->user_id);
        Yii::$app->user->login($user, 0);
        return [
            'code' => 200,
            'message' => [
                'userid' => $user->id,
                'name' => $user->name,
                'mobile' => $user->mobile,
            ],
        ];
    }

    public function actionLogout()
    {
        $this->layout = 'SsoApi';
        $website = Website::find()->all();
        Yii::$app->user->logout();
        return $this->render('/sso-api/logout', [
            'website' => $website
        ]);
    }
}
