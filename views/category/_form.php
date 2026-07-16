<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Category;

/** @var yii\web\View $this */
/** @var app\models\Category $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="max-w-2xl mx-auto px-4 py-8" dir="rtl">
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">

        <?php $form = ActiveForm::begin([
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'block mb-1 font-medium text-gray-700'],
                'inputOptions' => ['class' => 'w-full rounded-lg border border-gray-300 px-3 py-2 mb-4'],
                'errorOptions' => ['class' => 'text-red-500 text-sm mb-2'],
            ],
        ]); ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label('عنوان دسته‌بندی') ?>

        <?= $form->field($model, 'parent_id')->dropDownList(
            ArrayHelper::map(
                Category::find()->where(['parent_id' => null])->all(),
                'id',
                'title'
            ),
            ['prompt' => 'هیچ‌کدام (دسته‌بندی اصلی)']
        )->label('دسته‌بندی والد') ?>

        <div class="form-group mt-6">
            <?= Html::submitButton('ذخیره', ['class' => 'btn btn-success w-full']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>