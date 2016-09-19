<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\Login */

use app\assets\SendSMSAsset;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;

$this->title = '找回密码';
$this->params['breadcrumbs'][] = $this->title;
SendSMSAsset::register($this);

?>
<script>
    var actionId = 'passwordreset';
    var sendButton = 'getSMS';
</script>
<div class="passwordreset-get">
    <h1>2.验证身份</h1>
    <p>您的手机号为 <?=substr_replace(Yii::$app->session->get('mobile'),'****',3,4)?>，请填写短信动态码</p>
    <div class="row">
        <div class="col-lg-4">
            <?php $form = ActiveForm::begin(['id' => 'passwordreset-form']); ?>

            <?= Html::activeHiddenInput($model,'smsid') ?>

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

            <div class="form-group">
                <?= Html::submitButton('下一步', ['class' => 'btn btn-primary btn-block', 'name' => 'passwordreset-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>