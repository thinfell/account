<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use app\assets\SendSMSAsset;

$this->title = '找回密码';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="passwordreset-index">
    <h1>3.设置新密码</h1>

    <p>您的手机号为 <?=substr_replace(Yii::$app->session->get('mobile'),'****',3,4)?>，请填写短信动态码</p>

    <div class="row">
        <div class="col-lg-4">
            <?php $form = ActiveForm::begin(['id' => 'passwordreset-form']); ?>

            <?= $form->field($model, 'password', [
                'addon' => [
                    'prepend' => [
                        'content' => '<i class="glyphicon glyphicon-lock"></i>'
                    ]
                ]
            ])->passwordInput(['placeholder' => '设置新密码'])->label(false) ?>

            <?= $form->field($model, 'password_repeat', [
                'addon' => [
                    'prepend' => [
                        'content' => '<i class="glyphicon glyphicon-lock"></i>'
                    ]
                ]
            ])->passwordInput(['placeholder' => '确认密码'])->label(false) ?>

            <div class="form-group">
                <?= Html::submitButton('提交修改', ['class' => 'btn btn-primary btn-block', 'name' => 'passwordreset-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>