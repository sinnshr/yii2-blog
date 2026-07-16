<?php

/** @var yii\web\View $this */

$this->title = 'Yii2 Blog';
?>
<div>
    <div class="min-h-screen flex items-center justify-center rtl">
        <div class="text-center text-gray-800 max-w-xl">
            <h1 class="text-4xl mb-2 font-bold">وبلاگ Yii2</h1>
            <p class="text-lg mb-8 leading-relaxed">مقالات به روز درباره‌ی فناوری</p>

            <div class="bg-white p-5 mb-8 border border-gray-300 rounded-lg shadow-md">
                <p class="text-base m-2">🌟 بیش از ۱۰۰ مقاله منتشر شده</p>
                <p class="text-base m-2">👥 +۵۰۰۰ خواننده فعال</p>
            </div>

            <div class="flex gap-2.5 justify-center mt-8">
                            <?= \yii\helpers\Html::a('آخرین نوشته‌ها', ['article/index'], [
                                'class' => 'bg-red-500 text-white px-8 py-2.5 no-underline font-bold rounded-full',
                            ]) ?>
            </div>
        </div>
    </div>
</div>