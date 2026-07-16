<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "article".
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string|null $pdf_file
 * @property string|null $image
 * @property int $category_id
 * @property int $author_id
 *
 * @property Category $category
 * @property Comment[] $comments
 */
class Article extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'article';
    }

    /**
     * {@inheritdoc}
     */

    public $pdfFile;
    public $imageFile;

    public function rules()
    {
        return [
            [['pdf_file', 'image'], 'default', 'value' => null],
            [['title', 'content', 'category_id', 'author_id'], 'required'],
            [['content'], 'string'],
            [['category_id', 'author_id'], 'integer'],
            [['title', 'pdf_file', 'image'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['pdfFile'], 'file', 'extensions' => 'pdf'],
            [['imageFile'], 'file', 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'content' => 'Content',
            'pdf_file' => 'Pdf File',
            'image' => 'Image',
            'category_id' => 'Category ID',
            'author_id' => 'Author ID',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::class, ['article_id' => 'id']);
    }

    public function isLikedBy($userId)
    {
        return Favorite::find()
            ->where(['user_id' => $userId, 'article_id' => $this->id])
            ->exists();
    }

    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id' => 'author_id']);
    }

}
