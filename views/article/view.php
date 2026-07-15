<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use app\models\Comment;

/** @var yii\web\View $this */
/** @var app\models\Article $model */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Articles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<?php if (!Yii::$app->user->isGuest): ?>
    <?php if ($model->isLikedBy(Yii::$app->user->id)): ?>
        <?= Html::a('★ Remove Favorite', ['favorite/toggle', 'articleId' => $model->id], ['class' => 'btn btn-warning']) ?>
    <?php else: ?>
        <?= Html::a('☆ Add to Favorites', ['favorite/toggle', 'articleId' => $model->id], ['class' => 'btn btn-outline-warning']) ?>
    <?php endif; ?>
<?php endif; ?>

<div class="article-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'content:ntext',
            'pdf_file',
            'image',
            'category_id',
            'author_id',
        ],
    ]) ?>

    <?php foreach ($model->comments as $comment): ?>
        <p><strong>
                <?= $comment->user->username ?>:
            </strong>
            <?= $comment->text ?>
        </p>
    <?php endforeach; ?>

    <?php if (!Yii::$app->user->isGuest): ?>
        <?php $commentForm = new Comment(); ?>
        <?php $form = ActiveForm::begin(['action' => ['comment/create']]) ?>
        <?= $form->field($commentForm, 'text')->textarea() ?>
        <?= Html::hiddenInput('Comment[article_id]', $model->id) ?>
        <?= Html::submitButton('Post Comment') ?>
        <?php ActiveForm::end() ?>
    <?php else: ?>
        <p>برای ثبت نظر ابتدا
            <?= Html::a('وارد شوید.', ['site/login']) ?>
        </p>
    <?php endif; ?>

</div>