<?php

namespace app\controllers;

use app\models\User;
use panwenbin\helper\Curl;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;

class SsoController extends Controller
{
    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin($AuthenTickitRequestParamName)
    {
        $timestamp = microtime(true) * 10000;
        $sign = md5(Yii::$app->params['sso_website_id'].Yii::$app->params['sso_website_secret'].$timestamp);
        $result = Curl::to('http://account.chelintong.com/sso-api/login')->withData(['sso_website_id' => Yii::$app->params['sso_website_id'], 'sign' => $sign, 'timestamp' => $timestamp, 'AuthenTickitRequestParamName' => $AuthenTickitRequestParamName])->get();
        $result = json_decode($result);
        if($result->code == 200){
            $account = $result->message;
            return Yii::$app->user->login(User::getUserByUserid($account), 0);
        }else{
            Yii::$app->response->data =['code' => 0, 'message' => $result->message];
            return false;
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        return Yii::$app->user->logout();
    }
}
