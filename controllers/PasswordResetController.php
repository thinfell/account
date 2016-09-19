<?php

namespace app\controllers;

use app\models\PasswordReset;
use Yii;

class PasswordResetController extends \yii\web\Controller
{
    public function actionIndex()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new PasswordReset();
        $model->setScenario('index');
        if ($model->load(Yii::$app->request->post()) && $model->index()) {
            return $this->redirect(['get']);
        }else{
            Yii::$app->session->remove('mobile');
            Yii::$app->session->remove('step');
        }
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionGet()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if(Yii::$app->session->get('step') != 1){
            return $this->redirect(['index']);
        }
        $model = new PasswordReset();
        $model->setScenario('get');
        if ($model->load(Yii::$app->request->post()) && $model->get()) {
            return $this->redirect(['set']);
        }
        return $this->render('get', [
            'model' => $model,
        ]);
    }

    public function actionSet()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        if(Yii::$app->session->get('step') != 2){
            return $this->redirect(['index']);
        }
        $model = new PasswordReset();
        $model->setScenario('set');
        if ($model->load(Yii::$app->request->post()) && $model->set()) {
            return $this->redirect(['/login/default']);
        }
        return $this->render('set', [
            'model' => $model,
        ]);
    }

}
