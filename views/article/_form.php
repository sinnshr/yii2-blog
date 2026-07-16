<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Category;

/** @var yii\web\View $this */
/** @var app\models\Article $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="max-w-2xl mx-auto px-4 py-8" dir="rtl">
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">
        <h1 class="mb-3 text-lg font-bold"><?= Html::encode($this->title) ?></h1>
        <?php $form = ActiveForm::begin([
            'options' => ['enctype' => 'multipart/form-data'],
            'fieldConfig' => [
                'template' => "{label}\n{input}\n{error}",
                'labelOptions' => ['class' => 'block mb-1 font-medium text-gray-700'],
                'inputOptions' => ['class' => 'w-full rounded-lg border border-gray-300 px-3 py-2 mb-4'],
                'errorOptions' => ['class' => 'text-red-500 text-sm mb-2'],
            ],
        ]); ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true])->label('عنوان') ?>

        <?= $form->field($model, 'content')->textarea(['rows' => 6])->label('متن مقاله') ?>

        <?= $form->field($model, 'pdfFile')->fileInput()->label('فایل PDF') ?>

        <?= $form->field($model, 'imageFile')->fileInput()->label('تصویر') ?>

        <?= $form->field($model, 'category_id')->dropDownList(
            ArrayHelper::map(Category::find()->all(), 'id', 'title'),
            ['prompt' => 'انتخاب دسته‌بندی']
        )->label('دسته‌بندی') ?>

        <?= $form->field($model, 'author_id')->hiddenInput(['value' => Yii::$app->user->id])->label(false) ?>

        <div class="form-group mt-6 text-left">
            <?= Html::submitButton('ذخیره', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>