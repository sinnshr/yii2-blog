<?php

use yii\helpers\Html;

/** @var app\models\Article $model */
?>
<div class="flex gap-4 rounded-2xl border border-gray-200 bg-white p-4 shadow-sm hover:shadow-md transition">

    <?php if ($model->image): ?>
        <img src="<?= Html::encode(Yii::getAlias('@web/uploads/images/' . $model->image)) ?>"
            alt="<?= Html::encode($model->title) ?>" class="w-32 h-32 object-cover rounded-lg flex-shrink-0">
    <?php endif; ?>

    <div class="flex-1">
        <h2 class="text-lg font-bold mb-1">
            <?= Html::a(Html::encode($model->title), ['view', 'id' => $model->id], ['class' => 'hover:text-blue-600']) ?>
        </h2>

        <p class="text-sm text-gray-500 mb-2">
            نویسنده:
            <?= Html::encode($model->author->username) ?>
            | دسته‌بندی:
            <?= Html::encode($model->category->title) ?>
        </p>

        <p class="text-gray-700 text-sm mb-3">
            <?= Html::encode(mb_substr(strip_tags($model->content), 0, 150)) ?>...
        </p>

        <?= Html::a('ادامه مطلب ←', ['view', 'id' => $model->id], ['class' => 'text-base text-blue-600 hover:underline']) ?>
    </div>

</div>