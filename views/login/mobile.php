<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\Login */

use app\assets\SendSMSAsset;
use kartik\tabs\TabsX;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = '登录';
$this->params['breadcrumbs'][] = $this->title;
SendSMSAsset::register($this);

$items = [
    [
        'label' => '<i class="glyphicon glyphicon-th-large"></i> 普通登录',
        'url' => Url::to(['/login/default', 'SSO' => $SSO]),
    ],
    [
        'label' => '<i class="glyphicon glyphicon-phone"></i> 动态密码登录',
        'active' => true
    ]
];

?>
<script>
    var actionId = 'login';
    var sendButton = 'getSMS';
</script>
<div class="mobile-login">
    <h1>登录</h1>

    <p>一个帐号，玩转所有服务！</p>

    <div class="row">
        <div class="col-lg-4">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= Html::activeHiddenInput($model,'smsid') ?>

            <?= TabsX::widget([
                'items' => $items,
                'position' => TabsX::POS_ABOVE,
                'encodeLabels' => false
            ]) ?>

            <?= $form->field($model, 'mobile', [
                'addon' => [
                    'prepend' => [
                        'content' => '<i class="glyphicon glyphicon-phone"></i>'
                    ]
                ]
            ])->textInput(['placeholder' => '手机号'])->label(false) ?>

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

            <?= $form->field($model, 'rememberMe')->checkbox() ?>

            <div class="form-group">
                <?= Html::submitButton('立即登录', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>