<?php

namespace app\controllers;

use Yii;
use app\models\Register;
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
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new Register();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            $session = Yii::$app->session;
            $session->set('regMobile', $model->mobile);
            return $this->redirect(['/login/default']);
        }

        return $this->render('index',[
            'model' => $model
        ]);
    }
}
