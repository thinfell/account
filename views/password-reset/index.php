<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;

$this->title = '找回密码';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="passwordreset-index">
    <h1>1.输入登录帐号</h1>

    <div class="row">
        <div class="col-lg-4">
            <?php $form = ActiveForm::begin(['id' => 'passwordreset-form']); ?>

            <?= $form->field($model, 'account', [
                'addon' => [
                    'prepend' => [
                        'content' => '<i class="glyphicon glyphicon-user"></i>'
                    ]
                ]
            ])->textInput(['placeholder' => '邮箱/手机号/用户名'])->label(false) ?>

            <div class="form-group">
                <?= Html::submitButton('下一步', ['class' => 'btn btn-primary btn-block', 'name' => 'passwordreset-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>