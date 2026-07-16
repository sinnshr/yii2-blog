<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Comment;

/** @var yii\web\View $this */
/** @var app\models\Article $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'جدیدترین مقالات', 'url' => ['index'], 'class' => 'text-blue'];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="max-w-4xl mx-auto px-4 py-8 sm:px-6 lg:px-8" dir="rtl">
    <div class="rounded-2xl border border-gray-200 bg-white p-6 shadow-sm sm:p-8">

        <?php if ($model->image): ?>
            <img src="<?= Html::encode(Yii::getAlias('@web/uploads/images/' . $model->image)) ?>"
                alt="<?= Html::encode($model->title) ?>" class="w-full h-64 object-cover rounded-lg mb-6">
        <?php endif; ?>

        <h1 class="text-2xl font-bold mb-2"><?= Html::encode($this->title) ?></h1>

        <p class="text-sm text-gray-500 mb-6">
            نویسنده: <?= Html::encode($model->author->username) ?>
            | دسته‌بندی:
            <?php
                $category = $model->category;
                $displayCategory = $category && $category->parent ? $category->parent : $category;
            ?>
            <?= $displayCategory ? Html::a(Html::encode($displayCategory->title.'/'. $category->title), ['category/view', 'id' => $category->id]) : '' ?>
        </p>

        <div class="prose max-w-none mb-6">
            <?= nl2br(Html::encode($model->content)) ?>
        </div>

        <?php if ($model->pdf_file): ?>
            <p class="mb-6">
                <?= Html::a('📄 دانلود فایل PDF', Yii::getAlias('@web/uploads/pdfs/' . $model->pdf_file), [
                    'class' => 'btn btn-outline-primary',
                    'target' => '_blank',
                ]) ?>
            </p>
        <?php endif; ?>

        <div class="flex gap-2 mb-6">
            <?php if (!Yii::$app->user->isGuest): ?>
                <?php if ($model->isLikedBy(Yii::$app->user->id)): ?>
                    <?= Html::a('👎حذف از علاقه‌مندی‌ها', ['favorite/toggle', 'articleId' => $model->id], ['class' => 'btn btn-outline-danger']) ?>
                <?php else: ?>
                    <?= Html::a('👍افزودن به علاقه‌مندی‌ها', ['favorite/toggle', 'articleId' => $model->id], ['class' => 'btn btn-outline-danger']) ?>
                <?php endif; ?>
            <?php endif; ?>

            <?php if (Yii::$app->user->can('updateAnyArticle') || (!Yii::$app->user->isGuest && $model->author_id === Yii::$app->user->id)): ?>
                <?= Html::a('ویرایش', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
            <?php endif; ?>

            <?php if (Yii::$app->user->can('deleteArticle')): ?>
                <?= Html::a('حذف', ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'آیا از حذف این مقاله مطمئن هستید؟',
                        'method' => 'post',
                    ],
                ]) ?>
            <?php endif; ?>
        </div>

        <hr class="my-6">

        <h3 class="text-lg font-semibold mb-4">نظرات (<?= count($model->comments) ?>)</h3>

        <?php foreach ($model->comments as $comment): ?>
            <div class="mb-3 pb-3 border-b border-gray-100">
                <strong><?= Html::encode($comment->user->username) ?>:</strong>
                <?= Html::encode($comment->text) ?>
            </div>
        <?php endforeach; ?>

        <?php if (!Yii::$app->user->isGuest): ?>
            <?php $commentForm = new Comment(); ?>
            <?php $form = ActiveForm::begin(['action' => ['comment/create']]) ?>
            <?= $form->field($commentForm, 'text')->textarea(['rows' => 3])->label('دیدگاه شما') ?>
            <?= Html::hiddenInput('Comment[article_id]', $model->id) ?>
            <?= Html::submitButton('ثبت نظر', ['class' => 'btn btn-primary mt-2']) ?>
            <?php ActiveForm::end() ?>
        <?php else: ?>
            <p class="text-gray-500">
                برای ثبت نظر ابتدا <?= Html::a('وارد شوید', ['site/login'], ['class' => 'text-blue-600 hover:underline']) ?>.
            </p>
        <?php endif; ?>

    </div>
</div>