<?php

namespace app\controllers;

use Yii;
use yii\web\Response;

class ServerController extends \yii\web\Controller
{

    public function actionLogin()
    {
        $from = Yii::$app->session->get('from');
        return $this->render('index', [
            'from' => $from,
        ]);
    }

    public function actionLogout()
    {
        $from = Yii::$app->session->get('from');
        return $this->render('index', [
            'from' => $from,
        ]);
    }

}
