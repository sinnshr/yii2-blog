<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Category $model */

$this->title = 'ویرایش دسته‌بندی: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'دسته‌بندی‌ها', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'ویرایش';
?>
<div class="max-w-2xl mx-auto px-4 pt-8" dir="rtl">
    <h1 class="text-2xl font-bold"><?= Html::encode($this->title) ?></h1>
</div>

<?= $this->render('_form', [
    'model' => $model,
]) ?>