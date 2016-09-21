<?php

namespace app\controllers;

use Yii;
use yii\web\Response;

class ServerController extends \yii\web\Controller
{

    public  $enableCsrfValidation = false;

    public function actionIndex()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $return = [
            'a' => 1
        ];
        return $return;
    }

}
