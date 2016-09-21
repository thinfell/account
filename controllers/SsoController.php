<?php

namespace app\controllers;

use app\models\User;
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
    public function actionLogin($account)
    {
		return Yii::$app->user->login(User::findByUsername($account), 0);
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
