<?php

use app\models\Category;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\CategorySearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'دسته‌بندی‌ها';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="max-w-4xl mx-auto px-4 py-8" dir="rtl">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold"><?= Html::encode($this->title) ?></h1>
        <?= Html::a('+ دسته‌بندی جدید', ['create'], ['class' => 'btn btn-success']) ?>
    </div>

    <div class="rounded-2xl border border-gray-200 bg-white shadow-sm overflow-hidden p-8">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions' => ['class' => 'table w-full text-right'],
            'summary' => 'نمایش {begin}-{end} از {totalCount} مورد',
            'layout' => "{items}\n{summary}\n{pager}",
            'columns' => [
                'id',
                ['attribute' => 'title', 'label' => 'عنوان'],
                [
                    'attribute' => 'parent_id',
                    'label' => 'دسته‌بندی والد',
                    'value' => function ($model) {
                                return $model->parent ? $model->parent->title : 'دسته اصلی';
                            },
                ],
                [
                    'class' => ActionColumn::class,
                    'header' => 'عملیات',
                    'urlCreator' => function ($action, Category $model, $key, $index, $column) {
                                return Url::toRoute([$action, 'id' => $model->id]);
                            },
                ],
            ],
        ]); ?>
    </div>

</div>