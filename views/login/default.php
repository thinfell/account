<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\Login */

use kartik\tabs\TabsX;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = '登录';
$this->params['breadcrumbs'][] = $this->title;

$items = [
    [
        'label' => '<i class="glyphicon glyphicon-th-large"></i> 普通登录',
        'active' => true
    ],
    [
        'label' => '<i class="glyphicon glyphicon-phone"></i> 动态密码登录',
        'url' => Url::to(['/login/mobile', 'SSO' => $SSO]),
    ]
];

?>
<?php
    if(Yii::$app->session->get('step') == 3){
?>
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        <span aria-hidden="true">&times;</span>
        <span class="sr-only">Close</span>
    </button>
    <strong>密码找回成功!</strong> 您可以使用新密码登录, 如果登录遇到问题请联系管理员.
</div>
<?php
        Yii::$app->session->remove('step');
    }
    ?>
<div class="default-login">
    <h1>登录</h1>

    <p>一个帐号，玩转所有服务！</p>

    <div class="row">
        <div class="col-lg-4">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

            <?= TabsX::widget([
                'items' => $items,
                'position' => TabsX::POS_ABOVE,
                'encodeLabels' => false
            ]) ?>

            <?= $form->field($model, 'account', [
                'addon' => [
                    'prepend' => [
                        'content' => '<i class="glyphicon glyphicon-user"></i>'
                    ]
                ]
            ])->textInput(['placeholder' => '邮箱/手机号/用户名'])->label(false) ?>

            <?= $form->field($model, 'password', [
                'addon' => [
                    'prepend' => [
                        'content' => '<i class="glyphicon glyphicon-lock"></i>'
                    ]
                ]
            ])->passwordInput(['placeholder' => '密码'])->label(false) ?>

            <?= $form->field($model, 'rememberMe')->checkbox() ?>

            <div style="color:#999;margin:1em 0">
                如果您忘记密码，请<a href="<?=Url::to(['/password-reset'])?>">找回密码</a>。
            </div>

            <div class="form-group">
                <?= Html::submitButton('立即登录', ['class' => 'btn btn-primary btn-block', 'name' => 'login-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
