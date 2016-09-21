<?php

namespace app\controllers;

use Yii;
use yii\web\Response;

class SsoController extends \yii\web\Controller
{

    public function actionLogin()
    {
        $from = Yii::$app->session->get('from');
        return $this->render('login', [
            'from' => $from,
        ]);
    }

    public function actionLogout()
    {
        $from = Yii::$app->session->get('from');
        return $this->render('logout', [
            'from' => $from,
        ]);
    }

}
