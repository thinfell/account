<?php

namespace app\controllers;

use Yii;
use yii\web\Response;
use app\models\SSOServer;

class ServerController extends \yii\web\Controller
{

    public  $enableCsrfValidation = false;

    public function actionIndex()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $ssoServer = new SSOServer();
        $command = isset($_REQUEST['command']) ? $_REQUEST['command'] : null;

        if (!$command || !method_exists($ssoServer, $command)) {
            header("HTTP/1.1 404 Not Found");
            header('Content-type: application/json; charset=UTF-8');

            echo json_encode(['error' => 'Unknown command']);
            exit();
        }

        return $ssoServer->$command();
    }

}
