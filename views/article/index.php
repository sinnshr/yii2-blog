<?php

use yii\helpers\Html;
use yii\widgets\ListView;

/** @var yii\web\View $this */
/** @var app\models\ArticleSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'جدیدترین مقالات';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="max-w-5xl mx-auto px-4 py-8 sm:px-6 lg:px-8" dir="rtl">

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold"><?= Html::encode($this->title) ?></h1>

        <?php if (!Yii::$app->user->isGuest && Yii::$app->user->can('createArticle')): ?>
            <?= Html::a('+ مقاله جدید', ['create'], ['class' => 'btn btn-success']) ?>
        <?php endif; ?>
    </div>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_article_card',
        'layout' => "{items}\n<div class=\"mt-6\">{pager}</div>",
        'itemOptions' => ['class' => 'mb-4'],
    ]) ?>

</div>