<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;

class SsoController extends Controller
{
   
    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin($account)
    {
		return Yii::$app->user->login(User::getUser($account), 0);
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
