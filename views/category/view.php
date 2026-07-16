<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Category $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'دسته‌بندی‌ها', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="max-w-2xl mx-auto px-4 py-8" dir="rtl">
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">

        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold"><?= Html::encode($this->title) ?></h1>
            <div class="flex gap-2">
                <?= Html::a('ویرایش', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('حذف', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'آیا از حذف این دسته‌بندی مطمئن هستید؟',
                        'method' => 'post',
                    ],
                ]) ?>
            </div>
        </div>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                'title:text:عنوان',
                [
                    'attribute' => 'parent_id',
                    'label' => 'دسته‌بندی والد',
                    'value' => $model->parent ? $model->parent->title : 'دسته اصلی',
                ],
            ],
        ]) ?>

    </div>
</div>