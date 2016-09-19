<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use app\assets\SendSMSAsset;

$this->title = '注册';
$this->params['breadcrumbs'][] = $this->title;

SendSMSAsset::register($this);

?>
<script>
    var actionId = 'register';
    var sendButton = 'getSMS';
</script>
<div class="register-index">
    <h1>注册</h1>

    <p>注册帐号，玩转所有服务！</p>

    <div class="row">
        <div class="col-lg-4">
            <?php $form = ActiveForm::begin(['id' => 'register-form']); ?>

            <?= Html::activeHiddenInput($model,'smsid') ?>

            <?= $form->field($model, 'mobile', [
                'addon' => [
                    'prepend' => [
                        'content' => '<i class="glyphicon glyphicon-phone"></i>'
                    ]
                ]
            ])->textInput(['placeholder' => '手机'])->label(false) ?>

            <?= $form->field($model, 'SMS', [
                'addon' => [
                    'prepend' => [
                        'content' => '<i class="glyphicon glyphicon-envelope"></i>'
                    ],
                    'append' => [
                        'content' => Html::button('获取短信动态码', ['class' => 'btn btn-success', 'id' => 'getSMS']),
                        'asButton' => true
                    ]
                ]
            ])->textInput(['placeholder' => '短信动态码', 'maxLength' => 4])->label(false) ?>

            <?= $form->field($model, 'password', [
                'addon' => [
                    'prepend' => [
                        'content' => '<i class="glyphicon glyphicon-lock"></i>'
                    ]
                ]
            ])->passwordInput(['placeholder' => '创建密码'])->label(false) ?>

            <?= $form->field($model, 'password_repeat', [
                'addon' => [
                    'prepend' => [
                        'content' => '<i class="glyphicon glyphicon-lock"></i>'
                    ]
                ]
            ])->passwordInput(['placeholder' => '确认密码'])->label(false) ?>

            <?= $form->field($model, 'agreeLicence')->checkbox() ?>

            <div class="form-group">
                <?= Html::submitButton('立即加入', ['class' => 'btn btn-primary btn-block', 'name' => 'register-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>