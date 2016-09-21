<?php

namespace app\controllers;

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
        $SSO = Yii::$app->request->get('SSO');

        if (!Yii::$app->user->isGuest && $SSO != 'yes') {
            return $this->goHome();
        }elseif ($SSO == 'yes'){
            Yii::$app->user->logout();
        }

        if (!Yii::$app->session->has('from')){
            $from = Yii::$app->request->get('from');
            Yii::$app->session->set('from', $from);
        }

        $model = new Register();
        if ($model->load(Yii::$app->request->post()) && $SSO == 'yes' && $model->SSOsignup()) {
            $from_url = Yii::$app->session->get('from');
            Yii::$app->session->remove('from');
            return $from_url ? $this->redirect(Url::to([$from_url, 'AuthenTickitRequestParamName' => 'yes'])) : $this->goHome();
        }elseif ($model->load(Yii::$app->request->post()) && $model->signup()) {
            $from_url = Yii::$app->session->get('from');
            Yii::$app->session->remove('from');
            return $from_url ? $this->redirect($from_url) : $this->goHome();
        }

        return $this->render('index',[
            'model' => $model,
            'SSO' => $SSO,
        ]);
    }
}
