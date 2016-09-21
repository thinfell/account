<?php

namespace app\controllers;

use Yii;
use app\models\Login;
use yii\helpers\Url;
use yii\web\Controller;

class LoginController extends Controller
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

    public function actionDefault()
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

        $model = new Login();
        $model->setScenario('default');

        if ($model->load(Yii::$app->request->post()) && $SSO == 'yes' && $model->SSOLogin()) {
            $from_url = Yii::$app->session->get('from');
            Yii::$app->session->remove('from');
            if ($from_url){
                header("Location: ".$from_url.'?AuthenTickitRequestParamName=yes');
                exit;
            }else{
                return $this->goHome();
            }
        }elseif($model->load(Yii::$app->request->post()) && $model->Login()) {
            $from_url = Yii::$app->session->get('from');
            Yii::$app->session->remove('from');
            return $from_url ? $this->redirect($from_url) : $this->goHome();
        }

        return $this->render('default',[
            'model' => $model,
            'SSO' => $SSO,
        ]);
    }

    public function actionMobile()
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

        $model = new Login();
        $model->setScenario('mobile');

        if ($model->load(Yii::$app->request->post()) && $SSO == 'yes' && $model->SSOMobileLogin()) {
            $from_url = Yii::$app->session->get('from');
            Yii::$app->session->remove('from');
            return $from_url ? $this->redirect(Url::to([$from_url, 'AuthenTickitRequestParamName' => 'yes'])) : $this->goHome();
        }elseif ($model->load(Yii::$app->request->post()) && $model->MobileLogin()) {
            $from_url = Yii::$app->session->get('from');
            Yii::$app->session->remove('from');
            return $from_url ? $this->redirect($from_url) : $this->goHome();
        }

        return $this->render('mobile',[
            'model' => $model,
            'SSO' => $SSO,
        ]);
    }

}
