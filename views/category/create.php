<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Category $model */

$this->title = 'دسته‌بندی جدید';
$this->params['breadcrumbs'][] = ['label' => 'دسته‌بندی‌ها', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="max-w-2xl mx-auto px-4 pt-8" dir="rtl">
    <h1 class="text-2xl font-bold"><?= Html::encode($this->title) ?></h1>
</div>

<?= $this->render('_form', [
    'model' => $model,
]) ?>