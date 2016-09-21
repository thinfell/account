<?php

namespace app\controllers;

use Yii;
use app\models\Login;
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
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if (!Yii::$app->session->has('from')){
            $from = Yii::$app->request->get('from');
            Yii::$app->session->set('from', $from);
        }

        $model = new Login();
        $model->setScenario('default');

        $SSO = Yii::$app->request->get('SSO');

        if ($model->load(Yii::$app->request->post()) && $SSO == 'yes' && $model->SSOLogin()) {
            $from_url = Yii::$app->session->get('from');
            return $this->redirect($from_url);
        }elseif($model->load(Yii::$app->request->post()) && $model->Login()) {
            $from_url = Yii::$app->session->get('from');
            return $this->redirect($from_url);
        }

        return $this->render('default',[
            'model' => $model
        ]);
    }

    public function actionMobile()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if (!Yii::$app->session->has('from')){
            $from = Yii::$app->request->get('from');
            Yii::$app->session->set('from', $from);
        }

        $model = new Login();
        $model->setScenario('mobile');

        $SSO = Yii::$app->request->get('SSO');

        if ($model->load(Yii::$app->request->post()) && $SSO == 'yes' && $model->SSOMobileLogin()) {
            $from_url = Yii::$app->session->get('from');
            return $this->redirect($from_url);
        }elseif ($model->load(Yii::$app->request->post()) && $model->MobileLogin()) {
            $from_url = Yii::$app->session->get('from');
            return $this->redirect($from_url);
        }

        return $this->render('mobile',[
            'model' => $model
        ]);
    }

}
