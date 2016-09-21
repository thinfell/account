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
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if (!Yii::$app->session->has('from')){
            $from = Yii::$app->request->get('from');
            Yii::$app->session->set('from', $from);
        }

        $model = new Login();
        $model->setScenario('default');

        if($model->load(Yii::$app->request->post()) && $model->Login()) {
            return $this->redirect('/sso-api/login');
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

        if ($model->load(Yii::$app->request->post()) && $model->MobileLogin()) {
            return $this->redirect('/sso-api/login');
        }

        return $this->render('mobile',[
            'model' => $model
        ]);
    }

}
