<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var yii\widgets\ActiveForm $form */
/** @var app\models\LoginForm $model */

$this->title = 'ورود';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="max-w-md mx-auto px-4 py-12" dir="rtl">
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">

        <h1 class="text-2xl font-bold mb-2"><?= Html::encode($this->title) ?></h1>
        <p class="text-gray-500 text-sm mb-6">برای ورود، نام کاربری و رمز عبور خود را وارد کنید.</p>

        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'block mb-1 font-medium text-gray-700'],
                'inputOptions' => ['class' => 'w-full rounded-lg border border-gray-300 px-3 py-2 mb-4'],
                'errorOptions' => ['class' => 'text-red-500 text-sm mb-2'],
            ],
        ]); ?>

        <?= $form->errorSummary($model, ['class' => 'text-red-500 text-sm mb-4']) ?>

        <?= $form->field($model, 'username')->textInput(['autofocus' => true])->label('نام کاربری') ?>

        <?= $form->field($model, 'password')->passwordInput()->label('رمز عبور') ?>

        <?= $form->field($model, 'rememberMe')->checkbox([
            'template' => "<div class=\"flex items-center gap-2 mb-4\">{input} {label}</div>",
        ]) ?>

        <div class="form-group">
            <?= Html::submitButton('ورود', ['class' => 'btn btn-primary w-full', 'name' => 'login-button']) ?>
        </div>

        <?php ActiveForm::end(); ?>

        <p class="text-sm text-gray-500 mt-4">
            حساب کاربری ندارید؟
            <?= Html::a('ثبت‌نام کنید', ['site/signup'], ['class' => 'text-blue-600 hover:underline']) ?>
        </p>

    </div>
</div>